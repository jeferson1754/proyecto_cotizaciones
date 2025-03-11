<!--ventana para Confirmación de Eliminación--->
<div class="modal fade" id="editChildresn1<?php echo $mostrar['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $mostrar['ID']; ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel<?php echo $mostrar['ID']; ?>">
          <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Eliminación
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="recib_Delete.php">
        <input type="hidden" name="id" value="<?php echo $mostrar['ID']; ?>">

        <div class="modal-body p-4 text-center">
          <div class="mb-4">
            <div class="avatar-container mb-3">
              <div class="avatar-circle bg-danger bg-opacity-10 mx-auto d-flex align-items-center justify-content-center">
                <i class="fas fa-trash-alt text-danger fa-3x"></i>
              </div>
            </div>

            <p class="fs-5 mb-4">¿Realmente deseas eliminar este material?</p>

            <div class="alert alert-light border p-3 mb-4">
              <h5 class="mb-3 text-dark">
                <i class="fas fa-tag me-2 text-secondary"></i><?php echo $mostrar['Nombre']; ?>
              </h5>
              <div class="d-flex justify-content-center align-items-center">
                <span class="badge bg-primary me-2">Total:</span>
                <span class="fs-5 fw-bold text-primary"><?php echo '$' . number_format($mostrar['Total'], 0, ',', '.'); ?></span>
              </div>
            </div>

            <div class="text-muted small">
              <i class="fas fa-info-circle me-1"></i>Esta acción no se puede deshacer
            </div>
          </div>
        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Cancelar
          </button>
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash-alt me-1"></i>Eliminar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  .avatar-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
  }
</style>
<!---fin ventana Confirmación de Eliminación --->