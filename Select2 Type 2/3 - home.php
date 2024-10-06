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
                
                <?php foreach ($categories as $row): ?>
                    <option value="<?= esc($row['id']) ?>"><?= esc($row['name']) ?></option>
                <?php endforeach; ?>
                
            </select>
        </div>

        <button type="submit">Submit</button>
    </form>
    
<?= $this->endSection() ?>
