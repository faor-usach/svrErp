<div class="card" ng-if="getTotalAmarillos() > 0" style="margin-top: 10px;">
  <div class="card-header"><h4>Trabajos Para Facturar</h4></div>
  <div class="card-body">
    <table class="table table-dark table-hover table-bordered">
      <thead style="font-size: 12px; font-family: arial;" class="text-center">
        <tr>
          <th></th>
          <th>AM</th>
          <th>Tipo Cot.<br>Resp</th>
          <th>Clientes</th>
          <th>Valor</th>
          <th>FechaAM<br>FechaUP<br>Fectura</th>
          <th>Informes<br>Sub/N°</th>
          <th>Facturación</th>
          <th>Seguimiento</th>
        </tr>
      </thead>
      <tbody>
        <!--<tr ng-repeat="x in cotizacionesAM | filter: { informeUP: 'on', nSolicitud : '0', ordenCompra : 'Si', nFactura : '0' }" class="table-warning text-dark"> -->
        <tr ng-repeat="x in cotizacionesAM | filter: comparadorAmarillo | filter: search" class="table-warning text-dark">
          <td>
            <div ng-if="x.nFactPend > 0">
              <img src="imagenes/gener_32.png" align="left" width="16"> 
              {{x.nFactPend}}  
            </div>
            <div ng-if="x.Fan > 0">
              <img src="imagenes/extra_column.png" align="left" width="32" title="CLON">
            </div>
            <div ng-if="x.Clasificacion == 1">
              <img src="imagenes/Estrella_Azul.png" width=10>
              <img src="imagenes/Estrella_Azul.png" width=10>
              <img src="imagenes/Estrella_Azul.png" width=10>
            </div>
            <div ng-if="x.Clasificacion == 2">
              <img src="imagenes/Estrella_Azul.png" width=10>
              <img src="imagenes/Estrella_Azul.png" width=10>
            </div>
            <div ng-if="x.Clasificacion == 3">
              <img src="imagenes/Estrella_Azul.png" width=10>
            </div>
          </td>
          <td> 
            RAM-{{x.RAM}}<span ng-if="x.Fan > 0">-{{x.Fan}} </span><br>
            CAM-{{x.CAM}}
            <div ng-if="x.sDeuda > 0">
              <span class="badge badge-warning">{{x.sDeuda | currency : "$" : 0}}</span>
            </div>
          </td>
          <td>
            <div ng-if="x.oMail == 'on'">
              Confirmado x Correo
            </div>
              OC: {{x.nOC}} OCF: {{x.nOrden}}
            <div ng-if="x.HES == 'on'">
              <span class="badge badge-danger">HES: {{x.HEScot}} </span>
            </div>
            <div ng-if="x.tpEnsayo == 2">
              <span class="badge badge-dark">AF</span>
            </div>
            <div>
              {{x.usrResponzable}}
            </div>
          </td>
          <td> <b>{{x.Cliente}}</b> </td>
          <td> 
            <div ng-if="x.Moneda == 'U'">
              {{x.BrutoUF | currency : "" : 2}} UF 
            </div>
            <div ng-if="x.Moneda == 'P'">
              $ {{x.Bruto | currency : "" : 0}}  
            </div>
          </td>
          <td> 
            AM {{x.fechaTermino| date:'dd/MM/yyyy' }} 
            <div>Up: <span ng-if="x.fechaUp != '0000-00-00'">{{x.CodInforme}} {{x.fechaUp| date:'dd/MM/yyyy' }}</span> </div> 
            <div>Solicitud: {{x.nSolicitud }} </div> 
            <div>Factura: {{x.nFactura }} </div> 
          </td>
          <td class="text-center">
            {{x.infoSubidos}}/{{x.infoNumero}}
          </td>
          <td class="text-center">
            <div ng-if="x.nOrden == 'XXX'">
              <a href="facturacion/formSolicitaFactura.php?RutCli={{x.RutCli}}&Proceso=&nSolicitud=&nOC={{x.nOC}}&CAM={{x.CAM}}"> <img src="imagenes/tpv.png"  width="40" height="40" title="Facturación...">
              </a>
            </div>
            <div>
              <a href="facturacion/formSolicitaFactura.php?RutCli={{x.RutCli}}&Proceso=&nSolicitud=&nOC={{x.nOC}}&CAM={{x.CAM}}&nOrden={{x.nOrden}}"> <img src="imagenes/tpv.png"  width="40" height="40" title="Solicitud en espera..."></a>
            </div>
            
          </td>
          <td class="text-center">
            <a href="segAM.php?CAM={{x.CAM}}&RAM={{x.RAM}}&Rev={{x.Rev}}&Cta={{x.Cta}}&accion=Amarillo">
              <img src="imagenes/actividades.png"      width="40" height="40" title="Seguimientos">
            </a>
<!-- 
            <a href="plataformaErp.php?CAM={{x.CAM}}&RAM={{x.RAM}}&Rev={{x.Rev}}&Cta={{x.Cta}}&accion=SeguimientoAM">
              <img src="imagenes/actividades.png"      width="40" height="40" title="Seguimiento">
            </a> -->
          </td>

          <!-- <td class="text-center"> -->
            <!-- <input type="hidden" ng-model="CAM" ng-init="loadCAM({{x.CAM}})"> -->
            <?php
              $CAM = '{{x.CAM}}'; 
              // $agnoActual = date('Y'); 
              // $vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/OC-'.$CAM.'.xlsx';
              // if(file_exists($vDir)){
                // $vDir = 'tmp/OC-'.$CAM.'.xlsx';
                ?>
                  <!-- <a style="margin-top: 5px;" class="btn btn-warning" role="button" href="<?php echo $vDir;?>" title="Imprimir Orden de Compra"><i class="far fa-file-pdf"></i></a> -->
              <?php
              // }
              ?>
              <!-- <a style="margin-top: 5px;" class="btn btn-warning" role="button" href="procesosangular/formularios/iCAM.php?CAM={{x.CAM}}&Rev={{x.Rev}}&Cta=0&accion=Reimprime" title="Imprimir Cotización"><i class="far fa-file-pdf"></i></a> -->
          <!-- </td> -->


        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4" class="text-left">Total:</td>
          <td class="text-left" colspan="5">  
            <h5>
              UF {{ getTotalAmarillos() | currency : "" : 2 }}   
              UF Ref. {{ultUF = <?php echo $ultUF; ?>}}
              {{ (ultUF * getTotalAmarillos()) | currency : " $ " : 0 }}  
            </h5>
          </td>
        </tr>
        <tr>
          <td colspan="4" class="text-left">Total General: </td>
          <td class="text-left" colspan="5">  
            <h5>
              UF {{ getTotalBlancas() + getTotalRosados() + getTotalAmarillos() | currency : "" : 2 }}                
              {{ ultUF | currency : " UF Ref. " : 2}}
              {{ (ultUF * (getTotalBlancas() + getTotalRosados() + getTotalAmarillos())) | currency : " $ " : 0 }}  
            </h5>
          </td>
        </tr>

      </tfoot>
    </table>
  </div>
</div>
