<?= $this->extend('frontend/layout/app') ?>

<?= $this->section('title') ?>
    Home Page
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Home page</h1>

    <form action="<?= base_url('submit-category') ?>" method="post">
        <div>
            <label for="category">Select Category:</label>
            <select id="category" name="category" class="category-select" style="width: 100%;">
                <option></option> <!-- Empty option for placeholder -->
                <option value="1">Category 1</option>
                <option value="2">Category 2</option>
                <option value="3">Category 3</option>
                <option value="4">Category 4</option>
            </select>
        </div>

        <button type="submit">Submit</button>
    </form>
    
<?= $this->endSection() ?>
