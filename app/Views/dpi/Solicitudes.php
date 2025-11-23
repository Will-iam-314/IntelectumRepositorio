
<?= $this->extend('layouts/InspectorTemplate.php'); ?>

<?= $this->section('content');?>

<h1>SOLICITUDES</h1>



<!-- Filtros -->
<div class="row search-bar">
    <div class="col-md-3">
        <input type="text" id="searchSolicitante" class="form-control" placeholder="Buscar por solicitante...">
    </div>
    <div class="col-md-3">
        <input type="text" id="searchTitulo" class="form-control" placeholder="Buscar por título material...">
    </div>
    <div class="col-md-2">
        <input type="date" id="fechaInicio" class="form-control">
    </div>
    <div class="col-md-2">
        <input type="date" id="fechaFin" class="form-control">
    </div>
    <div class="col-md-2">
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

<!-- Tabla -->
<div class="table-responsive mt-4">
    <table class="table table-bordered table-striped align-middle" id="tramitesTable">
        <thead class="table-dark">
            <tr>
                <th>N°</th>
                <th>Código</th>
                <th>Solicitante</th>
                <th>Título Material</th>
                <th>Material</th>
                <th>Fecha Presentación</th>
                <th>Estado</th>
                <th>Opción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tramites)): ?>
                <?php $i = 1; foreach ($tramites as $t): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= esc($t['codigoTramite']) ?></td>
                        <td><?= esc($t['nombreCompletoSolicitante']) ?></td>
                        <td><?= esc($t['tituloMaterial']) ?></td>
                        <td><?= esc($t['tipomateriaMaterial']) ?></td>
                        <td><?= esc(date('d/m/Y', strtotime($t['fechapresentacionTramite']))) ?></td>
                        <td><?= esc($t['estadoTramite']) ?></td>
                        <td>
                            <?php if ($t['estadoTramite'] === "Material Publicado"): ?>

                                <a href="<?= base_url('dpi/generarConstancia/'.$t['codigoTramite']) ?>" class="btn btn-sm btn-primary">Emitir Constancia</a>

                            <?php elseif ($t['estadoTramite'] === "Constancia Emitida"): ?> 

                                <a href="<?= base_url('dpi/verConstancia/'.$t['codigoTramite']) ?>" class="btn btn-sm btn-primary">Ver Constancia</a>
                               
                            <?php else: ?> 

                                <span class="text-muted">Sin Opciones</span>
                                <!---  HACER UNA VISTA DONDE SEVEA LA CONSTANCIA Y DE PASO PUEDA VOLVER ENVIAR LA CONSTANCIA --->

               
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center">No hay trámites registrados</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>



<?= $this->endSection();?>

<?= $this->section('scripts');?>



<script>
    <?php if(session()->getFlashdata('success')): ?>
       alert('<?php echo session()->getFlashdata('success'); ?>');
    <?php endif; ?>
    const searchSolicitante = document.getElementById('searchSolicitante');
    const searchTitulo = document.getElementById('searchTitulo');
    const fechaInicio = document.getElementById('fechaInicio');
    const fechaFin = document.getElementById('fechaFin');
    const filterEstado = document.getElementById('filterEstado');
    const table = document.getElementById('tramitesTable').getElementsByTagName('tbody')[0];

    function filterTable() {
        const solicitante = searchSolicitante.value.toLowerCase();
        const titulo = searchTitulo.value.toLowerCase();
        const inicio = fechaInicio.value ? new Date(fechaInicio.value) : null;
        const fin = fechaFin.value ? new Date(fechaFin.value) : null;
        const estado = filterEstado.value.toLowerCase();

        for (let row of table.rows) {
            const colSolicitante = row.cells[2].textContent.toLowerCase();
            const colTitulo = row.cells[3].textContent.toLowerCase();
            const colFecha = new Date(row.cells[5].textContent.split('/').reverse().join('-')); 
            const colEstado = row.cells[6].textContent.toLowerCase();

            let visible = true;

            if (solicitante && !colSolicitante.includes(solicitante)) visible = false;
            if (titulo && !colTitulo.includes(titulo)) visible = false;
            if (inicio && colFecha < inicio) visible = false;
            if (fin && colFecha > fin) visible = false;
            if (estado && colEstado !== estado) visible = false;

            row.style.display = visible ? '' : 'none';
        }
    }

    searchSolicitante.addEventListener('input', filterTable);
    searchTitulo.addEventListener('input', filterTable);
    fechaInicio.addEventListener('change', filterTable);
    fechaFin.addEventListener('change', filterTable);
    filterEstado.addEventListener('change', filterTable);
</script>


<?= $this->endSection();?>