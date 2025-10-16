<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>




 <div class="d-flex align-items-center">
        
        <button style="all: unset;cursor: pointer;" onclick='confirmarRegreso()'> <img class="me-1" style="margin-top:-3px;" width=30 height=30 src="<?=base_url('assets/icons/flecha-atras.png')?>" alt="home"> </button>
        <span class="title-modules ms-2">Nueva Solicitud</span>
    </div>

<form class='' method="POST" action="<?= base_url('solicitante/nuevaSoli')?>" autocomplete="off" enctype="multipart/form-data" onsubmit= "mostrarLoading()">
    
    <?= csrf_field(); ?>

    <div class="border my-4 container-default">
    
        <h4>DATOS DEL MATERIAL</h4>
        
        <label class="label-form" for="input_tituloTesis">Titulo de la Tesis</label>
        <input type="text" name="tituloTesis" class="input-form" id="input_tituloTesis" value="<?= set_value('tituloTesis') ?>" required autofocus>

        <label class="label-form" for="">Autor(es)</label>
        <p class='m-0'>Por dejecto usted es un autor, precionar el boton si el material cuenta con mas autores</p>
        <button type="button" class="btn btn-outline-primary my-2" id="btn-show-autores">Agregar mas autores</button>
        
        <div id="autores-container" class="d-none"></div>

        <input type="hidden" name="autores[0][nombre]" value="<?= $solicitanteActualNombres ?>">
        <input type="hidden" name="autores[0][dni]" value="<?= $solicitanteActualDNI ?>">

        <label class="label-form" for="input_resumenTesis">Resumen </label>
        <textarea name="resumenTesis" class="input-form" id="input_resumenTesis" required><?= set_value('resumenTesis')?></textarea>

        <label class="label-form" for="input_keywordsTesis">Palabras Clave </label>
        <textarea name="keywordsTesis" class="input-form" id="input_keywordsTesis" required><?= set_value('keywordsTesis')?></textarea>
        
        <label class="label-form" for="input_lineaInvestigacion">Linea de Investigación</label>
        <input type="text" name="lineaInvestigacion" class="input-form" id="input_lineaInvestigacion" value="<?= set_value('lineaInvestigacion') ?>" required >
        
        
        

        <label class="label-form" for="input_CampoInvestigacion">Campo de Investigación</label>

        <div id="iframe-container" class="my-3 d-none">
            <button type="button" class="btn btn-outline-secondary mb-2" id="btn-close-iframe">Ocultar</button>
            <div class="iframe-wrapper">
                <iframe src="https://concytec-pe.github.io/Peru-CRIS/vocabularios/ocde_ford.html" frameborder="0" style="width: 100%; height: 500px;"></iframe>
            </div>
        </div>

        <button type="button" class="btn btn-info mt-2" id="btn-show-iframe">Ver Campos de Investigación</button>

        <input type="text" name="CampoInvestigacion" class="input-form" id="input_CampoInvestigacion" value="<?= set_value('CampoInvestigacion') ?>"  required>

        <label class="label-form" for="input_CampoAplicacion">Campo de Aplicación</label>
        <input type="text" name="CampoAplicacion" class="input-form" id="input_CampoAplicacion" value="<?= set_value('CampoAplicacion') ?>"  required>
    
        <label class="label-form" for="input_FechaSustentacion">Fecha de Sustentacion</label>
        <input type="date" name="FechaSustentacion" class="input-form" id="input_FechaSustentacion" value="<?= set_value('FechaSustentacion') ?>"  required >

        <label class="label-form" for="input_TesisFile">Archivo de la Tesis</label>
        <input type="file" name="TesisFile" class="input-form" id="input_TesisFile" accept=".pdf"  required>
    
    </div>

    <div class="border my-4 container-default">
        <h4 class="mt-4">GRADO ACADÉMICO A OPTAR</h4>
        
        <label class="label-form" for="select_gradoTipo">Tipo de Grado</label>
        <select id="select_gradoTipo" name="gradoTipo" class="input-form" required>
            <option value="" disabled selected>Seleccione el tipo de grado</option>
            <option value="titulo profesional" <?= set_select('gradoTipo', 'titulo profesional')?>>Título Profesional</option> 
            <option value="segunda especialidad" <?= set_select('gradoTipo', 'segunda especialidad')?>>Segunda Especialidad</option> 
            <option value="maestria" <?= set_select('gradoTipo', 'maestria')?>>Maestría</option> 
            <option value="doctorado" <?= set_select('gradoTipo', 'doctorado')?>>Doctorado</option> 
        </select>
        
        <label class="label-form" for="input_gradoDescripcion">Descripción del Grado (Ej: Nombre de la Maestría)</label>
        <input type="text" name="gradoDescripcion" class="input-form" id="input_gradoDescripcion" value="<?= set_value('gradoDescripcion') ?>" required>
    </div>

    <div class="border my-4 container-default">
        <h4>ASESOR Y JURADOS</h4>
        <label class="label-form" for="input_AsesorNombres">Asesor (Nombres y Apellidos)</label>
        <input type="text" name="Asesor" class="input-form" id="input_AsesorNombres" value="<?= set_value('AsesorNombres') ?>" required>
        
        <label class="label-form" for="input_AsesorDNI">Asesor (DNI)</label>
        <input type="text" name="AsesorDNI" class="input-form" id="input_AsesorDNI" value="<?= set_value('AsesorDNI') ?>" required>

        <label class="label-form" for="input_AsesorORCID">Asesor (ORCID)</label>
        <input type="text" name="AsesorORCID" class="input-form" id="input_AsesorORCID" value="<?= set_value('AsesorORCID') ?>" required>

        <label class="label-form" for="input_PresidenteJuradoNombres">Presidente (Nombres y Apellidos)</label>
        <input type="text" name="PresidenteJurado" class="input-form" id="input_PresidenteJuradoNombres" value="<?= set_value('PresidenteJuradoNombres') ?>" required>
   
        <label class="label-form" for="input_PrimerMiembroJuradoNombres">Primer Miembro (Nombres y Apellidos)</label>
        <input type="text" name="PrimerMiembroJurado" class="input-form" id="input_PrimerMiembroJuradoNombres" value="<?= set_value('PrimerMiembroJuradoNombres') ?>" required>

        <label class="label-form" for="input_SegundoMiembroJuradoNombres">Segundo Miembro (Nombres y Apellidos)</label>
        <input type="text" name="SegundoMiembroJurado" class="input-form" id="input_SegundoMiembroJuradoNombres" value="<?= set_value('SegundoMiembroJuradoNombres') ?>" required>
    </div>

    <div class="border my-4 container-default">
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


<?= $this->section('scripts');?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Lógica para el manejo de autores
        const btnShowAutores = document.getElementById('btn-show-autores');
        const autoresContainer = document.getElementById('autores-container');

        btnShowAutores.addEventListener('click', function() {
            autoresContainer.classList.remove('d-none');
            // Solo agregar el primer input si no existe
            if (autoresContainer.children.length === 0) {
                addNewAuthorInput(true); // Pasar 'true' para el primer autor
            }
            this.style.display = 'none';
        });

        // Lógica para agregar y eliminar autores
        autoresContainer.addEventListener('click', function(event) {
            const clickedElement = event.target;
            
            if (clickedElement.classList.contains('btn-add-autor')) {
                addNewAuthorInput();
            } else if (clickedElement.classList.contains('btn-remove-autor')) {
                const inputGroupToRemove = clickedElement.closest('.input-group');
                inputGroupToRemove.remove();

                if (autoresContainer.children.length === 0) {
                    autoresContainer.classList.add('d-none');
                    btnShowAutores.style.display = 'block';
                }
            }
        });

        // Función para crear y añadir un nuevo autor
        function addNewAuthorInput(isFirst = false) {
            const currentAuthors = autoresContainer.querySelectorAll('.input-group');
            const newIndex = currentAuthors.length + 1; // El índice comienza después del autor principal (índice 0)

            const newAuthorGroup = document.createElement('div');
            newAuthorGroup.className = 'input-group mb-3';

            const nameInput = document.createElement('input');
            nameInput.type = 'text';
            nameInput.name = `autores[${newIndex}][nombre]`;
            nameInput.className = 'form-control autor-input-nombre';
            nameInput.placeholder = 'Nombre completo del autor';
            nameInput.required = true;

            const dniInput = document.createElement('input');
            dniInput.type = 'text';
            dniInput.name = `autores[${newIndex}][dni]`;
            dniInput.className = 'form-control autor-input-dni';
            dniInput.placeholder = 'DNI';
            dniInput.required = true;
            
            newAuthorGroup.appendChild(nameInput);
            newAuthorGroup.appendChild(dniInput);
            
            // Lógica para los botones de remover y agregar
            const removeButton = document.createElement('button');
            removeButton.className = 'btn btn-outline-secondary btn-remove-autor';
            removeButton.type = 'button';
            removeButton.textContent = '-';

            const addButton = document.createElement('button');
            addButton.className = 'btn btn-outline-secondary btn-add-autor';
            addButton.type = 'button';
            addButton.textContent = '+';
            
            // Se agregan ambos botones para que el último input siempre tenga el [+]
            newAuthorGroup.appendChild(removeButton);
            newAuthorGroup.appendChild(addButton);

            // Remueve el botón de agregar del autor anterior (si existe) para que solo el último lo tenga
            const existingAddButton = autoresContainer.querySelector('.btn-add-autor');
            if (existingAddButton) {
                existingAddButton.remove();
            }

            autoresContainer.appendChild(newAuthorGroup);
        }
    });

    // Lógica para mostrar y ocultar el iframe
    document.addEventListener('DOMContentLoaded', function () {
        const btnShowIframe = document.getElementById('btn-show-iframe');
        const btnCloseIframe = document.getElementById('btn-close-iframe');
        const iframeContainer = document.getElementById('iframe-container');
        const inputCampoInvestigacion = document.getElementById('input_CampoInvestigacion');
        
        btnShowIframe.addEventListener('click', function() {
            iframeContainer.classList.remove('d-none');
            // Desplaza el input hacia abajo
            inputCampoInvestigacion.style.marginTop = '20px'; // Puedes ajustar este valor
            this.style.display = 'none'; // Oculta el botón de mostrar
        });

        btnCloseIframe.addEventListener('click', function() {
            iframeContainer.classList.add('d-none');
            // Devuelve el input a su posición original
            inputCampoInvestigacion.style.marginTop = '0';
            btnShowIframe.style.display = 'block'; // Muestra de nuevo el botón
        });
    });
</script>

<?= $this->endSection();?>