<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>



<div class="d-flex justify-content-between mb-4">
    <div class="d-flex align-items-center">
        <img class="me-1" width=30 height=30 src="<?=base_url('assets/icons/documento-azul.png')?>" alt="home">
        <span class="title-modules">Mis Trámites</span>
    </div>
    

    <div class="d-flex align-items-center btn-solicitar-inhome ">
      <a href="<?= base_url('solicitante/solicitud'); ?>"><img style="margin-top:-3px;" width=21 src="<?= base_url('assets/icons/mas-white.png') ?>" alt=""> Nueva Solicitud</a>
    </div>
    
</div>

  <!-- Barra de búsqueda -->
  <input type="text" id="search" class="form-control mb-3" placeholder="Buscar por título o código...">

  <!-- Filtros -->
  <div class="row mb-4">
    <!-- Fecha inicio -->
    <div class="col-md-3">
      <label for="fechaInicio" class="form-label">Fecha desde</label>
      <input type="date" id="fechaInicio" class="form-control">
    </div>
    <!-- Fecha fin -->
    <div class="col-md-3">
      <label for="fechaFin" class="form-label">Fecha hasta</label>
      <input type="date" id="fechaFin" class="form-control">
    </div>
    <!-- Estado -->
    <div class="col-md-3">
      <label for="estadoFiltro" class="form-label">Estado</label>
      <select id="estadoFiltro" class="form-select">
        <option value="">Todos</option>
        <?php 
        if (!empty($tramites)) {
          $estados = array_unique(array_column($tramites, 'estado'));
          foreach($estados as $estado): ?>
            <option value="<?= esc($estado) ?>"><?= esc($estado) ?></option>
          <?php endforeach; 
        }
        ?>
      </select>
    </div>
    <!-- Tipo de materia -->
    <div class="col-md-3">
      <label for="tipoFiltro" class="form-label">Tipo de Materia</label>
      <select id="tipoFiltro" class="form-select">
        <option value="">Todos</option>
        <?php 
        if (!empty($tramites)) {
          $tipos = array_unique(array_column($tramites, 'tipomateria'));
          foreach($tipos as $tipo): ?>
            <option value="<?= esc($tipo) ?>"><?= esc($tipo) ?></option>
          <?php endforeach; 
        }
        ?>
      </select>
    </div>
  </div>

  <!-- Contenedor de tarjetas -->
  <div id="tramitesContainer">
    <?php if (!empty($tramites)): ?>
      <?php foreach($tramites as $t): ?>
        <div class="tramite-card mb-3" 
             data-titulo="<?= strtolower($t['titulo']) ?>" 
             data-codigo="<?= strtolower($t['codigo']) ?>"
             data-fecha="<?= $t['fechapresentacion'] ?>"
             data-estado="<?= strtolower($t['estado']) ?>"
             data-tipo="<?= strtolower($t['tipomateria']) ?>">

          <div class="card p-3 w-100 card-clickable" onclick="window.location.href='<?= site_url('solicitante/detalleTramite/'.$t['codigo']) ?>'">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="card-title mb-1"><?= esc($t['titulo']) ?></h5>
                <p class="mb-0"><strong>Código:</strong> <?= esc($t['codigo']) ?></p>
                <p class="mb-0"><strong>Tipo:</strong> <?= esc($t['tipomateria']) ?></p>
                <p class="mb-0"><strong>Fecha:</strong> <?= date('d/m/Y', strtotime($t['fechapresentacion'])) ?></p>
              </div>
              <span class="badge bg-primary"><?= esc($t['estado']) ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    <?php else: ?>

      <div class="container-default mt-4">
        <div class="msg-nothing">
            <img class="mb-3" src="<?= base_url('assets/icons/box-empty-gray.png') ?>" alt="">
            <span class="d-block" >Sin trámites por el momento.</span>
        </div>
      </div>

    <?php endif; ?>

  </div>

  <!-- Paginación -->
  <div class="mt-4 d-flex justify-content-center">
    <nav>
      <ul class="pagination" id="pagination"></ul>
    </nav>
  </div>

<?= $this->endSection();?>

<?= $this->section('scripts');?>
<script>
  const searchInput = document.getElementById("search");
  const fechaInicio = document.getElementById("fechaInicio");
  const fechaFin = document.getElementById("fechaFin");
  const estadoFiltro = document.getElementById("estadoFiltro");
  const tipoFiltro = document.getElementById("tipoFiltro");
  const cards = document.querySelectorAll(".tramite-card");
  const itemsPerPage = 5;
  let currentPage = 1;

  function filtrar() {
    const q = searchInput.value.toLowerCase();
    const fInicio = fechaInicio.value ? new Date(fechaInicio.value) : null;
    const fFin = fechaFin.value ? new Date(fechaFin.value) : null;
    const estado = estadoFiltro.value.toLowerCase();
    const tipo = tipoFiltro.value.toLowerCase();

    let visibles = [];

    cards.forEach(card => {
      const titulo = card.dataset.titulo;
      const codigo = card.dataset.codigo;
      const fechaCard = new Date(card.dataset.fecha);
      const estadoCard = card.dataset.estado;
      const tipoCard = card.dataset.tipo;

      let visible = true;

      if (q && !(titulo.includes(q) || codigo.includes(q))) visible = false;
      if (fInicio && fechaCard.setHours(0,0,0,0) < fInicio.setHours(0,0,0,0)) visible = false;
      if (fFin && fechaCard.setHours(0,0,0,0) > fFin.setHours(23,59,59,999)) visible = false;
      if (estado && estado !== estadoCard) visible = false;
      if (tipo && tipo !== tipoCard) visible = false;

      card.style.display = visible ? "block" : "none";
      if (visible) visibles.push(card);
    });

    paginar(visibles);
  }

  function paginar(cardsVisibles) {
    const totalPages = Math.ceil(cardsVisibles.length / itemsPerPage);
    currentPage = Math.min(currentPage, totalPages) || 1;

    cards.forEach(card => card.style.display = "none");

    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    for (let i = start; i < end && i < cardsVisibles.length; i++) {
      cardsVisibles[i].style.display = "block";
    }

    // Render paginación
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = "";

    for (let i = 1; i <= totalPages; i++) {
      const li = document.createElement("li");
      li.className = "page-item" + (i === currentPage ? " active" : "");
      li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
      li.addEventListener("click", e => {
        e.preventDefault();
        currentPage = i;
        filtrar();
      });
      pagination.appendChild(li);
    }
  }

  // Eventos de filtros
  searchInput.addEventListener("keyup", filtrar);
  fechaInicio.addEventListener("change", filtrar);
  fechaFin.addEventListener("change", filtrar);
  estadoFiltro.addEventListener("change", filtrar);
  tipoFiltro.addEventListener("change", filtrar);

  // Inicializar
  filtrar();
</script>
<?= $this->endSection();?>

