<?= $this->extend('layouts/Authtemplate.php'); ?>

<?= $this->section('content');?>


<div id="container-Auth-v2">
    <div class="text-center">

        <div  id="heder-Auth-register"> 
            <div class="d-flex justify-content-center align-items-center" id="title-Auth">
                <img class="me-2" width=45  src="<?= base_url('assets/icons/IntelectumLogo.png')?>" alt="">
                <span class="ms-1" id="title-name-Auth"><?= name_system(); ?></span>
            </div>
            <div id="subtitle-Auth" >
                <span>Repositorio</span>
            </div>
        </div>
    </div>
    
    <div class="mt-4" id="body-Auth-registro ">
        <span id="label-registro">REGISTRO</span>
        <form method="POST" action="<?= base_url('registro')?>" autocomplete="off" onsubmit= "mostrarLoading()">

          <?= csrf_field(); ?>

          <div class="row">

                <div class="col-12 col-lg-6  ">
                
                    <label class="label-form" for="input_names">Nombres</label>
                    <input type="text" name="nombres" class="input-form" id="input_names" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo se permiten letras y espacios" value="<?= set_value('nombres') ?>"   required autofocus>
                </div>

                <div class="col-12 col-lg-6  ">
                    <label class="label-form" for="input_apellidos">Apellidos</label>
                    <input type="text" name="apellidos" class="input-form" id="input_apellidos" value="<?= set_value('apellidos') ?>" spellcheck="false" required>
                </div>

          </div>

          <div class="row">

                <div class="col-12 col-lg-6  ">
                    <label class="label-form" for="input_dni">DNI</label>
                    <input type="number" name="dni" class="input-form" id="input_dni" value="<?= set_value('dni') ?>" spellcheck="false" required>                            
                </div>

                <div class="col-12 col-lg-6  ">
                   <label class="label-form" for="select_carrera">Escuela Profesional</label>
                   
                    <select class="select-form" id="select_carrera" name="carrera">
                        <option value="" disabled selected hidden>Selecciona una escuela</option>
                        <?php foreach($carreras as $carrera): ?>
                            <option value="<?= $carrera['id_escuela']; ?>" <?= set_select('carrera', $carrera['id_escuela'])?>><?= $carrera['nombre_escuela']; ?></option>                    
                        <?php endforeach ?>
                    </select>
                    <span id="descripcion-select-carrera">Escuela profesional del cual esta tramitando el diploma</span>
                </div>

          </div>

          <label id="label-input-correo" class="label-form" for="input_correo">Correo Electronico</label>
          <input type="email" name="email" class="input-form" id="input_correo" value="<?= set_value('email') ?>" spellcheck="false" required>

           <div class="row">

                <div class="col-12 col-lg-6 mb-lg-0 mb-4 ">                
                    <label class="label-form" for="input_password">Contraseña</label>
                    <input type="password" name="password" class="input-form" id="input_password" value="<?= set_value('password') ?>" spellcheck="false" required>
                    <span id="descripcion-select-carrera">La Contraseña debe tener almenos 8 caracteres.</span>
                </div>

                <div class="col-12 col-lg-6  ">
                    <label class="label-form" for="input_repassword">Repite la Contraseña</label>
                    <input type="password" name="repassword" class="input-form" id="input_repassword" value="<?= set_value('repassword') ?>" spellcheck="false" required>
                </div>

          </div>



          <?php if(session()->getFlashdata('errors')!==null): ?>

            <div class= 'alert alert-danger mb-2 mt-5' role='alert'>
            <?= session()->getFlashdata('errors');?>
            </div>

          <?php  endif; ?>


          <button type="submit" class="btn-style1 mt-5">
              Registrarse
          </button>

          
        
          

        
          <div class="text-center mt-4">
              <a class="a-link-default" href="<?= base_url('verificar'); ?>">Verificar Correo</a>
          </div>
          

          <div class="text-center mt-1 ">
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
