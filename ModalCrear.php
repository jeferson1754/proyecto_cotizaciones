<!-- Modal para Crear Nuevo Material -->
<div class="modal fade" id="Crear" tabindex="-1" aria-labelledby="crearMaterialModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="crearMaterialModalLabel">
          <i class="fas fa-plus-circle me-2"></i>Nuevo Material
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form name="form-data" action="recibCliente.php" method="POST">
        <div class="modal-body">
          <div class="mb-4 text-center">
            <i class="fas fa-cube fa-3x text-primary mb-3"></i>
            <h5>Ingrese los detalles del material</h5>
            <p class="text-muted small">Complete todos los campos para agregar un nuevo material a la cotización</p>
          </div>

          <div class="mb-3">
            <label for="nombre" class="form-label fw-bold">
              <i class="fas fa-tag me-1"></i>Nombre del Material:
            </label>
            <input
              type="text"
              class="form-control form-control-lg"
              id="nombre"
              name="nombre"
              placeholder="Ej: Cemento, Arena, Madera..."
              required
              autofocus>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="valor" class="form-label fw-bold">
                <i class="fas fa-dollar-sign me-1"></i>Valor Unitario:
              </label>
              <div class="input-group">
                <span class="input-group-text">$</span>
                <input
                  type="number"
                  class="form-control form-control-lg"
                  id="valor"
                  name="valor"
                  placeholder="0"
                  min="0"
                  step="1"
                  required
                  oninput="calculateTotal2()">
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label for="cantidad" class="form-label fw-bold">
                <i class="fas fa-hashtag me-1"></i>Cantidad:
              </label>
              <input
                type="number"
                class="form-control form-control-lg"
                id="cantidad"
                name="cantidad"
                placeholder="0"
                min="1"
                step="1"
                required
                oninput="calculateTotal2()">
            </div>
          </div>

          <!-- Total calculation preview -->
          <div class="card bg-light mt-3">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold">Total Estimado:</span>
                <span class="fs-4 fw-bold text-primary" id="totalPreview">$0</span>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Cancelar
          </button>
          <button type="submit" class="btn btn-primary" id="btnEnviar">
            <i class="fas fa-save me-1"></i>Registrar Material
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function calculateTotal2() {
    const valor = parseFloat(document.getElementById('valor').value) || 0;
    const cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
    const total = valor * cantidad;

    // Format as currency
    const formatter = new Intl.NumberFormat('es-CL', {
      style: 'currency',
      currency: 'CLP',
      maximumFractionDigits: 0
    });

    document.getElementById('totalPreview').textContent = formatter.format(total);
  }

  // Initialize modal events
  document.addEventListener('DOMContentLoaded', function() {
    const crearModal = document.getElementById('Crear');
    crearModal.addEventListener('shown.bs.modal', function() {
      document.getElementById('nombre').focus();
    });

    // Reset form when modal is closed
    crearModal.addEventListener('hidden.bs.modal', function() {
      document.querySelector('#Crear form').reset();
      document.getElementById('totalPreview').textContent = '$0';
    });
  });
</script>