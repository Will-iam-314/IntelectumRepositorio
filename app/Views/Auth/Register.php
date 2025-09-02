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
        <form method="POST" action="<?= base_url('registro')?>" autocomplete="off" onsubmit= "mostrarLoading()">

          <?= csrf_field(); ?>

          <label class="label-form" for="input_names">Nombres</label>
          <input type="text" name="nombres" class="input-form" id="input_names" value="<?= set_value('nombres') ?>"   required autofocus>

          <label class="label-form" for="input_apellidos">Apellidos</label>
          <input type="text" name="apellidos" class="input-form" id="input_apellidos" value="<?= set_value('apellidos') ?>" spellcheck="false" required>

          <label class="label-form" for="input_dni">DNI</label>
          <input type="text" name="dni" class="input-form" id="input_dni" value="<?= set_value('dni') ?>" spellcheck="false" required>

          <label class="label-form" for="select_carrera">Carrera Profesional</label>
          <select id="select_carrera" name="carrera">

              <?php foreach($carreras as $carrera): ?>
                  <option value="<?= $carrera['id_escuela']; ?>" <?= set_select('carrera', $carrera['id_escuela'])?>><?= $carrera['nombre_escuela']; ?></option>                    
              <?php endforeach ?>
          </select>

          <label class="label-form" for="input_correo">Correo Electronico</label>
          <input type="email" name="email" class="input-form" id="input_correo" value="<?= set_value('email') ?>" spellcheck="false" required>

          <label class="label-form" for="input_password">Contraseña</label>
          <input type="password" name="password" class="input-form" id="input_password" value="<?= set_value('password') ?>" spellcheck="false" required>

            <label class="label-form" for="input_repassword">Repite la Contraseña</label>
          <input type="password" name="repassword" class="input-form" id="input_repassword" value="<?= set_value('repassword') ?>" spellcheck="false" required>

          <?php if(session()->getFlashdata('errors')!==null): ?>

            <div class= 'alert alert-danger my-3' role='alert'>
            <?= session()->getFlashdata('errors');?>
            </div>

          <?php  endif; ?>


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





<?= $this->endSection();?>
