<!--ventana para Update--->
<div class="modal fade" id="CrearA" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #563d7c !important;">
        <h6 class="modal-title" style="color: #fff; text-align: center;">
          Nuevo Anticipo
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>



      <form name="form-data" action="recibCliente copy.php" method="POST">

        <div class="modal-body" id="cont_modal">

      
          <div class="form-group">
            <label for="ubi" class="form-label">Valor:</label>
            <input type="number" class="form-control" min="0" name="valor">
          </div>
          <div class="form-group">
            <label for="fecha" class="form-label">Fecha de Paga:</label>
            <input type="date" class="form-control" name="fecha" value="<?= $fecha_actual ?>">
          </div>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary" id="btnEnviar">
            Guardar
          </button>
        </div>
    </div>
    </form>

  </div>
</div>
</div>
<!---fin ventana Update --->