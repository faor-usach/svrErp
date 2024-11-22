  
  <!-- The Modal -->
<script>
    jQuery(document).ready(function(){

  jQuery('#modal_seguimiento').on('hidden.bs.modal', function (e) {
      jQuery(this).removeData('bs.modal');
      jQuery(this).find('.modal-content').empty();
  })

    })
</script>

  <div class="modal fade" id="modal_seguimiento" role="dialog"> 
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"><h4>Cotización CAM "{{CAM}}" Rev. {{Rev}}</h4></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <h6>{{Cliente}} ({{Contacto}}) </h6>
            </div>
          </div>
          <div class="row bg-info text-white text-center">
            <div class="col-3">
              Aceptación
            </div>
            <div class="col-2">
              Acepta vía...
            </div>
            <div class="col-2">
              Hábiles
            </div>
            <div class="col-3">
              Estimada
            </div>
            <div class="col-2">
              Enviar Correo
            </div>
            <div class="col-3 bg-light text-dark" style="padding: 5px;">
              <input  type="date" 
                      ng-model="fechaAceptacion"
                      ng-change="calcularFechaEstimada(dHabiles, fechaAceptacion)"
                      class="form-control" 
                      >
            </div>
            <div class="col-2 bg-light text-dark" style="padding: 5px;">
              <div class="row text-center" style="padding: 5px;">
                <div class="col-4">
                  OC: 
                </div>
                <div class="col-4"> 
                  Mail: 
                </div>
                <div class="col-4">
                  Cta.Cte.: 
                </div>
                <div class="col-4">
                  <input type="checkbox" ng-model="oCompra"> 
                </div>
                <div class="col-4">
                  <input type="checkbox" ng-model="oMail">
                </div>
                <div class="col-4">
                  <input type="checkbox" ng-model="oCtaCte">
                </div>
              </div>
              
            </div>
            <div class="col-2 bg-light text-dark" style="padding: 5px;">
              <input  ng-model="dHabiles" 
                      type="text"
                      ng-change="calcularFechaEstimada(dHabiles, fechaAceptacion)"
                      class="form-control">
              {{resFecha}}
            </div>
            <div class="col-3 bg-light text-dark" style="padding: 5px;">
              <input  type="date" 
                      ng-model="fechaEstimadaTermino" 
                      class="form-control" 
                      >
            </div>
            <div class="col-2 bg-light text-dark" style="padding: 5px;">
              <select class     = "form-control"
                      ng-model  = "correoInicioPAM" 
                      ng-options  = "correoInicioPAM.codEnvio as correoInicioPAM.descripcionEnvio for correoInicioPAM in envios" >
                <option value="off">{{correoInicioPAM}}</option>
              </select>
            </div>
          </div>

          <div class="row bg-info text-white text-center">
            <div class="col-3">
              Orden de Compra
            </div>
            <div class="col-2">
              RAM
            </div>
            <div class="col-2">
              Cotizador
            </div>
            <div class="col-2">
              Responsable
            </div>
            <div class="col-3">
              Tipo de Ensayo
            </div>


            <div class="col-3 bg-light text-dark" style="padding: 5px;">
              <form name="myForm" enctype="multipart/form-data">

                <div class="form-group">
                  <input  ng-model = 'nOC'
                          name  = 'nOC'
                          id    = 'nOC'
                          type = 'text'
                          class='form-control'>
                </div>
                <div ng-show="upOC">

                  <div class="form-group">
                    <input id="archivos" multiple type="file" ng-model="pdf">
                    <button class="btn btn-primary btn-flat pull-right" ng-click="enviarFormulario()"><i class="fa fa-plus"></i> Agregar</button>
                     {{pdf}} {{fileName}}
                  </div>

                </div>

              </form>

            </div>
            <div class="col-2 bg-light text-dark" style="padding: 5px;">
              <div ng-show="RAMdisponibles">
                <select   ng-model="RAMdis" 
                          class="form-control"
                          ng-change="asignaRAM()"
                          ng-options="item.RAM+'-'+item.Fan as item.RAM+'-'+item.Fan for item in RAMs">
                  <option value="{{item.RAM}}" selected>{{item.RAM}}</option>
                </select>
              </div>
              RAM {{RAMdis}}
              <div ng-show="RAMasignada">
                Asignada: 
                <input  ng-model = 'RAM'
                        type = 'text'
                        class='form-control'
                        style="padding-top: 15px;">
              </div>
            </div>
            
            <div class="col-2 bg-light text-dark" style="padding: 5px;">
              <select   ng-model="usrCotizador" 
                        class="form-control"
                        ng-options="itemCot.usr as itemCot.usr for itemCot in data">
                <option value="{{itemCot.usrCotizador}}" selected>{{itemCot.usrCotizador}}</option>
              </select><br>
              {{usrCotizador}}
            </div>
            <div class="col-2 bg-light text-dark" style="padding: 5px;">
              <select   ng-model="usrResponzable" 
                        class="form-control"
                        ng-options="itemRes.usr as itemRes.usr for itemRes in dataResponsable">
                <option value="{{itemRes.usrResponzable}}" selected>{{itemRes.usrResponzable}}</option>
              </select><br>
              {{usrResponzable}}
            </div>
            <div class="col-3 bg-light text-dark" style="padding: 5px;">
              <select class     = "form-control"
                      ng-model  = "tpEnsayo" 
                      ng-change   = "activadesactivaValor()"
                      ng-options  = "tpEnsayo.codEnsayo as tpEnsayo.descripcion for tpEnsayo in tipoEnsayo" >
                <option value="1">{{tpEnsayo}}</option>
              </select>
            </div>


          </div>

          <div class="row bg-info text-white text-center">
            <div class="col-12 text-left">
              <h5>Contacto Cliente</h5>
            </div>
            <div class="col-12 bg-light text-dark" ng-if="contactoRecordatorio != ''">

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Fecha Contacto</th>
                    <th>Fecha Recordatorio</th>
                    <th>Descripción Contacto</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="x in seguimientoCAM">
                    <td> {{x.fechaContacto | date:'dd-MM-yyyy' }} </td>
                    <td> {{x.proxRecordatorio | date:'dd-MM-yyyy' }} </td>
                    <td> {{x.contactoRecordatorio}} </td>
                  </tr>
                </tbody>
              </table>





            </div>
            <div class="col-12 bg-light text-dark" style="padding: 5px;">
              <textarea ng-model="NewcontactoRecordatorio" class="form-control"></textarea>
            </div>
          </div>
          <div class="row bg-info text-white text-center">
            <div class="col-12 text-left">
              <h5>Descripción / Observaciones:</h5>
            </div>
            <div class="col-12 bg-light text-dark" style="padding: 5px;">
              <textarea ng-model="Observacion" class="form-control"></textarea>
            </div>
          </div>


        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer"> 
        <div class="btn-group btn-group-lg">

              <a type="button" class="btn btn-danger m-1" data-dismiss="modal" ng-click="cerrarCAM(CAM)">
                <i class="fas fa-paperclip"></i> Cerrar CAM
              </a>
                <a type="button" ng-show="RAMasignada" class="btn btn-danger m-1" data-dismiss="modal" ng-click="separarRAM(CAM, RAM)">
                  <i class="fas fa-cut"></i> Separar RAM
                </a>
              <a  type          = "button" 
                  class         = "btn btn-success"  
                  data-dismiss  = "modal"
                  ng-click      = "guardaCAM(CAM, RAM, RAMdis, usrCotizador, usrResponzable, fechaEstimadaTermino, fechaAceptacion, nOC, oCompra, oMail, oCtaCte, correoInicioPAM, tpEnsayo, NewcontactoRecordatorio, Observacion, Estado, dHabiles, Rev)">
                  <i class="far fa-save"></i> Guardar
              </a> 
              <!-- href          = "formularios/iCAMArchiva.php?CAM={{CAM}}&Rev=0&Cta=0&accion=Reimprime" -->
              <a  type          = "button" 
                  class         = "btn btn-success m-1" 
                  data-dismiss  = "modal"
                  ng-click      = "guardaCAMPAM(CAM, RAM, RAMdis, usrCotizador, usrResponzable, fechaEstimadaTermino, fechaAceptacion, nOC, oCompra, oMail, oCtaCte, correoInicioPAM, tpEnsayo, NewcontactoRecordatorio, Observacion, Estado, dHabiles, Rev)">
                  <i class="far fa-save"></i> PAM
              </a> 
              <button type="button" class="btn btn-danger m-1" data-dismiss="modal">Close</button>
        </div>
          {{resGuarda}} {{errors}}
      </div>
    </div>
  </div>
