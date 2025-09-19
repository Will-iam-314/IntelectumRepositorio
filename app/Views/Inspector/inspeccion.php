
<?= $this->extend('layouts/InspectorTemplate.php'); ?>

<?= $this->section('content');?>

<button onclick='confirmarRegreso()'>Atras</button>

<h1>INSPECCION</h1>

<div class="container-fluid">
    <h3 class="mb-4">
        Trámite: <?= esc($tituloMaterial) ?> 
        <small class="text-muted">(Código: <?= esc($codigoTramite) ?>)</small>
    </h3>

    <div class="row">
        <!-- Columna izquierda: visor de PDF -->
        <div class="col-lg-7 mb-3">
            <iframe id="pdfViewer" width=720 height=720 src="<?= base_url('inspector/documentos/verTesis/'.$fileTesis) ?>"></iframe>
        </div>

        <!-- Columna derecha: Tabs -->
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
                
                <!-- TAB INSPECCIÓN -->
                <div class="tab-pane fade show active" id="inspeccion" role="tabpanel">
                    <div class="mb-3">
                        <label for="documentSelect" class="form-label">Seleccionar documento</label>
                        <select id="documentSelect" class="form-select">
                            <option value="<?= base_url('inspector/documentos/verTesis/'.$fileTesis) ?>">Tesis</option>
                            <option value="<?= base_url('inspector/documentos/verDeclaracionJurada/'.$fileDeclaracionJuradaTramite) ?>">Declaración Jurada</option>
                            <option value="<?= base_url('inspector/documentos/verAutorizacionPublicacion/'.$fileAutorizacionPublicacionTramite) ?>">Autorización Publicación</option>
                        </select>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="toggleObservaciones">
                        <label class="form-check-label" for="toggleObservaciones">Añadir observaciones</label>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea id="observaciones" class="form-control" rows="4" disabled></textarea>
                    </div>

                    <button class="btn btn-success w-100">Terminar Inspección</button>
                </div>

                <!-- TAB DETALLE -->
                <div class="tab-pane fade" id="detalle" role="tabpanel">
                    <h5>Datos del Trámite</h5>
                    <ul>
                        <li><strong>Código:</strong> <?= esc($codigoTramite) ?></li>
                        <li><strong>Fecha de presentación:</strong> <?= date('d/m/Y', strtotime($fechapresentacionTramite)) ?></li>
                        <li><strong>Estado:</strong> <?= esc($estadoTramite) ?></li>
                    </ul>

                    <h5>Datos de la Tesis</h5>
                    <ul>
                        <li><strong>Título:</strong> <?= esc($tituloMaterial) ?></li>
                        <li><strong>Resumen:</strong> <?= esc($resumenTesis) ?></li>
                        <li><strong>Palabras clave:</strong> <?= esc($palabrasclaveTesis) ?></li>
                    </ul>

                    <h5>Docentes</h5>
                    <ul>
                        <li><strong>Asesor:</strong> <?= esc($nombresAsesor.' '.$apellidosAsesor) ?></li>
                        <li><strong>Jurado 1:</strong> <?= esc($nombresJurado1.' '.$apellidosJurado1) ?></li>
                        <li><strong>Jurado 2:</strong> <?= esc($nombresJurado2.' '.$apellidosJurado2) ?></li>
                        <li><strong>Jurado 3:</strong> <?= esc($nombresJurado3.' '.$apellidosJurado3) ?></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection();?>

<?= $this->section('scripts');?>

<script>
        // cambiar documento en visor
        document.getElementById('documentSelect').addEventListener('change', function() {
            document.getElementById('pdfViewer').src = this.value;
        });

        // toggle observaciones
        document.getElementById('toggleObservaciones').addEventListener('change', function() {
            document.getElementById('observaciones').disabled = !this.checked;
        });
    </script>

<?= $this->endSection();?>