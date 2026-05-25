<?= $this->extend('layouts/InspectorTemplate.php'); ?>

<?= $this->section('content');?>

<div class="container-fluid py-4">
    <!-- Encabezado con botón de regreso -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <button onclick='regresarSolicitudes()' class="btn btn-outline-secondary mb-2">
                <i class="fas fa-arrow-left me-2"></i>Atrás
            </button>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-search-plus me-2"></i>DETALLE DEL TRAMITE
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

        <!-- Panel de  detalles -->
        <div class="col-lg-5">
            <div class="card shadow-sm">

                <div class="card-header bg-white">
                    
                    <ul class="nav nav-tabs card-header-tabs" id="tabMenu" role="tablist">
                        
                 
                 

                        <li class="nav-item" role="presentation">
                            <button style="color:black !important;" class="nav-link active" id="detalle-tab" data-bs-toggle="tab" 
                                    data-bs-target="#detalle" type="button" role="tab">
                                <i class="fas fa-info-circle me-2"></i> Detalle
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button style="color:black !important;" class="nav-link" id="revisiones-tab" data-bs-toggle="tab" 
                                    data-bs-target="#revisiones" type="button" role="tab">
                                <i class="fas fa-info-circle me-2"></i>Revisiones
                            </button>
                        </li>

                  

                    </ul>
                </div>
                
                <div class="card-body">
                    <div class="tab-content" id="tabContent">
                        
                        
                        <!-- Tab de Detalle -->
                        <div class="tab-pane fade show active" id="detalle" role="tabpanel">
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

                        <div class="tab-pane fade " id="revisiones" role="tabpanel">
                        
                            <div class="detail-section">
                                <?php if(!empty($revisiones)): ?>

                                    <div class="row g-3">

                                        <?php foreach($revisiones as $index => $revision): ?>

                                            <div class="col-12">
                                                <div class="card shadow-sm border-0">
                                                    <div class="card-header bg-light">
                                                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">

                                                            <div>
                                                                <h6 class="mb-1 fw-bold">
                                                                    Revisión #<?= $index + 1 ?>
                                                                </h6>

                                                                <small class="text-muted">
                                                                    <?= date('d/m/Y h:i A', strtotime($revision['date_create_materiarevision'])) ?>
                                                                </small>

                                                            </div>

                                                            <div class="mt-2 mt-md-0">

                                                                <?php
                                                                    $badgeClass='secondary';

                                                                    switch(strtolower($revision['estado_materiarevision'])){

                                                                        case 'observado':
                                                                            $badgeClass='warning';
                                                                            break;

                                                                        case 'aprobado':
                                                                            $badgeClass='success';
                                                                            break;

                                                                       
                                                                    }
                                                                ?>

                                                                <span class="badge bg-<?= $badgeClass ?> fs-6">

                                                                    <?= ucfirst($revision['estado_materiarevision']) ?>

                                                                </span>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="card-body">

                                                        <h6 class="text-primary mb-3">
                                                            Observaciones del Inspector
                                                        </h6>

                                                        <div style="background-color:#f8f9fa;" class="border rounded p-3 ">

                                                            <?php if(strtolower($revision['estado_materiarevision']) == 'observado'):  ?>
                                                                <?= $revision['observacion_materiarevision'] ?>
                                                            <?php else: ?>
                                                                 Material Aprobado
                                                            <?php endif; ?>

                                                            
 
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        <?php endforeach; ?>

                                    </div>

                                <?php else: ?>

                                    <div class="alert alert-info text-center">

                                        No existen revisiones registradas.

                                    </div>

                                <?php endif; ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

    /* Estilos del visor PDF */
    .pdf-container {
        width: 100%;
        height: 100%;
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

</script>
<?= $this->endSection();?> 