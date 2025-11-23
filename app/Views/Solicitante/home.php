<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>



<div class="d-flex justify-content-between">
    <div class="d-flex align-items-center">
        <img class="me-1" width=30 height=30 src="<?=base_url('assets/icons/home-azul.png')?>" alt="home">
        <span class="title-modules">Inicio</span>
    </div>

    <div class="d-flex align-items-center btn-solicitar-inhome">
        <a href="<?= base_url('solicitante/solicitud'); ?>">
            <img style="margin-top:-3px;" width=21 src="<?= base_url('assets/icons/mas-white.png') ?>" alt=""> Nueva Solicitud
        </a>
    </div>
</div>

<?php if(!empty($tramite)): ?>

    <div class="container-default mt-4 shadow-sm">
        
        <!-- Título del trámite -->
        <div class="mb-3 container-title-reciente">
            <span class="titulo-seccion">Trámite Más Reciente: </span>
            <span class="codigo-tramite"><?= esc($tramite['codigo']); ?></span>
        </div>

        <!-- Stepper de progreso -->
        <div class="stepper-container">
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
                    $isActive = ($i <= $indiceActual);
                    $circleClass = $isActive ? 'active' : 'inactive';
                    $labelClass = $isActive ? 'active' : 'inactive';
            ?>
                <div class="stepper-item <?= $isActive ? 'active' : '' ?>">
                    <?php if($i < $total - 1): ?>
                        <?php 
                            // La línea solo es activa si la SIGUIENTE etapa también está activa
                            $nextIsActive = ($i + 1 <= $indiceActual);
                        ?>
                        <div class="stepper-line <?= $nextIsActive ? 'active' : '' ?>"></div>
                    <?php endif; ?>
                    
                    <div class="stepper-circle <?= $circleClass ?>">
                        <?= $i + 1 ?>
                    </div>
                    <div class="stepper-label <?= $labelClass ?>">
                        <?= esc($etapa) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Card con información del trámite -->
        <div class="card-tramite mb-3">
            <div>
                <div class="titulo-proyecto"><?= esc($tramite['titulo']); ?></div>
                <div class="fecha-proyecto">
                    Fecha de Presentación: <?= esc(date('d/m/Y', strtotime($tramite['fechapresentacion']))); ?>
                </div>
            </div>
            <div class="dias-badge mt-3">
                <span>
                    <?php
                    $fechaPresentacion = new DateTime($tramite['fechapresentacion']);
                    $hoy = new DateTime();
                    $dias = $hoy->diff($fechaPresentacion)->days;
                    echo $dias;
                    ?>
                </span>
                
                Días Transcurridos
            </div>
        </div>

       
        <div class="text-center mt-5 mb-4">
            <a href="<?= base_url('solicitante/detalleTramite/'.esc($tramite['codigo']) ) ?>" class="btn-style4">
                Ver mas
            </a>
        </div>


    </div>

<?php else: ?>
    <div class="container-default mt-4">
        <div class="msg-nothing">
            <img class="mb-3" src="<?= base_url('assets/icons/box-empty-gray.png') ?>" alt="">
            <span class="d-block">Sin trámites por el momento.</span>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection();?>

<?= $this->section('scripts');?>
<?= $this->endSection();?>