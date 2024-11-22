var app = angular.module('myApp', []);

app.filter('formatoNumero', function() {
    return function(x) {
      if (x == null) {
        return null;
      }
  
      if (x == undefined) {
        return undefined; 
      }
  
      let str = '';
      let rest, floor;
  
      do {
        rest = x % 1000;
        floor = Math.floor(x / 1000);
  
        str = (floor == 0) ? rest + str : '.' + x.toString().slice(-3) + str; 
  
        x = Math.floor(x / 1000);
      } while (x > 0);
  
      return str;
    }
});

app.run(function($rootScope){
    $rootScope.fechaRegistro        = new Date();
    $rootScope.fechaRegistro        = new Date();
});

app.controller('ctrlGastos', function($scope, $http) {
    $scope.CAM          = '';
    $scope.RAM          = '';
    $scope.cColor       = '';
    $scope.bColor       = '';
    $scope.Formulario   = '';
    $scope.cIva         = '';
    $scope.IdProyecto   = '';
    $scope.Concepto     = '';
    $scope.nInforme     = '';
    $scope.docGastosUPs  = false;
    $scope.dataConcepto  = false;



    const $archivosSeg = document.querySelector("#archivosSeguimiento");
    $scope.fileName = $archivosSeg;
    $scope.enviarFormularioSeg = function () {
        let archivosSeg = $archivosSeg.files;
        alert('Subir Archivo... '+$archivosSeg.files);
    }
    $scope.enviarFormulario = function (evento) {
        //alert($scope.Otam);
        let archivosSeg = $archivosSeg.files;
            if (archivosSeg.length > 0) {
                let formdata = new FormData();

                // Agregar cada archivo al formdata
                angular.forEach(archivosSeg, function (archivosSeg) {
                    formdata.append(archivosSeg.name, archivosSeg);
                });
 
                // Finalmente agregamos el nombre
                formdata.append("FOR", $scope.nInforme);
                //$scope.res = formdata;
 
                // Hora de enviarlo
 
                // Primero la configuración
                let configuracion = {
                    headers: {
                        "Content-Type": undefined,
                    },
                    transformRequest: angular.identity,
                };
                // var id = $scope.Otam;
                var id = $scope.nInforme;
                // Ahora sí
                $http
                    .post("guardar_archivos.php?nGasto="+id , formdata, configuracion) 
                    .then(function (respuesta) {
                        //console.log("Después de enviar los archivos, el servidor dice:", respuesta.data);
                        $scope.pdf = respuesta.data;
                        alert('Fichero subido correctamente...');
                        //window.location.href = 'segAM.php?CAM='+$scope.CAM+'&RAM='+$scope.RAM+'&Rev=0&Cta=0';
                    })
                    .catch(function (detallesDelError) {
                        //console.warn("Error al enviar archivos:", detallesDelError);
                        alert("Error al enviar archivos: "+ detallesDelError);
                    })
            } else {
                if($scope.archivosSeguimiento == ''){
                    //alert("No se ha seleccionado ningún archivo para subir...");
                }
            }
    };

    $scope.imprimirSolicitudPrueba = function(){
        //alert($scope.Formulario+' '+$scope.Iva+' '+$scope.IdProyecto);
        $http.post('registraDataGastos.php',{
            accion:             "solicitudGastos"
        })
        .then(function (response) {
            $scope.nInforme              = response.data.nInforme;
        }, function(error) {
            $scope.errors = error.message;
            alert('Error...'+$scope.errors);
        });

    }

    $scope.filtroTabla = function(f, p, i){
        return (f || p || i);
    }


    $scope.activaBtnGenera = function(){

            $scope.btnGenera = true;
    }

    $scope.loadSolicitudes = function(Formulario, cIva, IdProyecto){
        if(Formulario == undefined){ Formulario = ''; }
        if(IdProyecto == undefined){
            IdProyecto = '';
        }
        if(cIva == undefined){
            cIva = '';
        }
        $http.post("dataSolicitudes.php",{
            Formulario  : Formulario,
            cIva        : cIva,
            IdProyecto  : IdProyecto,
            accion      : "lecturaSolicitudes"
        })   
        .then(function(response){
            $scope.dataSolicitudes = response.data.records;
        }, function(error) {
            alert(error.message);
            $scope.errors = error.message;
        });

    }

    $scope.loadSolicitudes($scope.Formulario,$scope.cIva, $scope.IdProyecto);

    $scope.subirDocumentosSolicitud = function(){
        $http.post('registraDataGastos.php',{
            Formulario:         $scope.Formulario,
            Iva:                $scope.cIva,
            IdProyecto:         $scope.IdProyecto,
            Concepto:           $scope.Concepto,
            accion:             "solicitudGastos"
        })
        .then(function (response) {
            $scope.nInforme              = response.data.nInforme;
            // alert('Informe '+response.data.nInforme);
            // Activar despues de buscar el Numero de Informe
            $scope.enviarFormulario();
            alert('Se subio archivo con los documentos para adjuntar...'+$scope.nInforme);
        }, function(error) {
            $scope.errors = error.message;
            alert('Error...'+$scope.errors);
        });
    }

    $scope.imprimirSolicitud = function(){
        //alert($scope.Formulario+' '+$scope.Iva+' '+$scope.IdProyecto);
        if($scope.nInforme > 0){
            window.location.href = 'formularios/F3BCompilado.php?Formulario='+$scope.Formulario+'&Iva='+$scope.cIva+'&IdProyecto='+$scope.IdProyecto+'&Concepto='+$scope.Concepto;
            alert('Se generó solicitud...'+$scope.nInforme);
            window.location.href = 'eformulariosAjax.php';
        }else{
            $scope.buscaNumSolEmiteFormulariosinAnexo();
        }
    }
    $scope.buscaNumSolEmiteFormulariosinAnexo = function(){
        $http.post('registraDataGastos.php',{
            Formulario:         $scope.Formulario,
            Iva:                $scope.cIva,
            IdProyecto:         $scope.IdProyecto,
            Concepto:           $scope.Concepto,
            accion:             "solicitudGastos"
        })
        .then(function (response) {
            $scope.nInforme              = response.data.nInforme;
            window.location.href = 'formularios/F3BCompilado.php?Formulario='+$scope.Formulario+'&Iva='+$scope.cIva+'&IdProyecto='+$scope.IdProyecto+'&Concepto='+$scope.Concepto;
            alert('Aceptar para generar Compilado de Gastos...'+$scope.nInforme); 
            window.location.href = 'eformulariosAjax.php';
        }, function(error) {
            $scope.errors = error.message;
            alert('Error...'+$scope.errors);
        });

    }

    $scope.activaImpresion = function(){
        // alert($scope.Concepto);
        if($scope.Concepto != ''){
            $scope.docGastosUPs     = true;
        }else{
            $scope.docGastosUPs     = false;
        }
        if($scope.Concepto == undefined){
            $scope.docGastosUPs     = false;
        }else{
            $scope.docGastosUPs     = true;
        }
    }

    $scope.docGastosUP = function(){
        if($scope.Formulario != '' && $scope.cIva != '' && $scope.IdProyecto != ''){
            $scope.dataConcepto     = true;
        }else{
            $scope.dataConcepto     = false;
        }
        $scope.loadGastos($scope.Formulario, $scope.cIva, $scope.IdProyecto);

    }
    
    $scope.retocederSeguimientoRosado = function(){
        $scope.enviarFormularioRosado()
        // alert($scope.CAM);
        $http.post('registroDataErp.php',{
            CAM:        $scope.CAM,
            RAM:        $scope.RAM,
            Fan:        $scope.Fan,
            nOC:        '',
            accion:     "grabarAmRosado"
        })
        .then(function (response) {
            alert('Registro AM enviado al paso anterior...'); 
            window.location.href = 'plataformaErp.php?CAM='+$scope.CAM;
        }, function(error) {
            $scope.errors = error.message;
            alert('Error...'+$scope.errors);
        });

    }
    $scope.guardarSeguimientoRosado = function(){
        $scope.enviarFormularioRosado()
        $http.post('registroDataErp.php',{
            CAM:        $scope.CAM,
            RAM:        $scope.RAM,
            Fan:        $scope.Fan,
            nOC:        $scope.nOC,
            accion:     "grabarAmRosado"
        })
        .then(function (response) {
            alert('Registro guardado correctamente...');
            window.location.href = 'plataformaErp.php?CAM='+$scope.CAM;
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });

    }

    $scope.existeOC = function(){
        $scope.activaUp = true;
    }

    $scope.activarSubidaOC = function(){
        if($scope.nOC != ''){
            $scope.activaUp = true;
        }else{
            $scope.activaUp = false;
        }
    }

    $scope.loadCAM = function(CAM, RAM, accion){
        $scope.CAM      = CAM;
        $scope.RAM      = RAM;
        $scope.cColor   = accion;

        if(accion == 'Amarillo'){ $scope.bColor = 'bg-warning text-dark' }
        if(accion == 'Rosado')  { $scope.bColor = 'bg-danger text-white' }
        
        $http.post('registroData.php',{
            CAM:        $scope.CAM,
            RAM:        $scope.RAM,
            accion:     "LeerCAM"
        })
        .then(function (response) {
            $scope.CAM              = response.data.CAM;
            $scope.RAM              = response.data.RAM;
            $scope.nOC              = response.data.nOC;
            $scope.HES              = response.data.HES;
            $scope.Cliente          = response.data.Cliente;
            $scope.Contacto         = response.data.Contacto;
            $scope.Fan              = response.data.Fan;
            $scope.obsServicios     = response.data.obsServicios;
            $scope.informeUP        = response.data.informeUP;
            $scope.fechaInformeUP   = new Date(response.data.fechaInformeUP.replace(/-/g, '\/').replace(/T.+/, ''));
            $scope.nContacto        = response.data.nContacto;
            $scope.usrCotizador     = response.data.usrCotizador;
            $scope.usrResponzable   = response.data.usrResponzable;
            $scope.archivosSeguimiento = "archivo.pdf";
            if($scope.nOC != ''){ $scope.activaUp = true; }
        }, function(error) {
            alert(error);
        });
    }


    // $scope.total = function(){
    //     if($scope.Cantidad > 0 && $scope.valorUnitario > 0){
    //         $scope.valorTotal = $scope.Cantidad * $scope.valorUnitario;
    //         return $scope.valorTotal;
    //     }
    // };


});