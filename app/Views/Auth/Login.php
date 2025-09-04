<?= $this->extend('layouts/Authtemplate.php'); ?>

<?= $this->section('content');?>


<div id="container-Auth-2">
    <div  id="heder-Auth">
        <div class="d-flex justify-content-center align-items-center" id="title-Auth">
            <img class="me-2" width=45  src="<?= base_url('assets/icons/IntelectumLogo.png')?>" alt="">
            <span class="ms-1" id="title-name-Auth"><?= name_system(); ?></span>
        </div>
        <div id="subtitle-Auth" >
            <span>Repositorio</span>
        </div>
    </div>
    <div id="body-Auth">
        <form method="POST" action="<?= base_url('auth')?>" autocomplete="off" onsubmit= "mostrarLoading()">

            <?= csrf_field(); ?> 
            <label class="label-form" for="input_mail">Correo Electronico</label>
            <input type="email" name="email" class="input-form" id="input_mail" spellcheck="false" required>

            <label class="label-form" for="input_password">Contraseña</label>
            <input type="password" name="password" class="input-form" id="input_password" spellcheck="false" required>

            <div class="text-end mt-3">
                <a href="">¿Olvidaste tu Contraseña?</a>
            </div>

            <?php if(session()->getFlashdata('errors')!==null): ?>

                <div class= 'alert alert-danger my-3' role='alert'>
                <?= session()->getFlashdata('errors');?>
                </div>

            <?php  endif; ?>

            <button type="submit" class="btn-style1 mt-3">
                Iniciar Sesión
            </button>

            <button  class="btn-style2-google mt-3">
                <img id="icono-google-Auth" width=25 src="<?= base_url('assets/icons/google.png')?>" alt="">
                Inicia Sesión con Google
            </button>
        </form>

        <div  class=" mt-3">
            <span id="text-end-body-Auth" >¿No tienes una Cuenta? </span><a href="<?= base_url('registrarse') ; ?>">Crea una aqui</a>
        </div>
    </div>
    <div id="footer-Auth">
        <p>
            Universidad Nacional de Ucayali -
            Vicerrectorado de Investigación 2025 ©
        </p>
    </div>
</div>



<?= $this->endSection();?>

<?= $this->section('scripts');?>



<?= $this->endSection();?>