<?= $this->extend('layouts/InspectorTemplate.php'); ?>

<?= $this->section('content');?>

<div class="container-fluid py-4">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-file-alt me-2"></i>Gestión de Solicitudes
        </h1>
        <div class="text-muted">
            <small>Total: <span id="totalRegistros"><?= count($tramites) ?></span> solicitudes</small>
        </div>
    </div>

    <!-- Panel de Filtros -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
            </h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small text-muted">Solicitante</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                        <input type="text" id="searchSolicitante" class="form-control" placeholder="Buscar solicitante...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">Título del Material</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-book"></i></span>
                        <input type="text" id="searchTitulo" class="form-control" placeholder="Buscar título...">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Fecha Inicio</label>
                    <input type="date" id="fechaInicio" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Fecha Fin</label>
                    <input type="date" id="fechaFin" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Estado</label>
                    <select id="filterEstado" class="form-select">
                        <option value="">Todos los estados</option>
                        <?php 
                        $estadosUnicos = array_unique(array_column($tramites, 'estadoTramite'));
                        foreach ($estadosUnicos as $estado): ?>
                            <option value="<?= esc($estado) ?>"><?= esc($estado) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btnLimpiarFiltros">
                        <i class="fas fa-eraser me-1"></i>Limpiar Filtros
                    </button>
                    <span class="ms-3 text-muted small" id="resultadosFiltrados"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Solicitudes -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Solicitudes</h6>
            <div class="d-flex align-items-center">
                <label class="me-2 small text-muted mb-0">Mostrar:</label>
                <select id="recordsPerPage" class="form-select form-select-sm" style="width: auto;">
                    <option value="20">20</option>
                    <option value="40">40</option>
                    <option value="60">60</option>
                    <option value="80">80</option>
                    <option value="100">100</option>
                </select>
                <span class="ms-2 small text-muted">registros por página</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tramitesTable">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;vertical-align: middle;">N°</th>
                            <th class="text-center" style="width: 100px;vertical-align: middle;">Código</th>
                            <th style="width: 200px;vertical-align: middle;">Solicitante</th>
                            <th style="width: 500px;vertical-align: middle;">Título Material</th>
                           <!-- <th style="width: 130px;">Tipo Material</th> --->
                            <th class="text-center"style="width: 100px;vertical-align: middle;">Fecha Presentación</th>
                            <th class="text-center"style="width: 130px;vertical-align: middle;">Escuela</th>
                            <th class="text-center" style="width: 100px;vertical-align: middle;">Estado</th>
                            <th class="text-center" style="width: 200px;vertical-align: middle;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tramites)): ?>
                            <?php $i = count($tramites); foreach ($tramites as $t): ?>
                                <tr data-estado="<?= esc($t['estadoTramite']) ?>">
                                    <td class="text-center text-muted"><?= $i-- ?></td>
                                    <td><code class="small"><?= esc($t['codigoTramite']) ?></code></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                       
                                            <span><?= esc($t['nombreCompletoSolicitante']) ?></span>
                                        </div>
                                    </td>
                                    <td class="text-wrap"><?= esc($t['tituloMaterial']) ?></td>
                                    <!--<td><span class="badge bg-info text-dark"></span></td>-->
                                    <td class="text-nowrap text-center">
                                       
                                        <?= esc(date('d/m/Y', strtotime($t['fechapresentacionTramite']))) ?>
                                    </td>
                                    <td class="text-wrap text-center" ><?=esc($t['solicitanteEscuela'])?></td>

                                    
                                    <td class="text-wrap">
                                        <?php 
                                        $estadoBadge = match($t['estadoTramite']) {
                                            'Solicitud Presentada' => 'bg-warning text-dark',
                                            'Material Aprobado' => 'bg-success',
                                            'Material Publicado' => 'bg-info',
                                            'Observado' => 'bg-danger',
                                            'Observaciones Levantadas' => 'bg-secondary',
                                            'Constancia Emitida' => 'bg-primary',
                                            default => 'bg-secondary'
                                        };
                                        ?>
                                        <span style="color:white; border-radius:10px; font-size:14px;" class="<?= $estadoBadge ?> d-block p-2 text-center fw-bold">
                                            <?= esc($t['estadoTramite']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($t['estadoTramite'] === "Solicitud Presentada" && $t['inspectorAsignado'] == false): ?>
                                            <a href="<?= base_url('inspector/inspeccion/'.$t['codigoTramite']).'/0' ?>" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-search me-1"></i>Inspeccionar
                                            </a>

                                        <?php elseif($t['estadoTramite'] === "Material Aprobado" && $t['inspectorAsignado'] == true): ?> 
                                            <a href="<?= base_url('inspector/publicacion/'.$t['idTramite'].'/'.$t['codigoTramite'])?>" 
                                               class="btn btn-sm btn-success">
                                                <i class="fas fa-file-export me-1"></i>Generar Publicación
                                            </a>

                                        <?php elseif($t['estadoTramite'] === "Material Publicado" && $t['inspectorAsignado'] == true): ?> 
                                            <span class="text-muted small">
                                                <i class="fas fa-hourglass-half me-1"></i>Generando constancia
                                            </span>
                                        
                                        <?php elseif($t['inspectorAsignado'] == true && !in_array($t['estadoTramite'], ["Observado", "Observaciones Levantadas", "Constancia Emitida"])): ?> 
                                            <a href="<?= base_url('inspector/inspeccion/'.$t['codigoTramite']).'/1' ?>" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-play me-1"></i>Continuar Inspección
                                            </a>

                                        <?php elseif($t['estadoTramite'] === "Observado" && $t['inspectorAsignado'] == true): ?> 
                                            <span class="text-muted small">
                                                <i class="fas fa-clock me-1"></i>Esperando correcciones
                                            </span>
                                        
                                        <?php elseif($t['estadoTramite'] === "Observaciones Levantadas" && $t['inspectorAsignado'] == true): ?> 
                                            <a href="<?= base_url('inspector/inspeccionObservaciones/'.$t['codigoTramite'].'/'.$t['idMaterial']) ?>" 
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-clipboard-check me-1"></i>Ver Correcciones
                                            </a>

                                        <?php elseif($t['estadoTramite'] === "Constancia Emitida"): ?> 
                                            <span class="text-success small">
                                                <i class="fas fa-check-circle me-1"></i>Completado
                                            </span>

                                        <?php else: ?> 
                                            <span class="text-muted small">
                                                <i class="fas fa-user-check me-1"></i>Inspector, ya asignado
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    <p class="mb-0">No hay trámites registrados</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted small" id="paginationInfo">
                        Mostrando <span id="showingFrom">0</span> a <span id="showingTo">0</span> de <span id="totalFiltered">0</span> registros
                    </p>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Navegación de páginas">
                        <ul class="pagination pagination-sm justify-content-end mb-0" id="pagination">
                            <!-- Los botones de paginación se generarán dinámicamente -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
        flex-shrink: 0;
    }
    
    .table tbody tr {
        transition: background-color 0.2s;
    }
    
    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .input-group-text {
        border-right: 0;
    }
    
    .input-group .form-control {
        border-left: 0;
    }
    
    .input-group .form-control:focus {
        border-color: #ced4da;
        box-shadow: none;
    }
    
    .card {
        border: none;
        border-radius: 0.5rem;
    }
    
    code {
        background-color: #f8f9fa;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
    }

    .pagination {
        gap: 0.25rem;
    }

    .page-link {
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
        color: #0d6efd;
        padding: 0.375rem 0.75rem;
        transition: all 0.2s;
    }

    .page-link:hover {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .page-item.disabled .page-link {
        cursor: not-allowed;
    }

    .paginated-hidden {
        display: none !important;
    }
</style>

<?= $this->endSection();?>

<?= $this->section('scripts');?>

<script>
    // Alerta de éxito
    <?php if(session()->getFlashdata('success')): ?>
        alert('<?php echo session()->getFlashdata('success'); ?>');
    <?php endif; ?>

    // Referencias a elementos
    const searchSolicitante = document.getElementById('searchSolicitante');
    const searchTitulo = document.getElementById('searchTitulo');
    const fechaInicio = document.getElementById('fechaInicio');
    const fechaFin = document.getElementById('fechaFin');
    const filterEstado = document.getElementById('filterEstado');
    const btnLimpiarFiltros = document.getElementById('btnLimpiarFiltros');
    const table = document.getElementById('tramitesTable').getElementsByTagName('tbody')[0];
    const resultadosFiltrados = document.getElementById('resultadosFiltrados');
    const recordsPerPage = document.getElementById('recordsPerPage');
    const pagination = document.getElementById('pagination');
    const showingFrom = document.getElementById('showingFrom');
    const showingTo = document.getElementById('showingTo');
    const totalFiltered = document.getElementById('totalFiltered');
    const totalRegistros = <?= count($tramites) ?>;

    // Variables de paginación
    let currentPage = 1;
    let rowsPerPage = 20;

    // Función para parsear fecha dd/mm/yyyy
    function parseFecha(fechaStr) {
        const partes = fechaStr.trim().split('/');
        if (partes.length !== 3) return null;
        return new Date(partes[2], partes[1] - 1, partes[0]);
    }

    // Obtener todas las filas visibles
    function getVisibleRows() {
        return Array.from(table.rows).filter(row => row.style.display !== 'none');
    }

    // Función principal de filtrado
    function filterTable() {
        const solicitante = searchSolicitante.value.toLowerCase().trim();
        const titulo = searchTitulo.value.toLowerCase().trim();
        const inicio = fechaInicio.value ? new Date(fechaInicio.value) : null;
        const fin = fechaFin.value ? new Date(fechaFin.value) : null;
        const estado = filterEstado.value.toLowerCase();

        Array.from(table.rows).forEach(row => {
            const colSolicitante = row.cells[2].textContent.toLowerCase();
            const colTitulo = row.cells[3].textContent.toLowerCase();
            const fechaTexto = row.cells[5].textContent.trim();
            const colFecha = parseFecha(fechaTexto);
            const colEstado = row.getAttribute('data-estado').toLowerCase();

            let visible = true;

            // Aplicar filtros
            if (solicitante && !colSolicitante.includes(solicitante)) visible = false;
            if (titulo && !colTitulo.includes(titulo)) visible = false;
            if (inicio && colFecha && colFecha < inicio) visible = false;
            if (fin && colFecha && colFecha > fin) visible = false;
            if (estado && colEstado !== estado) visible = false;

            // Mostrar/ocultar fila según filtro
            row.style.display = visible ? '' : 'none';
        });

        // Resetear a la primera página después de filtrar
        currentPage = 1;
        updatePagination();
    }

    // Actualizar paginación y mostrar filas correspondientes
    function updatePagination() {
        const visibleRows = getVisibleRows();
        const totalRows = visibleRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        // Asegurar que currentPage esté en rango válido
        if (currentPage > totalPages) currentPage = totalPages || 1;

        // Calcular índices
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        // Ocultar todas las filas primero
        Array.from(table.rows).forEach(row => {
            if (row.style.display !== 'none') {
                row.classList.add('paginated-hidden');
            }
        });

        // Mostrar solo las filas de la página actual
        visibleRows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.classList.remove('paginated-hidden');
            }
        });

        // Actualizar información de paginación
        updatePaginationInfo(start, end, totalRows);

        // Generar botones de paginación
        renderPaginationButtons(totalPages);

        // Actualizar contador de resultados filtrados
        actualizarContador(totalRows);
    }

    // Actualizar información de registros mostrados
    function updatePaginationInfo(start, end, total) {
        showingFrom.textContent = total > 0 ? start + 1 : 0;
        showingTo.textContent = Math.min(end, total);
        totalFiltered.textContent = total;
    }

    // Renderizar botones de paginación
    function renderPaginationButtons(totalPages) {
        pagination.innerHTML = '';

        // Botón anterior
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="#" aria-label="Anterior">
            <i class="fas fa-chevron-left"></i>
        </a>`;
        prevLi.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                updatePagination();
            }
        });
        pagination.appendChild(prevLi);

        // Lógica de páginas a mostrar
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, currentPage + 2);

        // Primera página
        if (startPage > 1) {
            addPageButton(1);
            if (startPage > 2) {
                const dotsLi = document.createElement('li');
                dotsLi.className = 'page-item disabled';
                dotsLi.innerHTML = '<span class="page-link">...</span>';
                pagination.appendChild(dotsLi);
            }
        }

        // Páginas intermedias
        for (let i = startPage; i <= endPage; i++) {
            addPageButton(i);
        }

        // Última página
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                const dotsLi = document.createElement('li');
                dotsLi.className = 'page-item disabled';
                dotsLi.innerHTML = '<span class="page-link">...</span>';
                pagination.appendChild(dotsLi);
            }
            addPageButton(totalPages);
        }

        // Botón siguiente
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="#" aria-label="Siguiente">
            <i class="fas fa-chevron-right"></i>
        </a>`;
        nextLi.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                updatePagination();
            }
        });
        pagination.appendChild(nextLi);
    }

    // Agregar botón de página
    function addPageButton(pageNum) {
        const li = document.createElement('li');
        li.className = `page-item ${pageNum === currentPage ? 'active' : ''}`;
        li.innerHTML = `<a class="page-link" href="#">${pageNum}</a>`;
        li.addEventListener('click', (e) => {
            e.preventDefault();
            currentPage = pageNum;
            updatePagination();
        });
        pagination.appendChild(li);
    }

    // Actualizar contador de resultados filtrados
    function actualizarContador(visibleCount) {
        if (visibleCount < totalRegistros) {
            resultadosFiltrados.textContent = `Mostrando ${visibleCount} de ${totalRegistros} registros`;
            resultadosFiltrados.style.display = 'inline';
        } else {
            resultadosFiltrados.style.display = 'none';
        }
    }

    // Limpiar todos los filtros
    function limpiarFiltros() {
        searchSolicitante.value = '';
        searchTitulo.value = '';
        fechaInicio.value = '';
        fechaFin.value = '';
        filterEstado.value = '';
        filterTable();
    }

    // Cambiar registros por página
    recordsPerPage.addEventListener('change', function() {
        rowsPerPage = parseInt(this.value);
        currentPage = 1;
        updatePagination();
    });

    // Event Listeners para filtros
    searchSolicitante.addEventListener('input', filterTable);
    searchTitulo.addEventListener('input', filterTable);
    fechaInicio.addEventListener('change', filterTable);
    fechaFin.addEventListener('change', filterTable);
    filterEstado.addEventListener('change', filterTable);
    btnLimpiarFiltros.addEventListener('click', limpiarFiltros);

    // Inicializar paginación
    updatePagination();
</script>

<?= $this->endSection();?>