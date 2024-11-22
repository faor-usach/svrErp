var app = angular.module('myApp', []);
app.run(function($rootScope){
    $rootScope.CodInforme           = 'AM';
    $rootScope.Otam                 = '';
    $rootScope.usrResponzable       = '';
    $rootScope.tpoProx              = 0;
    $rootScope.tpoAvisoAct          = 0;
    $rootScope.Actividad            = '';
    $rootScope.actRepetitiva        = true;
    $rootScope.respaldoEnsayo       = false;
    $rootScope.Acreditado           = false; 
    $rootScope.msg                  = false;
    $rootScope.requeridaActividad   = true;
    $rootScope.prgActividad         = new Date();
    $rootScope.fechaProxAct         = new Date();
    $rootScope.mostrarValImpacto    = true;

});

app.controller('CtrlQuimicos', function($scope, $http) {

    $scope.Exito = false;

});

