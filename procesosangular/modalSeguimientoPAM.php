  
  <!-- The Modal -->
<script>
    jQuery(document).ready(function(){

  jQuery('#modal_seguimientoPAM').on('hidden.bs.modal', function (e) {
      jQuery(this).removeData('bs.modal');
      jQuery(this).find('.modal-content').empty();
  })

    })
</script>

  <div class="modal fade" id="modal_seguimientoPAM" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"><h4>Proceso PAM RAM "{{RAM}}-{{Fan}}" de CAM "{{CAM}}" </h4></h4>
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
            <div class="col-4">
              Fecha Término
            </div>
            <div class="col-4">
              Orden de Compra
            </div>
            <div class="col-4">
              Situación
            </div>
            <div class="col-4 bg-light text-dark" style="padding: 5px;">
              <input  type="date" 
                      ng-model="ft" 
                      class="form-control">
                      <!-- ng-change="calcularDiasHabilesPAM(fechaEstimadaTermino, fechaInicio)" -->
            </div>
            <div class="col-4 bg-light text-dark" style="padding: 5px;">
              <input  ng-model = 'nOC'
                      type = 'text'
                      class='form-control'>
            </div>
            <div class="col-4 bg-light text-dark" style="padding: 5px;">
              <select class     = "form-control"
                      ng-model  = "Estado" 
                      ng-options  = "Estado.codEstado as Estado.descripcion for Estado in tipoEstado" >
                <option value="P">{{Estado}}</option>
              </select>
            </div>
          </div>

          <div class="row bg-info text-white text-center">
            <div class="col-4">
              Días Hábiles
            </div>
            <div class="col-4">
              Responsable
            </div>
            <div class="col-4">
              Ensayo
            </div>
            <div class="col-4 bg-light text-dark" style="padding: 5px;">

              <input  ng-model="dHabiles" 
                      type="text" 
                      class="form-control">
                      <!-- ng-change="calcularFechaEstimadaPAM(dHabiles, fechaInicio)" -->
            </div>
            <div class="col-4 bg-light text-dark" style="padding: 5px;">
              <select   ng-model="usrResponzable" 
                        class="form-control"
                        ng-options="itemRes.usr as itemRes.usr for itemRes in dataResponsable">
                <option value="{{itemRes.usrResponzable}}" selected>{{itemRes.usrResponzable}}</option>
              </select><br>
            </div>
            <div class="col-4 bg-light text-dark" style="padding: 5px;">
              <select class     = "form-control"
                      ng-model  = "tpEnsayo" 
                      ng-change   = "activadesactivaValor()"
                      ng-options  = "tpEnsayo.codEnsayo as tpEnsayo.descripcion for tpEnsayo in tipoEnsayo" >
                <option value="1">{{tpEnsayo}}</option>
              </select>
            </div>
          </div>

<!--
          <div class="row bg-warning text-dark">
            <div class="col-12">
              <h4>ASIGNACIÓN DE PEGAS</h4>
            </div>
            <div class="col-6 bg-secondary text-white">
              Fecha Pega
            </div>
            <div class="col-6 bg-secondary text-white">
              Responsable Pega
            </div>
            <div class="col-6 bg-light text-dark" style="padding: 5px;">
              <input  type="date" 
                      ng-model="fechaPega" 
                      class="form-control">
            </div>
            <div class="col-6 bg-light text-dark" style="padding: 5px;">
              <select   ng-model="usrPega" 
                        class="form-control"
                        ng-options="itemPega.usr as itemPega.usr for itemPega in dataPega">
                <option value="{{itemPega.usrPega}}" selected>{{itemPega.usrPega}}</option>
              </select><br>
            </div>

          </div>

          <div class="row bg-info text-white text-center">
            <div class="col-12 text-left">
              <h5>Descripción / Observaciones:</h5>
            </div>
            <div class="col-12 bg-light text-dark" style="padding: 5px;">
              <textarea ng-model="Descripcion" class="form-control"></textarea>
            </div>
          </div>
        </div>
-->        
        <!-- Modal footer -->
        <div class="modal-footer">
          <div class="btn-group">
              <a style="padding: 5px;" type="button" class="btn btn-danger" data-dismiss="modal" ng-click="volverCAM(CAM)">
                <i class="fas fa-reply"></i>
                Volver a CAM
              </a>
          </div>

          <div class="btn-group">
              <a  type="button" 
                  class="btn btn-success"
                  data-dismiss="modal"
                  ng-click="guardaPAM(CAM, Fan, RAM, ft, nOC, Estado, dHabiles, usrResponzable, tpEnsayo)">
                  <i class="far fa-save"></i>
                  Guardar
                  <!-- ng-click="guardaPAM(CAM, Fan, RAM, fechaEstimadaTermino, nOC, Estado, dHabiles, usrResponzable, tpEnsayo, fechaPega, usrPega, Descipcion)"> -->
              </a> 
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          {{resGuardaPAM}} {{errors}}
      </div>
    </div>
  </div>
