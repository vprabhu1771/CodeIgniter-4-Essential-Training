# Chapter - 15 Create Migration and Model using Single Command

In CodeIgniter 4, there isn't a built-in command to create both a migration and a model in a single command like in Laravel's Artisan. However, you can create a custom shell command that handles both operations. Below are the steps to create a migration and a model in a more streamlined way.

### Step 1: Create the Migration

Run the following command to create a migration file:

```bash
php spark make:migration CreateDepartmentsTable
```

### Step 2: Create the Model

Run the following command to create a model file:

```bash
php spark make:model Department
```

### Step 3: Automate with a Custom Shell Command (Optional)

If you want to create a single command that does both, you can create a custom shell command in CodeIgniter 4. Here’s how to do it:

1. **Create a Custom Command:**
   Create a new file in `app/Commands`, for example, `CreateMigrationAndModel.php`.

   ```php
   <?php

   namespace App\Commands;

   use CodeIgniter\CLI\BaseCommand;
   use CodeIgniter\CLI\CLI;

   class CreateMigrationAndModel extends BaseCommand
   {
       protected $group       = 'Custom';
       protected $name        = 'make:migration-model';
       protected $description = 'Create a migration and model for a specified table';

       public function run(array $params)
       {
           if (count($params) < 1) {
               CLI::error('Please specify a name for the migration and model.');
               return;
           }

           $name = ucfirst($params[0]);
           $migrationName = "Create" . $name . "Table";
           $modelName = $name;

           // Create Migration
           $migrationCommand = "php spark make:migration $migrationName";
           shell_exec($migrationCommand);
           CLI::write("Migration created: $migrationName");

           // Create Model
           $modelCommand = "php spark make:model $modelName";
           shell_exec($modelCommand);
           CLI::write("Model created: $modelName");
       }
   }
   ```

2. **Register the Command:**
   Open `app/Config/Commands.php` and register the new command:

   ```php
   public $commands = [
       // Other commands
       'make:migration-model' => 'App\Commands\CreateMigrationAndModel',
   ];
   ```

3. **Run Your Custom Command:**
   You can now create both a migration and a model by running:

   ```bash
   php spark make:migration-model Department
   ```

This command will create both a migration file named `CreateDepartmentsTable.php` and a model file named `Department.php`.

### Summary

While CodeIgniter 4 does not have a built-in command to create a migration and a model simultaneously, creating a custom command is a viable option for streamlining the process. This way, you can easily manage your migrations and models together with a single command.