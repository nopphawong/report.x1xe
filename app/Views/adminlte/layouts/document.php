<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <?= link_tag("assets/dist/plugins/fontawesome-free/css/all.min.css") ?>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <?= link_tag("https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css") ?>

    <?= link_tag("assets/dist/css/adminlte.min.css") ?>
    <?= link_tag("assets/dist/vendors/fonts/boxicons.css") ?>

    <?php foreach ($includes_css as $css) : ?>
        <?= link_tag($css) ?>
    <?php endforeach ?>

    <!-- jQuery -->
    <?= script_tag("assets/dist/plugins/jquery/jquery.min.js") ?>
    <!-- Bootstrap 4 -->
    <?= script_tag("assets/dist/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>
    <!-- AdminLTE App -->
    <?= script_tag("assets/dist/js/adminlte.js") ?>

    <?= script_tag("https://cdn.jsdelivr.net/npm/sweetalert2@11") ?>
    <?= script_tag("https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js") ?>

    <?php foreach ($includes_js as $js) : ?>
        <?= script_tag($js) ?>
    <?php endforeach ?>

    <script src="https://unpkg.com/vue@3.4.21/dist/vue.global.prod.js"></script>

    <!-- Include Lodash from a CDN -->
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>

    <?php foreach ($vuejs as $js) : ?>
        <?= script_tag($js) ?>
    <?php endforeach ?>
</head>

<body>
    <div class="wrapper">

        <?= $this->renderSection('content') ?>

    </div>
</body>

</html>