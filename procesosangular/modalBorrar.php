  
  <!-- The Modal -->
<script>
    jQuery(document).ready(function(){

  jQuery('#modal_borrar').on('hidden.bs.modal', function (e) {
      jQuery(this).removeData('bs.modal');
      jQuery(this).find('.modal-content').empty();
  })

    })
</script>

  <div class="modal fade" id="modal_borrar" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"><h4>Cerrar - Borrar -> Cotización CAM "{{CAM}}"</h4></h4>
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
          <div class="btn-group">
              <a style="padding: 5px;" type="button" class="btn btn-danger" data-dismiss="modal" ng-click="cerrarCAM(CAM, Observacion)">
                <i class="fas fa-paperclip"></i> Cerrar CAM
              </a>
          </div>

          {{resGuarda}} {{errors}}
      </div>
    </div>
  </div>
