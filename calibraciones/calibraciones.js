    var app = angular.module('myApp', []);
    app.controller('TodoCtrl', function($scope, $http) {
        $http.post("obtenerCalibraciones.php")  
        .then(function(res){ 
            $scope.calA = res.data.calA; 
            $scope.calB = res.data.calB;
            $scope.EquilibrioX = res.data.EquilibrioX;
            $scope.calC = res.data.calC;
            $scope.calD = res.data.calD;
        }, function(res){
            $scope.datResp = 'Error';
        })  
        $scope.guardarNewQu = function(Simbolo, valorDefecto, imprimible){
            $scope.resNew = $scope.idEnsayo+' '+$scope.tpMuestra;
            $http.post('guardarSimbolo.php',{
                                            idEnsayo:$scope.idEnsayo, 
                                            tpMuestra:$scope.tpMuestra, 
                                            sQuimico:Simbolo,
                                            vDefecto:valorDefecto, 
                                            Imprime:imprimible 
                                        })
            .then(function (res) {
                loadQuimicoAceros($scope.idEnsayo, $scope.tpMuestra);
                loadQuimicoCobre($scope.idEnsayo, $scope.tpMuestra);
                loadQuimicoAluminio($scope.idEnsayo, $scope.tpMuestra);
            });
        }
        $scope.agregarQu = function(e, m){
            $scope.idEnsayo     = e;
            $scope.tpMuestra    = m;
            $scope.Simbolo      = '';
            $scope.valorDefecto = '<';
            $scope.imprimible   = 'on';
        }
        $scope.guardarQu = function(e, m, s, v, i){
            $http.post('guardarSimbolo.php',{
                                            idEnsayo:e, 
                                            tpMuestra:m, 
                                            sQuimico:s,
                                            vDefecto:v, 
                                            Imprime:i 
                                        })
            .then(function (res) {
                $scope.resQu = 'Ok';
            });
        }
        $scope.estadoOnOff = function(e, m, s, v, i){
            $http.post('guardarSimbolo.php',{
                                            idEnsayo:e, 
                                            tpMuestra:m, 
                                            sQuimico:s,
                                            vDefecto:v, 
                                            Imprime:i 
                                        })
            .then(function (res) {
                loadQuimicoAceros(e, m);
                loadQuimicoCobre(e, m);
                loadQuimicoAluminio(e, m);
            });
        }
        $scope.guardar = function(){
            $http.post('guardarCalibraciones.php',{
                                            calA:$scope.calA, 
                                            calB:$scope.calB, 
                                            EquilibrioX:$scope.EquilibrioX,
                                            calC:$scope.calC, 
                                            calD:$scope.calD 
                                        })
            .then(function (res) {
                $scope.msgGraba = true;
                $scope.datResp="Registro grabado exitosamente...";
            });
        }
        function loadQuimicoAceros(q, a){ 
            $http.get("leerTablaQuAc.php")
            .then(function (response) {$scope.namesAc = response.data.records;}); 
        }  
        function loadQuimicoCobre(q, a){ 
            $http.get("leerTablaQuCo.php")
            .then(function (response) {$scope.namesCo = response.data.records;}); 
        }  
        function loadQuimicoAluminio(q, a){ 
            $http.get("leerTablaQuAl.php")
            .then(function (response) {$scope.namesAl = response.data.records;}); 
        }  
        loadQuimicoAceros("Qu", "Ac");
        loadQuimicoCobre("Qu", "Co");
        loadQuimicoAluminio("Qu", "Co");
    });
