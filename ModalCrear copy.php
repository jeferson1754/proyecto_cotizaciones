<!--ventana para Update--->
<div class="modal fade" id="Crear" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #563d7c !important;">
        <h6 class="modal-title" style="color: #fff; text-align: center;">
          Nuevo Registro
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>



      <form name="form-data" action="recibCliente.php" method="POST">

        <div class="modal-body" id="cont_modal">
          <div class="form-group">
            <label for="name" class="form-label">Nombre del Material:</label>
            <input type="text" class="form-control" name="nombre" required='true' autofocus>
          </div>

          <div class="form-group">
            <label for="ubi" class="form-label">Valor Unitario:</label>
            <input type="number" class="form-control" min="0" name="valor" required>
          </div>
          
          <div class="form-group">
            <label for="ubi" class="form-label">Cantidad:</label>
            <input type="number" class="form-control" min="0" name="cantidad" required>
          </div>

        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary" id="btnEnviar">
            Registrar Material
          </button>
        </div>
    </div>
    </form>

  </div>
</div>
</div>
<!---fin ventana Update --->