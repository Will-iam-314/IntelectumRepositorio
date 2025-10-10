<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>

<div class="container-fluid py-4">
    <h1 class="mb-4">Mis Constancias </h1>

    
    <div class="row">
        <?php if (!empty($tramites)): ?>
            <?php foreach ($tramites as $tramite): ?>
                
                <div class="col-12 col-md-6 col-xl-3 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0 text-truncate">
                                <?= esc($tramite['tipomateria']) ?>
                            </h5>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title text-success">
                                Código: <?= esc($tramite['codigo']) ?>
                            </h6>
                            <p class="card-text flex-grow-1 text-dark">
                                <strong title="">
                                    <?= esc($tramite['titulo']) ?>
                                </strong>
                            </p>
                            
                            
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                           
                                <a href="<?= base_url('Constancia/' . esc($tramite['codigo'])) ?>" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-success w-100"
                                   title="Ver constancia de publicación">
                                    <i class="fas fa-eye"></i> Ver Constancia
                                </a>
                            
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    Aún no cuentas con ninguna constancia.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>


<?= $this->endSection();?>

<?= $this->section('scripts');?>
<?= $this->endSection();?>
