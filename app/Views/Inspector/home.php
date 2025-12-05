
<?= $this->extend('layouts/InspectorTemplate.php'); ?>

<?= $this->section('content');?>


<div class="mt-4">
    <h2>¡Bienvenido Inspector <?php echo(session('nombres').' '.session('apellidos')) ?>!</h2>
</div>



<?= $this->endSection();?>

<?= $this->section('scripts');?>



<?= $this->endSection();?>