<?= $this->extend('frontend/layout/app') ?>

<?= $this->section('title') ?>

Forget Password

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">

    <h1>Welcome To Forget Password Page</h1>

    <form id="forgotPasswordForm" onsubmit="return validateForm()">

        <div class="input-group">

            <label for="email">Email Address</label>

            <input type="email" id="email" name="email" required>

        </div>

        <button type="submit" class="btn">Submit</button>

        <div id="error-message" class="error-message"></div>

    </form>

</div>

<?= $this->endSection() ?>