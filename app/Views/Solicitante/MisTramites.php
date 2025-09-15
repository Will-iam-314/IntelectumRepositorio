<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>

<h1>MIS TRAMITES</h1>
<a href="<?= base_url('solicitante/solicitud'); ?>">Solicitar Constancia URL</a>

<?php foreach($tramites as $tramite): ?>
    <?= $tramite['codigo_tramite']?> 
<?php endforeach ?>

<?= $this->endSection();?>

