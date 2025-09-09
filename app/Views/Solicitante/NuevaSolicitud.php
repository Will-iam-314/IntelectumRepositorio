<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>

<button onclick='confirmarRegreso()'>Atras</button>
<h1 class='px-5'>Nueva Solicitud</h1>


<form class='px-5' method="POST" action="<?= base_url('solicitante/nuevaSoli')?>" autocomplete="off" enctype="multipart/form-data" onsubmit= "mostrarLoading()">
    <?= csrf_field(); ?>

    <div class="border my-4">
        <h4>DATOS DEL MATERIAL</h4>
        
        <label class="label-form" for="input_tituloTesis">Titulo de la Tesis</label>
        <input type="text" name="tituloTesis" class="input-form" id="input_tituloTesis" value="<?= set_value('tituloTesis') ?>"   required autofocus>

        <label class="label-form" for="input_resumenTesis">Resumen </label>
        <textarea name="resumenTesis" class="input-form" id="input_resumenTesis" required><?= set_value('resumenTesis')?></textarea>

        <label class="label-form" for="input_keywordsTesis">Palabras Clave </label>
        <textarea name="keywordsTesis" class="input-form" id="input_keywordsTesis" required><?= set_value('keywordsTesis')?></textarea>
        
        <label class="label-form" for="select_lineaInvestigacion">Linea de Investigación</label>
        <select id="select_lineaInvestigacion" name="lineaInvestigacion">

            <?php foreach($lineas as $linea): ?>
                <option value="<?= $linea['id_linea']; ?>" <?= set_select('lineaInvestigacion', $linea['id_linea'])?>><?= $linea['nombre_linea']; ?></option>                    
            <?php endforeach ?>
        </select>

        <label class="label-form" for="input_CampoInvestigacion">Campo de Investigación</label>
        <input type="text" name="CampoInvestigacion" class="input-form" id="input_CampoInvestigacion" value="<?= set_value('CampoInvestigacion') ?>"   required>

        <label class="label-form" for="input_CampoAplicacion">Campo de Aplicación</label>
        <input type="text" name="CampoAplicacion" class="input-form" id="input_CampoAplicacion" value="<?= set_value('CampoAplicacion') ?>"   required>
    
        <label class="label-form" for="input_FechaSustentacion">Fecha de Sustentacion</label>
        <input type="date" name="FechaSustentacion" class="input-form" id="input_FechaSustentacion" value="<?= set_value('FechaSustentacion') ?>"   required >

        <label class="label-form" for="input_TesisFile">Archivo de la Tesis</label>
        <input type="file" name="TesisFile" class="input-form" id="input_TesisFile" accept=".pdf"   required>
    
    </div>

    <div class="border my-4">
        <h4>ASESOR Y JURADOS</h4>

        <label class="label-form" for="select_Asesor">Asesor</label>
        <select id="select_Asesor" name="Asesor">
            <?php foreach($docentes as $docente): ?>
                <option value="<?= $docente['id_docente']; ?>" <?= set_select('Asesor', $docente['id_docente'])?>><?= $docente['nombres_docente'].' '.$docente['apellidos_docente']; ?></option>                    
            <?php endforeach ?>
        </select>
   
        <label class="label-form" for="select_PresidenteJurado">Presidente</label>
        <select id="select_PresidenteJurado" name="PresidenteJurado">
            <?php foreach($docentes as $docente): ?>
                <option value="<?= $docente['id_docente']; ?>" <?= set_select('PresidenteJurado', $docente['id_docente'])?>><?= $docente['nombres_docente'].' '.$docente['apellidos_docente']; ?></option>                    
            <?php endforeach ?>
        </select>

        <label class="label-form" for="select_PrimerMiembroJurado">Primer Miembro</label>
        <select id="select_PrimerMiembroJurado" name="PrimerMiembroJurado">
            <?php foreach($docentes as $docente): ?>
                <option value="<?= $docente['id_docente']; ?>" <?= set_select('PrimerMiembroJurado', $docente['id_docente'])?>><?= $docente['nombres_docente'].' '.$docente['apellidos_docente']; ?></option>                    
            <?php endforeach ?>
        </select>

        <label class="label-form" for="select_SegundoMiembroJurado">Segundo Miembro</label>
        <select id="select_SegundoMiembroJurado" name="SegundoMiembroJurado">
            <?php foreach($docentes as $docente): ?>
                <option value="<?= $docente['id_docente']; ?>" <?= set_select('SegundoMiembroJurado', $docente['id_docente'])?>><?= $docente['nombres_docente'].' '.$docente['apellidos_docente']; ?></option>                    
            <?php endforeach ?>
        </select>

    </div>

    <div class="border my-4">
        <h4>DOCUMENTOS</h4>
        
        <label class="label-form" for="input_DeclaracionJuradaFile">Declaracion Jurada</label>
        <input type="file" name="DeclaracionJuradaFile" class="input-form" id="input_DeclaracionJuradaFile"  required accept=".pdf">

        <label class="label-form" for="input_AutorizaciónPublicacioFile">Autorizacion de Publicación</label>
        <input type="file" name="AutorizaciónPublicacioFile" class="input-form" id="input_AutorizaciónPublicacioFile"  required accept=".pdf">

    </div>

    <?php if(session()->getFlashdata('errors')!==null): ?>

        <div class= 'alert alert-danger my-3' role='alert'>
        <?= session()->getFlashdata('errors');?>
        </div>

    <?php  endif; ?>

    <button type="submit" class="btn-style1 mt-3">
        Solicitar
    </button>

</form>



<?= $this->endSection();?>
