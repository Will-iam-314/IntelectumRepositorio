<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>

 <div class="d-flex align-items-center">
        
        <button style="all: unset;cursor: pointer;" onclick='confirmarRegreso()'> <img class="me-1" style="margin-top:-3px;" width=30 height=30 src="<?=base_url('assets/icons/flecha-atras.png')?>" alt="home"> </button>
        <span class="title-modules ms-2">Nueva Solicitud</span>
    </div>

<form class='mb-4' method="POST" action="<?= base_url('solicitante/nuevaSoli')?>" autocomplete="off" enctype="multipart/form-data" onsubmit= "mostrarLoading()">
    
    <?= csrf_field(); ?>

    <div class="border my-4 container-default">          
    
        <span class="tarjet-cyan mb-3">Datos de la Tesis</span>  
            
        <label class="label-form" for="input_tituloTesis">Titulo de la Tesis</label>
        <span class="description-input">Digitar sin comillas y tenga encuenta que tal como ingrese el titulo, se mostrará en su Constancia.</span>
        <input type="text" name="tituloTesis" class="input-form" id="input_tituloTesis" value="<?= set_value('tituloTesis') ?>" required autofocus>

        <label class="label-form" for="">Autor(es)</label>
        <span class="description-input">Por defecto usted es un autor, preciona el boton si el material cuenta con mas autores</span>
        <button type="button" class="btn-style2 " id="btn-show-autores">Agregar mas autores</button>
        
        <div id="autores-container" class="d-none mt-2"></div>

        <input type="hidden" name="autores[0][nombre]" value="<?= $solicitanteActualNombres ?>">
        <input type="hidden" name="autores[0][dni]" value="<?= $solicitanteActualDNI ?>">

        <label class="label-form" for="input_resumenTesis">Resumen </label>
        <span class="description-input">Ingresar el resumen de su tesis en español y correctamente redactado.</span>
        <textarea name="resumenTesis" class="input-form" id="input_resumenTesis" required><?= set_value('resumenTesis')?></textarea>

        <label class="label-form" for="input_keywordsTesis">Palabras Clave </label>
        <span class="description-input">Mínimo 03 palabras clave coherentes separados por una coma (,). La inicial de cada palabra clave debe ir con Mayúscula.</span>
        <textarea name="keywordsTesis" class="input-form" id="input_keywordsTesis" required><?= set_value('keywordsTesis')?></textarea>
        



        <label class="label-form" for="input_lineaInvestigacion">Linea de Investigación</label>
        <span class="description-input">Haz clic en “Ver lineas”, busca la que se relacione con tu investigación y cópiala en el campo.</span>
        <div id="iframe-container-lineas" class="mt-1 mb-3 d-none">
            <button type="button" class="mb-2 btn-style3-danger" id="btn-close-iframe-lineas">Ocultar</button>
            <div class="iframe-wrapper">
                <iframe class='iframe-styles' src="<?= base_url('docs/Lineas_investigacion.pdf') ?>" frameborder="0" style="width: 100%; height: 500px;"></iframe>
            </div>
        </div>
        <button type="button" class="btn-style2 mb-3" id="btn-show-iframe-lineas">Ver lineas</button>
        <input type="text" name="lineaInvestigacion" class="input-form" id="input_lineaInvestigacion" value="<?= set_value('lineaInvestigacion') ?>" required >
        

       

        <label class="label-form" for="input_CampoInvestigacion">Campo de Investigación</label>
        <div class="d-flex">
            <span class="description-input">Haz clic en "Ver Campos de Investigacion", busca el campo que mas se relacione con tu investigación y cópiala en el campo. </span>
            <i class="fa fa-question-circle icon-help-question ms-2" aria-hidden="true"></i>
        </div>
        <div id="iframe-container-CampoInvestigacion" class="mt-1 mb-3  d-none">
            <button type="button" class="mb-2 btn-style3-danger" id="btn-close-iframe-CampoInvestigacion">Ocultar</button>
            <div class="iframe-wrapper">
                <iframe class='iframe-styles' src="https://concytec-pe.github.io/Peru-CRIS/vocabularios/ocde_ford.html" frameborder="0" style="width: 100%; height: 500px;"></iframe>
            </div>
        </div>
        <button type="button" class="btn-style2 mb-3" id="btn-show-iframe-CampoInvestigacion">Ver Campos de Investigación</button>
        <input type="text" name="CampoInvestigacion" class="input-form" id="input_CampoInvestigacion" value="<?= set_value('CampoInvestigacion') ?>"  required>




        <label class="label-form" for="input_CampoAplicacion">Campo de Aplicación</label>
        <div class="d-flex">
            <span class="description-input">Haz clic en "Ver Campos de Aplicación", busca el campo que mas se relacione con tu investigación y cópia el codigo numerico de 6 digitos y pegalo en el campo. </span>
            <i class="fa fa-question-circle icon-help-question" aria-hidden="true"></i>
        </div>
        <div id="iframe-container-CampoAplicacion" class="mt-1 mb-3 d-none">
            <button type="button" class="mb-2 btn-style3-danger" id="btn-close-iframe-CampoAplicacion">Ocultar</button>
            <div class="iframe-wrapper">
                <iframe class='iframe-styles' src="<?= base_url('docs/Campos_Aplicacion.pdf') ?>" frameborder="0" style="width: 100%; height: 500px;"></iframe>
            </div>
        </div>            
        <button type="button" class="btn-style2 mb-3" id="btn-show-iframe-CampoAplicacion">Ver Campos de Aplicación</button>            
        <input type="text" name="CampoAplicacion" class="input-form" id="input_CampoAplicacion" value="<?= set_value('CampoAplicacion') ?>"  required>




    
        <label class="label-form" for="input_FechaSustentacion">Fecha de Sustentacion</label>
        <input type="date" name="FechaSustentacion" class="input-form" id="input_FechaSustentacion" value="<?= set_value('FechaSustentacion') ?>"  required >

        <label class="label-form" for="input_TesisFile">Archivo de la Tesis</label>
        <div class="">
            <span class="description-input"> Cargar el Archivo de las tesis con el siguiente formato: </span>
            <ul class="description-input">
                <li>Pg.1.  Caratula (sin numeración)</li>
                <li>Pg.2.  Acta de Sustentación y/o Defensa de la Tesis</li>
                <li>Pg.3.  Constancia Originalidad del Trabajo de Investigación (COTI)</li>
                <li>Pg.4.  Autorización de Publicación | descargue y rellene el formato que mas se acomode a su situacion (<a href="<?= base_url('docs/Formatos_Autorizacion_publicacion.pdf') ?>" target=_blank>Descargar Formatos</a>)</li>
                <li>Pg.5.  En adelante el contenido de la tesis desde la Dedicatoria hasta los Anexos, tal como lo señala su reglamento.</li>
            </ul>
            
        </div>
        <input type="file" name="TesisFile" class="form-control" id="input_TesisFile" accept=".pdf"  required>
    
    </div>

    <div class="border my-4 container-default">
        <span class="tarjet-cyan mb-3">Datos del Grado Academico a Optar</span>
        
        <label class="label-form" for="select_gradoTipo">Tipo de Grado</label>
        <select id="select_gradoTipo" name="gradoTipo" class="input-form" required>
            <option value="" disabled selected>Seleccione el grado</option>
            <option value="titulo profesional" <?= set_select('gradoTipo', 'titulo profesional')?>>Título Profesional</option> 
            <option value="segunda especialidad" <?= set_select('gradoTipo', 'segunda especialidad')?>>Segunda Especialidad</option> 
            <option value="maestria" <?= set_select('gradoTipo', 'maestria')?>>Maestría</option> 
            <option value="doctorado" <?= set_select('gradoTipo', 'doctorado')?>>Doctorado</option> 
        </select>
        
        <label class="label-form" for="input_gradoDescripcion">Descripción del Grado</label>
        <div class="">
            <div class="d-flex">
                <span class="description-input">Describa el Grado a Optar segun corresponda</span>
                <i class="fa fa-question-circle icon-help-question ms-3" aria-hidden="true"></i>
            </div>
            
            <ul class="description-input">
                Ejemplo:
                <li><strong>Titulo Profesion:</strong>  Licenciatura en ... , Ingenieria en ... , </li>
                <li><strong>Mestria:</strong>  Gestion Publica ,  </li>
                
          
            </ul>
            
        </div>
        <input type="text" name="gradoDescripcion" class="input-form" id="input_gradoDescripcion" value="<?= set_value('gradoDescripcion') ?>" required>
    </div>

    <div class="border my-4 container-default">
         <span class="tarjet-cyan mb-3">Datos del Asesor</span>

        <label class="label-form" for="input_AsesorNombres">Nombres y Apellidos</label>
        <input type="text" name="Asesor" class="input-form" id="input_AsesorNombres" value="<?= set_value('AsesorNombres') ?>" required>
        
        <label class="label-form" for="input_AsesorDNI">DNI</label>
        <input type="text" name="AsesorDNI" class="input-form" id="input_AsesorDNI" value="<?= set_value('AsesorDNI') ?>" required>

        <label class="label-form" for="input_AsesorORCID">ORCID</label>
        <input type="text" name="AsesorORCID" class="input-form" id="input_AsesorORCID" value="<?= set_value('AsesorORCID') ?>" required>

       
    </div>

    <div class="border my-4 container-default">

        <span class="tarjet-cyan mb-3">Datos del los Jurados</span>            

        <label class="label-form" for="input_PresidenteJuradoNombres">Nombres y Apellidos del Presidente</label>
        <input type="text" name="PresidenteJurado" class="input-form" id="input_PresidenteJuradoNombres" value="<?= set_value('PresidenteJurado') ?>" required>
   
        <label class="label-form" for="input_PrimerMiembroJuradoNombres">Nombres y Apellidos del Primer Miembro</label>
        <input type="text" name="PrimerMiembroJurado" class="input-form" id="input_PrimerMiembroJuradoNombres" value="<?= set_value('PrimerMiembroJurado') ?>" required>

        <label class="label-form" for="input_SegundoMiembroJuradoNombres">Nombres y Apellidos del Segundo Miembro</label>
        <input type="text" name="SegundoMiembroJurado" class="input-form" id="input_SegundoMiembroJuradoNombres" value="<?= set_value('SegundoMiembroJurado') ?>" required>           
    </div>

    <div class="border my-4 container-default">
        <span class="tarjet-cyan mb-3">Documentos del Tramite</span> 
        
        <label class="label-form" for="input_DeclaracionJuradaFile">Declaracion Jurada</label>
        <input type="file" name="DeclaracionJuradaFile" class="form-control" id="input_DeclaracionJuradaFile" required accept=".pdf">

        <label class="label-form" for="input_AutorizaciónPublicacioFile">Autorizacion de Publicación</label>
        <input type="file" name="AutorizaciónPublicacioFile" class="form-control" id="input_AutorizaciónPublicacioFile" required accept=".pdf">
    </div>

    <?php if(session()->getFlashdata('errors')!==null): ?>
        <div class= 'alert alert-danger my-3' role='alert'>
            <?= session()->getFlashdata('errors');?>
        </div>
    <?php endif; ?>

    <button type="submit" class="btn-style1 mt-2">
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
            nameInput.style = 'outline:none;border: 1px solid #dad9d9;border-radius: 5px;padding: 8px 10px;margin-right:10px;width:44%;';
            
            nameInput.className = ' autor-input-nombre';
            nameInput.placeholder = 'Nombre completo del autor';
            nameInput.required = true;

            nameInput.addEventListener('focus',()=>{nameInput.style.border='1px solid #3F81BB';});
            nameInput.addEventListener('blur',()=>{nameInput.style.border='1px solid #dad9d9';});

            const dniInput = document.createElement('input');
            dniInput.type = 'text';
            dniInput.name = `autores[${newIndex}][dni]`;
            dniInput.style= 'outline:none;border: 1px solid #dad9d9;border-radius: 5px;padding: 8px 10px; width:43%;'
            dniInput.className = 'autor-input-dni';
            dniInput.placeholder = 'DNI';
            dniInput.required = true;

            dniInput.addEventListener('focus',()=>{dniInput.style.border='1px solid #3F81BB';});
            dniInput.addEventListener('blur',()=>{dniInput.style.border='1px solid #dad9d9';});
            
            newAuthorGroup.appendChild(nameInput);
            newAuthorGroup.appendChild(dniInput);
            
            // Lógica para los botones de remover y agregar
            const removeButton = document.createElement('button');
            removeButton.className = 'btn-remove-autor';
            removeButton.type = 'button';
            removeButton.style='width:5%;margin-left:10px;font-size:20px;font-weight:bold;color:white; border-radius:7px;border:none; background-color:rgba(226, 64, 78, 1);';
            removeButton.textContent = '-';

            const addButton = document.createElement('button');
            addButton.className = ' btn-add-autor';
            addButton.type = 'button';
            addButton.style='width:5%;margin-left:10px;font-size:20px;font-weight:bold;color:white; border-radius:7px;border:none; background-color:rgba(106, 197, 132, 1);'
            addButton.textContent = '+';

            ////

            const mq = window.matchMedia("(max-width: 1200px)");
            
            function aplicarEstiloResponsive(e) {
                if (e.matches) {
                    nameInput.style = "outline:none;border: 1px solid #dad9d9;border-radius: 5px;padding: 8px 10px;margin-right:10px;width:35%;";
                    dniInput.style= 'outline:none;border: 1px solid #dad9d9;border-radius: 5px;padding: 8px 10px; width:35%;';
                    addButton.style='width:10%;margin-left:10px;font-size:20px;font-weight:bold;color:white; border-radius:7px;border:none; background-color:rgba(106, 197, 132, 1);';
                    removeButton.style='width:10%;margin-left:10px;font-size:20px;font-weight:bold;color:white; border-radius:7px;border:none; background-color:rgba(226, 64, 78, 1);';
                } else {
                    nameInput.style = "outline:none;border: 1px solid #dad9d9;border-radius: 5px;padding: 8px 10px;margin-right:10px;width:44%;";
                    dniInput.style= 'outline:none;border: 1px solid #dad9d9;border-radius: 5px;padding: 8px 10px; width:43%;';
                    addButton.style='width:5%;margin-left:10px;font-size:20px;font-weight:bold;color:white; border-radius:7px;border:none; background-color:rgba(106, 197, 132, 1);';
                    removeButton.style='width:5%;margin-left:10px;font-size:20px;font-weight:bold;color:white; border-radius:7px;border:none; background-color:rgba(226, 64, 78, 1);';
                }
            }

            // 1️⃣ Ejecutar cuando carga la página
            aplicarEstiloResponsive(mq);

            // 2️⃣ Mantenerlo escuchando en tiempo real (como un bucle)
            mq.addEventListener("change", aplicarEstiloResponsive);


            
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

        //Iframe para lineas de investigacion
        const btnShowIframeLineas = document.getElementById('btn-show-iframe-lineas');
        const btnCloseIframeLineas = document.getElementById('btn-close-iframe-lineas');
        const iframeContainerLineas = document.getElementById('iframe-container-lineas');

        btnShowIframeLineas.addEventListener('click',function(){
            iframeContainerLineas.classList.remove('d-none');
            this.style.display = 'none'; //oculta el boton mostrar
        });

        btnCloseIframeLineas.addEventListener('click',function(){
            iframeContainerLineas.classList.add('d-none');
            btnShowIframeLineas.style.display = 'block';
        });

        //iframe para campo investigacion
        const btnShowIframeCampoInvs = document.getElementById('btn-show-iframe-CampoInvestigacion');
        const btnCloseIframeCampoInvs = document.getElementById('btn-close-iframe-CampoInvestigacion');
        const iframeContainerCampoInvs = document.getElementById('iframe-container-CampoInvestigacion');

        
        btnShowIframeCampoInvs.addEventListener('click', function() {
            iframeContainerCampoInvs.classList.remove('d-none');
            this.style.display = 'none'; // Oculta el botón de mostrar
        });

        btnCloseIframeCampoInvs.addEventListener('click', function() {
            iframeContainerCampoInvs.classList.add('d-none');
            btnShowIframeCampoInvs.style.display = 'block'; // Muestra de nuevo el botón
        });

        //iframe para  campo de aplicacion
        const btnShowIframeCampoApli = document.getElementById('btn-show-iframe-CampoAplicacion');
        const btnCloseIframeCampoApli = document.getElementById('btn-close-iframe-CampoAplicacion');
        const iframeContainerCampoApli = document.getElementById('iframe-container-CampoAplicacion');

        btnShowIframeCampoApli.addEventListener('click',function(){
            iframeContainerCampoApli.classList.remove('d-none');
            this.style.display = 'none';
        });

        btnCloseIframeCampoApli.addEventListener('click',function(){
            iframeContainerCampoApli.classList.add('d-none');
            btnShowIframeCampoApli.style.display = 'block';
        });
    });
</script>

<?= $this->endSection();?>