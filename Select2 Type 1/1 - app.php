<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->renderSection('title') ?: 'Default Title' ?>
    </title>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Own JS -->
    <script src="<?= base_url() ?>/main.js"></script>
</head>
<body>

    <!-- Include the Header partial -->
    <?= $this->include('frontend/layout/header') ?>

    <!-- Include the Topbar partial -->
    <?= $this->include('frontend/layout/topbar') ?>

    <!-- Content Section -->
    <?= $this->renderSection('content') ?>

    <!-- Include the Footer partial -->
    <?= $this->include('frontend/layout/footer') ?>

</body>
</html>
