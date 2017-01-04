Ext.define('Infosys_web.view.TopMenus' ,{
    extend: 'Ext.toolbar.Toolbar',
    alias : 'widget.topmenus',
    
    requires: [
        'Ext.button.Split'
    ],
    
    initComponent: function() {
        var me = this

        this.items = [{
            xtype: 'button',
            iconCls: 'icon-note',
            text : 'Parametros Generales',
            menu: [{
                text: 'Cuentas de Centralizacion',
                iconCls: '',
                menu: [{
                        text: 'Ventas',
                        iconCls: '',
                        itemId: 'pg_cc_ventas',
                        disabled: false,
                        action: 'mcentraliza'
                     
                },{
                        text: 'Adquisiciones',
                        iconCls: '',
                        itemId: 'pg_cc_adq',
                        disabled: false,
                        action: ''
                },{
                        text: 'Inventario',
                        iconCls: '',
                        itemId: 'pg_cc_inventario',
                        disabled: false,
                        action: ''
                },{
                        text: 'Cuentas Corrientes',
                        iconCls: '',
                        itemId: 'pg_cc_ccorrientes',
                        disabled: false,
                        action: ''
                }]

           },
            {
                text: 'Parametros de Sistema',
                iconCls: '',
                itemId: 'pg_psistema',
                disabled: false,
                action: ''
            
            },
            {
                text: 'Control Correlativos',
                iconCls: '',
                itemId: 'pg_ccorrelativos',
                disabled: false,
                action: 'mcorrelativos'
            
            }],
           
        },'-',{
            xtype: 'button',
            iconCls: 'icon-carro',
            text : 'Ventas y Facturacion',
            menu: [{
                text: 'Tablas Generales',
                iconCls: '',
                menu: [{
                        text: 'Clientes',
                        iconCls: '',
                        itemId: 'vyf_tg_clientes',
                        disabled: false,
                        action: 'mclientes'
                },{
                        text: 'Vendedores',
                        itemId: 'vyf_tg_vendedores',
                        disabled: false,
                        iconCls: '',
                        action: 'mvendedores'
                },{
                        text: 'Ciudad',
                        itemId: 'vyf_tg_ciudad',
                        disabled: false,
                        iconCls: '',
                        action: 'mciudades'
                },{
                        text: 'Comuna',
                        itemId: 'vyf_tg_comuna',
                        disabled: false,
                        iconCls: '',
                        action: 'mcomunas'
                },{
                        text: 'Codigo Actividad Economica',
                        iconCls: '',
                         itemId: 'vyf_tg_cactividade',
                        disabled: false,
                        action: 'mcodactivecon'
                },{
                        text: 'Condiciones de Pago',
                        itemId: 'vyf_tg_cpago',
                        disabled: false,
                        iconCls: '',
                        action: 'mcondicionpagos'
                },{
                        text: 'Sucursales',
                        itemId: 'vyf_tg_sucursales',
                        disabled: false,
                        iconCls: '',
                        action: 'msucursales'
                },{
                        text: 'Tablas Descuentos',
                        itemId: 'vyf_tg_tablasdescuento',
                        disabled: false,
                        iconCls: '',
                        action: 'mtablas'
                },{
                        text: 'Control de Caja',
                        itemId: 'vyf_tg_ccaja',
                        disabled: false,
                        iconCls: '',
                             menu: [{
                            text: 'Banco',
                            iconCls: '',
                            action: 'mbancos'
                        },{
                            text: 'Plaza',
                            iconCls: '',
                            action: 'mplazas'
                        },{
                            text: 'Cajero',
                            iconCls: '',
                            action: 'mcajeros'
                        },{
                            text: 'Caja',
                            iconCls: '',
                            action: 'mcajas'
                    }]
                }]
              

            },
            {
                text: 'Ingreso de Movimientos',
                iconCls: '',
                 menu: [,{
                        text: 'Punto de Ventas',
                        iconCls: '',
                        //itemId: 'vyf_im_flotes',
                        //disabled: false,
                        menu: [{
                            text: 'Ingreso Nota venta',
                            iconCls: '',
                            action: 'mpreventa'
                        }]
                },{
                        text: 'Ventas',
                        iconCls: '',
                        menu: [{
                            text: 'Venta Directa',
                            itemId: 'vyf_im_ventas',
                            disabled: false,
                            iconCls: '',
                            action: 'mejemplo'
                        },{
                            text: 'Caja',
                            iconCls: '',
                            action: 'mpagocaja'
                        },{
                            text: 'Guia Despacho',
                            iconCls: '',
                            action: 'mguias'
                        },{
                            text: 'Nota de Credito',
                            iconCls: '',
                            action: 'meNotacredito'
                        },{
                            text: 'Nota de Debito',
                            iconCls: '',
                            action: 'meNotadebito'
                        }]
                       
                },{
                        text: 'Control de Caja',
                        iconCls: '',
                        itemId: 'vyf_im_ccaja',
                        disabled: false,
                        menu: [{
                            text: 'Apertura de Caja',
                            iconCls: '',
                            action: ''
                        },{
                            text: 'Ingreso Recaudacion',
                            iconCls: '',
                            action: ''
                        },{
                            text: 'Consulta',
                            iconCls: '',
                            action: ''
                        },{
                            text: 'Libro de Recaudacion',
                            iconCls: '',
                            action: ''
                        },{
                            text: 'Informe de Caja Diaria',
                            iconCls: '',
                            action: ''
                        },{
                            text: 'Cierre de Caja Diaria',
                            iconCls: '',
                            action: ''
                        }]

                },{
                        text: 'Facturacion por Lotes',
                        iconCls: '',
                        itemId: 'vyf_im_flotes',
                        disabled: false,
                        menu: [{
                            text: 'Factura Guias',
                            iconCls: '',
                            action: 'fguias'
                        },{
                            text: 'Factura Nota de Ventas',
                            iconCls: '',
                            action: ''
                        }]
                }]

             
            
            },{
                text: 'Cotizacion y Pedido',
                iconCls: '',
                 menu: [{
                        text: 'Cotizacion',
                        itemId: 'vyf_cp_cotizacion',
                        disabled: false,
                        iconCls: '',
                        action: 'mcotizacion'
                       
                },{
                        text: 'Nota de Venta (Pedidos)',
                        iconCls: '',
                        itemId: 'vyf_cp_nventa',
                        disabled: false,
                        action: ''
                },{
                        text: 'Consultas',
                        iconCls: '',
                        itemId: 'vyf_cp_consultas',
                        disabled: false,
                        menu: [{
                            text: 'Cotizacion',
                            iconCls: '',
                            action: ''
                        },{
                            text: 'Nota de Venta (Pedidos)',
                            iconCls: '',
                            action: ''
                        }]
                }]         

            },{
                text: 'Estadisticas',
                iconCls: '',
                menu: [{
                        text: 'Control Caja',
                        itemId: 'vyf_eds_ventas',
                        disabled: false,
                        action: 'mcontrolcaja'
                       
                },{
                        text: 'Comisiones',
                        itemId: 'vyf_eds_comisiones',
                        disabled: false,
                        iconCls: '',
                        action: 'mcomisiones'
                },{
                        text: 'Recaudaciones',
                        itemId: 'vyf_eds_recaudaciones',
                        disabled: false,
                        iconCls: '',
                        action: 'mrecauda'
                },{
                        text: 'Resportes',
                        disabled: false,
                        itemId: 'vyf_eds_reportes',
                        iconCls: '',
                             menu: [{
                            text: 'Libro Ventas',
                            iconCls: '',
                            action: 'mejemplo'
                        }]
                },]

            },{
                text: 'Centralizacion',
                iconCls: '',
                menu: [{
                        text: 'Centralizacion Contable',
                        iconCls: '',
                        itemId: 'vyf_centr_ccontable',
                        disabled: false,
                        action: ''
                }]
             
            },{
                text: 'Facturaci&oacute;n Electr&oacute;nica',
                iconCls: '',
                menu: [{
                        text: 'Registro de Empresa',
                        iconCls: '',
                        itemId: 'vyf_registro_empresa',
                        disabled: '',
                        action: 'mregempresa'
                },{
                        text: 'Par&aacute;metros Generales',
                        iconCls: '',
                        itemId: 'vyf_param_generales',
                        disabled: '',
                        action: 'mparamgenerales'
                },{
                        text: 'Carga Certificado Digital',
                        iconCls: '',
                        itemId: 'vyf_cert_digital',
                        disabled: '',
                        action: 'mcargacertdigital'
                },{
                        text: 'Carga Manual CAF',
                        iconCls: '',
                        itemId: 'vyf_carga_manual_caf',
                        disabled: '',
                        action: 'mcargamanualcaf'
                },{
                        text: 'Carga DTE Compras',
                        iconCls: '',
                        itemId: 'vyf_carga_dte_provee',
                        disabled: '',
                        action: 'mcargadteprovee'
                },{
                        text: 'Generaci&oacute;n Nuevo Libro Compra/Venta',
                        iconCls: '',
                        itemId: 'vyf_libro_compra_venta',
                        disabled: '',
                        action: 'mlibrocompraventa'
                },/*{
                        text: 'Hist&oacute;rico Libros Compra/Venta',
                        iconCls: '',
                        itemId: 'vyf_hist_libro_compra_venta',
                        disabled: '',
                        action: 'mhistlibrocompraventa'
                },*/{
                        text: 'Carga Contribuyentes Autorizados',
                        iconCls: '',
                        itemId: 'vyf_carga_contribuyentes',
                        disabled: '',   
                        action: 'mcargacontribuyentes'
                },{
                        text: 'Registro Emails',
                        iconCls: '',
                        itemId: 'vyf_email',
                        disabled: '',   
                        action: 'memail'
                }]
             

            }],           

        },{
                xtype: 'button',
                iconCls: 'icon-user',
                text : 'Acceso Directo',
                menu: [
                {
                    text: 'Ventas',
                    iconCls: '',
                    itemId: 'vv_acc_preventa',
                    disabled: false,
                    action: 'mejemplo'                
                },{
                    text: 'Cotizaciones',
                    iconCls: '',
                    itemId: 'vv_acc_cotiza',
                    disabled: false,
                    action: 'mcotizacion'                
                },{
                    text: 'Productos',
                    iconCls: '',
                    itemId: 'vv_acc_productos',
                    disabled: false,
                    action: 'mproductos'                
                }],            
            }
            ,'->',{
                xtype: 'button',
                iconCls: 'icon-user',
                text : 'Usuarios',
                menu: [
                {
                    text: 'Usuarios',
                    itemId: 'sys_user',
                    disabled: false,
                    iconCls: '',
                    action: 'musuarios'
                
                },
                {
                    text: 'Roles',
                    itemId: 'sys_roles',
                    disabled: false,
                    iconCls: '',
                    action: 'mroles'
                
                },
                {
                    text: 'Bitacora',
                    itemId: 'sys_bitacora',
                    disabled: false,
                    iconCls: '',
                    action: 'mbitacora'
                
                }],
               
            },{
                text: 'Salir',
                iconCls: 'disabled',
                handler: function(){
                    Ext.Ajax.request({
                        url: preurl + 'login/salir',
                        success: function(response){
                            window.location = preurl_js;
                        },
                        failure: function(){
                            target.setLoading(false);
                        }
                    });
                }
            },'-',{
                text: 'Mis Datos',
                iconCls: 'micuenta',
                handler: function(){
                    Ext.create('Infosys_web.view.CambioPass').show()
                }
            }
       
            ];
        
        this.callParent(arguments);
    }
});