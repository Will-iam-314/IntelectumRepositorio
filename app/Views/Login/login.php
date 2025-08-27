<?= $this->extend('layouts/login/template.php'); ?>

<?= $this->section('content');?>


<div id="container-login-2">
    <div  id="heder-login">
        <div class="d-flex justify-content-center align-items-center" id="title-login">
            <img class="me-2" width=45  src="<?= base_url('assets/icons/IntelectumLogo.png')?>" alt="">
            <span class="ms-1" id="title-name-login"><?= name_system(); ?></span>
        </div>
        <div id="subtitle-login" >
            <span>Repositorio</span>
        </div>
    </div>
    <div id="body-login">
        <form action="">

            <label class="label-form" for="input_mail">Correo Electronico</label>
            <input type="email" name="" class="input-form" id="input_mail" spellcheck="false">

            <label class="label-form" for="input_password">Contraseña</label>
            <input type="password" name="" class="input-form" id="input_password" spellcheck="false">

            <div class="text-end mt-3">
                <a href="">¿Olvidaste tu Contraseña?</a>
            </div>

            <button type="submit" class="btn-style1 mt-3">
                Iniciar Sesión
            </button>

            <button  class="btn-style2-google mt-3">
                <img id="icono-google-login" width=25 src="<?= base_url('assets/icons/google.png')?>" alt="">
                Inicia Sesión con Google
            </button>
        </form>

        <div class="border">
            <span>¿No tienes una Cuenta? </span><a href="">Crea una aqui</a>
        </div>
    </div>
</div>



<?= $this->endSection();?>