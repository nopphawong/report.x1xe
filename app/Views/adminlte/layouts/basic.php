<?= $this->extend("adminlte/layouts/document") ?>

<?= $this->section("content") ?>

    <?= $this->include("adminlte/layouts/_topbar") ?>

    <?= $this->include("adminlte/layouts/_sidebar") ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?= $this->renderSection('content') ?>
    </div>

    <?= $this->include("adminlte/layouts/_footer") ?>

<?= $this->endSection() ?>