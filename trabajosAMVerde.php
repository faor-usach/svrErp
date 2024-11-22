<div class="card" style="margin-top: 10px;">
  <div class="card-header"><h4>Seguimiento Factura</h4></div>
  <div class="card-body">
    <table class="table table-dark table-hover table-bordered">
      <thead style="font-size: 12px; font-family: arial;" class="text-center">
        <tr>
          <th></th>
          <th>AM</th>
          <th>Tipo Cot.<br>Resp</th>
          <th>Clientes</th>
          <th>Valor</th>
          <th>FechaAM<br>FechaUP<br>Factura</th>
          <th>Informes<br>Sub/N°</th>
          <th>Seguimiento</th>
        </tr>
      </thead>
      <tbody>
        <!--<tr ng-repeat="x in cotizacionesAM | filter: { informeUP: 'on', nSolicitud : '0', ordenCompra : 'Si', nFactura : '0' }" class="table-warning text-dark"> -->
        <tr ng-repeat="x in cotizacionesAM | filter: comparadorVerde | filter: search" class="table-success text-dark">
          <td>
          {{x.color}}

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
              <span class="badge badge-danger">HES</span> {{x.HEScot}}
            </div>
            <div>
              {{x.usrResponzable}}
            </div>
          </td>
          <td> <b>{{x.Cliente}}</b> </td>
          <td> {{x.BrutoUF | currency : "" : 2}} UF </td>
          <td> 
            AM {{x.fechaTermino| date:'dd/MM/yyyy' }} 
            <div>Up: <span ng-if="x.fechaUp != '0000-00-00'">{{x.CodInforme}} {{x.fechaUp| date:'dd/MM/yyyy' }}</span> </div> 
            <div>Factura: {{x.nFactura }} </div> 
            <div>Solicitud: {{x.nSolicitud }} </div> 
          </td>
          <td class="text-center">
            {{x.infoSubidos}}/{{x.infoNumero}}
          </td>
          <td class="text-center">
            <a href="plataformaErp.php?CAM={{x.CAM}}&RAM={{x.RAM}}&Rev={{x.Rev}}&Cta={{x.Cta}}&accion=SeguimientoAM">
              <img src="imagenes/actividades.png"      width="40" height="40" title="Seguimiento">
            </a>
          </td>
        </tr>


        <tr ng-repeat="x in cotizacionesAM | filter: comparadorAzul | filter: search" class="table-primary text-dark">
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
              <span class="badge badge-danger">HES</span> {{x.HEScot}}
            </div>
            <div>
              {{x.usrResponzable}}
            </div>
          </td>
          <td> <b>{{x.Cliente}}</b> </td>
          <td> {{x.BrutoUF | currency : "" : 2}} UF </td>
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
            <a href="plataformaErp.php?CAM={{x.CAM}}&RAM={{x.RAM}}&Rev={{x.Rev}}&Cta={{x.Cta}}&accion=SeguimientoAM">
              <img src="imagenes/actividades.png"      width="40" height="40" title="Seguimiento">
            </a>
          </td>
        </tr>

      </tbody>
      <!--
      <tfoot>
        <tr>
          <td colspan="4" class="text-left">Total:</td>
          <td class="text-left"> {{ getTotalVerdes() | currency : "" : 2 }} </td>
        </tr>
      </tfoot>
      -->
    </table>
  </div>
</div>
