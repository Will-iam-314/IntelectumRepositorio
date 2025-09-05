<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>

<button onclick='confirmarRegreso()'>Atras</button>
<h1>Nueva Solicitud</h1>


<form class='p-5' method="POST" action="<?= base_url('')?>" autocomplete="off" onsubmit= "mostrarLoading()">
    <?= csrf_field(); ?>

    <div class="border mt-2">
        <h4>DATOS DEL MATERIAL</h4>
        
        <label class="label-form" for="input_tituloTesis">Titulo de la Tesis</label>
        <input type="text" name="tituloTesis" class="input-form" id="input_tituloTesis" value="<?= set_value('tituloTesis') ?>"   required autofocus>

        <label class="label-form" for="input_abstractTesis">Abstrac </label>
        <textarea name="abstractTesis" class="input-form" id="input_abstractTesis" value=" <?= set_value('abstractTesis')?> " required></textarea>

        <label class="label-form" for="input_keywordsTesis">Palabras Clave </label>
        <textarea name="keywordsTesis" class="input-form" id="input_keywordsTesis" value=" <?= set_value('keywordsTesis')?> " required></textarea>
        
        <label class="label-form" for="select_carrera">Linea de Investigación</label>
          <select id="select_lineaInvestigacion" name="carrera">

              <?php foreach($carreras as $carrera): ?>
                  <option value="<?= $carrera['id_escuela']; ?>" <?= set_select('carrera', $carrera['id_escuela'])?>><?= $carrera['nombre_escuela']; ?></option>                    
              <?php endforeach ?>
          </select>
    

    </div>

    <div class="border mt-2">
        <h4>ASESOR Y JURADOS</h4>
        
        <label class="label-form" for="input_tituloTesis">Titulo de la Tesis</label>
        <input type="text" name="tituloTesis" class="input-form" id="input_tituloTesis" value="<?= set_value('tituloTesis') ?>"   required autofocus>

        <label class="label-form" for="input_names">Fecha de Sustentacion</label>
        <input type="date" name="tituloTesis" class="input-form" id="input_names" value="<?= set_value('') ?>"   required autofocus>

    </div>

    <div class="border mt-2">
        <h4>DOCUMENTOS</h4>
        
        <label class="label-form" for="input_tituloTesis">Titulo de la Tesis</label>
        <input type="text" name="tituloTesis" class="input-form" id="input_tituloTesis" value="<?= set_value('tituloTesis') ?>"   required autofocus>

        <label class="label-form" for="input_names">Fecha de Sustentacion</label>
        <input type="date" name="tituloTesis" class="input-form" id="input_names" value="<?= set_value('') ?>"   required autofocus>

    </div>
</form>



<?= $this->endSection();?>
