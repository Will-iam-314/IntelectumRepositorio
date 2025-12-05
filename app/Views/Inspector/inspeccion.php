<?= $this->extend('layouts/InspectorTemplate.php'); ?>

<?= $this->section('content');?>

<div class="container-fluid py-4">
    <!-- Encabezado con botón de regreso -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <button onclick='confirmarRegreso()' class="btn btn-outline-secondary mb-2">
                <i class="fas fa-arrow-left me-2"></i>Atrás
            </button>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-search-plus me-2"></i>Inspección de Material
            </h1>
        </div>
    </div>

    <!-- Información del trámite -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-2">
                        <i class="fas fa-file-alt text-primary me-2"></i>
                        <?= esc($tituloMaterial) ?>
                    </h5>
                    <p class="text-muted mb-0">
                        <span class="badge bg-secondary me-2">
                            <i class="fas fa-hashtag me-1"></i><?= esc($codigoTramite) ?>
                        </span>
                        <small>
                            <i class="fas fa-calendar me-1"></i>
                            Presentado: <?= date('d/m/Y', strtotime($fechapresentacionTramite)) ?>
                        </small>
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <span class="badge bg-info fs-6">
                        <i class="fas fa-info-circle me-1"></i><?= esc($estadoTramite) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerta de observaciones anteriores -->
    <?php if(!empty($observaciones)): ?>
        <div class="alert alert-warning shadow-sm" role="alert">
            <div class="d-flex">
                <div class="me-3">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                </div>
                <div>
                    <h5 class="alert-heading">
                        <i class="fas fa-clipboard-list me-2"></i>Observaciones Anteriores
                    </h5>
                    <p class="mb-0"><?= nl2br(esc($observaciones)) ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Contenedor principal: Visor y Panel -->
    <div class="row g-4">
        <!-- Visor de documentos -->
        <div class="col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-file-pdf me-2"></i>Visor de Documentos
                    </h6>
                </div>
                <div class="card-body p-2">
                    <div class="pdf-container">
                        <iframe 
                            id="pdfViewer" 
                            class="pdf-viewer"
                            src="<?= base_url('inspector/documentos/verTesis/'.$fileTesis) ?>"
                            title="Visor de PDF">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de inspección y detalles -->
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <ul class="nav nav-tabs card-header-tabs" id="tabMenu" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button style="color:black !important;" class="nav-link active" id="inspeccion-tab" data-bs-toggle="tab" 
                                    data-bs-target="#inspeccion" type="button" role="tab">
                                <i class="fas fa-clipboard-check me-2"></i>Inspección
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button style="color:black !important;" class="nav-link" id="detalle-tab" data-bs-toggle="tab" 
                                    data-bs-target="#detalle" type="button" role="tab">
                                <i class="fas fa-info-circle me-2"></i>Detalle
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body">
                    <div class="tab-content" id="tabContent">
                        
                        <!-- Tab de Inspección -->
                        <div class="tab-pane fade show active" id="inspeccion" role="tabpanel">
                            <form action="<?= base_url('inspector/nuevaInspeccion/'.$idMaterial.'/'.$codigoTramite) ?>" 
                                  method="POST" onsubmit="mostrarLoading()">
                                <?= csrf_field() ?>
                                
                                <!-- Selector de documento -->
                                <div class="mb-4">
                                    <label for="documentSelect" class="form-label fw-bold">
                                        <i class="fas fa-folder-open me-2"></i>Seleccionar Documento
                                    </label>
                                   
                                    <select id="documentSelect" class="form-select form-select-lg">
                                        <option value="<?= base_url('inspector/documentos/verTesis/'.$fileTesis) ?>" selected>
                                            <i class="fas fa-book"></i> Tesis Principal
                                        </option>
                                        <option value="<?= base_url('inspector/documentos/verDeclaracionJurada/'.$fileDeclaracionJuradaTramite) ?>">
                                            Declaración Jurada
                                        </option>
                                        <option value="<?= base_url('inspector/documentos/verAutorizacionPublicacion/'.$fileAutorizacionPublicacionTramite) ?>">
                                            Autorización de Publicación
                                        </option>
                                    </select>
                                </div>

                                <!-- Switch de observaciones -->
                                <div class="card bg-light mb-4">
                                    <div class="card-body">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="tiene_observaciones" 
                                                   type="checkbox" id="toggleObservaciones" role="switch">
                                            <label class="form-check-label fw-bold" for="toggleObservaciones">
                                                <i class="fas fa-comment-dots me-2"></i>Añadir Observaciones
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Área de observaciones -->
                                <div class="mb-4">
                                    <label for="observaciones" class="form-label fw-bold">
                                        <i class="fas fa-edit me-2"></i>Observaciones
                                    </label>
                                    <textarea id="observaciones" name="observaciones" 
                                              class="form-control" rows="14" 
                                              placeholder="Presione Enter para agregar una nueva observación..."
                                              disabled></textarea>
                                    <small class="text-muted mt-1 d-block">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Use Enter para crear nuevas viñetas. 
                                    </small>
                                </div>
                                
                                <!-- Botón de envío -->
                                <button type="submit" class="btn btn-success btn-lg w-100 mb-1">
                                    <i class="fas fa-check-circle me-2"></i>Terminar Inspección
                                </button>
                            </form>
                        </div>

                        <!-- Tab de Detalle -->
                        <div class="tab-pane fade" id="detalle" role="tabpanel">
                            <div class="detail-section">
                                <!-- Datos del Trámite -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-folder text-primary me-2"></i>Datos del Trámite
                                    </h5>
                                    <ul class="list-unstyled ps-3">
                                        <li class="mb-2">
                                            <strong><i class="fas fa-hashtag text-muted me-2"></i>Código:</strong> 
                                            <code><?= esc($codigoTramite) ?></code>
                                        </li>
                                        <li class="mb-2">
                                            <strong><i class="fas fa-calendar-day text-muted me-2"></i>Fecha de presentación:</strong> 
                                            <?= date('d/m/Y', strtotime($fechapresentacionTramite)) ?>
                                        </li>
                                        <li class="mb-2">
                                            <strong><i class="fas fa-flag text-muted me-2"></i>Estado:</strong> 
                                            <span class="badge bg-info"><?= esc($estadoTramite) ?></span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Datos del Material -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-book text-primary me-2"></i>Datos del Material
                                    </h5>
                                    <ul class="list-unstyled ps-3">
                                        <li class="mb-2">
                                            <strong><i class="fas fa-heading text-muted me-2"></i>Título:</strong> 
                                            <?= esc($tituloMaterial) ?>
                                        </li>
                                        <li class="mb-2">
                                            <strong><i class="fas fa-align-left text-muted me-2"></i>Resumen:</strong> 
                                            <div class="text-muted small mt-1"><?= esc($resumenTesis) ?></div>
                                        </li>
                                        <li class="mb-2">
                                            <strong><i class="fas fa-tags text-muted me-2"></i>Palabras clave:</strong>
                                            <div class="mt-1">
                                                <?php foreach($palabrasclaveTesis as $palabraClave): ?>
                                                    <span class="badge bg-secondary me-1 mb-1"><?= trim($palabraClave) ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        </li>
                                        <li class="mb-2">
                                            <strong><i class="fas fa-users text-muted me-2"></i>Autores:</strong>
                                            <?php if (!empty($autores)): ?>
                                                <ul class="list-unstyled ms-4 mt-2">
                                                    <?php foreach ($autores as $autor): ?>
                                                        <li class="mb-1">
                                                            <i class="fas fa-user-circle text-primary me-2"></i>
                                                            <?= $autor['nombre'] ?? 'N/D' ?> 
                                                            <small class="text-muted">(DNI: <?= $autor['dni'] ?? 'N/D' ?>)</small>
                                                        </li>
                                                    <?php endforeach; ?>    
                                                </ul>
                                            <?php else: ?>
                                                <p class="text-muted small">No se encontraron autores.</p>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Datos del Solicitante -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-user-graduate text-primary me-2"></i>Datos del Solicitante
                                    </h5>
                                    <ul class="list-unstyled ps-3">
                                        <li class="mb-2">
                                            <strong><i class="fas fa-id-card text-muted me-2"></i>Nombres:</strong> 
                                            <?= esc($solicitanteNombre) ?>
                                        </li>
                                        <li class="mb-2">
                                            <strong><i class="fas fa-id-card text-muted me-2"></i>Apellidos:</strong> 
                                            <?= esc($solicitanteApellido) ?>
                                        </li>
                                        <li class="mb-2">
                                            <strong><i class="fas fa-fingerprint text-muted me-2"></i>DNI:</strong> 
                                            <code><?= esc($solicitanteDNI) ?></code>
                                        </li>
                                        <li class="mb-2">
                                            <strong><i class="fas fa-graduation-cap text-muted me-2"></i>Carrera:</strong> 
                                            <?= esc($solicitanteEscuela) ?>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Docentes -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-chalkboard-teacher text-primary me-2"></i>Docentes
                                    </h5>
                                    <ul class="list-unstyled ps-3">
                                        <li class="mb-2">
                                            <strong><i class="fas fa-user-tie text-success me-2"></i>Asesor:</strong> 
                                            <?= esc($Asesor) ?>
                                        </li>
                                        <li class="mb-2">
                                            <strong><i class="fas fa-user-tie text-info me-2"></i>Jurado 1:</strong> 
                                            <?= esc($Jurado1) ?>
                                        </li>
                                        <li class="mb-2">
                                            <strong><i class="fas fa-user-tie text-info me-2"></i>Jurado 2:</strong> 
                                            <?= esc($Jurado2) ?>
                                        </li>
                                        <li class="mb-2">
                                            <strong><i class="fas fa-user-tie text-info me-2"></i>Jurado 3:</strong> 
                                            <?= esc($Jurado3) ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes de error -->
    <?php if(session()->getFlashdata('errors')!==null): ?>
        <div class="alert alert-danger shadow-sm mt-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('errors');?>
        </div>
    <?php endif; ?>
</div>

<style>
    /* Estilos del visor PDF */
    .pdf-container {
        width: 100%;
        height: 720px;
        background: #f5f5f5;
        border-radius: 0.375rem;
        overflow: hidden;
    }

    .pdf-viewer {
        width: 100%;
        height: 100%;
        border: none;
    }

    /* Estilos responsive para el visor */
    @media (max-width: 1199.98px) {
        .pdf-container {
            height: 600px;
        }
    }

    @media (max-width: 991.98px) {
        .pdf-container {
            height: 500px;
        }
    }

    @media (max-width: 767.98px) {
        .pdf-container {
            height: 400px;
        }
    }

    /* Tabs personalizados */
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 0.75rem 1.25rem;
        transition: all 0.3s;
    }

    .nav-tabs .nav-link:hover {
        color: #0d6efd;
        background-color: #f8f9fa;
    }

    .nav-tabs .nav-link.active {
        color: #0d6efd;
        background-color: #fff;
        border-bottom: 3px solid #0d6efd;
    }

    /* Área de observaciones */
    #observaciones {
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
        line-height: 1.6;
        resize: vertical;
    }

    #observaciones:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;
    }

    /* Switch personalizado */
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    /* Sección de detalles */
    .detail-section {
        max-height: 650px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 10px;
    }

    .detail-section::-webkit-scrollbar {
        width: 8px;
    }

    .detail-section::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .detail-section::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .detail-section::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Cards */
    .card {
        border: none;
        border-radius: 0.5rem;
    }

    .card-header {
        border-bottom: 2px solid #e9ecef;
    }

    /* Badges */
    code {
        background-color: #f8f9fa;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        color: #d63384;
    }

    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .detail-section {
            max-height: none;
        }
    }

    /* Animaciones */
    .card {
        transition: transform 0.2s;
    }

    .btn {
        transition: all 0.3s;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Alert personalizado */
    .alert {
        border-left: 4px solid;
        border-radius: 0.5rem;
    }

    .alert-warning {
        border-left-color: #ffc107;
    }

    .alert-danger {
        border-left-color: #dc3545;
    }
</style>

<?= $this->endSection();?>

<?= $this->section('scripts');?>

<script>
    // Cambiar documento en visor
    document.getElementById('documentSelect').addEventListener('change', function() {
        const viewer = document.getElementById('pdfViewer');
        viewer.src = this.value;
        
        // Añadir efecto de carga
        viewer.style.opacity = '0.5';
        setTimeout(() => {
            viewer.style.opacity = '1';
        }, 300);
    });

    // Toggle observaciones
    const toggle = document.getElementById('toggleObservaciones');
    const observaciones = document.getElementById('observaciones');

    toggle.addEventListener('change', function() {
        if (this.checked) {
            observaciones.disabled = false;
            observaciones.focus();
            // Inicializar con primera viñeta si está vacío
            if (observaciones.value === '') {
                observaciones.value = '●_';
            }
        } else {
            observaciones.disabled = true;
            observaciones.value = ""; // limpiar si se desactiva
        }
    });

    // Manejo de viñetas en textarea
    const textarea = document.getElementById('observaciones');

    textarea.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            
            const start = this.selectionStart;
            const end = this.selectionEnd;
            const value = this.value;
            
            // Si la línea actual está vacía (solo tiene "●_"), eliminar la viñeta
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

    // Confirmación de regreso
    function confirmarRegreso() {
        if (confirm('¿Está seguro de que desea salir? Los cambios no guardados se perderán.')) {
            window.history.back();
        }
    }

    // Función para mostrar loading (debe ser definida según tu implementación)
    function mostrarLoading() {
        // Implementar según necesidades
        console.log('Procesando inspección...');
    }
</script>

<?= $this->endSection();?>