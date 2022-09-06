<div class="modal fade col-md-offset-2 col-md-8" id="creditoModal" role="dialog" aria-labelledby="myModalLabel">
	 <div class="modal-dialog modal-md" style="margin-left:15%;margin-top:10%; background-color:white;  border-color: black; border-radius: 10px;">
		<div class="row">
			<div class="col-lg-12">
			<!-- INICIO ROW ENCABEZADO -->
			<div class="row">
				<center><h2>Medio de pago - Crédito</h2></center>
			</div>
			<hr>
			<!-- FIN INO DEL LOCAL Y TOTAL -->
			<!-- INICIO MEDIOS DE PAGO -->
			<div class="row">
				<div class="col-lg-12">
					<div class="col-sm-offset-2 col-sm-8">
						<form class="form-horizontal">
							<div class="form-group mpEfectivo_total">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Número de Tarjeta</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mpCredito_numeroTarjeta" name="mpCredito_numeroTarjeta" placeholder="Últimos 4 números de la tarjeta">
								</div>
							</div>
							<div class="form-group">
							<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Tipo de Tarjeta</label>
							<div class="col-sm-8">
								<select id="mpCredito_TipoTarjeta" name="mpCredito_tipoTarjeta" class="form-control">
									<option value="0"></option>
									<option value="1">VISA</option>
									<option value="2">Master Card</option>
									<option value="3">MAGNA</option>
									<option value="4">American Express</option>
									<option value="5">Diner's Club</option>
									<option value="6">Presto</option>
									<option value="7">Compra personal</option>
								</select>
							</div>
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Cantidad de cuotas</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mpCredito_cantidadCuotas" name="mpCredito_cantidadCuotas" placeholder="1 o 3 - 12">
								</div>
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Cod. Autorización</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mpCredito_codAutorizacion" name="mpCredito_codAutorizacion" placeholder="">
								</div>
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Monto</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mpCredito_monto" name="mpCredito_monto" placeholder="">
								</div>
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Folio Actual</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mpCredito_folioActual" name="mpCredito_folioActual" placeholder="" disabled="true">
								</div>
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Total</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mpCredito_total" name="mpCredito_total" placeholder="" disabled="true">
								</div>
							</div>
						</form>			
					</div>	
				</div>
			</div>
				<div class="row">
					<div class="col-lg-12 mpBotonesAceCan">
						<center>
							<button id="mpCredito_aceptar" class="btn btn-default mpBotonesAceCan" disabled>
							<span class="glyphicon glyphicon-ok color_iconoAceptar"></span>
							<label>Aceptar(F2)</label></button>		   
							<button id="mpCredito_cancelar" class="btn btn-default mpBotonesAceCan">
							<span class="glyphicon glyphicon-remove color_iconoCancelar"></span>
							<label>Cancelar(ESC)</label></button>
						</center>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>