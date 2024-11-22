var mDatos = angular.module('myApp', []);
mDatos.controller('controlOfe', function($scope, $http){

    $scope.CodInforme = '';
    $scope.OFE = '';
    $scope.swOFE = false;

    $scope.imprimirrrrr = function(CodInforme){
        $http.post('accionesInformes.php', {CodInforme:CodInforme})
        .then(function (response) {
             alert('Generado');
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
         });
    }

    $scope.imprimeOFE = function(){
        $http.post('accionesOFE.php', {
                                                OFE:$scope.OFE
                                            })
        .then(function (response) {
            $scope.resGuarda = 'OK';
            $scope.swOFE = true;

        }, function(error) {
            $scope.resGuarda = 'No';
            $scope.errors = error.message;
            alert(error.message);
        });
    }


});
