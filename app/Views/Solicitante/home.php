


<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>

<h1>HOME SOLICITANTE</h1>


<a href="<?= base_url('solicitante/solicitud'); ?>">Solicitar Constancia URL</a>

<!-- Encabezado fuera del card -->
<div class="mb-2">
    <span class="badge bg-primary">Trámite reciente</span>
    <strong>Código: <?= $tramite['codigo']; ?></strong>
</div>

<!-- Card -->
<div class="card w-100 shadow-sm">

    <!-- Estado actual arriba a la izquierda -->
    <div class="card-header">
        <strong>Estado actual:</strong> <?= $tramite['estado']; ?>
    </div>

    <div class="card-body">

        <!-- Línea de progreso con etapas -->
        <div class="mb-4">
            <div class="progress" style="height: 30px;">
                <?php 
                    // $etapas = ['Enviado','Revisado','Observado','Observaciones Levantadas','Aprobado','Finalizado'];
                    $estadoActual = $tramite['estado'];

                    // Filtrar etapas dinámicamente
                    $mostrarEtapas = [];
                    foreach ($etapas as $etapa) {
                        if (in_array($etapa, ['Observado', 'Observaciones Levantadas'])) {
                            // Mostrar solo si el estado actual es esa etapa o está después
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

        <!-- Datos del trámite -->
        <div>
            <p><strong>Título:</strong> <?= $tramite['titulo']; ?></p>
            <p><strong>Fecha de presentación:</strong> <?= date('d/m/Y', strtotime($tramite['fechapresentacion'])); ?></p>
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

<?= $this->endSection();?>

<?= $this->section('scripts');?>



<?= $this->endSection();?>