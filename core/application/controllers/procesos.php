<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procesos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('format');
		$this->load->database();
	}


	public function lectura_csv_fe(){
			$path = "./facturacion_electronica/csv/";
			$directorio = opendir($path);

			while ($archivo = readdir($directorio)){

			    if (!is_dir($archivo)){

			        $array_archivo = explode(".",$archivo);
			        $extension = $array_archivo[count($array_archivo)-1];

			        if(strtoupper($extension) == 'CSV'){
					 	$path_archivo = $path.$archivo;

						$this->load->model('facturaelectronica');
						$codproceso = $this->facturaelectronica->guarda_csv($path_archivo);

						$this->facturaelectronica->crea_dte_csv($codproceso);	
						//rename($path_archivo,$path."procesados/".$archivo);
			        }
		        
			    }
			}			



	}


	public function lectura_csv_fe_manual(){

			$archivo = "./facturacion_electronica/csv/procesados/FACT_PROC_2016084114.CSV";
			$this->load->model('facturaelectronica');
			$codproceso = $this->facturaelectronica->guarda_csv($archivo);
			$this->facturaelectronica->crea_dte_csv($codproceso);


	}



	public function envio_programado_sii(){
		set_time_limit(0);
		$this->load->model('facturaelectronica');
		$facturas = $this->facturaelectronica->get_factura_no_enviada();


		foreach ($facturas as $factura) {
			$idfactura = $factura->idfactura;
			$factura = $this->facturaelectronica->datos_dte($idfactura);
			$config = $this->facturaelectronica->genera_config();
			include $this->facturaelectronica->ruta_libredte();


			$token = \sasco\LibreDTE\Sii\Autenticacion::getToken($config['firma']);
			if (!$token) {
			    foreach (\sasco\LibreDTE\Log::readAll() as $error){
			    	$result['error'] = true;

			    }
			    $result['message'] = "Error de conexión con SII";		   
			   	echo json_encode($result);
			    exit;
			}

			$Firma = new \sasco\LibreDTE\FirmaElectronica($config['firma']); //lectura de certificado digital
			$rut = $Firma->getId(); 
			$rut_consultante = explode("-",$rut);
			$RutEnvia = $rut_consultante[0]."-".$rut_consultante[1];

			//$xml = $factura->dte;
			$archivo = "./facturacion_electronica/dte/".$factura->path_dte.$factura->archivo_dte;
		 	if(file_exists($archivo)){
		 		$xml = file_get_contents($archivo);
		 	}else{
		 		$xml = $factura->dte;
		 	}


			$EnvioDte = new \sasco\LibreDTE\Sii\EnvioDte();
			$EnvioDte->loadXML($xml);
			$Documentos = $EnvioDte->getDocumentos();	

			$DTE = $Documentos[0];
			$RutEmisor = $DTE->getEmisor(); 

			// enviar DTE
			$result_envio = \sasco\LibreDTE\Sii::enviar($RutEnvia, $RutEmisor, $xml, $token);

			// si hubo algún error al enviar al servidor mostrar
			if ($result_envio===false) {
			    foreach (\sasco\LibreDTE\Log::readAll() as $error){
			        $result['error'] = true;
			    }
			    $result['message'] = "Error de envío de DTE";		   
			   	echo json_encode($result);
			    exit;
			}

			// Mostrar resultado del envío
			if ($result_envio->STATUS!='0') {
			    foreach (\sasco\LibreDTE\Log::readAll() as $error){
					$result['error'] = true;
			    }
			    $result['message'] = "Error de envío de DTE";		   
			   	echo json_encode($result);
			    exit;
			}


			$track_id = 0;
			$track_id = (float)$result_envio->TRACKID;
		    $this->db->where('id', $factura->id); 
			$this->db->update('folios_caf',array('trackid' => $track_id)); 

			$datos_empresa_factura = $this->facturaelectronica->get_empresa_factura($idfactura);
			
			if($track_id != 0 && $datos_empresa_factura->e_mail != ''){ //existe track id, se envía correo
				$this->facturaelectronica->envio_mail_dte($idfactura);
			}

			echo "idfactura: " .$factura->id." -- folio : ".$factura->folio." -- trackid : ". $track_id . "<br>";
			ob_flush(); 

			$result['success'] = true;
			$result['message'] = $track_id != 0 ? "DTE enviado correctamente" : "Error en env&iacute;o de DTE";
			$result['trackid'] = $track_id;
			echo json_encode($result);
			
		}

	}		


	public function envio_programado_consumo_folios(){
		set_time_limit(0);
		$this->load->model('facturaelectronica');
		$consumo_folios = $this->facturaelectronica->consumo_folios_no_enviada();
		$empresa = $this->facturaelectronica->get_empresa();
		$RutEmisor = $empresa->rut.'-'.$empresa->dv;
		$config = $this->facturaelectronica->genera_config();
		include $this->facturaelectronica->ruta_libredte();

		foreach ($consumo_folios as $consumo_folio) {
			//$idfactura = $factura->idfactura;
			//$factura = $this->facturaelectronica->datos_dte($idfactura);
			

			$token = \sasco\LibreDTE\Sii\Autenticacion::getToken($config['firma']);
			if (!$token) {
				var_dump(\sasco\LibreDTE\Log::readAll());
			    foreach (\sasco\LibreDTE\Log::readAll() as $error){
			    	$result['error'] = true;

			    }
			    $result['message'] = "Error de conexión con SII";		   
			   	echo json_encode($result);
			    exit;
			}

			$Firma = new \sasco\LibreDTE\FirmaElectronica($config['firma']); //lectura de certificado digital
			$rut = $Firma->getId(); 
			$rut_consultante = explode("-",$rut);
			$RutEnvia = $rut_consultante[0]."-".$rut_consultante[1];

			//$xml = $factura->dte;
			$archivo = "./facturacion_electronica/Consumo_Folios/".$consumo_folio->path_consumo_folios.$consumo_folio->archivo_consumo_folios;
		 	if(file_exists($archivo)){
		 		$xml = file_get_contents($archivo);
		 	}else{
		 		$xml = $consumo_folio->xml;
		 	}

			// enviar DTE
			$result_envio = \sasco\LibreDTE\Sii::enviar($RutEnvia, $RutEmisor, $xml, $token);

			// si hubo algún error al enviar al servidor mostrar
			if ($result_envio===false) {
					var_dump(\sasco\LibreDTE\Log::readAll());
			    foreach (\sasco\LibreDTE\Log::readAll() as $error){
			        $result['error'] = true;
			    }
			    $result['message'] = "Error de envío de DTE";		   
			   	echo json_encode($result);
			    exit;
			}

			// Mostrar resultado del envío
			if ($result_envio->STATUS!='0') {
			    foreach (\sasco\LibreDTE\Log::readAll() as $error){
					$result['error'] = true;
			    }
			    $result['message'] = "Error de envío de DTE";		   
			   	echo json_encode($result);
			    exit;
			}


			$track_id = 0;
			$track_id = $result_envio->TRACKID;
		    $this->db->where('id', $consumo_folio->id);
			$this->db->update('consumo_folios',array('trackid' => $track_id)); 

			/*$datos_empresa_factura = $this->facturaelectronica->get_empresa_factura($idfactura);
			
			if($track_id != 0 && $datos_empresa_factura->e_mail != ''){ //existe track id, se envía correo
				$this->facturaelectronica->envio_mail_dte($idfactura);
			}*/

			echo "idconsumofolios: " .$consumo_folio->id." -- consumo folios : ".$consumo_folio->archivo_consumo_folios." -- trackid : ". $track_id . "<br>";
			ob_flush(); 

			$result['success'] = true;
			$result['message'] = $track_id != 0 ? "DTE enviado correctamente" : "Error en env&iacute;o de DTE";
			$result['trackid'] = $track_id;
			echo json_encode($result);
			
		}

	}	

	public function proceso_consumo_folios(){
		set_time_limit(0);
		//https://palena.sii.cl/cgi_dte/UPL/DTEauth?1   -subir
		//https://palena.sii.cl/cgi_dte/UPL/DTEauth?3 --consultar
			//header('Content-type: text/plain; charset=ISO-8859-1');

/*

ilefort@itelecom.cl
dte.cl_sii@einvoicing.signature-cloud.com
dte.cl@einvoicing.signature-cloud.com
*/



			$this->load->model('facturaelectronica');
			include $this->facturaelectronica->ruta_libredte();
			$empresa = $this->facturaelectronica->get_empresa();
			$fec_inicio = $empresa->fec_inicio_boleta;
			$fecha_hoy = date('Y-m-d');
			$dias_evalua = 10;

			while($dias_evalua >= 0){
				$fecha_consumo= strtotime("- $dias_evalua days", strtotime ($fecha_hoy));
				$fecha = date('Y-m-d',$fecha_consumo);
				//echo $fecha."<br>";
				
				if(strtotime($fecha) >= strtotime($fec_inicio)){
					$consumo_folios = $this->facturaelectronica->get_consumo_folios($fecha);
					if(count($consumo_folios) == 0){
						$this->genera_consumo_folios($fecha);	
					}
					
				}

				$dias_evalua--;
			}

	}		


	public function genera_consumo_folios($fecha){
		

		//echo $fecha; exit;
		header('Content-type: text/plain; charset=ISO-8859-1');
		$this->load->model('facturaelectronica');
      	$config = $this->facturaelectronica->genera_config();
      	


		$empresa = $this->facturaelectronica->get_empresa();
		$facturas = $this->facturaelectronica->get_boletas_dia($fecha);
		$Firma = new sasco\LibreDTE\FirmaElectronica($config['firma']); //lectura de certificado digital            
		$ConsumoFolio = new sasco\LibreDTE\Sii\ConsumoFolio();
		$ConsumoFolio->setFirma($Firma);
		//print_r($facturas);  exit;
		$lista_folios = array();
		if(count($facturas) > 0){
			foreach ($facturas as $factura) {
				$idfactura = $factura->idfactura;
				$factura = $this->facturaelectronica->datos_dte($idfactura);
				$archivo = "./facturacion_electronica/dte/".$factura->path_dte.$factura->archivo_dte;
				//echo $archivo; exit;
			 	if(file_exists($archivo)){
			 		$xml = file_get_contents($archivo);
			 	}else{
			 		$xml = $factura->dte;
			 	}
				//echo $xml;


				$rut = $Firma->getId(); 
				$rut_consultante = explode("-",$rut);
				$RutEnvia = $rut_consultante[0]."-".$rut_consultante[1];

				//$xml = $factura->dte;
				


				$EnvioBOLETA = new \sasco\LibreDTE\Sii\EnvioDte();
				$EnvioBOLETA->loadXML($xml);
				// agregar detalle de boletas
				foreach ($EnvioBOLETA->getDocumentos() as $Dte) {
				    $ConsumoFolio->agregar($Dte->getResumen());
				}


				// crear carátula para el envío (se hace después de agregar los detalles ya que
				// así se obtiene automáticamente la fecha inicial y final de los documentos)
				$CaratulaEnvioBOLETA = $EnvioBOLETA->getCaratula();
				$lista_folios[] = $factura->folio;
				
			}


			/**** definir folio min, folio max, cant folios, lista folios ****/
			$folio_min = min($lista_folios);
			$folio_max = max($lista_folios);
			$cant_folios = count($lista_folios);

		}else{

			$ConsumoFolio->setDocumentos([39,61,41]);
			$folio_min = 0;
			$folio_max = 0;
			$cant_folios = 0;

		}

		


		// crear carátula para el envío (se hace después de agregar los detalles ya que
		// así se obtiene automáticamente la fecha inicial y final de los documentos)
		$ConsumoFolio->setCaratula([
		    'RutEmisor' => $empresa->rut.'-'.$empresa->dv,
		    'FchResol' => $empresa->fec_resolucion,
		    'NroResol' =>  $empresa->nro_resolucion,
			'FchInicio' => $fecha,
			'FchFinal' => $fecha,
			'SecEnvio' => 1

		]);
		//echo $ConsumoFolio->generar()."<br>";

		$ConsumoFolio->generar();
		if ($ConsumoFolio->schemaValidate()) {
		    $xml_consumo_folios = $ConsumoFolio->generar();
		    $nombre_archivo =  "Consumo_Folios_" . str_replace("-","",$fecha) . ".xml";
		    $path = date('Ym').'/';
			if(!file_exists('./facturacion_electronica/Consumo_Folios/'.$path)){
				mkdir('./facturacion_electronica/Consumo_Folios/'.$path,0777,true);
			}			    
			$f_archivo = fopen('./facturacion_electronica/Consumo_Folios/'.$path.$nombre_archivo,'w');
			fwrite($f_archivo,$xml_consumo_folios);
			fclose($f_archivo);


			$array_consumo_folios = array (
											'fecha' => $fecha,
											'cant_folios' => $cant_folios,
											'folio_desde' => $folio_min,
											'folio_hasta' => $folio_max,
											'path_consumo_folios' => $path,
											'archivo_consumo_folios' => $nombre_archivo,
											'xml' => $xml_consumo_folios,
											'trackid' => '0',
											'created_at' => date('Y-m-d H:i:s')

										);
			$this->db->insert('consumo_folios',$array_consumo_folios);
			$id_consumo_folios = $this->db->insert_id();



			if(count($lista_folios) > 0){
				$this->db->where_in('f.folio', $lista_folios);
	            $this->db->where('c.tipo_caf', 39);
	            $this->db->update('folios_caf f inner join caf c on f.idcaf = c.id',array('id_consumo_folios' => $id_consumo_folios)); 
			}

  			




		  //  $track_id = $ConsumoFolio->enviar();
		  //  var_dump($track_id);
		}

// si hubo errores mostrar
			///foreach (\sasco\LibreDTE\Log::readAll() as $error)
    			//echo $error,"\n";



	}	

	public function get_contribuyentes(){

		set_time_limit(0);
		$this->load->model('facturaelectronica');
		$this->facturaelectronica->get_contribuyentes();
	}	

	
}









