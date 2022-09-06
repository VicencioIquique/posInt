<div class="modal fade col-md-offset-3 col-md-6" id="efectivoModal" role="dialog" aria-labelledby="myModalLabel">
	 <div class="modal-dialog modal-md" style="margin-left:15%;margin-top:15%; background-color:white;  border-color: black; border-radius: 10px;">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<center><h2>Medio de pago - Efectivo</h2></center>
				</div>				
				<div class="col-lg-12"style="margin-bottom : 10%">
				<hr/>
					<form class=" col-lg-offset-2 form-horizontal">
						<div class="form-group mpEfectivo_totalV">
							<label class="control-label col-lg-3							etiquetaFormulario" for="exampleInputEmail1">TOTAL</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" id="mpEfectivo_total" name="mpEfectivo_total" placeholder="" disabled>
							</div>
						</div>
						<div class="form-group ">
							<label class="control-label col-lg-3 etiquetaFormulario" for="exampleInputEmail1">Efectivo</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" id="mpEfectivo_efectivo" name="mpEfectivo_efectivo" placeholder="">
							</div>
						</div>
						<div class="form-group ">
							<label class="control-label col-lg-3 etiquetaFormulario" for="exampleInputEmail1">Vuelto</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" id="mpEfectivo_vuelto" name="mpEfectivo_vuelto" placeholder="" disabled>
							</div>
						</div>
					</form>
					<center>
						<button id="mpEfectivo_aceptar" class="btn btn-default mpEfectivo_aceptar" disabled>
							<span class="glyphicon glyphicon-ok color_iconoAceptar"></span>
							<label>Aceptar(F2)</label>
						</button>
						<button id="mpEfectivo_cancelar" class="btn btn-default mpEfectivo_cancelar">
							<span class="glyphicon glyphicon-remove color_iconoCancelar"></span>
							<label>Cancelar (ESC)</label>
						</button>
					</center>
				</div>
			</div>
		</div>
	</div>
</div>