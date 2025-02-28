<!--ventana para Update--->
<div class="modal fade" id="Nueva_Cotizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #563d7c !important;">
        <h6 class="modal-title" style="color: #fff; text-align: center;">
          Nueva Cotizacion
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <style>
        .div1 {
          text-align: center;
        }
      </style>



      <form name="form-data" action="recib_Delete_Cotizacion.php" method="POST">
        <div class="modal-body div1" id="cont_modal">
          <h3>Desea crear una nueva cotizacion y eliminar esta?</h3>
        </div>
        <div class="modal-footer" style="display: flex;justify-content: center;">
          <button type=" submit" name="Nueva" class="btn btn-primary" id="btnEnviar">
            Si, deseo crear una nueva cotizacion y eliminar esta
          </button>
          <button type="button" class="btn btn-light" onclick="toggleDiv()">
            No, deseo guardar esta y crear otra
          </button>

          <div id="formDiv" class="form-group" style="display:none">
            <div class="form-group">
              <label for="nombre_cliente" class="col-form-label">
                Nombre de la Cliente:
              </label>
              <input type="text" name="nombre_cliente" id="nombre" list="nombres" class="form-control">
              <datalist id="nombres">
                <?php
                $clientes = $conexion->query("SELECT DISTINCT Nombre FROM `clientes_cotizacion`;;");

                foreach ($clientes as $cliente) {
                  echo "<option value='" . $cliente['Nombre'] . "'></option>";
                }

                ?>
              </datalist>
              <div class="modal-footer" style="display: flex;justify-content: center;">
                <button type="submit" name="guardar" class="btn btn-primary">
                  Guardar Cotizacion
                </button>
              </div>
            </div>
          </div>
          <script>
            function toggleDiv() {
              var formDiv = document.getElementById('formDiv');
              var nombreInput = document.getElementById('nombre');
              if (formDiv.style.display === 'none' || formDiv.style.display === '') {
                formDiv.style.display = 'block';
                nombreInput.setAttribute('required', 'required');
              } else {
                formDiv.style.display = 'none';
                nombreInput.removeAttribute('required');
              }
            }
          </script>
        </div>
    </div>
    </form>

  </div>
</div>
</div>
<!---fin ventana Update --->