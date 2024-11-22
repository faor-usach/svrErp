var mDatos = angular.module('myApp', []);
mDatos.controller('controlInformes', function($scope, $http){ 

    $scope.CodInforme           = '';
    $scope.CodCertificado       = '';
    $scope.tpEnsayo             = '';
    $scope.btnInformeOficial    = false; 
    $scope.btnOtrosEnsayos      = false;
    $scope.certConformidad      = false;


    $scope.editarInforme = function(CodInforme){ 
        //alert(CodInforme);
        $http.post('moduloInformes.php', { 
                                        CodInforme  :   CodInforme,
                                        accion      :   "leerData"
                                        })
        .then(function (response) {
            $scope.RAMA                 = response.data.RAMA;
            $scope.RutCli               = response.data.RutCli;
            $scope.CodInforme           = response.data.CodInforme;
            $scope.CodCertificado       = response.data.CodCertificado;
            $scope.tpEnsayo             = response.data.tpEnsayo;
            $scope.Cliente              = response.data.Cliente;
            $scope.Direccion            = response.data.Direccion;
            $scope.nMuestras            = response.data.nMuestras;
            $scope.tipoMuestra          = response.data.tipoMuestra;
            $scope.amEnsayo             = response.data.amEnsayo;
            $scope.Contacto             = response.data.Contacto;
            $scope.tpEnsayo             = response.data.tpEnsayo;
            $scope.fechaInforme         = new Date(response.data.fechaInforme.replace(/-/g, '\/').replace(/T.+/, ''));
            $scope.fechaRecepcion       = new Date(response.data.fechaRecepcion.replace(/-/g, '\/').replace(/T.+/, ''));
            $scope.leerMuestras(response.data.CodInforme);

            if($scope.tpEnsayo == '5'){
                $scope.btnInformeOficial    = true;
                $scope.certConformidad      = true;
                
                $scope.leerCertificadosConformidad($scope.tpEnsayo, $scope.CodCertificado, $scope.RutCli);
                
            }else{
                $scope.btnOtrosEnsayos      = true;
                $scope.certConformidad      = false;
            }
        }, function(error) {
            $scope.resGuarda = 'No';
            $scope.errors = error.message;
            alert('Error... '+error);
        });
    }

    $scope.leerMuestras = function(CodInforme){
        //alert(CodInforme);
        
        $http.post('moduloInformes.php', {
                                        CodInforme  :   CodInforme,
                                        accion      :   "leerMuestras"
                                        })
        .then(function (response) {
            $scope.dataMuestras = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });
    
    }

    


    $scope.guardaramEnsayo = function(){
        $http.post('moduloInformes.php', {
                                        CodInforme  :   $scope.CodInforme,
                                        amEnsayo    :   $scope.amEnsayo,
                                        accion      :   "guardaramEnsayo"
                                        })
        .then(function (response) {
            //$scope.dataMuestras = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });

    }

    $scope.guardarTipoMuestra = function(){
        $http.post('moduloInformes.php', {
                                        CodInforme  :   $scope.CodInforme,
                                        tipoMuestra :   $scope.tipoMuestra,
                                        accion      :   "guardarTipoMuestra"
                                        })
        .then(function (response) {
            //$scope.dataMuestras = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });

    }
    $scope.guardarfechaRecepcion = function(){
        $http.post('moduloInformes.php', {
                                        CodInforme      :   $scope.CodInforme,
                                        fechaRecepcion  :   $scope.fechaRecepcion,
                                        accion          :   "guardarfechaRecepcion"
                                        })
        .then(function (response) {
            //$scope.dataMuestras = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });

    }
    $scope.guardarfechaInforme = function(){
        $http.post('moduloInformes.php', {
                                        CodInforme      :   $scope.CodInforme,
                                        fechaInforme    :   $scope.fechaInforme,
                                        accion          :   "guardarfechaInforme"
                                        })
        .then(function (response) {
            //$scope.dataMuestras = response.data.records;
        }, function(error) {
            $scope.errors = error.message; 
            alert(error.message);
        });

    }
    $scope.guardarnMuestras = function(){
        $http.post('moduloInformes.php', {
                                        CodInforme      :   $scope.CodInforme,
                                        nMuestras       :   $scope.nMuestras,
                                        accion          :   "guardarnMuestras"
                                        })
        .then(function (response) {
            //$scope.dataMuestras = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });

    }

    $scope.verificaInforme = function(){
        //alert('Informe '+$scope.tpEnsayo);
        $http.post('moduloInformes.php', {
                                        CodInforme  :   $scope.CodInforme,
                                        tpEnsayo    :   $scope.tpEnsayo,
                                        accion      :   "guardartpEnsayo"
                                        })
        .then(function (response) {
            //$scope.dataMuestras = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });

        if($scope.tpEnsayo == 5){
            $scope.certConformidad      = true;
            $scope.btnInformeOficial    = true;
            $scope.btnOtrosEnsayos      = false;
        }else{
            $scope.certConformidad      = false;
            $scope.btnInformeOficial    = false;
            $scope.btnOtrosEnsayos      = true;
        }
    }

    $scope.mostrarQR = function(CodCertificado, CodInforme){
        //alert(CodCertificado+' '+CodInforme);
        $http.post('moduloInformes.php', {
                                        CodInforme      :   $scope.CodInforme,
                                        CodCertificado  :   $scope.CodCertificado,
                                        accion          :   "mostrarQR"
                                        })
        .then(function (response) {
            //$scope.dataCertificados = response.data.records;
        }, function(error) {
            $scope.resGuarda = 'No';
            $scope.errors = error.message;
            alert(error.message);
        });

    }


    $scope.leerCertificadosConformidad = function(tpEnsayo, CodCertificado, RutCli){
        //alert('Tipo Ensayo '+$scope.RutCli+' '+RutCli);
        if($scope.tpEnsayo == 5){
            $http.post('moduloInformes.php', {
                                            RutCli          :   $scope.RutCli,
                                            CodInforme      :   $scope.CodInforme,
                                            accion          :   "leerCertificadoConformidad"
                                            })
            .then(function (response) {
                $scope.dataCertificados = response.data.records;
            }, function(error) {
                $scope.resGuarda = 'No';
                $scope.errors = error.message;
                alert('Error... '+error.message);
            });
        }
    }

    //$scope.leerCertificadosConformidad();

    $scope.leerEnsayos = function(){
        $http.post('moduloInformes.php', {
                                        CodInforme  :   CodInforme,
                                        accion      :   "leerEnsayos"
                                        })
        .then(function (response) {
            $scope.dataEnsayos = response.data.records;
        }, function(error) {
            $scope.resGuarda = 'No';
            $scope.errors = error.message;
            alert(error.message);
        });
    }

    $scope.leerEnsayos();

    $scope.imprimirrrrr = function(CodInforme){
        $http.post('accionesInformes.php', {CodInforme:CodInforme})
        .then(function (response) {
             alert('Generado');
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
         });
    }

    $scope.imprimir = function(c){ 
        //alert($scope.CodInforme);
        $http.post('accionesInformes.php', {
                                                CodInforme:$scope.CodInforme
                                            })
        .then(function (response) {
            $scope.resGuarda = 'OK';
        }, function(error) {
            $scope.resGuarda = 'No';
            $scope.errors = error.message;
            alert(error.message);
        });
    }


});
