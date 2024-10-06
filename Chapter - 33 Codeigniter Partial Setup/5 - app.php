<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->renderSection('title') ?: 'Default Title' ?>
    </title>
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
