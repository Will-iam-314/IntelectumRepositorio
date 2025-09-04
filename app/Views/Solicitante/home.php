


<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>

<h1>CONTENT SOLICITANTE</h1>

<?= $this->endSection();?>

<?= $this->section('scripts');?>

<script>
    // Reemplaza la entrada actual, eliminando la anterior del historial
    window.onload = function() {
        history.replaceState(null, '', location.href);
    };
</script>

<?= $this->endSection();?>