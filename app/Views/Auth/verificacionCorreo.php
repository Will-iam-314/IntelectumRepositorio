<?= $this->extend('layouts/Authtemplate.php'); ?>

<?= $this->section('content');?>



<div id="container-Auth-2">
    <div class="border"  id="heder-Auth">
        <div class="d-flex justify-content-center align-items-center" id="title-Auth">
            <img class="me-2" width=45  src="<?= base_url('assets/icons/IntelectumLogo.png')?>" alt="">
            <span class="ms-1" id="title-name-Auth"><?= name_system(); ?></span>
        </div>
        <div id="subtitle-Auth" >
            <span>Repositorio</span>
        </div>
    </div>
    <div id="body-Auth">
        <h3>REGISTRO - Verificacion de Correo</h3>
        <form method="POST" action="<?= base_url('verificacion')?>" autocomplete="off" onsubmit= "mostrarLoading()">

            <?= csrf_field(); ?>

            <p>Hemos enviado un código de verificación a tu correo electrónico. Por favor, ingrésalo a continuación para confirmar tu cuenta.
            </p>
            <label class="label-form" for="input_names">Código</label>
            <input type="text" name="codigo" class="input-form" id="input_codigo" placeholder="Ingrese el Código"   required autofocus>

            <?php if(session()->getFlashdata('errors')!==null): ?>

                <div class= 'alert alert-danger my-3' role='alert'>
                <?= session()->getFlashdata('errors');?>
                </div>

            <?php  endif; ?>

            <?php if(isset($error)): ?>

                <div class= 'alert alert-danger my-3' role='alert'>
                    <?= $error ?>
                </div>

            <?php  endif; ?>

            
            <button type="submit" class="btn-style1 mt-3">
                Verificar Código
            </button>

            
            <div class="text-center mt-2">
                <a href="<?= base_url(); ?>">Iniciar sesión</a>
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

