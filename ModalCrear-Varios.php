<!-- Modal para Crear Múltiples Materiales -->
<div class="modal fade" id="Crear2" tabindex="-1" role="dialog" aria-labelledby="tituloModalMateriales" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Encabezado del Modal -->
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="tituloModalMateriales">
          <i class="fas fa-plus-circle mr-2"></i>Crear Múltiples Materiales
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Cuerpo del Modal -->
      <div class="modal-body">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <i class="fas fa-info-circle mr-2"></i>Agregue los materiales que necesite y sus detalles
          <button type="button" class="btn-close" data-dismiss="alert" aria-label="Cerrar"></button>
        </div>

        <form id="create-materials-form" action="procesar_materiales.php" method="post">
          <!-- Encabezados de la tabla -->
          <div class="row mb-2 font-weight-bold ocultar">
            <div class="col-md-4">Nombre del Material</div>
            <div class="col-md-2">Valor Unitario</div>
            <div class="col-md-2">Cantidad</div>
            <div class="col-md-2">Total</div>
            <div class="col-md-2">Acciones</div>
          </div>

          <!-- Contenedor de materiales -->
          <div id="materials-container">
            <div class="mb-3" data-index="0">
              <div class="row">
                <div class="col-md-4">
                  <input type="text" class="form-control" name="material[]" placeholder="Nombre del material" required>
                </div>
                <div class="col-md-2">
                  <div class="input-group">
                    <input
                      type="text"
                      class="form-control valor_unitario valor_formateado"
                      name="valor_uni[]"
                      placeholder="$0"
                      required
                      oninput="formatCurrency(this); replicateValue(this)">
                  </div>
                </div>
                <div class="col-md-2">
                  <input
                    type="number"
                    class="form-control cantidad"
                    name="cantidad[]"
                    placeholder="0"
                    min="1"
                    required
                    oninput="calculateTotal(this)">
                </div>
                <div class="col-md-2">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$</span>
                    </div>
                    <input
                      type="text"
                      class="form-control total"
                      name="total[]"
                      placeholder="0"
                      readonly>
                  </div>
                </div>
                <div class="col-md-2">
                  <button
                    type="button"
                    class="btn btn-outline-danger btn-block btn-delete"
                    onclick="removeMaterialInput(this)"
                    disabled>
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Resumen de totales -->
          <div class="row mt-4 mb-3">
            <div class="col-md-8 text-right">
              <strong>Total acumulado:</strong>
            </div>
            <div class="col-md-2">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">$</span>
                </div>
                <input type="text" class="form-control" id="grand-total" value="0" readonly>
              </div>
            </div>
            <div class="col-md-2"></div>
          </div>

          <!-- Botones del formulario -->
          <div class="row mt-4">
            <div class="col-md-6">
              <button type="button" class="btn btn-success btn-block  w-100" id="add-material-button" onclick="addMaterialInput()">
                <i class="fas fa-plus mr-1"></i> Añadir Material
              </button>
            </div>
            <div class="col-md-6">
              <button type="submit" class="btn btn-primary w-100" id="create-materials-button">
                <i class="fas fa-save me-1"></i> Guardar Materiales
              </button>
            </div>
          </div>
        </form>
      </div>

      <!-- Pie del Modal -->
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times mr-1"></i> Cerrar
        </button>
        <button type="button" class="btn btn-danger" onclick="resetForm()">
          <i class="fas fa-redo mr-1"></i> Reiniciar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript para la funcionalidad -->
<script>
  // Variable para seguir el conteo de materiales
  let materialCount = 1;

  // Función para añadir un nuevo material
  function addMaterialInput() {
    const container = document.getElementById('materials-container');
    const newInput = document.createElement('div');
    newInput.className = 'mb-3';
    newInput.dataset.index = materialCount;

    newInput.innerHTML = `
   <div class="row">
                <div class="col-md-4">
                  <input type="text" class="form-control" name="material[]" placeholder="Nombre del material" required>
                </div>
                <div class="col-md-2">
                  <div class="input-group">
                    <input
                      type="text"
                      class="form-control valor_unitario valor_formateado"
                      name="valor_uni[]"
                      placeholder="$0"
                      required
                      oninput="formatCurrency(this); replicateValue(this)">
                  </div>
                </div>
                <div class="col-md-2">
                  <input
                    type="number"
                    class="form-control cantidad"
                    name="cantidad[]"
                    placeholder="0"
                    min="1"
                    required
                    oninput="calculateTotal(this)">
                </div>
                <div class="col-md-2">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$</span>
                    </div>
                    <input
                      type="text"
                      class="form-control total"
                      name="total[]"
                      placeholder="0"
                      readonly>
                  </div>
                </div>
                <div class="col-md-2">
                     <button type="button" class="btn btn-outline-danger btn-block btn-delete" onclick="removeMaterialInput(this)">
                  <i class="fas fa-trash-alt"></i>
                </button>
                </div>
              </div>
    `;

    container.appendChild(newInput);


    materialCount++;

    // Efecto de resaltado al añadir nuevo material
    const addedItem = container.lastElementChild;
    addedItem.style.backgroundColor = '#f0fff0';
    setTimeout(() => {
      addedItem.style.transition = 'background-color 1s';
      addedItem.style.backgroundColor = 'transparent';
    }, 100);
  }

  // Función para eliminar un material
  function removeMaterialInput(button) {
    const materialInput = button.closest('.material-input');

    // Efecto de desvanecimiento al eliminar
    materialInput.style.transition = 'opacity 0.5s';
    materialInput.style.opacity = '0';

    setTimeout(() => {
      materialInput.remove();
      updateDeleteButtons();
      updateGrandTotal();
    }, 500);
  }

  // Función para formatear el valor como moneda
  function formatCurrency(input) {
    let value = input.value;
    value = value.replace(/[^\d,-]/g, ''); // Eliminar caracteres no numéricos, excepto coma y guion
    input.value = value;
  }

  // Función para calcular el total basado en el valor unitario y la cantidad
  function calculateTotal(input) {
    let row = input.closest('.row');
    let valorUnitario = parseFloat(row.querySelector('.valor_formateado').value.replace(/[^0-9]+/g, "")) || 0;
    let cantidad = parseFloat(row.querySelector('.cantidad').value) || 0;
    let total = valorUnitario * cantidad;

    // Actualiza el total en el campo correspondiente
    row.querySelector('.total').value = total.toLocaleString('es-CL', {
      style: 'currency',
      currency: 'CLP'
    });

    row.querySelector('.valor_formateado').value = valorUnitario.toLocaleString('es-CL', {
      style: 'currency',
      currency: 'CLP'
    });

    updateGrandTotal();
  }



  // Actualizar el total acumulado
  function updateGrandTotal() {
    const totalInputs = document.querySelectorAll('.total');
    let grandTotal = 0;

    totalInputs.forEach(input => {
      // Obtenemos el valor del input y limpiamos los caracteres no numéricos
      let value = parseFloat(input.value.replace(/[^0-9]+/g, "")) || 0; // Eliminar todo lo que no sea número o punto

      // Sumamos el valor al total acumulado
      grandTotal += parseFloat(value) || 0;
    });

    // Actualizamos el valor del grand total con formato
    document.getElementById('grand-total').value = grandTotal.toLocaleString('es-CL', {
      minimumFractionDigits: 0,
      maximumFractionDigits: 0
    });
  }

  // Función para eliminar el campo de material
  function removeMaterialInput(button) {
    let row = button.closest('.mb-3');
    row.remove();
    updateGrandTotal();
  }

  // Reiniciar el formulario
  function resetForm() {
    if (confirm('¿Está seguro de reiniciar el formulario? Perderá todos los datos ingresados.')) {
      const container = document.getElementById('materials-container');

      // Mantener solo el primer input y reiniciarlo
      while (container.children.length > 1) {
        container.removeChild(container.lastChild);
      }

      const firstInput = container.firstElementChild;
      const inputs = firstInput.querySelectorAll('input');
      inputs.forEach(input => {
        input.value = '';
      });

      document.getElementById('grand-total').value = '0';
      updateDeleteButtons();
      materialCount = 1;
    }
  }

  // Inicializar al cargar la página
  document.addEventListener('DOMContentLoaded', function() {
    updateDeleteButtons();

    // Prevenir que se envíe el formulario si no hay materiales
    document.getElementById('create-materials-form').addEventListener('submit', function(event) {
      const materialInputs = document.querySelectorAll('.material-input');
      const hasEmptyInputs = Array.from(materialInputs).some(input => {
        return !input.querySelector('[name="material[]"]').value ||
          !input.querySelector('[name="valor_uni[]"]').value ||
          !input.querySelector('[name="cantidad[]"]').value;
      });

      if (hasEmptyInputs) {
        event.preventDefault();
        alert('Por favor complete todos los campos requeridos.');
      }
    });
  });
</script>