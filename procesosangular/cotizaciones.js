    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.Estado = "P";
        $rootScope.fechaEstimadaTermino = new Date();
        $rootScope.ft = new Date(); 
        $rootScope.totalPAMs = 0;
        $rootScope.upOC   = true;
        $rootScope.tipoEstado = [
            {
                codEstado:"P",
                descripcion:"En Proceso"  
            },{
                codEstado:"T",
                descripcion:"Terminar Proceso"
            },{
                codEstado:"E",
                descripcion:"Volver a CAM"
            },{
                codEstado:"N",
                descripcion:"Anular Proceso"
            }
            ];
        $rootScope.tpEnsayo = "1";
        $rootScope.tipoEnsayo = [
            {
                codEnsayo:"1",
                descripcion:"Informe de Caracterización"
            },{
                codEnsayo:"2",
                descripcion:"Análisis de Falla"
            },{
                codEnsayo:"3",
                descripcion:"Certificado de Ensayos"
            }
            ,{
                codEnsayo:"4",
                descripcion:"Informe de Resultados"
            }
            ];
        $rootScope.correoInicioPAM  = "off";
        $rootScope.envios = [
            {
                codEnvio:"on",
                descripcionEnvio:"Si" 
            },{
                codEnvio:"off",
                descripcionEnvio:"No"
            }
            ];
        $rootScope.RAM              = '';
        $rootScope.usrCotizador     = '';
        $rootScope.usrResponzable   = '';
        $rootScope.oCompra          = false;
        $rootScope.oMail            = false; 
        $rootScope.oCtaCte          = false; 
        $rootScope.nOC              = '';

    });

    app.controller('CtrlCotizaciones', function($scope, $http) {


        const $archivos = document.querySelector("#archivos");
        $scope.fileName = $archivos;
        $scope.enviarFormulario = function (CAM) {
            let archivos = $archivos.files;
                if (archivos.length > 0) {
                    let formdata = new FormData();
    
                    // Agregar cada archivo al formdata
                    angular.forEach(archivos, function (archivo) {
                        formdata.append(archivo.name, archivo);
                    });
     
                    // Finalmente agregamos el nombre
                    formdata.append("CAM", $scope.CAM);
                    $scope.res = formdata;
     
                    // Hora de enviarlo
     
                    // Primero la configuración
                    let configuracion = {
                        headers: {
                            "Content-Type": undefined,
                        },
                        transformRequest: angular.identity,
                    };
                    // Ahora sí
                    $http
                        .post("guardar_archivos.php", formdata, configuracion) 
                        .then(function (respuesta) {
                            //console.log("Después de enviar los archivos, el servidor dice:", respuesta.data);
                            $scope.pdf = respuesta.data;
                        })
                        .catch(function (detallesDelError) {
                            //console.warn("Error al enviar archivos:", detallesDelError);
                            alert("Error al enviar archivos: "+ detallesDelError);
                        })
                } else {
                    alert("Rellena el formulario y selecciona algunos archivos");
                }
            };
        

/*
            $interval(function () {
                $scope.ConsultaEstado();
            }, 1000);
*/            
            $scope.Exito = false;
    
            $scope.ConsultaEstado = function(){
                $http.post('registroCotizaciones.php',{
                    accion:"ConsultaEstado"
                })
                .then(function (response) {
                    $scope.newCotizacion  = response.data.newCotizacion;
                    if(response.data.newCotizacion == 'on'){
                        $scope.Exito = true;
                        //$scope.CambiaEstado();
                    }
                });
            }

            $scope.CambiaEstado = function(){
                $http.post('registroCotizaciones.php',{
                    accion:"EstadoOff"
                })
                .then(function (response) {
                    $scope.leerCotizacionesCAM();
                    //$scope.leerCotizacionesPAM();
                    $scope.Exito = false;
                });
            }
                    

        $scope.lecturaUsuarios = function(){
            $scope.errors = "";
            $http.get("leerUsuarios.php")  
            .then(function(response){  
                $scope.Ingenieros = response.data.records; 
            }, function(error) {
                $scope.errors = error.message;
            });
        }
        $scope.leerCotizacionesCAM = function(){
            $scope.tablaCAM = false;
            $scope.cargaDatos = true;
            $scope.errors = "";
            $http.post("leerCAMs.php")   
            .then(function(response){  
                $scope.CotizacionesCAM = response.data.records;
                $scope.tablaCAM = true;
                $scope.cargaDatos = false;
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.getTotalCAMs = function(){
            var totalCAM = 0;
            for(var i = 0; i < $scope.CotizacionesCAM.length; i++){
                var x = $scope.CotizacionesCAM[i];
                //if(x.Moneda == 'U' && x.Estado == 'E'){
                if(x.Fan == 0){
                    if(x.Moneda == 'U'){
                        totalCAM += parseFloat(x.BrutoUF); 
                    }
                }
            }
            //$scope.tResultados = total;
            return totalCAM;
        }

        $scope.leerCotizacionesPAM = function(){
            $scope.tablaPAM = true;
            $scope.errors = "";
            $http.post("leerPAMs.php")   
            .then(function(response){  
                $scope.CotizacionesPAM = response.data.records;
                 $scope.tablaPAM = true;
            }, function(error) {
                $scope.errors = error.message;
            });
        }


        $scope.getTotalPAMs = function(){ 
            var totalPAM = 0;
            for(var i = 0; i < $scope.CotizacionesPAM.length; i++){
                var x = $scope.CotizacionesPAM[i];
                if(x.Fan == 0){
                    totalPAM += parseFloat(x.NetoUF);
                }
            }
            //$scope.tResultados = total;
            return totalPAM;
        }


        $scope.muestraTodos = function(usr){
            $scope.leerCotizacionesCAM();
            $scope.leerCotizacionesPAM();
        }
        $scope.calcularFechaEstimada = function(dHabiles, fechaAceptacion){
            $http.post("calcularFecha.php",{dHabiles:dHabiles, fechaAceptacion:fechaAceptacion})
            .then(function(response){
                $scope.fechaEstimadaTermino = new Date(response.data.fechaEstimadaTermino.replace(/-/g, '\/').replace(/T.+/, ''));
            }, function(error) {
                $scope.resFecha = error.message;
            });
        }
        $scope.calcularFechaEstimadaPAM = function(dHabiles, fechaInicio){
            //alert('Entra');
            $http.post("calcularFechaPAM.php",{dHabiles:dHabiles, fechaInicio:fechaInicio})
            .then(function(response){
                $scope.fechaEstimadaTermino = new Date(response.data.fechaEstimadaTermino.replace(/-/g, '\/').replace(/T.+/, ''));
            }, function(error) {
                $scope.resFecha = error.message;
            });
        }
        $scope.calcularDiasHabilesPAM = function(fechaEstimadaTermino, fechaInicio){
            $http.post("calculardHabilesPAM.php",{fechaEstimadaTermino:fechaEstimadaTermino, fechaInicio:fechaInicio})
            .then(function(response){
                //alert('Entra '+fechaEstimadaTermino+' '+fechaInicio);
                $scope.dHabiles = response.data.dHabiles;
            }, function(error) {
                $scope.resFecha = error.message;
                alert($scope.resFecha);
            });
        }

        $scope.filtroUsr = function(usr){ 
            $scope.filtroClientes = '';
            //$scope.filtroClientes = usr;
            $scope.tablaCAM = false;
            $scope.tablaPAM = false;
            $scope.cargaDatos = true;

            $scope.errors = ""; 
            $http.post("leerCAMs.php", {usrCotizador:usr})   
            .then(function(response){  
                $scope.CotizacionesCAM = response.data.records;
                $scope.tablaCAM = true;
            }, function(error) {
                $scope.errors = error.message;
            });
            // if(usr == 'Baja'){
            //     $scope.tablaPAM = false
            //     $scope.tablaCAM = false
            // }
            $scope.errors = "";
            $http.post("leerPAMs.php", {usrCotizador:usr})  
            .then(function(response){  
                $scope.CotizacionesPAM = response.data.records;
                $scope.tablaCAM = true;
                if(usr != 'Baja'){
                    $scope.tablaPAM = true
                }
    
            }, function(error) {
                $scope.errors = error.message;
            });
            $scope.cargaDatos = false;
        }

        $scope.lecturaUsuarios();
        $scope.leerCotizacionesCAM();
        $scope.leerCotizacionesPAM();

        $scope.verColorLinea = function(Estado, RAM, BrutoUF, nDias, rCot, fechaAceptacion, proxRecordatorio, colorCam){
            mColor = 'Blanco';
            retorno = {'default-color': true};
            if(Estado == 'E'){
                if(nDias <= 3){
                //if(nDias < 0){
                    retorno = {'rojo-class': true};
                    mColor = 'Rojo';
                }else{
                    retorno = {'amarillo-class': true};
                    mColor = 'Amarillo';
                }
            }
            if(RAM > 0){
                retorno = {'verde-class': true};
                mColor = 'Verde';
            }
           
            if(mColor == 'Rojo'){
                if(BrutoUF <= rCot){
                    retorno = {'verde-class': true};
                    mColor = 'Verde';
                }
            }

            if(proxRecordatorio == '0000-00-00'){
                retorno = {'verde-class': true};
                mColor = 'Verde';
            }


            if(Estado != 'E'){
                retorno = {'default-color': true};
                mColor = 'Blanco';
            }

            if(Estado == 'C'){
                retorno = {'azul-class': true};
                mColor = 'Azul';
            }


            /*
            if(colorCam == 'Blanco')    { retorno = {'default-color': true};    }
            if(colorCam == 'Rojo')      { retorno = {'rojo-class': true};       }
            if(colorCam == 'Amarilla')  { retorno = {'amarillo-class': true};   }
            if(colorCam == 'Verde')     { retorno = {'verde-class': true};      }
            */
            return retorno;
        }
        $scope.verColorLineaPAM = function(Estado, RAM, Fan, nDias, dhf, dha, rCot){
            mColor = 'Blanco';
            retorno = {'default-color': true};
            if(Estado == 'P' && nDias <= 1){
                if(nDias <= 0){
                    retorno = {'rojo-class': true};
                    mColor = 'Rojo';
                }else{
                    retorno = {'amarillo-class': true};
                    mColor = 'Amarillo';
                }
            }else{
                if(Estado == 'P'){
                    retorno = {'verde-class': true};
                    mColor = 'Verde';
                }
            }
            if(dhf > 0){ 
                if(dhf == 2 || dhf == 1){ 
                    retorno = {'amarillo-class': true};
                    mColor = 'Amarillo';
                }else{
                    retorno = {'verde-class': true};
                    mColor = 'Verde';
                }
            }
            if(dha > 0){ 
                retorno = {'rojo-class': true};
                mColor = 'Rojo';
            }
            if(Fan > 0){ 
                retorno = {'verdechillon-class': true};
                mColor = 'Clon';
            }
            
            return retorno;
        }


        // Seguimiento PAM
        $scope.seguimientoPAM = function(CAM, RAM){
            $scope.CAM = CAM;
            $scope.RAM = RAM;
            $http.post("leerSeguimientoCotizacion.php",{CAM:CAM})
                .then(function(response){

                    $scope.correoInicioPAM      = response.data.correoInicioPAM;
                    $scope.nOC                  = response.data.nOC;
                    $scope.RAM                  = response.data.RAM;
                    $scope.Fan                  = response.data.Fan;
                    $scope.usrCotizador         = response.data.usrCotizador; 
                    $scope.usrResponzable       = response.data.usrResponzable; 
                    $scope.tpEnsayo             = response.data.tpEnsayo;
                    $scope.Estado               = response.data.Estado;
                    $scope.usrPega              = response.data.usrPega;
                    $scope.Descripcion          = response.data.Descripcion;
                    $scope.dHabiles             = response.data.dHabiles;
                    $scope.Observacion          = response.data.Observacion;
                    $scope.RutCli               = response.data.RutCli;
                    $scope.Cliente              = response.data.Cliente;
                    $scope.Contacto             = response.data.Contacto;
                    $scope.fechaInicio          = new Date(response.data.fechaInicio.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaAceptacion      = new Date(response.data.fechaAceptacion.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaEstimadaTermino = new Date(response.data.fechaEstimadaTermino.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaTermino         = new Date(response.data.fechaTermino.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaPega            = new Date(response.data.fechaPega.replace(/-/g, '\/').replace(/T.+/, ''));
                    if(response.data.fechaTermino == '0000-00-00'){
                        $scope.fechaTermino = new Date();
                    }
                    $scope.leerUsrResponsable();
                    $scope.leerUsrPega();
                });           

        }
        $scope.volverCAM = function(CAM){
            $http.post('volverCAM.php', {
                                                    CAM:CAM
                        })
            .then(function (response) {
                $scope.resGuarda = 'OK';
                $scope.leerCotizacionesCAM()
                $scope.leerCotizacionesPAM()
            }, function(error) {
                $scope.resGuarda = 'No';
                $scope.errors = error.message;
            });
        }
        //Guardar Seguimiento
        $scope.separarRAM = function(CAM, RAM){
            $http.post('separaRAM.php', {
                                                    CAM:CAM, 
                                                    RAM:RAM
                        })
            .then(function (response) {
                $scope.resGuarda = 'OK';
                $scope.leerCotizacionesCAM()
                $scope.leerCotizacionesPAM()
            }, function(error) {
                $scope.resGuarda = 'No';
                $scope.errors = error.message;
            });
        }
        //$scope.guardaPAM = function(CAM, Fan, RAM, fechaEstimadaTermino, nOC, Estado, dHabiles, usrResponzable, tpEnsayo, fechaPega, usrPega, Descripcion){
        $scope.guardaPAM = function(CAM, Fan, RAM, fechaEstimadaTermino, nOC, Estado, dHabiles, usrResponzable, tpEnsayo){
            //alert('Entra '+fechaEstimadaTermino);
            if(RAM == null)     { RAM = 0;      }
            //if(Descripcion == null)     { Descripcion = '';      }
            $scope.resGuardaPAM = 'CAM '+CAM;
            //$scope.resGuardaPAM += ' Desc '+Descripcion;
/*            
            $scope.resGuardaPAM += ' RAM '+RAM;
            $scope.resGuardaPAM += ' Est '+Estado;
            $scope.resGuardaPAM += ' Ter '+fechaTermino;
            $scope.resGuardaPAM += ' Hab '+dHabiles;
            $scope.resGuardaPAM += ' nOC '+nOC;
            $scope.resGuardaPAM += ' Res '+usrResponzable; 
            $scope.resGuardaPAM += ' TP '+tpEnsayo;
            $scope.resGuardaPAM += ' usr '+usrPega;
*/
            //alert(' Res '+RAM);


            $http.post('grabarSeguimientoPAM.php', {
                                                    CAM:CAM, 
                                                    RAM:RAM,
                                                    Fan:Fan,
                                                    fechaEstimadaTermino:fechaEstimadaTermino,
                                                    nOC:nOC,
                                                    Estado:Estado,
                                                    dHabiles:dHabiles,
                                                    usrResponzable:usrResponzable,
                                                    tpEnsayo:tpEnsayo
                                                    //fechaPega:fechaPega,
                                                    //usrPega:usrPega,
                                                    //Descripcion:Descripcion
                        })
            .then(function (response) {
                $scope.resGuarda = 'OK';
                $scope.leerCotizacionesCAM()
                $scope.leerCotizacionesPAM()
            }, function(error) {
                $scope.resGuarda = 'No';
                $scope.errors = error.message;
            });


            $nOC                = '';
            $dHabiles           = 0;
            $tpEnsayo           = '';
            $usrPega            = '';
            $Descripcion        = '';

        }      


        // Fin Seguimiento PAM

        // Seguimiento
        $scope.editarSeguimiento = function(CAM){
            $scope.CAM = CAM;

            $http.post("leerSeguimientoCotizacion.php",{CAM:CAM})
                .then(function(response){
                    //alert('Entra');
                    $scope.correoInicioPAM      = response.data.correoInicioPAM;
                    $scope.nOC                  = response.data.nOC;
                    $scope.RAM                  = response.data.RAM;
                    $scope.Fan                  = response.data.Fan;
                    $scope.RAMdis               = response.data.RAM+'-'+response.data.Fan;
                    $scope.Rev                  = response.data.Rev;
                    $scope.Estado               = response.data.Estado;
                    $scope.usrCotizador         = response.data.usrCotizador;
                    $scope.dHabiles             = response.data.dHabiles;
                    $scope.usrResponzable       = response.data.usrResponzable;
                    $scope.tpEnsayo             = response.data.tpEnsayo;
                    $scope.contactoRecordatorio = response.data.contactoRecordatorio;
                    $scope.Observacion          = response.data.Observacion;
                    $scope.RutCli               = response.data.RutCli;
                    $scope.Cliente              = response.data.Cliente;
                    $scope.Contacto             = response.data.Contacto;
                    $scope.fechaAceptacion      = new Date(response.data.fechaAceptacion.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaEstimadaTermino = new Date(response.data.fechaEstimadaTermino.replace(/-/g, '\/').replace(/T.+/, ''));
                    if(response.data.fechaAceptacion == '0000-00-00'){
                        $scope.fechaAceptacion = new Date();
                    }

                    $scope.oCompra      = false;
                    if(response.data.oCompra == 'on'){
                        $scope.oCompra      = true;
                    }
                    $scope.oMail        = false;
                    if(response.data.oMail == 'on'){
                        $scope.oMail      = true;
                    }
                    $scope.oCtaCte      = false;
                    if(response.data.oCtaCte == 'on'){
                        $scope.oCtaCte      = true;
                    }
                    $scope.RAMasignada = false;
                    if(response.data.RAM> 0){
                        $scope.RAMasignada = true;
                    }
                    $scope.leerUsrCotizador();
                    $scope.leerUsrResponsable();
                    $scope.loadRamsDisponibles(response.data.RutCli);
                    $scope.leerSeguimientoCAM(CAM);
                    //$scope.apply();
                    //$scope.oCompra      = true;
                    //salert('Entra '+$scope.oCompra);
                }, function(error) {
                    $scope.errors = error.message;
                    alert('Error '+$scope.errors);
                });           
        }

        $scope.leerSeguimientoCAM = function(CAM){
            $http.post("leerSeguimientoCAMs.php", {CAM:CAM})  
            .then(function(response){  
                $scope.seguimientoCAM = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });

        }


        // Borrar
        $scope.editarBorrar = function(CAM){
            $scope.CAM = CAM;
            $http.post("leerSeguimientoCotizacion.php",{CAM:CAM})
                .then(function(response){

                    $scope.correoInicioPAM      = response.data.correoInicioPAM;
                    $scope.nOC                  = response.data.nOC;
                    $scope.RAM                  = response.data.RAM;
                    $scope.usrCotizador         = response.data.usrCotizador;
                    $scope.dHabiles             = response.data.dHabiles;
                    $scope.usrResponzable       = response.data.usrResponzable;
                    $scope.tpEnsayo             = response.data.tpEnsayo;
                    $scope.contactoRecordatorio = response.data.contactoRecordatorio;
                    $scope.Observacion          = response.data.Observacion;
                    $scope.RutCli               = response.data.RutCli;
                    $scope.Cliente              = response.data.Cliente;
                    $scope.Contacto             = response.data.Contacto;
                    $scope.fechaAceptacion      = new Date(response.data.fechaAceptacion.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaEstimadaTermino = new Date(response.data.fechaEstimadaTermino.replace(/-/g, '\/').replace(/T.+/, ''));
                    if(response.data.fechaAceptacion == '0000-00-00'){
                        $scope.fechaAceptacion = new Date();
                    }

                    $scope.oCompra      = false;
                    if(response.data.oCompra == 'on'){
                        $scope.oCompra      = true;
                    }
                    $scope.oMail        = false;
                    if(response.data.oMail == 'on'){
                        $scope.oMail      = true;
                    }
                    $scope.oCtaCte      = false;
                    if(response.data.oCtaCte == 'on'){
                        $scope.oCtaCte      = true;
                    }
                    $scope.RAMasignada = false;
                    if(response.data.RAM> 0){
                        $scope.RAMasignada = true;
                    }
                    $scope.leerUsrCotizador();
                    $scope.leerUsrResponsable();
                    $scope.loadRamsDisponibles(response.data.RutCli);
                    //$scope.apply();
                    //$scope.oCompra      = true;
                    //salert('Entra '+$scope.oCompra);
                });           
        }

        $scope.cerrarCAM = function(CAM, Observacion){
            //alert(Observacion);
            $http.post("cerrarCAM.php",{
                                        CAM:CAM,
                                        Observacion: Observacion
                                    })
            .then(function(response){  
                $scope.leerCotizacionesCAM()
                $scope.leerCotizacionesPAM() 
                //alert('Cerrada');
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.leerUsrCotizador = function() {
            $http.post("leerUsuarios.php")  
            .then(function(response){  
                $scope.data = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        };
        $scope.leerUsrResponsable = function() {
            $http.post("leerUsuarios.php")  
            .then(function(response){  
                $scope.dataResponsable = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        };
        $scope.leerUsrPega = function() {
            $http.post("leerUsuarios.php")  
            .then(function(response){  
                $scope.dataPega = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        };
        $scope.loadRamsDisponibles = function(rut){
            $scope.res = rut;
            $scope.RAMdisponibles = false;
            $http.post("leerRegistroMateriales.php",{RutCli:rut})  
            .then(function(response){  
                $scope.RAMs = response.data.records;
                console.log($scope.RAMs);
                $scope.RAMdisponibles = true;
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        //Guardar Seguimiento
        $scope.guardaCAMPAM = function(CAM, RAM, RAMdis, usrCotizador, usrResponzable, fechaEstimadaTermino, fechaAceptacion, nOC, oCompra, oMail, oCtaCte, correoInicioPAM, tpEnsayo, NewcontactoRecordatorio, Observacion, Estado, dHabiles, Rev){
            if(RAMdis == null)  { 
                RAMdis = 0;  
            }else{
                if(RAMdis > 0){ RAM = RAMdis; }
            }
            if(RAM == null)     { RAM = 0;      }
            if(NewcontactoRecordatorio == null ){ NewcontactoRecordatorio = ''; }
            if(Observacion == null ){ Observacion = ''; }

            $scope.resGuarda = 'CAM '+CAM;
            $scope.resGuarda += ' RAM '+RAM;
            $scope.resGuarda += ' RAMd '+RAMdis;
            //$scope.resGuarda += ' Cot '+usrCotizador;
            //$scope.resGuarda += ' Res '+usrResponzable;
            //$scope.resGuarda += ' Est '+fechaEstimadaTermino;
            //$scope.resGuarda += ' Ace '+fechaAceptacion;
            //$scope.resGuarda += ' nOC '+nOC;
            //$scope.resGuarda += ' OC '+oCompra;
            //$scope.resGuarda += ' OMail '+oMail;
            //$scope.resGuarda += ' oCta '+oCtaCte;
            $scope.resGuarda += ' Ini '+correoInicioPAM;
            $scope.resGuarda += ' Ens '+tpEnsayo;
            $scope.resGuarda += ' Cont '+ NewcontactoRecordatorio;
            $scope.resGuarda += ' Obs '+ Observacion;

            //alert(RAMdis+' '+$scope.RAM);

            if(parseInt(RAMdis) > 0){
                console.log('RAM Dis'+RAMdis);
            }
            if(RAM > 0){
                RAMdis = RAM+'-'+$scope.Fan;
                console.log('RAM DIS 2'+RAMdis);
            }
            // console.log('RAM dis 3'+RAMdis);


            $http.post('grabarSeguimientoCAMPAM.php', { 
                                                    CAM:$scope.CAM, 
                                                    RAM:RAM,
                                                    RAMdis:RAMdis,
                                                    Rev:Rev,
                                                    usrCotizador:usrCotizador,
                                                    usrResponzable:usrResponzable,
                                                    fechaEstimadaTermino:fechaEstimadaTermino,
                                                    correoInicioPAM:correoInicioPAM,
                                                    fechaAceptacion:fechaAceptacion,
                                                    nOC:nOC,
                                                    oCompra:oCompra,
                                                    oMail:oMail,
                                                    oCtaCte:oCtaCte,
                                                    tpEnsayo:tpEnsayo,
                                                    NewcontactoRecordatorio:NewcontactoRecordatorio,
                                                    Observacion:Observacion,
                                                    Estado:Estado,
                                                    dHabiles:dHabiles
                        })
            .then(function (response) {
                $scope.resGuarda = 'OK';
                $scope.leerCotizacionesCAM() 
                $scope.leerCotizacionesPAM()
                if(correoInicioPAM == 'on'){
                    $scope.enviarCorreo(CAM, RAM);
                }
                
                // window.open("formularios/iCAMArchiva.php?CAM="+$scope.CAM+'&Rev=0&Cta=0&accion=Reimprime');
                window.location.href("formularios/iCAMArchiva.php?CAM="+$scope.CAM+'&Rev=0&Cta=0&accion=Reimprime');
                // $location.url("www.google.com/");
            }, function(error) {
                $scope.resGuarda = 'No';
                $scope.errors = error.message;
            });
         
            $scope.oCompra  = false; 
            $scope.oMail    = false;
            $scope.oCtaCte  = false;
            $contactoRecordatorio = '';
            $Observacion = '';

        }
        $scope.guardaCAM = function(CAM, RAM, RAMdis, usrCotizador, usrResponzable, fechaEstimadaTermino, fechaAceptacion, nOC, oCompra, oMail, oCtaCte, correoInicioPAM, tpEnsayo, NewcontactoRecordatorio, Observacion, Estado, dHabiles, Rev){
            if(RAMdis == null)  { 
                RAMdis = 0;  
            }else{
                if(RAMdis > 0){ RAM = RAMdis; }
            }
            if(RAM == null)     { RAM = 0;      }
            if(NewcontactoRecordatorio == null ){ NewcontactoRecordatorio = ''; }
            if(Observacion == null ){ Observacion = ''; }

            $scope.resGuarda = 'CAM '+CAM;
            $scope.resGuarda += ' RAM '+RAM;
            $scope.resGuarda += ' RAMd '+RAMdis;
            //$scope.resGuarda += ' Cot '+usrCotizador;
            //$scope.resGuarda += ' Res '+usrResponzable;
            //$scope.resGuarda += ' Est '+fechaEstimadaTermino;
            //$scope.resGuarda += ' Ace '+fechaAceptacion;
            //$scope.resGuarda += ' nOC '+nOC;
            //$scope.resGuarda += ' OC '+oCompra;
            //$scope.resGuarda += ' OMail '+oMail;
            //$scope.resGuarda += ' oCta '+oCtaCte;
            $scope.resGuarda += ' Ini '+correoInicioPAM;
            $scope.resGuarda += ' Ens '+tpEnsayo;
            $scope.resGuarda += ' Cont '+ NewcontactoRecordatorio;
            $scope.resGuarda += ' Obs '+ Observacion;

            //alert('Entra...'+RAMdis+' RAM...'+RAM+'-'+$scope.Fan);
            if(parseInt(RAMdis) > 0){
                console.log(RAMdis);
            }
            if(RAM > 0){
                RAMdis = RAM+'-'+$scope.Fan;
                console.log(RAMdis);
            }
            // console.log(RAMdis);


            $http.post('grabarSeguimientoCAM.php', { 
                                                    CAM:$scope.CAM, 
                                                    RAM:RAM,
                                                    RAMdis:RAMdis,
                                                    Rev:Rev,
                                                    usrCotizador:usrCotizador,
                                                    usrResponzable:usrResponzable,
                                                    fechaEstimadaTermino:fechaEstimadaTermino,
                                                    correoInicioPAM:correoInicioPAM,
                                                    fechaAceptacion:fechaAceptacion,
                                                    nOC:nOC,
                                                    oCompra:oCompra,
                                                    oMail:oMail,
                                                    oCtaCte:oCtaCte,
                                                    tpEnsayo:tpEnsayo,
                                                    NewcontactoRecordatorio:NewcontactoRecordatorio,
                                                    Observacion:Observacion,
                                                    Estado:Estado,
                                                    dHabiles:dHabiles
                        })
            .then(function (response) {
                $scope.resGuarda = 'OK';
                $scope.leerCotizacionesCAM()
                $scope.leerCotizacionesPAM()
                if(correoInicioPAM == 'on'){
                    $scope.enviarCorreo(CAM, RAM);
                }
                //$location.url("www.google.com/");
            }, function(error) {
                $scope.resGuarda = 'No';
                $scope.errors = error.message;
            });
            
            $scope.oCompra  = false;
            $scope.oMail    = false;
            $scope.oCtaCte  = false;
            $contactoRecordatorio = '';
            $Observacion = '';

        }    

        $scope.enviarCorreo = function(CAM, RAM){
            //alert(CAM+' '+RAM);
            $http.post('enviarCorreoEstadoServicio.php', {
                                                    CAM:CAM, 
                                                    RAM:RAM
                        })
            .then(function (response) {
                //window.location.url("https://simet.cl/erp/cotizaciones/enviar.php");
                //window.open('https://simet.cl/erp/cotizaciones/enviar.php');
                $scope.destinatario = '';
                $scope.RAM                  = response.data.RAM;
                $scope.CAM                  = response.data.CAM;
                $scope.mail_destinatario    = response.data.mail_destinatario;
                $scope.emailCotizador       = response.data.emailCotizador;
                $scope.Cliente              = response.data.Cliente;
                $scope.fInicio              = new Date(response.data.fInicio.replace(/-/g, '\/').replace(/T.+/, ''));
                $scope.fTermino             = new Date(response.data.fTermino.replace(/-/g, '\/').replace(/T.+/, ''));
                fInicio = $scope.fInicio;
                $scope.horaPAM              = response.data.horaPAM;
                $scope.Descripcion          = response.data.Descripcion;
                //window.open('https://simet.cl/erp/cotizaciones/enviarCorreo2.php?mail_destinatario='+response.data.mail_destinatario+'&Cliente='+response.data.Cliente+'&RAM='+RAM+'&CAM='+CAM+'&fInicio='+fInicio+'&horaPAM='+response.data.horaPAM+'&fTermino='+$scope.fTermino+'&emailCotizador='+response.data.emailCotizador+'&Descripcion='+response.data.Descripcion);
                window.open('plataformaCotizaciones.php?enviarCorreo=SI&CAM='+$scope.CAM+'&RAM='+RAM);
            }, function(error) {
                $scope.errors = error.message;
                alert($scope.errors);
            });

        }

        $scope.cambiaCotizador = function(){
            $scope.usrCotiza = $scope.usrCotizador;
        }
        // Fin Seguimiento

        // CREAR COTIZACIÓN
        $scope.leerClientes = function() {
            $scope.Cliente = "";
            $scope.Contacto = "";
            $http.post("leerClientes.php")  
            .then(function(response){  
                $scope.dataClientes = response.data.records;
                $scope.fechaCotizacion = new Date();
            }, function(error) {
                $scope.errors = error.message;
            });
        };
        $scope.leerClientes();
        $scope.leerContacto = function() {
            $scope.resCli = 'Cliente '+$scope.Cliente;
            $http.post("leerContactos.php")  
            .then(function(response){  
                $scope.dataContactos = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        };

        $scope.cargarContactos = function(){
            alert('Cliente '+$scope.Cliente);
        }



        $scope.restablecerCAM = function(CAM){
            // alert('Restablecer ...'+CAM);
            $http.post("dataPlataformaErp.php", {
                CAM     : CAM,
                accion  : "revivirCAM"
            })  
            .then(function(response){  
                alert('Se restablecio CAM '+CAM);
                $scope.filtroClientes = CAM;
                window.location.href = 'plataformaCotizaciones.php';
            }, function(error) {
                $scope.errors = error.message;
                alert($scope.errors);
            });

        }

        $scope.loadRegistro = function(CAM){
            $scope.CAM = CAM;
            $http.post("controlRegistros.php", {CAM:CAM})  
            .then(function(response){  
                $scope.Cliente  = response.data.Cliente;
                $scope.HES      = response.data.HES; 
                $scope.RAM      = response.data.RAM;
                if($scope.RAM > 0) {
                    $scope.muestraRAM = true;
                }
            }, function(error) {
                $scope.errors = error.message;
            });

        }
        // FIN CREAR COTIZACIÓN
    });
