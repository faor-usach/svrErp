<?php
	include_once("../inc/funciones.php");
?>	
<div class="row">
	<div class="col-6">
		<?php mCAMs(); ?>
	</div>
	<div class="col-6">
		<?php mPAMs(); ?>
	</div>		
</div>
<?php
function mPAMs(){
	global $ultUF;
	?>

	<div ng-show="cargaDatos"> 
		<img src="../imagenes/enProceso.gif" width="50"> 
	</div>
	<table class="table table-dark table-hover" style="margin-top: 5px;" ng-show="tablaPAM">
		<thead>
			<tr>
				<th>&nbsp; 			</th>
				<th>PAM				</th>
				<th>Inicio			</th>
				<th>Termino			</th>
				<th>Clientes		</th>
				<th>Observaciones	</th>
				<th>Imprimir 		</th>
				<th>Acciones		</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="Pam in CotizacionesPAM | filter: filtroClientes" 
				ng-class="verColorLineaPAM(Pam.Estado, Pam.RAM, Pam.Fan, Pam.nDias, Pam.dhf, Pam.dha, Pam.rCot)">

				<td>
					<!--
					<div ng-if="Cam.correoAutomatico == 'on'">
						<img style="padding:5px;" src="../imagenes/siEnviado.png" align="left" width="32" title="Cotización enviado en correo automatico">
					</div>
					-->
					<div ng-if="Pam.Fan > 0">
						<div class="badge badge-pill badge-danger">
							<h6 title="Facturas Pendientes">CLON</h6>
						</div>
					</div>
					<div ng-if="Pam.nFactPend > 0">
						<div class="badge badge-pill badge-danger">
							<h6 title="Facturas Pendientes">{{Pam.nFactPend}}</h6>
						</div>
					</div>
					<div ng-if="Pam.tpEnsayo == 2">
						<h5 title="Análisis de Falla"><span class="badge badge-secondary">AF</span></h5>
					</div>
					<div ng-if="Pam.OFE == 'on'">
						<a class="btn btn-warning" role="button" href="ofe/index.php?OFE= {{Pam.CAM}}&accion=OFE" title="Editar Oferta Econóica">OFE</a>
					</div>
					
					<div ng-if="Pam.Clasificacion > 0">
						<br>
						<div ng-if="Pam.Clasificacion == 1">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
						</div>
						<div ng-if="Pam.Clasificacion == 2">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
						</div>
						<div ng-if="Pam.Clasificacion == 3">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
						</div>
					</div>

				</td>
				<td>
					R{{Pam.RAM}}<span ng-if="Pam.Fan > 0">-{{Pam.Fan}}</span><br>
					C{{Pam.CAM}}<br>
					<div ng-if="Pam.Rev > 0">
						Rev. 0{{Pam.Rev}} 
					</div>
					<div ng-if="Pam.sDeuda > 0">
						<img class="p-2" src="../imagenes/bola_amarilla.png">
						<h5><span class="badge badge-warning" title="Moroso">{{Pam.sDeuda | currency:"$ ":0}}</span></h5>
					</div>

				</td>
				<td>
					{{Pam.usrResponzable}}
					{{Pam.fechaInicio | date:'dd/MM'}}

				</td>
				<td>
					{{Pam.dHabiles}} días<br>
					{{Pam.nDias}}<br>
					{{Pam.diaTermino}}<br>
					{{Pam.fechaEstimadaTermino | date:'dd/MM'}}<br>
					<div ng-if="Pam.dhf > 0 && Pam.dha == 0">
						<div ng-if="Pam.dhf == 1">
							<span class="badge badge-success">{{Pam.dhf}}</span>
						</div>
						<div ng-if="Pam.dhf > 1">
							<span class="badge badge-primary">{{Pam.dhf}}</span>
						</div>
					</div>
					<div ng-if="Pam.dha > 0">
						<span class="badge badge-danger" title="Días de atraso">{{Pam.dha}}</span>
					</div>
				</td>
				<td>{{Pam.Cliente}} <br> 
					<div ng-if="Pam.Moneda=='P'">
						{{Pam.Bruto}}
					</div>
					<div ng-if="Pam.Moneda=='U'">
						{{Pam.BrutoUF}}
					</div>
					<div ng-if="Pam.Moneda=='D'">
						{{Pam.BrutoUS}}
					</div>

				</td>
				<td>
					<h6>{{Pam.Descripcion}}</h6>
				</td>
				<td>

					<a class="btn btn-info" role="button" href="../registroMat/formularios/iRAM.php?RAM={{Pam.RAM}}" title="Imprimir RAM"><i class="fas fa-print"></i></a>


					<div ng-if="Pam.OTAM == 'NO'"> 
						<a 	style="margin-top: 5px;" 
							class="btn btn-light"
							role="button"
							href="../otamsajax/pOtams.php?RAM={{Pam.RAM}}&CAM={{Pam.CAM}}&accion=Nuevo&prg=Procesos" 
							data-toggle="tooltip"
							title="Crear Ensayos"><img src="../imagenes/materiales.png" width="22"></a>
					</div>
					<div ng-if="Pam.OTAM == 'SI'">
						<a 	style="margin-top: 5px;" 
							class="btn btn-light" 
							role="button" 
							href="../otamsajax/pOtams.php?RAM={{Pam.RAM}}&CAM={{Pam.CAM}}&accion=Old&prg=" 
							title="Ensayos"><i class="fas fa-bong"></i></a>
					</div>

				</td>
				<td>
					<button type="button" 
		        				class="btn btn-light"
		        				data-toggle="modal" 
		        				data-target="#modal_seguimientoPAM" 
		        				title="Seguimiento"
		        				ng-click="seguimientoPAM(Pam.CAM, Pam.RAM)"> 
		        		<i class="fas fa-project-diagram"></i> 
		        	</button>				
					<a 	style="margin-top: 5px;"
								type="button"
								href="modCotizacion.php?CAM={{Pam.CAM}}&Rev={{Pam.Rev}}&Cta=0&accion=Actualizar"
		        				class="btn btn-warning"
		        				title="Editar"> 
		        		<i class="fas fa-edit"></i> 
		        	</a>


					<a style="margin-top: 5px;" class="btn btn-light" role="button" href="formularios/iCAMArchiva.php?CAM={{Pam.CAM}}&Rev={{Pam.Rev}}&Cta=0&accion=Reimprime" title="Imprimir Cotización"><i class="far fa-file-pdf"></i></a>

					<a 	style="margin-top: 5px;"
								type="button"
								href="mDocumentos.php?CAM={{Pam.CAM}}&RAM={{Pam.RAM}}&Rev={{Pam.Rev}}&Cta=0&accion=Up"
		        				class="btn btn-secondary"
		        				title="Up Documentos"> 
		        		<i class="far fa-file-pdf"></i>  
		        	</a>


		        </td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6">
					<h5>
					Total en PAM :
					{{ getTotalPAMs() | currency : "UF " : 2 }}  UF Ref.	{{ultUF = <?php echo $ultUF; ?>}}
 					{{ultUF * getTotalPAMs() | currency : " $ " : 0}}
 					</h5>
				</td>
			</tr>
		</tfoot>

	</table>
<?php
}
function mCAMs(){
	global $ultUF;
	?>
	<div ng-show="cargaDatos">
		<img src="../imagenes/enProceso.gif" width="50">
	</div>
	<table class="table table-dark table-hover" style="margin-top: 5px;" ng-show="tablaCAM">
		<thead>
			<tr>
				<th>&nbsp; 		</th>
				<th>CAM			</th>
				<th>Fecha		</th>
				<th>Clientes	</th>
				<th>Total		</th>
				<th>Valida Hasta		</th>
				<th>Est. 		</th>
				<th>Acciones	</th>
			</tr>
		</thead>
		<tbody>

			<tr ng-repeat="Cam in CotizacionesCAM | filter: filtroClientes" 
				ng-class="verColorLinea(Cam.Estado, Cam.RAM, Cam.BrutoUF, Cam.nDias, Cam.rCot, Cam.fechaAceptacion, Cam.proxRecordatorio, Cam.colorCam)">

				<td>
					<div ng-if="Cam.Fan > 0">
						<div class="badge badge-pill badge-danger">
							<h6 title="Facturas Pendientes">CLON</h6>
						</div>
					</div>
					<div ng-if="Cam.correoAutomatico == 'on'">
						<img style="padding:5px;" src="../imagenes/siEnviado.png" align="left" width="40" title="Cotización enviado en correo automatico">
					</div>
					<div ng-if="Cam.nFactPend > 0"> 
						<br>
						<img src="../imagenes/gener_32.png" title="Precaución Cliente con {{Cam.nFactPend}} Facturas Pendientes" align="left" width="32"> 
						<span class="badge badge-danger" title="Cliente con {{Cam.nFactPend}} Facturas Pendientes">{{Cam.nFactPend}}</span>
					</div>
					<div ng-if="Cam.tpEnsayo == 2">
						<h5 title="Análisis de Falla"><span class="badge badge-secondary">AF</span></h5>
					</div>
					<div ng-if="Cam.OFE == 'on'">
						<a class="btn btn-warning" role="button" href="ofe/index.php?OFE={{Cam.CAM}}&accion=OFE" title="Editar Oferta Econóica">OFE</a>
					</div>
					<div ng-if="Cam.Clasificacion > 0">
						<br>
						<div ng-if="Cam.Clasificacion == 1">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
						</div>
						<div ng-if="Cam.Clasificacion == 2">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
						</div>
						<div ng-if="Cam.Clasificacion == 3">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
						</div>
					</div>
				</td>
				<td>
					C{{Cam.CAM}}<br>
					<div ng-if="Cam.RAM > 0">
						R{{Cam.RAM}}<span ng-if="Cam.Fan > 0">-{{Cam.Fan}}</span>
					</div>
					<div ng-if="Cam.Rev > 0">
						Rev. 0{{Cam.Rev}} 
					</div>
					<div ng-if="Cam.fechaAceptacion != '0000-00-00'">
						<span class="badge badge-warning">Aceptada</span> 
					</div>
					<div ng-if="Cam.sDeuda > 0">
						<img class="p-2" src="../imagenes/bola_amarilla.png">
						<h5><span class="badge badge-warning" title="Moroso">{{Cam.sDeuda | currency:"$ ":0}}</span></h5>
					</div>

				</td>
				<td>
					{{Cam.fechaCotizacion | date:'dd/MM/yy'}}<br>
					{{Cam.usrCotizador}}
				</td>
				<td>
					{{Cam.Cliente}}
					<div ng-if="Cam.Estado == 'C'">
						<hr>
						{{Cam.Observacion}}
					</div>
				</td>
				<td>
					<div ng-if="Cam.Bruto > 0">
						{{Cam.Bruto | currency:"$ ":0}}
					</div>
					<div ng-if="Cam.BrutoUF > 0">
						{{Cam.BrutoUF | currency:"UF "}}
					</div>

				</td>
				<td>
					<!-- 
						{{Cam.fechaEstimadaTermino | date:'dd/MM'}} 
						{{Cam.fechaxVencer | date:'dd/MM'}}<br>
					-->
					{{Cam.fechaTermino | date:'dd/MM/yy'}}<br>
					<span class="badge badge-pill badge-danger" ng-if="Cam.nDias < 0">
						<h6>{{Cam.nDias}}</h6>
					</span>
					<span class="badge badge-pill badge-primary" ng-if="Cam.nDias > 0">
						<h6>{{Cam.nDias}}</h6>
					</span>
					<br>
				</td>
				<td>
					<div ng-if="Cam.enviadoCorreo == ''">
						<img style="padding:5px;" src="../imagenes/noEnviado.png" align="left" width="40" title="Cotización NO Enviada">
						{{Cam.fechaEnvio | date:'dd/MM/yy'}}
					</div>
					<div ng-if="Cam.enviadoCorreo == 'on' && Cam.Contactar == 'No'">
						<img style="padding:5px;" src="../imagenes/enviarConsulta.png" align="left" width="40" title="Cotización enviado en correo automatico">
						{{Cam.fechaEnvio | date:'dd/MM/yy'}}
					</div>
					<div ng-if="Cam.proxRecordatorio != '0000-00-00'">
						<img style="padding:5px;" src="../imagenes/alerta.gif" align="left" width="50" title="Contactar con Cliente">
						Contactar {{Cam.proxRecordatorio | date:'dd/MM/yy'}}
					</div>
				</td>
				<td>
					<button 	type="button" 
								ng-if="Cam.Estado != 'C'"
		        				class="btn btn-light"
		        				data-toggle="modal" 
		        				data-target="#modal_seguimiento" 
		        				title="Seguimiento"
		        				ng-click="editarSeguimiento(Cam.CAM)">  
		        		<i class="fas fa-project-diagram"></i> 
		        	</button>				
					<a 			style="margin-top: 5px;"
								ng-if="Cam.Estado != 'C'"						
								type="button"
								href="modCotizacion.php?CAM={{Cam.CAM}}&Rev={{Cam.Rev}}&Cta=0&accion=Actualizar"
		        				class="btn btn-warning"
		        				title="Editar"> 
		        		<i class="fas fa-edit"></i> 
		        	</a>
					<button 	type="button" 
								ng-if="Cam.Estado != 'C'"
		        				class="btn btn-danger"
		        				data-toggle="modal" 
		        				data-target="#modal_borrar" 
		        				title="Cerrar CAM"
		        				ng-click="editarBorrar(Cam.CAM)"  
		        				style="margin-top: 5px;">
		        		<i class="fas fa-trash-alt"></i> 
		        	</button>	
					<button     type="button" 
								ng-if="Cam.Estado == 'C'"
		        				class="btn btn-danger"
		        				title="Restablecer"
		        				ng-click="restablecerCAM(Cam.CAM)"  
		        				style="margin-top: 5px;">
						<i class="fas fa-undo-alt"></i>
		        	</button>	
					<a 			style="margin-top: 5px;"
								ng-if="Cam.Estado != 'C'"
								type="button"
								href="mDocumentos.php?CAM={{Cam.CAM}}&Rev={{Cam.Rev}}&Cta=0&accion=Up"
		        				class="btn btn-secondary"
		        				title="Up Documentos"> 
		        		<i class="far fa-file-pdf"></i> 
		        	</a>

		        </td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="5">
					<h5>
					Total :
					{{ getTotalCAMs() | currency : "UF " : 2 }} UF Ref.	{{ultUF = <?php echo $ultUF; ?>}}
 					{{ultUF * getTotalCAMs() | currency : " $ " : 0}}
 					</h5>
				</td>
			</tr>
		</tfoot>
	</table>
	

<?php
}

?>
