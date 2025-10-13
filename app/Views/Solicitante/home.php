<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>


<div class="d-flex justify-content-between">
    <span class="title-modules">Inicio</span>

    <div class="d-flex align-items-center btn-solicitar-inhome ">
      <a href="<?= base_url('solicitante/solicitud'); ?>">Nueva Solicitud</a>
    </div>
    
</div>


<?php if(!empty($tramite)): ?>

    <!-- Encabezado fuera del card -->
    <div class="mb-2">
        <span class="badge bg-primary">Trámite reciente</span>
        <strong>Código: <?= esc($tramite['codigo']); ?></strong>
    </div>

    <!-- Card -->
    <div class="card w-100 shadow-sm">

        <!-- Estado actual arriba a la izquierda -->
        <div class="card-header">
            <strong>Estado actual:</strong> <?= esc($tramite['estado']); ?>
        </div>

        <div class="card-body">

            <!-- Línea de progreso con etapas -->
            <div class="mb-4">
                <div class="progress" style="height: 30px;">
                    <?php 
                        $estadoActual = $tramite['estado'];

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
                            <?= esc($etapa) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Datos del trámite -->
            <div>
                <p><strong>Título:</strong> <?= esc($tramite['titulo']); ?></p>
                <p><strong>Fecha de presentación:</strong> <?= esc(date('d/m/Y', strtotime($tramite['fechapresentacion']))); ?></p>
                <p><strong>Días transcurridos:</strong> 
                    <?php
                        $fechaPresentacion = new DateTime($tramite['fechapresentacion']);
                        $hoy = new DateTime();
                        $dias = $hoy->diff($fechaPresentacion)->days;
                        echo $dias;
                    ?> días
                </p>
            </div>

        </div>
    </div>

<?php else: ?>
    <div class="alert alert-info mt-3">
        Sin trámites por el momento.
    </div>
<?php endif; ?>

<?= $this->endSection();?>

<?= $this->section('scripts');?>
<?= $this->endSection();?>
