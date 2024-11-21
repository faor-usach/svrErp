<div class="card" style="margin-top: 10px;">
  <div class="card-header"><h4>Trabajos sin HES</h4></div>
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
          <th>Seguimiento</th>
        </tr>
      </thead>
      <tbody>
        <!--
        <tr ng-repeat="x in cotizacionesAM | filter:{'infoNumero':'0'}" class="table-light text-dark">
        -->
        <tr ng-repeat="x in cotizacionesAM | filter: comparadorRosado | filter: search" class="table-danger text-dark">
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
              OC: {{x.nOC}}
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
            <a href="segAM.php?CAM={{x.CAM}}&RAM={{x.RAM}}&Rev={{x.Rev}}&Cta={{x.Cta}}&accion=Rosado"> 
              <img src="imagenes/actividades.png"      width="40" height="40" title="Seguimientos">
            </a>
            <!-- <a href="plataformaErp.php?CAM={{x.CAM}}&RAM={{x.RAM}}&Rev={{x.Rev}}&Cta={{x.Cta}}&accion=SeguimientoAM">
              <img src="imagenes/actividades.png"      width="40" height="40" title="Seguimientos">
            </a> -->
          </td>


          <!--
          <td class="text-center">
					  <a 	style="margin-top: 5px;"
								type="button"
								href="procesosangular/modCotizacionAM.php?CAM={{x.CAM}}&Rev={{x.Rev}}&Cta=0&accion=Actualizar"
		        				class="btn btn-warning"
		        				title="Editar CAM"> 
		        		<i class="fas fa-edit"></i> 
		        	</a>
              <a style="margin-top: 5px;" class="btn btn-warning" role="button" href="procesosangular/formularios/iCAM.php?CAM={{x.CAM}}&Rev={{x.Rev}}&Cta=0&accion=Reimprime" title="Imprimir Cotización"><i class="far fa-file-pdf"></i></a>
            </td>
          -->



        </tr>
      </tbody>
      
      <tfoot>
        <tr>
          <td colspan="4" class="text-left">Total:</td>
          <td class="text-left" colspan="4">  
            <h5>
              UF {{ getTotalRosados() | currency : "" : 2 }}  
              UF Ref. {{ultUF = <?php echo $ultUF; ?>}}
              {{ (ultUF * getTotalRosados()) | currency : " $ " : 0 }}  
            </h5>
          </td>
        </tr>

        <tr ng-if="getTotalAmarillos() == 0">
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
