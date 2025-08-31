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
        <h3>Registro</h3>
        <form method="POST" action="<?= base_url('registro')?>" autocomplete="off" onsubmit="mostrarLoading()">

            <label class="label-form" for="input_names">Nombres</label>
            <input type="text" name="nombres" class="input-form" id="input_names" spellcheck="false">

            <label class="label-form" for="input_apellidos">Apellidos</label>
            <input type="text" name="apellidos" class="input-form" id="input_apellidos" spellcheck="false">

            <label class="label-form" for="input_dni">DNI</label>
            <input type="text" name="dni" class="input-form" id="input_dni" spellcheck="false">

            <label class="label-form" for="select_carrera">Carrera Profesional</label>
            <select id="select_carrera" name="carrera">
                <?php foreach($carreras as $carrera): ?>
                    <option value="<?= $carrera['id_escuela']; ?>"><?= $carrera['nombre_escuela']; ?></option>                    
                <?php endforeach ?>
            </select>

            <label class="label-form" for="input_correo">Correo Electronico</label>
            <input type="text" name="email" class="input-form" id="input_correo" spellcheck="false">

            <label class="label-form" for="input_password">Contraseña</label>
            <input type="password" name="password" class="input-form" id="input_password" spellcheck="false">

             <label class="label-form" for="input_repassword">Repite la Contraseña</label>
            <input type="password" name="repassword" class="input-form" id="input_repassword" spellcheck="false">

            <button type="submit" class="btn-style1 mt-3">
                Registrarse
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


<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div  class="modal-content contenedor-modal-load">
      <div  class=" cont-modal-load-spinner">
        <div class="spinner-border spinner-custom" role="status" style=""></div>
      </div>
      <p class=" text-cont-modal-load">Cargando</p>
    </div>
  </div>
</div>




<?= $this->endSection();?>

<?= $this->section('scripts');?>

<script>
  function mostrarLoading() {
    let modal = new bootstrap.Modal(document.getElementById('loadingModal'), {
      backdrop: 'static',   // evita que lo cierren
      keyboard: false       // evita que cierren con ESC
    });
    modal.show();
  }
</script>

<?= $this->endSection();?>