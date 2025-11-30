<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>

 <div class="d-flex align-items-center">
    <img class="me-1" width=30 height=30 src="<?=base_url('assets/icons/documento-azul.png')?>" alt="home">
    <span class="title-modules">Mis Constancias</span>
</div>

<div class="container mx-0 mt-4 mb-5 ">

    <div class="row g-4">
        <?php if (!empty($tramites)): ?>
            <?php foreach ($tramites as $tramite): ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="constancia-card-constancias shadow-sm" 
                         onclick="window.open('<?= base_url('Constancia/' . esc($tramite['codigo'])) ?>', '_blank')"
                         role="button"
                         tabindex="0"
                         onkeypress="if(event.key === 'Enter') window.open('<?= base_url('Constancia/' . esc($tramite['codigo'])) ?>', '_blank')">
                        
                        <div class="pdf-icon-container-constancias d-flex justify-content-center align-items-center py-5">
                            <i class="fas fa-file-pdf pdf-icon-constancias"></i>
                        </div>
                        
                        <div class="p-4">
                            <div class="mb-3">
                                <?php
                                    // Extraer y formatear el código
                                    $codigoCompleto = $tramite['codigo'];
                                    // Quitar 'ITR' del inicio
                                    $sinPrefijo = substr($codigoCompleto, 3);
                                    // Extraer los últimos 2 dígitos (año)
                                    $anio = substr($sinPrefijo, -2);
                                    // Extraer el número (todo menos los últimos 2 dígitos)
                                    $numero = substr($sinPrefijo, 0, -2);
                                    // Formatear con ceros a la izquierda (4 dígitos)
                                    $numeroFormateado = str_pad($numero, 4, '0', STR_PAD_LEFT);
                                    // Formato final: N° 0005-25
                                    $codigoFormateado = "N° {$numeroFormateado}-20{$anio}";
                                ?>
                                <span class="codigo-badge-constancias">
                                    Constancia <?= esc($codigoFormateado) ?>
                                </span>
                            </div>
                            
                            <h3 class="constancia-titulo-constancias mb-3">
                                <?= esc($tramite['titulo']) ?>
                            </h3>
                            
                            <?php if (isset($tramite['fecha'])): ?>
                                <div class="constancia-fecha-constancias d-flex align-items-center">
                                    <i class="far fa-calendar-alt me-2"></i>
                                    <span><?= esc($tramite['fecha']) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="container-default mt-4">
                <div class="msg-nothing">
                    <img class="mb-3" src="<?= base_url('assets/icons/box-empty-gray.png') ?>" alt="">
                    <span class="d-block" >Aún no cuentas con ninguna constancia.</span>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection();?>

<?= $this->section('scripts');?>

<?= $this->endSection();?>