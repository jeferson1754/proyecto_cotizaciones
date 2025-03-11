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
                <input
                  type="text"
                  class="form-control form-control-lg valor_formateado"
                  id="valor"
                  name="valor"
                  placeholder="$0"
                  required
                  oninput="formatCurrency(this); replicateValue();">
              </div>
            </div>

            <!-- Input number para replicar el valor -->

            <input
              type="number"
              class="form-control form-control-lg"
              id="valorNumber"
              name="valorNumber"
              placeholder="0"
              min="0"
              step="0.01"
              style="display:none;"
              required>


            <script>
              // Función para formatear el valor como moneda
              function formatCurrency(input) {
                let value = input.value;
                value = value.replace(/[^\d,-]/g, ''); // Eliminar caracteres no numéricos, excepto coma y guion
                input.value = value;
              }

              // Función para replicar el valor en el input number
              function replicateValue() {
                let textValue = document.getElementById("valor").value;
                let numberValue = parseFloat(textValue.replace(/[^0-9]+/g, "")); // Elimina todo excepto números y puntos

                // Asignar el valor numérico al input number
                document.getElementById("valorNumber").value = numberValue || 0;
              }
            </script>


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
                max="1000000"
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
  // Función para calcular el total
  function calculateTotal2() {
    // Obtiene el valor unitario, asegurándose de limpiarlo con parseCurrency
    let valor = Math.floor(parseFloat(document.getElementById("valorNumber").value)) || 0;
    // Asegurarse de que la cantidad sea un número entero
    let cantidad = Math.floor(parseFloat(document.getElementById("cantidad").value)) || 0;

    // Calcula el total
    let total = valor * cantidad;

    // Actualiza el total en la tarjeta de Total Estimado
    document.getElementById("totalPreview").textContent = total.toLocaleString('es-CL', {
      style: 'currency',
      currency: 'CLP'
    });

  }
</script>