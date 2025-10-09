<?= $this->extend('layouts/dpiTemplate.php'); ?>

<?= $this->section('content');?>

<h1>CONSTANCIA</h1>


    
    <div class="">
        
            
        <button id="btnEnviarConstancia" class="btn btn-primary btn-lg" >
            Enviar Constancia 📧
        </button>
            
        
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



<?= $this->endSection();?>

<?= $this->section('scripts');?>



<?= $this->endSection();?>

