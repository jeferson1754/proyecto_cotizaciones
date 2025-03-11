<!--ventana para Update--->
<div class="modal fade" id="editChildresn<?php echo $mostrar['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">
          <i class="fas fa-edit me-2"></i>Actualizar Información
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="recib_Update.php" id="updateForm<?php echo $mostrar['ID']; ?>">
        <input type="hidden" name="id" value="<?php echo $mostrar['ID']; ?>">

        <div class="modal-body p-4">
          <div class="mb-3">
            <label for="nombre<?php echo $mostrar['ID']; ?>" class="form-label fw-bold">
              <i class="fas fa-tag me-1 text-primary"></i>Nombre:
            </label>
            <input type="text" name="nombre" class="form-control" id="nombre<?php echo $mostrar['ID']; ?>"
              value="<?php echo $mostrar['Nombre']; ?>" required="true">
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="valor<?php echo $mostrar['ID']; ?>" class="form-label fw-bold">
                <i class="fas fa-dollar-sign me-1 text-success"></i>Valor Unitario:
              </label>
              <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="text" class="form-control valor_formateado" name="valor" id="valor<?php echo $mostrar['ID']; ?>"
                  value="<?php echo $mostrar['Valor Unitario']; ?>" oninput="formatCurrency(this); calcularTotal(<?php echo $mostrar['ID']; ?>)">
              </div>
            </div>
            <div class="col-md-6">
              <label for="cantidad<?php echo $mostrar['ID']; ?>" class="form-label fw-bold">
                <i class="fas fa-cubes me-1 text-warning"></i>Cantidad:
              </label>
              <input type="number" class="form-control" name="cantidad" id="cantidad<?php echo $mostrar['ID']; ?>"
                value="<?php echo $mostrar['Cantidad']; ?>" min="1" step="1" max="1000000"
                oninput="calcularTotal(<?php echo $mostrar['ID']; ?>)">
            </div>
          </div>

          <div class="mb-3">
            <label for="total<?php echo $mostrar['ID']; ?>" class="form-label fw-bold">
              <i class="fas fa-calculator me-1 text-danger"></i>Total:
            </label>
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="text" class="form-control bg-light" name="total" id="total<?php echo $mostrar['ID']; ?>"
                value="<?php echo number_format($mostrar['Total'], 0, ',', '.'); ?>" readonly>
            </div>
            <div class="form-text text-muted">
              <small><i class="fas fa-info-circle me-1"></i>Este valor se calcula automáticamente</small>
            </div>
          </div>
        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Cancelar
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Guardar Cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function calcularTotal(id) {
    let valor = parseCurrency(document.getElementById("valor" + id).value);
    let cantidad = parseInt(document.getElementById("cantidad" + id).value) || 0;

    let total = valor * cantidad;

    // Actualizar el campo Total
    document.getElementById("total" + id).value = total.toLocaleString('es-CL');
  }
</script>
<!---fin ventana Update --->