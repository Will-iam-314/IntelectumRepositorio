<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>

<div class="d-flex flex-wrap align-items-center gap-2">       
    <button class="btn btn-link p-0 border-0" onclick='Regresar()'>
        <img class="me-1" width="30" height="30" src="<?=base_url('assets/icons/flecha-atras.png')?>" alt="Regresar"> 
    </button>
 
    <span class="title-modules">Detalle del Trámite</span> 
    <span class="codigo-title-detalleTramite"><?= esc($tramite['codigoTramite']) ?></span>
</div>

<div class="container-default mt-4 shadow-sm">


    <div class="container-title-reciente">
        <span class="titulo-estado-tramite-detalleTramite">Estado Actual: </span>

        <?php if( $tramite['estadoTramite'] == 'Observado' ): ?>
            <span class="estado-tramite-detalleTramite-observado"><?= $tramite['estadoTramite']; ?></span>
        <?php elseif($tramite['estadoTramite'] == 'Material Aprobado'):?>
            <span class="estado-tramite-detalleTramite"><?= $tramite['estadoTramite']; ?></span>
        <?php else:?>
            <span class="estado-tramite-detalleTramite"><?= $tramite['estadoTramite']; ?></span>
        <?php endif;?>
        

    </div>

    <!-- Stepper de progreso -->
    <div class="stepper-container">
        <?php 
            $estadoActual = $tramite['estadoTramite'];

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
    
    <?php if ($tramite['estadoTramite'] === 'Observado'): ?>
        <div class="text-center mt-4 mb-5">
            
            <a href="<?= base_url('solicitante/observaciones/'.esc($tramite['codigoTramite']) ) ?>" class="btn-style4">Ver y Levantar Observaciones</a>
            
        </div>
    <?php endif; ?>

    <div class="card-tramite mb-3">
        <div>
            <div class="titulo-proyecto"><?= esc($tramite['tituloMaterial']); ?></div>
            
            <div class="fecha-proyecto">
                Fecha de Presentación: <?= esc(date('d/m/Y', strtotime($tramite['fechapresentacionTramite']))); ?>
            </div>
        </div>
        <div class="dias-badge mt-3">
            <span>
                <?php
                $fechaPresentacion = new DateTime($tramite['fechapresentacionTramite']);
                $hoy = new DateTime();
                $dias = $hoy->diff($fechaPresentacion)->days;
                echo $dias;
                ?>
            </span>
            
            Días Transcurridos
        </div>
    </div>
    
    <div class="contenedor-autores-detalleTramite">
        <h2 class="autores-titulo-detalleTramite">Autor(es)</h2>
        <div class="row g-4">
             <?php foreach ($tramite['autores'] as $autor): ?>
                <div class="col-12 col-sm-6 col-lg-6">
                    <div class="container-card-autores-detalleTramite d-flex">
                        <i class="fa fa-user autor-icon-detalleTramite"></i>
                        <div class="autor-nombre-detalleTramite"><?= $autor['nombre'] ?? 'N/D' ?> </div>
                    </div>                   
                </div>
            <?php endforeach; ?>    
        </div>

        

    </div>

    <div class="contendor-archivos-detalleTramite">
        <h2 class="archivos-titulo-detalleTramite">Archivos</h2>
        
        <div class="row g-4">


            <!-- Archivo 0: Tesis -->
            <div class="col-12 col-sm-6 col-lg-4">
                <?php if(!empty($tramite['fileTesis'])): ?>
                    <a href="<?= base_url('solicitante/documentos/verTesis/'.$tramite['fileTesis']) ?>" 
                    target="_blank" 
                    class="archivo-card-detalleTramite">
                        <i class="fas fa-file-pdf archivo-icon-detalleTramite"></i>
                        <div class="archivo-nombre-detalleTramite">Tesis</div>
                    </a>
                <?php else: ?>
                    <div class="archivo-card-detalleTramite disabled-detalleTramite">
                        <i class="fas fa-file-pdf archivo-icon-detalleTramite"></i>
                        <div class="archivo-nombre-detalleTramite">Tesis</div>
                        <div class="archivo-estado-detalleTramite">No disponible</div>
                    </div>
                <?php endif; ?>
            </div>

        
            <!-- Archivo 1: Declaración Jurada -->
            <div class="col-12 col-sm-6 col-lg-4">
                <?php if(!empty($tramite['fileDeclaracionJuradaTramite'])): ?>
                    <a href="<?= base_url('solicitante/documentos/verDeclaracionJurada/'.$tramite['fileDeclaracionJuradaTramite']) ?>" 
                    target="_blank" 
                    class="archivo-card-detalleTramite">
                        <i class="fas fa-file-pdf archivo-icon-detalleTramite"></i>
                        <div class="archivo-nombre-detalleTramite">Declaración Jurada</div>
                    </a>
                <?php else: ?>
                    <div class="archivo-card-detalleTramite disabled-detalleTramite">
                        <i class="fas fa-file-pdf archivo-icon-detalleTramite"></i>
                        <div class="archivo-nombre-detalleTramite">Declaración Jurada</div>
                        <div class="archivo-estado-detalleTramite">No disponible</div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Archivo 2: Autorización de Publicación -->
            <div class="col-12 col-sm-6 col-lg-4">
                <?php if(!empty($tramite['fileAutorizacionPublicacionTramite'])): ?>
                    <a href="<?= base_url('solicitante/documentos/verAutorizacionPublicacion/'.$tramite['fileAutorizacionPublicacionTramite']) ?>" 
                    target="_blank" 
                    class="archivo-card-detalleTramite">
                        <i class="fas fa-file-pdf archivo-icon-detalleTramite"></i>
                        <div class="archivo-nombre-detalleTramite">Autorización de Publicación</div>
                    </a>
                <?php else: ?>
                    <div class="archivo-card-detalleTramite disabled-detalleTramite">
                        <i class="fas fa-file-pdf archivo-icon-detalleTramite"></i>
                        <div class="archivo-nombre-detalleTramite">Autorización de Publicación</div>
                        <div class="archivo-estado-detalleTramite">No disponible</div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
   
 
   
    




    
</div>





<?= $this->endSection();?>

<?= $this->section('scripts');?>
<?= $this->endSection();?>