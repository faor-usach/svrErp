<?php 
	//header('Content-Type: text/html; charset=iso-8859-1');
?>

		<div class="row" style="padding: 10px;">
			<div class="col-8">
				<div class="card"> 
					<div class="card-header">Detalle Cotización {{CAM}} </div>
				  	<div class="card-body">
						<table class="table table-primary table-hover table-bordered">
							<thead>
								<tr>
									<th>Lin 			</th>
									<th>Cantidad 		</th>
									<th>Cod.Serv. 		</th>
									<th width="45%">Servicios 		</th>
									<th width="10%">Unitario 		</th>
									<th width="10%">Neto 			</th>
									<th>Acción			</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="Items in dataItems"
									ng-class="{'default-color': true}">
									<td> {{Items.nLin}} </td>
									<td class="default-color">
										<input 	type="text" 
												size="3"
												maxlength="3" 
												ng-model="Items.Cantidad"
												ng-change="actualizaDatosItems(Items.nLin, Items.Cantidad, Items.unitarioUF, Items.unitarioP, Items.unitarioUS, Items.NetoUF)"
												class="form-control" > 		
									</td>
									<td class="default-color">{{Items.nServicio}} 		</td>
									<td class="default-color">{{Items.Servicio}} 		</td>
									<td class="default-color">
										<div ng-if="Moneda == 'U'">
											<input 	type="text" 
													size="5"
													maxlength="5" 
													ng-change="actualizaDatosItems(Items.nLin, Items.Cantidad, Items.unitarioUF, Items.unitarioP, Items.unitarioUS)"
													ng-model="Items.unitarioUF" 
													class="form-control" >
										</div>
										<div ng-if="Moneda == 'P'">
											UF {{Items.unitarioUF}}

											<input 	type="text" 
													size="7"
													maxlength="7" 
													ng-change="actualizaDatosItems(Items.nLin, Items.Cantidad, Items.unitarioUF, Items.unitarioP, Items.unitarioUS)"
													ng-model="Items.unitarioP" 
													class="form-control" >
										</div>
										<div ng-if="Moneda == 'D'">
											<input 	type="text" 
													size="5"
													maxlength="5" 
													ng-change="actualizaDatosItems(Items.nLin, Items.Cantidad, Items.unitarioUF, Items.unitarioP, Items.unitarioUS)"
													ng-model="Items.unitarioUS" 
													class="form-control" >
										</div>
									</td>
									<td class="default-color">
										<div ng-if="Moneda == 'U'">
											{{Items.NetoUF = Items.Cantidad * Items.unitarioUF}}
										</div> 		
										<div ng-if="Moneda == 'P'">
											{{Items.Neto = Items.Cantidad * Items.unitarioP}}
										</div> 		
										<div ng-if="Moneda == 'D'">
											{{Items.NetoUS = Items.Cantidad * Items.unitarioUS}}
										</div> 		
									</td>
									<td class="default-color">


										<button  style="margin-top: 5px;" class="btn btn-info" type="button" ng-click="quitarServicio(Items.nLin, $index)"  title="Quitar Servicio"><i class="fas fa-truck-moving"></i></button>
									</td>
								</tr>
							</tbody>
								<tr>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th>US$ {{totalNeto = getTotalDetalle(pDescuento) | number:0}}</th>
									<th></th>
								</tr>

							<tfoot>
								<tr>
									<td colspan="4" rowspan="3" class="default-color"></td>
									<td>
										Neto 
										<span ng-if="pDescuento > 0">{{pDescuento | number:0}}% Desc.</span>
									</td>
									<td> 
										<div ng-if="Moneda == 'U'">
											UF {{sumaNetoTotal | number:0}}
										</div> 
										<div ng-if="Moneda == 'P'">
											$ {{sumaNetoTotal | number:0}}
										</div> 
										<div ng-if="Moneda == 'D'">
											US$ {{sumaNetoTotal | number:0}}
										</div> 
									</td>
									<td></td>
								</tr>
								<tr>
									<td>Iva <span ng-if="exentoIva == true">Exento</span></td>
									<td> 
										<div ng-if="Moneda == 'U'">
											UF {{sumaIvaTotal | number:0}}
										</div> 
										<div ng-if="Moneda == 'P'">
											$ {{sumaIvaTotal | number:0}}
										</div> 
										<div ng-if="Moneda == 'D'">
											US$ {{sumaIvaTotal | number:0}}
										</div> 
									</td>
									<td></td>
								</tr>
								<tr>
									<td>Total</td>
									<td> 
										<div ng-if="Moneda == 'U'">
											UF {{sumaBrutoTotal | number:0}}
										</div> 
										<div ng-if="Moneda == 'P'">
											$ {{sumaBrutoTotal | number:0}}
										</div> 
										<div ng-if="Moneda == 'D'">
											US$ {{sumaBrutoTotal | number:0}}
										</div> 
									</td>
									<td></td>
								</tr>
							</tfoot>
						</table>


				  	</div>
				 </div>
			</div>
			<div class="col-4">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-3">
								Servicios
							</div>
							<div class="col-9">
								<input ng-model="filtroServicios" class="form-control" type="text">
							</div>
						</div>

					</div>
				  	<div class="card-body">
						<table class="table table-primary table-hover">
							<thead>
								<tr>
									<th>
										Servicios
									</th>
									<th ng-if="Moneda == 'U' || Moneda == 'P'">
										UF	
									</th>
									<th ng-if="Moneda == 'D'">$US	</th>
									<th>Acción			</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="Ser in dataServicios | filter: filtroServicios"
									ng-class="verColorLineaServicios(Ser.tpServicio, Ser.Estado)">
									<td>
									  	{{Ser.nServicio}}	{{Ser.Servicio}}
									</td>
									<td ng-if="Moneda == 'U' || Moneda == 'P'">
										{{Ser.ValorUF}}
									</td>
									<td ng-if="Moneda == 'P'">
										{{Ser.ValorPesos}}
									</td>
									<td ng-if="Moneda == 'D'">
										{{Ser.ValorUS}}
									</td>
									<td>
										<button style="margin-top: 5px;" 
												class="btn btn-info" 
												type="button" 
												ng-click="agregarServicio(Ser.nServicio, Ser.Servicio, Ser.ValorUF, Ser.ValorUS)"
												title="Agregar Servicio">
											<i class="fas fa-people-carry"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>
				  	</div>
				 </div>
			</div>
		</div>
