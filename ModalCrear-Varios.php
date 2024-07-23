<!--ventana para Update--->
<div class="modal fade" id="Crear2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #563d7c !important;">
        <h6 class="modal-title" style="color: #fff; text-align: center;">
          Crear Múltiples Materiales
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" id="cont_modal">
        <form id="create-materials-form" action="procesar_materiales.php" method="post">
          <div id="materials-container">
            <div class="material-input">
              <input type="text" class="form-control text" name="material[]" placeholder="Nombre del Material" required>
              <input type="number" class="form-control text" name="valor_uni[]" placeholder="Valor Uni." required oninput="calculateTotal(this)">
              <input type="number" class="form-control text" name="cantidad[]" placeholder="Cantidad" required oninput="calculateTotal(this)">
              <input type="number" class="form-control text" name="total[]" placeholder="00" disabled>
              <button type="button" style="height: 38px;line-height: normal;" class="btn btn-danger" onclick="removeMaterialInput(this)" disabled="true">Eliminar</button>
            </div>
          </div>
          <button type="button" class="btn btn-primary" id="add-material-button" onclick="addMaterialInput()">Añadir Material</button>
          <button type="submit" class="btn btn-info" id="create-materials-button">Crear Materiales</button>
        </form>

      </div>
    </div>
    </form>

  </div>
</div>
</div>
<!---fin ventana Update --->