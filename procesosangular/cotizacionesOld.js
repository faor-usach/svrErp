    var app = angular.module('myApp', []);
    app.controller('CtrlCotizaciones', function($scope, $http) {

        $scope.verRangos = function(){
            $scope.errors = "";
            $http.get("leerRangos.php")   
            .then(function(response){  
                $scope.indMin   = response.data.indMin;
                $scope.indMeta  = response.data.indMeta;
                $scope.rCot     = response.data.rCot;
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.verRangos();

        $scope.lecturaUsuarios = function(){
            $scope.errors = "";
            $http.get("leerUsuarios.php")  
            .then(function(response){  
                $scope.Ingenieros = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.lecturaUsuarios();

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

        $scope.leerCotizacionesCAM();

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

        $scope.leerCotizacionesPAM();

        $scope.muestraTodos = function(usr){
            $scope.leerCotizacionesCAM();
            $scope.leerCotizacionesPAM();
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
            }, function(error) {
                $scope.errors = error.message;
            });
            if(usr == 'Baja'){
                $scope.tablaPAM = false
            }
            $scope.errors = "";
            $http.post("leerPAMs.php", {usrCotizador:usr})  
            .then(function(response){  
                $scope.CotizacionesPAM = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
            $scope.cargaDatos = false;
            $scope.tablaCAM = true;
            if(usr != 'Baja'){
                $scope.tablaPAM = true
            }
        }

        $scope.verColorLinea = function(Estado, RAM, BrutoUF, nDias, rCot){
            mColor = 'Blanco';
            retorno = {'default-color': true};
            if(Estado == 'E'){
                if(nDias <= 3){
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
            if(Estado != 'E'){
                retorno = {'default-color': true};
                mColor = 'Blanco';
            }
            if(Estado == 'C'){
                retorno = {'azul-class': true};
                mColor = 'Azul';
            }
            
            //return {'default-color': false, 'amarillo-class': false, 'verde-class': true, 'rojo-class': false};
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
            
            //return {'default-color': false, 'amarillo-class': false, 'verde-class': true, 'rojo-class': false};
            return retorno;
        }

        $scope.editarSeguimiento = function(CAM){
            
            $scope.tpEnsayo = "1";
            $scope.tipoEnsayo = [
                {
                    codEnsayo:"1",
                    descripcion:"Caracterización"
                },{
                    codEnsayo:"2",
                    descripcion:"Análisis de Falla"
                }
                ];

            $scope.correoInicioPAM  = "off";
            $scope.envios = [
                {
                    codEnvio:"on",
                    descripcionEnvio:"Si"
                },{
                    codEnvio:"off",
                    descripcionEnvio:"No"
                }
                ];


            $scope.CAM = CAM;
            $scope.RAM              = '';
            $scope.usrCotizador     = '';
            $scope.usrResponzable   = '';
            $scope.oCompra          = false;
            $scope.oMail            = false;
            $scope.oCtaCte          = false; 
            $scope.nOC              = '';
            
            $scope.leerUsrCotizador();
            $scope.leerUsrResponsable();

            $http.post("leerSeguimientoCotizacion.php",{CAM:CAM})
            .then(function(response){  
                $scope.correoInicioPAM      = response.data.correoInicioPAM;
                $scope.nOC                  = response.data.nOC;
                $scope.RAM                  = response.data.RAM;
                $scope.usrCotizador         = response.data.usrCotizador;
                $scope.usrResponzable       = response.data.usrResponzable;
                $scope.tpEnsayo             = response.data.tpEnsayo;
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
                $scope.loadRamsDisponibles(response.data.RutCli);
                $scope.apply();
            });
        }
        $scope.asignaRAM = function(){
            $scope.RAM = $scope.RAMdi;
            $scope.RAMasignada = false;
        }
        $scope.guardaCAM = function(RAM, RAMnew, usrCotizador, usrResponzable, correoInicioPAM, fechaEstimadaTermino){
            if(RAMnew > 0){
                RAM = RAMnew;
            }
            $scope.RAM = RAM;
/*            
            $http.post('grabarSeguimientoCAM.php', {
                                                    CAM:$scope.CAM, 
                                                    RAM:RAM,
                                                    RutCli:RutCli,
                                                    oCompra:oCompra,
                                                    oMail:oMail,
                                                    oCtaCte:oCtaCte,
                                                    fechaAceptacion:new Date(fechaAceptacion),
                                                    nOC:nOC
                        })
            .then(function (response) {
                $scope.resGuarda = $scope.CAM+' '+RAMnew+' '+usrCotizador+' '+usrResponzable+' '+correoInicioPAM+' '+fechaEstimadaTermino;
                $scope.resGuarda = 'OK';
                $scope.leerCotizacionesCAM()
                $scope.leerCotizacionesPAM()
            }, function(error) {
                $scope.resGuarda = 'No';
                $scope.errors = error.message;
            });
*/            
        }

        $scope.guardarSeguimientoCAM = function(CAM, RAM, RutCli, oCompra, oMail, oCtaCte, fechaAceptacion, nOC){
            $scope.resGuarda = usrCotizador;
            $http.post('grabarSeguimientoCAM.php', {
                                                    CAM:CAM, 
                                                    RAM:RAM,
                                                    RutCli:RutCli,
                                                    oCompra:oCompra,
                                                    oMail:oMail,
                                                    oCtaCte:oCtaCte,
                                                    fechaAceptacion:new Date(fechaAceptacion),
                                                    nOC:nOC
                        })
            .then(function (response) {
                $scope.resGuarda = 'OK';
                $scope.leerCotizacionesCAM()
                $scope.leerCotizacionesPAM()
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.loadRamsDisponibles = function(rut){
            $scope.res = rut;
            $scope.RAMdisponibles = false;
            $http.post("leerRegistroMateriales.php",{RutCli:rut})  
            .then(function(response){  
                $scope.RAMs = response.data.records;
                $scope.RAMdisponibles = true;
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

    });

