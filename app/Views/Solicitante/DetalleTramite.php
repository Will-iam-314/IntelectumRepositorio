<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>

<button onclick='Regresar()'>Atrás</button>

<h1>DETALLE TRAMITE</h1>

<div class="card w-100 shadow-sm">
    <div class="card-header">
        <strong>Estado actual:</strong> <?= $estadoTramite; ?>
    </div>

    <div class="card-body">
        <div class="mb-4">
            <div class="progress" style="height: 30px;">
                <?php 
                    $etapas = ['Solicitud Presentada', 'Inspector Asignado', 'En revisión', 'Observado', 'Observaciones Levantadas', 'Material Aprobado', 'Material Publicado', 'Constancia Emitida'];
                    $estadoActual = $estadoTramite;

                    // Filtrar etapas dinámicamente
                    $mostrarEtapas = [];
                    foreach ($etapas as $etapa) {
                        if (in_array($etapa, ['Observado', 'Observaciones Levantadas'])) {
                            if ($estadoActual === $etapa || array_search($estadoActual, $etapas) > array_search($etapa, $etapas)) {
                                $mostrarEtapas[] = $etapa;
                            }
                        } else {
                            $mostrarEtapas[] = $etapa;
                        }
                    }

                    $total = count($mostrarEtapas);
                    $indiceActual = array_search($estadoActual, $mostrarEtapas);

                    foreach($mostrarEtapas as $i => $etapa):
                        $color = ($i <= $indiceActual) ? 'bg-primary' : 'bg-light text-dark';
                ?>
                        <div class="progress-bar <?= $color ?>" role="progressbar" style="width: <?= 100/$total ?>%">
                            <?= $etapa ?>
                        </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div>
            <p><strong>Título:</strong> <?= $tituloMaterial; ?></p>
            <p><strong>Fecha de presentación:</strong> <?= date('d/m/Y', strtotime($fechapresentacionTramite)); ?></p>
            <p><strong>Días transcurridos:</strong> 
                <?php
                    $fechaPresentacion = new DateTime($fechapresentacionTramite);
                    $hoy = new DateTime();
                    $dias = $hoy->diff($fechaPresentacion)->days;
                    echo $dias;
                ?> días
            </p>
        </div>
    </div>
</div>

<?php if ($estadoTramite === 'Observado'): ?>
    <div class="text-center mt-4">
        
        <a href="<?= base_url('solicitante/observaciones/'.esc($codigoTramite) ) ?>" class="btn btn-warning btn-lg">ver y levantar Observaciones</a>
        
    </div>
<?php endif; ?>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">
        <strong>📑 Datos del Trámite</strong>
    </div>
    <div class="card-body">
        <p><strong>Código:</strong> <?= esc($codigoTramite) ?></p>
        <p><strong>Fecha de presentación:</strong> <?= date('d/m/Y', strtotime($fechapresentacionTramite)) ?></p>
        <p><strong>Estado:</strong> <?= esc($estadoTramite) ?></p>
        <p><strong>Declaración jurada:</strong> 
            <?php if(!empty($fileDeclaracionJuradaTramite)): ?>
                <a href="<?= base_url('solicitante/documentos/verDeclaracionJurada/'.$fileDeclaracionJuradaTramite) ?>" target="_blank">Ver archivo</a>
            <?php else: ?>
                <span class="text-muted">No disponible</span>
            <?php endif; ?>
        </p>
        <p><strong>Autorización de publicación:</strong> 
            <?php if(!empty($fileAutorizacionPublicacionTramite)): ?>
                <a href="<?= base_url('solicitante/documentos/verAutorizacionPublicacion/'.$fileAutorizacionPublicacionTramite) ?>" target="_blank">Ver archivo</a>
            <?php else: ?>
                <span class="text-muted">No disponible</span>
            <?php endif; ?>
        </p>
    </div>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-success text-white">
        <strong>📘 Datos de la Tesis</strong>
    </div>
    <div class="card-body">
        <p><strong>Título:</strong> <?= esc($tituloMaterial) ?></p>
        <p><strong>Tipo de materia:</strong> <?= esc($tipomateriaMaterial) ?></p>
        <p><strong>Resumen:</strong> <?= esc($resumenTesis) ?></p>
        <p><strong>Palabras clave:</strong> <?= esc($palabrasclaveTesis) ?></p>
        <p><strong>Archivo de Tesis:</strong> 
            <?php if(!empty($fileTesis)): ?>
                <a href="<?= base_url('solicitante/documentos/verTesis/'.$fileTesis) ?>" target="_blank">Ver archivo</a>
            <?php else: ?>
                <span class="text-muted">No disponible</span>
            <?php endif; ?>
        </p>
    </div>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-info text-white">
        <strong>👨‍🏫 Docentes</strong>
    </div>
    <div class="card-body">
        <p><strong>Asesor:</strong> <?= esc($nombresAsesor . ' ' . $apellidosAsesor) ?></p>
        <hr>
        <p><strong>Miembros del Jurado Evaluador</strong></p>
        <p><strong>Presidente de Jurados:</strong> <?= esc($nombresJurado1 . ' ' . $apellidosJurado1) ?></p>
        <p><strong>Primer Miembro:</strong> <?= esc($nombresJurado2 . ' ' . $apellidosJurado2) ?></p>
        <p><strong>Segundo Miembro:</strong> <?= esc($nombresJurado3 . ' ' . $apellidosJurado3) ?></p>
    </div>
</div>

<?= $this->endSection();?>

<?= $this->section('scripts');?>
<?= $this->endSection();?>