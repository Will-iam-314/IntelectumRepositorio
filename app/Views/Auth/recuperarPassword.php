<?= $this->extend('layouts/Authtemplate.php'); ?>

<?= $this->section('content');?>


 
<div id="container-Auth-2">
    <div  id="heder-Auth-1">
        <div class="d-flex justify-content-center align-items-center" id="title-Auth">
            <img class="me-1 ms-1" width=45  src="<?= base_url('assets/icons/IntelectumLogo.png')?>" alt="">
            <span class="ms-0" id="title-name-Auth"><?= name_system(); ?></span>
        </div>
        <div id="subtitle-Auth" >
            <span>Repositorio</span>
        </div> 
    </div>
    <div class="mt-3">
        <div class="text-center" id="label-registro">
            <span>Recuperar Contraseña</span>
        </div>

        <p class="mt-2" style="text-align: justify;">
            Ingresa el correo electrónico asociado a tu cuenta. Te enviaremos un código de verificación para restablecer tu contraseña.
        </p>
        
        <form method="POST" action="<?= base_url('recuperarPassword')?>" autocomplete="off" onsubmit= "mostrarLoading()">

            <?= csrf_field(); ?>

           
            <label class="label-form" for="input_correo_recuperar">Correo</label>
            <input type="text" name="correo_recuperar" class="input-form" id="input_correo_recuperar" placeholder="Ingrese el Correo electronico"   required autofocus>

            <div class="text-start mt-2">
                <a class="a-link-default" href="<?= base_url('verificarRecuperacion'); ?>">Ya tengo un código</a>
            </div>
            
            <?php if(session()->getFlashdata('errors')!==null): ?>

                <div class= 'alert alert-danger my-3 ' role='alert'>
                <?= session()->getFlashdata('errors');?>
                </div>

            <?php  endif; ?>

            <?php if(isset($error)): ?>

                <div class= 'alert alert-danger my-3' role='alert'>
                    <?= $error ?>
                </div>

            <?php  endif; ?>

            
            <button type="submit" class="btn-style1 mt-4">
                Enviar
            </button>

            
            <div class="text-center mt-2">
                <a class="a-link-default" href="<?= base_url(); ?>">Iniciar sesión</a>
            </div>
        </form>



    </div>
    <div id="footer-Auth">
        <p>
            Universidad Nacional de Ucayali -
            Vicerrectorado de Investigación 2025 ©
        </p>
    </div>
</div>




<?= $this->endSection();?>

