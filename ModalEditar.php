<!--ventana para Update--->
<div class="modal fade" id="editChildresn<?php echo $mostrar['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #563d7c !important;">
        <h6 class="modal-title" style="color: #fff; text-align: center;">
          Actualizar Información
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form method="POST" action="recib_Update.php">
        <input type="hidden" name="id" value="<?php echo $mostrar['ID']; ?>">

        <div class="modal-body" id="cont_modal">

          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $mostrar['Nombre']; ?>" required="true">
          </div>

          <div class="form-group">
            <label for="ubi" class="form-label">Valor:</label>
            <input type="number" class="form-control" min="0" name="valor" value="<?php echo $mostrar['Valor Unitario']; ?>">
          </div>

          <div class="form-group">
            <label for="ubi" class="form-label">Cantidad:</label>
            <input type="number" class="form-control" min="0" name="cantidad" value="<?php echo $mostrar['Cantidad']; ?>">
          </div>
          <div class="form-group">
            <label for="ubi" class="form-label">Total:</label>
            <input type="number" class="form-control" name="total" disabled="true" value="<?php echo $mostrar['Total']; ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!---fin ventana Update --->