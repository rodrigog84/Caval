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
						rename($path_archivo,$path."procesados/".$archivo);
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


}









