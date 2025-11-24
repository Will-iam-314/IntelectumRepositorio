<?= $this->extend('layouts/InspectorTemplate.php'); ?>

<?= $this->section('content');?>

<button onclick='confirmarRegreso()'>Atrás</button>

<h1>INSPECCIÓN</h1>

<div class="container-fluid">
    <h3 class="mb-4">
        Trámite: <?= esc($tituloMaterial) ?> 
        <small class="text-muted">(Código: <?= esc($codigoTramite) ?>)</small>
    </h3>

    <?php if(!empty($observaciones)): ?>
        <div class="alert alert-warning" role="alert">
            <strong>⚠️ Observaciones Anteriores:</strong>
            <p class="mb-0"><?= nl2br(esc($observaciones)) ?></p>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-lg-7 mb-3">
            <iframe id="pdfViewer" width=720 height=720 src="<?= base_url('inspector/documentos/verTesis/'.$fileTesis) ?>"></iframe>
        </div>

        <div class="col-lg-5">
            <ul class="nav nav-tabs" id="tabMenu" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="inspeccion-tab" data-bs-toggle="tab" data-bs-target="#inspeccion" type="button" role="tab">
                        Inspección
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="detalle-tab" data-bs-toggle="tab" data-bs-target="#detalle" type="button" role="tab">
                        Detalle
                    </button>
                </li>
            </ul>
            <div class="tab-content border border-top-0 p-3 bg-light" id="tabContent">
                
                <div class="tab-pane fade show active" id="inspeccion" role="tabpanel">
                    
                    <form action="<?= base_url('inspector/nuevaInspeccion/'.$idMaterial.'/'.$codigoTramite) ?>" method="POST" onsubmit= "mostrarLoading()">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="documentSelect" class="form-label">Seleccionar documento</label>
                            <select id="documentSelect" class="form-select">
                                <option value="<?= base_url('inspector/documentos/verTesis/'.$fileTesis) ?>">Tesis</option>
                                <option value="<?= base_url('inspector/documentos/verDeclaracionJurada/'.$fileDeclaracionJuradaTramite) ?>">Declaración Jurada</option>
                                <option value="<?= base_url('inspector/documentos/verAutorizacionPublicacion/'.$fileAutorizacionPublicacionTramite) ?>">Autorización Publicación</option>
                            </select>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" name="tiene_observaciones" type="checkbox" id="toggleObservaciones">
                            <label class="form-check-label" for="toggleObservaciones">Añadir observaciones</label>
                        </div>

                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea  id="observaciones" name="observaciones" class="form-control" rows="10" disabled></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100">Terminar Inspección</button>
                    </form>
                </div>

                <div class="tab-pane fade" id="detalle" role="tabpanel">
                    <h5>Datos del Trámite</h5>
                    <ul>
                        <li><strong>Código:</strong> <?= esc($codigoTramite) ?></li>
                        <li><strong>Fecha de presentación:</strong> <?= date('d/m/Y', strtotime($fechapresentacionTramite)) ?></li>
                        <li><strong>Estado:</strong> <?= esc($estadoTramite) ?></li>
                    </ul>

                    <h5>Datos del Material</h5>
                    <ul>
                        <li><strong>Título:</strong> <?= esc($tituloMaterial) ?></li>
                        <li><strong>Resumen:</strong> <?= esc($resumenTesis) ?></li>
                        <li><strong>Palabras clave:</strong> 
                     
                        <?php foreach($palabrasclaveTesis as $palabraClave){
                            echo($palabraClave.", ");
                        } ?>
 
                        </li>

                        <li><strong>Autores:</strong> </li>
                        <?php if (!empty($autores)): ?>
                            <ul>
                                <?php foreach ($autores as $autor): ?>
                                    <li>
                                        Nombre: <?= $autor['nombre'] ?? 'N/D' ?> 
                                        (DNI: <?= $autor['dni'] ?? 'N/D' ?>)
                                    </li>
                                <?php endforeach; ?>    
                            </ul>    



                            
                        <?php else: ?>
                            <p>No se encontraron autores.</p>
                        <?php endif; ?>
                    </ul>

                    <h5>Datos del Solicitante</h5>  
                    <ul>
                        <li><strong>Nombres:</strong> <?= esc($solicitanteNombre) ?></li>
                        <li><strong>Apellidos:</strong> <?= esc($solicitanteApellido) ?></li>
                        <li><strong>DNI:</strong> <?= esc($solicitanteDNI) ?></li>
                        <li><strong>Carrera:</strong> <?= esc($solicitanteEscuela) ?></li>
                    </ul>

                    <h5>Docentes</h5>
                    <ul>
                        <li><strong>Asesor:</strong> <?= esc($Asesor) ?></li>
                        <li><strong>Jurado 1:</strong> <?= esc($Jurado1) ?></li>
                        <li><strong>Jurado 2:</strong> <?= esc($Jurado2) ?></li>
                        <li><strong>Jurado 3:</strong> <?= esc($Jurado3) ?></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>

<?php if(session()->getFlashdata('errors')!==null): ?>
    <div class= 'alert alert-danger my-3' role='alert'>
        <?= session()->getFlashdata('errors');?>
    </div>
<?php endif; ?>

<?= $this->endSection();?>

<?= $this->section('scripts');?>

<script>
    // cambiar documento en visor
    document.getElementById('documentSelect').addEventListener('change', function() {
        document.getElementById('pdfViewer').src = this.value;
    });

    // toggle observaciones
    const toggle = document.getElementById('toggleObservaciones');
    const observaciones = document.getElementById('observaciones');

    toggle.addEventListener('change', function() {
        if (this.checked) {
            observaciones.disabled = false;
        } else {
            observaciones.disabled = true;
            observaciones.value = ""; // limpiar si se desactiva
        }
    });

    const textarea = document.getElementById('observaciones');

    // Inicializar con primera viñeta
    if (textarea.value === '') {
        textarea.value = '●_';
    }

    textarea.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            
            const start = this.selectionStart;
            const end = this.selectionEnd;
            const value = this.value;
            
            // Si la línea actual está vacía (solo tiene "• "), eliminar la viñeta
            const lineStart = value.lastIndexOf('\n', start - 1) + 1;
            const currentLine = value.substring(lineStart, start);
            
            if (currentLine.trim() === '●_') {
                // Eliminar la viñeta vacía
                this.value = value.substring(0, lineStart) + value.substring(start);
                this.selectionStart = this.selectionEnd = lineStart;
            } else {
                // Agregar nueva línea con viñeta
                const newText = value.substring(0, start) + '\n●_' + value.substring(end);
                this.value = newText;
                this.selectionStart = this.selectionEnd = start + 3;
            }
        }
    });



</script>

<?= $this->endSection();?>