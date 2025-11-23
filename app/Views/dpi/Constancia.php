<?= $this->extend('layouts/dpiTemplate.php'); ?>

<?= $this->section('content');?>

<h1>CONSTANCIA</h1>


    
    <div class="">

        <a href="<?= base_url('dpi/enviarConstancia/'.$dniSolicitante)?>" class="btn btn-primary btn-lg" >Enviar Constancia 📧 </a>
            
    </div>
    
 
    <div class="">
      
            <iframe 
                src="<?= base_url('Constancia/'.$codigoTramite) ?>" 
                title="Visor de Constancia PDF"
                class="w-100"
                height = 900 
                allowfullscreen
            >
              
            </iframe>
       
    </div>

    <?php if($success = session()->get('success')): ?>
        <div class="alert alert-success">
            <?= $success ?>
        </div>
    <?php endif; ?>



<?= $this->endSection();?>

<?= $this->section('scripts');?>



<?= $this->endSection();?>

