<!-- Modal para Nueva Cotización -->
<div class="modal fade" id="Nueva_Cotizacion" tabindex="-1" aria-labelledby="nuevaCotizacionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nuevaCotizacionModalLabel">
          <i class="fas fa-file-invoice me-2"></i>Nueva Cotización
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form name="form-data" action="recib_Delete_Cotizacion.php" method="POST">
        <div class="modal-body">
          <div class="text-center mb-4">
            <div class="alert alert-warning">
              <i class="fas fa-question-circle fa-2x mb-3"></i>
              <h5>¿Qué desea hacer con la cotización actual?</h5>
              <p class="text-muted mb-0">Seleccione una de las siguientes opciones</p>
            </div>
          </div>

          <div class="d-grid gap-3 mb-2">
            <!-- Option 1: Create new and delete current -->
            <button type="submit" name="Nueva" class="btn btn-primary btn-lg w-100" id="btnEnviar">
              <i class="fas fa-trash-alt me-2"></i>Crear nueva y eliminar actual
            </button>

            <!-- Option 2: Save current and create new -->
            <button type="button" class="btn btn-outline-primary btn-lg w-100" id="saveAndCreateBtn" onclick="toggleClientForm()">
              <i class="fas fa-save me-2"></i>Guardar actual y crear nueva
            </button>
          </div>

          <!-- Client form - initially hidden -->
          <div id="clientFormSection" style="display:none" class="mt-4 border-top pt-4">
            <div class="mb-3">
              <label for="nombre_cliente" class="form-label fw-bold">
                <i class="fas fa-user me-1"></i>Nombre del Cliente:
              </label>
              <div class="input-group">
                <input
                  type="text"
                  name="nombre_cliente"
                  id="nombre"
                  list="nombres"
                  class="form-control form-control-lg"
                  placeholder="Seleccione o ingrese un nombre"
                  autocomplete="off">
                <button class="btn btn-outline-secondary" type="button">
                  <i class="fas fa-search"></i>
                </button>
              </div>
              <datalist id="nombres">
                <?php
                $clientes = $conexion->query("SELECT DISTINCT Nombre FROM `clientes_cotizacion`;");
                foreach ($clientes as $cliente) {
                  echo "<option value='" . $cliente['Nombre'] . "'></option>";
                }
                ?>
              </datalist>
              <div class="form-text">Seleccione un cliente existente o ingrese uno nuevo</div>
            </div>

            <div class="d-grid">
              <button type="submit" name="guardar" class="btn btn-success btn-lg">
                <i class="fas fa-check-circle me-2"></i>Guardar Cotización
              </button>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function toggleClientForm() {
    const clientFormSection = document.getElementById('clientFormSection');
    const nombreInput = document.getElementById('nombre');

    if (clientFormSection.style.display === 'none') {
      // Show form with animation
      clientFormSection.style.display = 'block';
      nombreInput.setAttribute('required', 'required');
      nombreInput.focus();

      // Change button appearance
      document.getElementById('saveAndCreateBtn').classList.add('active');
    } else {
      // Hide form
      clientFormSection.style.display = 'none';
      nombreInput.removeAttribute('required');

      // Reset button appearance
      document.getElementById('saveAndCreateBtn').classList.remove('active');
    }
  }
</script>