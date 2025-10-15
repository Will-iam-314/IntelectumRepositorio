<?= $this->extend('layouts/Authtemplate.php'); ?>

<?= $this->section('content');?>



<div id="container-Auth-v2">
  
    <div>
        <div class="d-flex justify-content-center align-items-center" id="title-Auth">
            <img class="me-1 ms-1" width=45  src="<?= base_url('assets/icons/IntelectumLogo.png')?>" alt="">
            <span class="ms-0" id="title-name-Auth"><?= name_system(); ?></span>
        </div>
        <div id="subtitle-Auth" >
            <span>Repositorio</span>
        </div> 
    </div>


 
    <div id="label-registro" class="text-center py-3 mt-2">
        <span style="font-size:35px;">¡Contraseña Restablecida!</span>
    </div>


    <div class="mt-4">
        <p style="text-align:justify;"> Estimado(a). Su contraseña ha sido restablecida correctamente. 
            Ahora puede iniciar sesión con su nueva credencial.
        </p>
    </div>

    <div class="text-center mt-5 mb-4" >
        <a style="text-decoration:none;padding-left:20px !important;padding-right:20px !important" class="btn-style1" href="<?= base_url(); ?>">Iniciar Sesion</a>
    </div>
    

</div>

<script>
    history.pushState(null, '', location.href);
    window.onpopstate = function () {
        window.location.href = "<?=base_url('/')?>"; // o la ruta que quieras
    };
</script>


<?= $this->endSection();?>

