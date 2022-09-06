<div class="modal fade col-md-offset-2 col-md-8" id="debitoModal" role="dialog" aria-labelledby="myModalLabel">
	 <div class="modal-dialog modal-md" style="margin-left:15%;margin-top:10%; background-color:white;  border-color: black; border-radius: 10px;">
		<div class="row">
			<div class="col-lg-12">				
				<!-- INICIO ROW ENCABEZADO -->
				<div class="row">
					<center><h2>Medio de pago - Red Compra</h2></center>
				</div>
				<hr>
				<!-- FIN INO DEL LOCAL Y TOTAL -->
				<!-- INICIO MEDIOS DE PAGO -->
				<div class="row">
					<div class="col-lg-12">
						<div class="col-sm-offset-2 col-sm-8 mpRedCompraMargenSup">
							<form class="form-horizontal">
								<div class="form-group">
									<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Número de Tarjeta</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="mpRedCompra_numeroTarjeta" name="mpRedCompra_numeroTarjeta" placeholder="Últimos 4 números de la tarjeta">
									</div>
								</div>
								<div class="form-group ">
									<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Cod.Autorización</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="mpRedCompra_codAutorizacion" name="mpRedCompra_codAutorizacion" placeholder="">
									</div>
								</div>
								<div class="form-group ">
									<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Monto</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="mpRedCompra_monto" name="mpRedCompra_monto" placeholder="">
									</div>
								</div>
								<div class="form-group ">
									<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Folio Actual</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="mpRedCompra_folioActual" name="mpRedCompra_folioActual" placeholder="" disabled="true">
									</div>
								</div>
								<div class="form-group ">
									<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Total</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="mpRedCompra_total" name="mpRedCompra_Total" placeholder="" disabled="true">
									</div>
								</div>
							</form>
						</div>	
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 mpBotonesAceCan">
					<center>
						<button id="mpRedCompra_aceptar" class="btn btn-default"disabled>
						<span class="glyphicon glyphicon-ok color_iconoAceptar"></span>
						<label>Aceptar(F2)</label><br></button>		   
						<button id="mpRedCompra_cancelar" class="btn btn-default">
						<span class="glyphicon glyphicon-remove color_iconoCancelar"></span>
						<label>Cancelar(ESC)</label><br></button>
					</center>
				   </div>
				</div>
			</div>
		</div>
	</div>
</div>