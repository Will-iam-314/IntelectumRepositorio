<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>

<button onclick='confirmarRegreso()'>Atras</button>
<h1 class='px-5'>Nueva Solicitud</h1>

<form class='px-5' method="POST" action="<?= base_url('solicitante/nuevaSoli')?>" autocomplete="off" enctype="multipart/form-data" onsubmit= "mostrarLoading()">
    <?= csrf_field(); ?>

    <div class="border my-4">
        <h4>DATOS DEL MATERIAL</h4>
        
        <label class="label-form" for="input_tituloTesis">Titulo de la Tesis</label>
        <input type="text" name="tituloTesis" class="input-form" id="input_tituloTesis" value="<?= set_value('tituloTesis') ?>" required autofocus>

        <label class="label-form" for="">Autor(es)</label>
        <p class='m-0'>Por dejecto usted es un autor, precionar el boton si el material cuenta con mas autores</p>
        <button type="button" class="btn btn-outline-primary my-2" id="btn-show-autores">Agregar mas autores</button>
        
        <div id="autores-container" class="d-none"></div>

        <label class="label-form" for="input_resumenTesis">Resumen </label>
        <textarea name="resumenTesis" class="input-form" id="input_resumenTesis" required><?= set_value('resumenTesis')?></textarea>

        <label class="label-form" for="input_keywordsTesis">Palabras Clave </label>
        <textarea name="keywordsTesis" class="input-form" id="input_keywordsTesis" required><?= set_value('keywordsTesis')?></textarea>
        
        <label class="label-form" for="select_lineaInvestigacion">Linea de Investigación</label>
        <select id="select_lineaInvestigacion" name="lineaInvestigacion" class="input-form">
            <?php foreach($lineas as $linea): ?>
                <option value="<?= $linea['id_linea']; ?>" <?= set_select('lineaInvestigacion', $linea['id_linea'])?>><?= $linea['nombre_linea']; ?></option>                      
            <?php endforeach ?>
        </select>

        <label class="label-form" for="input_CampoInvestigacion">Campo de Investigación</label>
        <input type="text" name="CampoInvestigacion" class="input-form" id="input_CampoInvestigacion" value="<?= set_value('CampoInvestigacion') ?>"  required>

        <label class="label-form" for="input_CampoAplicacion">Campo de Aplicación</label>
        <input type="text" name="CampoAplicacion" class="input-form" id="input_CampoAplicacion" value="<?= set_value('CampoAplicacion') ?>"  required>
    
        <label class="label-form" for="input_FechaSustentacion">Fecha de Sustentacion</label>
        <input type="date" name="FechaSustentacion" class="input-form" id="input_FechaSustentacion" value="<?= set_value('FechaSustentacion') ?>"  required >

        <label class="label-form" for="input_TesisFile">Archivo de la Tesis</label>
        <input type="file" name="TesisFile" class="input-form" id="input_TesisFile" accept=".pdf"  required>
    
    </div>

    <div class="border my-4">
        <h4>ASESOR Y JURADOS</h4>

        <label class="label-form" for="select_Asesor">Asesor</label>
        <select id="select_Asesor" name="Asesor" class="input-form">
            <?php foreach($docentes as $docente): ?>
                <option value="<?= $docente['id_docente']; ?>" <?= set_select('Asesor', $docente['id_docente'])?>><?= $docente['nombres_docente'].' '.$docente['apellidos_docente']; ?></option>                      
            <?php endforeach ?>
        </select>
   
        <label class="label-form" for="select_PresidenteJurado">Presidente</label>
        <select id="select_PresidenteJurado" name="PresidenteJurado" class="input-form">
            <?php foreach($docentes as $docente): ?>
                <option value="<?= $docente['id_docente']; ?>" <?= set_select('PresidenteJurado', $docente['id_docente'])?>><?= $docente['nombres_docente'].' '.$docente['apellidos_docente']; ?></option>                      
            <?php endforeach ?>
        </select>

        <label class="label-form" for="select_PrimerMiembroJurado">Primer Miembro</label>
        <select id="select_PrimerMiembroJurado" name="PrimerMiembroJurado" class="input-form">
            <?php foreach($docentes as $docente): ?>
                <option value="<?= $docente['id_docente']; ?>" <?= set_select('PrimerMiembroJurado', $docente['id_docente'])?>><?= $docente['nombres_docente'].' '.$docente['apellidos_docente']; ?></option>                      
            <?php endforeach ?>
        </select>

        <label class="label-form" for="select_SegundoMiembroJurado">Segundo Miembro</label>
        <select id="select_SegundoMiembroJurado" name="SegundoMiembroJurado" class="input-form">
            <?php foreach($docentes as $docente): ?>
                <option value="<?= $docente['id_docente']; ?>" <?= set_select('SegundoMiembroJurado', $docente['id_docente'])?>><?= $docente['nombres_docente'].' '.$docente['apellidos_docente']; ?></option>                      
            <?php endforeach ?>
        </select>
    </div>

    <div class="border my-4">
        <h4>DOCUMENTOS</h4>
        
        <label class="label-form" for="input_DeclaracionJuradaFile">Declaracion Jurada</label>
        <input type="file" name="DeclaracionJuradaFile" class="input-form" id="input_DeclaracionJuradaFile" required accept=".pdf">

        <label class="label-form" for="input_AutorizaciónPublicacioFile">Autorizacion de Publicación</label>
        <input type="file" name="AutorizaciónPublicacioFile" class="input-form" id="input_AutorizaciónPublicacioFile" required accept=".pdf">
    </div>

    <?php if(session()->getFlashdata('errors')!==null): ?>
        <div class= 'alert alert-danger my-3' role='alert'>
            <?= session()->getFlashdata('errors');?>
        </div>
    <?php endif; ?>

    <button type="submit" class="btn-style1 mt-3">
        Solicitar
    </button>
</form>

<?= $this->endSection();?>

---

<?= $this->section('scripts');?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnShowAutores = document.getElementById('btn-show-autores');
        const autoresContainer = document.getElementById('autores-container');

        // Contenido del primer campo de autor para recrearlo
        const firstAuthorHtml = `
            <div class="input-group mb-3">
                <input type="text" name="autores[]" class="form-control input-form autor-input" placeholder="Nombre completo del autor" required>
                <button class="btn btn-outline-secondary btn-remove-autor" type="button">-</button>
                <button class="btn btn-outline-secondary btn-add-autor" type="button">+</button>
            </div>
        `;

        // Muestra el contenedor de autores y oculta el botón al hacer clic
        btnShowAutores.addEventListener('click', function() {
            // Verifica si el contenedor está vacío de campos de autor y lo rellena
            if (autoresContainer.querySelectorAll('.input-group').length === 0) {
                autoresContainer.insertAdjacentHTML('beforeend', firstAuthorHtml);
            }
            autoresContainer.classList.remove('d-none');
            this.style.display = 'none'; // Oculta el botón
        });

        // Lógica para agregar y eliminar campos de autor dinámicamente
        autoresContainer.addEventListener('click', function(event) {
            const clickedElement = event.target;

            // Lógica para agregar un nuevo autor
            if (clickedElement.classList.contains('btn-add-autor')) {
                // Clona el primer campo, que siempre tendrá el botón de agregar
                const newAuthorInputGroup = autoresContainer.querySelector('.input-group').cloneNode(true);
                
                // Limpia el valor del nuevo input
                const newInput = newAuthorInputGroup.querySelector('.autor-input');
                newInput.value = ''; 
                newInput.placeholder = "Nombre completo de otro autor";

                // Remueve el botón de agregar del nuevo campo clonado
                newAuthorInputGroup.querySelector('.btn-add-autor').remove();
                
                autoresContainer.appendChild(newAuthorInputGroup);
            } 
            // Lógica para eliminar un autor
            else if (clickedElement.classList.contains('btn-remove-autor')) {
                const inputGroupToRemove = clickedElement.closest('.input-group');
                inputGroupToRemove.remove();

                // Verifica si no queda ningún campo de autor y vuelve a mostrar el botón
                if (autoresContainer.querySelectorAll('.input-group').length === 0) {
                    autoresContainer.classList.add('d-none');
                    btnShowAutores.style.display = 'block';
                }
            }
        });
    });
</script>
<?= $this->endSection();?>