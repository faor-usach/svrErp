    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.muestraBotones       = false;
        $rootScope.Situacion            = 0;
        $rootScope.RutCli               = '';
        $rootScope.Cliente              = '';
        $rootScope.Direccion            = '';
        $rootScope.CodigoVerificacion   = '';
        $rootScope.desabilitar          = false;
        $rootScope.habilitar            = false;

        $rootScope.fechaCertificado     = new Date();
        $rootScope.tipoHes = [
            {
                codHes:"on",
                descripcion:"Requiere HES" 
            },{
                codHes:"off",
                descripcion:"Sin HES"
            }
            ];

    });
    app.controller('CtrlClientes', function($scope, $http)  { 
        $scope.leerClientes = function(){  
            $http.get("leerCli.php")
            .then(function (response) {$scope.dataCli = response.data.records;});        
        };
        $scope.leerClientes();

        $scope.leerInformesAsociados = function(Rut){ 
            //alert(Rut);
            $http.post("leerInfo.php",{
                                        RutCli  : Rut 
            }).then(function (response) { 
                $scope.dataInfo = response.data.records;
            }, function(error) {
                alert(error);
            });        
        };

        $scope.loadDataCertificado = function(na){
            $scope.nAcero = na;
                $http.post("leerDatoCertificado.php",{
                        nAcero   :   na, 
                        accion      :   'L'})
                    .then(function(response){
                        $scope.nAcero            = response.data.nAcero;
                        $scope.Acero             = response.data.Acero;
                        $scope.Estado               = response.data.Estado;
                        if($scope.Estado == 'on'){
                            $scope.desabilitar      = true;
                            $scope.habilitar        = false;
                        }else{
                            $scope.desabilitar      = false;
                            $scope.habilitar        = true;
                        }
                
                        $scope.muestraBotones       = true;
                }, function(error) {
                    $scope.errors = error.message;
                    $scope.rutRes = error;
                });
        }

        $scope.mostrarQR = function(CodInforme){
            //alert(CodInforme);
            $http.post("leerDatoCertificado.php",{
                CodInforme      :   CodInforme, 
                CodCertificado  :   $scope.CodCertificado, 
                accion:'rescataCodigos'
            })
            .then(function(response){
                $scope.CodigoVerificacionAM   = response.data.CodigoVerificacion;
                $scope.idMuestra              = response.data.idMuestra;
                $scope.imgQR                  = response.data.imgQR;
        }, function(error) {
            $scope.errors = error.message;
            $scope.rutRes = error;
        });
}

        $scope.upCertificado = function(){
                $http.post("upLoadCertificado.php",{CodCertificado:$scope.CodCertificado, pdf:$scope.pdf, accion:'L'})
                    .then(function(response){
                      alert('Certificado en la nuve...');  
                      //$location.url("https://simet.cl/certificados/certificados/leerbd.php");
                }, function(error) {
                    $scope.errors = error.message;
                    $scope.rutRes = error;
                });
        }
        
        $scope.guardarDatosCertificado = function(){
            Grabar = true;
            nAcero = $scope.nAcero;
            // alert($scope.Acero);
            $http.post("leerDatoCertificado.php",{
                                                    nAcero   : nAcero, 
                                                    Acero    : $scope.Acero, 
                                                    accion:'G'
                                               })
            .then(function(response){
                    $scope.rutRes = 'Registro grabado...'+nAcero+' '+$scope.Acero;
                    $scope.muestraBotones = true;
                    $scope.loadDataCertificado(nAcero);
            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });
            
        }
        $scope.desabilitarDatos = function(){
            $http.post("leerDatoCertificado.php",{
                                                nAcero   : $scope.nAcero, 
                                                accion:'D'
                                            })
            .then(function(response){
                    //$scope.rutRes = 'Deshabilitado el registro...';
                    $scope.loadDataCertificado($scope.nAcero);
            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });
        }


        $scope.habilitarDatos = function(){
            //alert($scope.RutCli);
            $http.post("leerDatoCertificado.php",{
                                                nAcero   :   $scope.nAcero, 
                                                accion:'H'
                                            })
                .then(function(response){
                    $scope.rutRes = 'Habilitado...';
                    $scope.loadDataCertificado($scope.nAcero);
            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });
        }


        const $archivos = document.querySelector("#archivos");
        $scope.fileName = $archivos;
        $scope.enviarFormulario = function () { 
        let archivos = $archivos.files;
            if (archivos.length > 0) {
                let formdata = new FormData();

                // Agregar cada archivo al formdata
                angular.forEach(archivos, function (archivo) {
                    formdata.append(archivo.name, archivo);
                });
 
                // Finalmente agregamos el nombre
                formdata.append("CodCertificado", $scope.CodCertificado);
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

        $scope.msgActivacion = function(){
            alert('Se activado Certificado en el sitio web...');
        }


    });
