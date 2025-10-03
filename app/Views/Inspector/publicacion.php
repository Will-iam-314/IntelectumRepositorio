<?= $this->extend('layouts/InspectorTemplate.php'); ?>

<?= $this->section('content');?>

<div class="container mt-5">
    <div class="card mb-4 shadow-sm">
        <div class="card-body text-center">
            <h5 class="card-title">Archivos para Publicación</h5>
            <p class="card-text">Haz clic para descargar los archivos que serán publicados.</p>
            <a href="<?= base_url('inspector/downloadPaquete/'.$codigoTramite) ?>" class="btn btn-primary btn-lg">
                <i class="fas fa-download"></i> Descargar archivos de publicación
            </a>
        </div>
    </div>

    <form action="<?= base_url('inspector/registrarURLpubliacion/'.$idTramite) ?>" method="post">
        <?= csrf_field() ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Estado de Publicación</h5>
                <div class="d-flex align-items-center justify-content-between">
                    <p class="card-text mb-0 fs-5">¿Se publicó el material?</p>
                    
                    <div class="form-check form-switch form-check-inline me-2">
                        <input class="form-check-input" type="checkbox" id="publicadoSwitch">
                        <label class="form-check-label" for="publicadoSwitch" id="publicadoLabel">No</label>
                    </div>
                </div>

                <div id="urlContainer" class="mt-3 d-none">
                    <label for="urlPublicacion" class="form-label">URL de la Publicación:</label>
                    <input type="url" class="form-control" id="urlPublicacion" name="urlPublicacion" placeholder="Ingrese el URL">
                </div>
            </div>
        </div>
        
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success btn-lg" id="guardarBtn" disabled>Guardar</button>
        </div>
    </form>
</div>

<?= $this->endSection();?>



<?= $this->section('scripts');?>
<script>
    const toggleSwitch = document.getElementById('publicadoSwitch');
    const label = document.getElementById('publicadoLabel');
    const guardarBtn = document.getElementById('guardarBtn');
    const urlContainer = document.getElementById('urlContainer');
    const urlInput = document.getElementById('urlPublicacion');

    toggleSwitch.addEventListener('change', function() {
        if (this.checked) {
            label.textContent = 'Sí';
            guardarBtn.disabled = false; // Habilitar el botón
            urlContainer.classList.remove('d-none'); // Mostrar el campo de URL
            urlInput.setAttribute('required', 'required'); // Hacer el campo requerido
        } else {
            label.textContent = 'No';
            guardarBtn.disabled = true;  // Deshabilitar el botón
            urlContainer.classList.add('d-none'); // Ocultar el campo de URL
            urlInput.removeAttribute('required'); // Eliminar el requisito
            urlInput.value = ''; // Limpiar el valor
        }
    });
</script>
<?= $this->endSection();?>