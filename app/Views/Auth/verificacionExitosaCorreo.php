<?= $this->extend('layouts/Authtemplate.php'); ?>

<?= $this->section('content');?>



<div id="container-Auth-v2">
  
    <div class="border">
        <div class="d-flex justify-content-start align-items-center" id="title-Auth">
            <img class="me-2" width=45  src="<?= base_url('assets/icons/IntelectumLogo.png')?>" alt="">
            <span class="ms-1" id="title-name-Auth"><?= name_system(); ?></span>
        </div>
        <div id="" >
            <span>Repositorio</span>
        </div>
    </div>


    <div class="border d-flex justify-content-center">
        <div class="border">
            <p>VERIFICACIÓN EXITOSA</p>
        </div>
    </div>

    <div>
        <p> Sr(a). Manolo Camelo, su cuenta en Intelectum Repositorio ha sido 
            creada y verificada exitosamente. Ya puede iniciar sesión utilizando
            el correo y la contraseña que registró anteriormente.
        </p>
    </div>

    <a href="<?= base_url(); ?>">Iniciar Sesion</a>

</div>

<script>
    history.pushState(null, '', location.href);
    window.onpopstate = function () {
        window.location.href = "<?=base_url('/')?>"; // o la ruta que quieras
    };
</script>


<?= $this->endSection();?>

