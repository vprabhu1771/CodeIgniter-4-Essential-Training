#

1. Project Setup

```
composer create-project codeigniter4/appstarter project-root
```

2. Rename `env` to `.env`

```
under project-root -> rename env to .env
```

3. Open `.env`

```
under project-root -> .env
```

4. `.env`

```
#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------

# CI_ENVIRONMENT = production
CI_ENVIRONMENT = development


--------------------------------------------------------------------
DATABASE
--------------------------------------------------------------------

database.default.hostname = localhost
database.default.database = ci4
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix =
```

5. **Generate the Migration File**  
Use the CodeIgniter CLI to create a migration file for the `users` table.

```
php spark make:migration create_users_table
```

6. **Edit the Migration File**  
Open the generated migration file located in `app/Database/Migrations/` and define the schema for the `users` table.

```php
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'first_name'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'last_name'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'password'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);

        $this->forge->addKey('user_id', true);
        
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
```

### Step 2: Run the Migration

Run the migration to create the `users` table in your database:

```bash
php spark migrate
```


### Step 3: PHP JWT Setup

1. **[Firebase php jwt](https://github.com/firebase/php-jwt)**  

2. **Install php-jwt**

```
cd app/ThridParty
```

```
mkdir Firebase
```

```
download Firebase/php-jwt.zip
```

```
extract Firebase/php-jwt.zip
```

```
copy to app/ThridParty/Firebase/php-jwt
```

```
rename folder app/ThridParty/Firebase/jwt
```

3. **Open `Autoload.php`**

```
under app -> Config -> Open Autoload.php
```

4. **`Autoload.php`**

```
<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

/**
 * -------------------------------------------------------------------
 * AUTOLOADER CONFIGURATION
 * -------------------------------------------------------------------
 *
 * This file defines the namespaces and class maps so the Autoloader
 * can find the files as needed.
 *
 * NOTE: If you use an identical key in $psr4 or $classmap, then
 * the values in this file will overwrite the framework's values.
 */
class Autoload extends AutoloadConfig
{
    /**
     * -------------------------------------------------------------------
     * Namespaces
     * -------------------------------------------------------------------
     * This maps the locations of any namespaces in your application to
     * their location on the file system. These are used by the autoloader
     * to locate files the first time they have been instantiated.
     *
     * The '/app' and '/system' directories are already mapped for you.
     * you may change the name of the 'App' namespace if you wish,
     * but this should be done prior to creating any namespaced classes,
     * else you will need to modify all of those classes for this to work.
     *
     * Prototype:
     *```
     *   $psr4 = [
     *       'CodeIgniter' => SYSTEMPATH,
     *       'App'	       => APPPATH
     *   ];
     *```
     *
     * @var array<string, string>
     */
    public $psr4 = [
        APP_NAMESPACE => APPPATH, // For custom app namespace
        'Config'      => APPPATH . 'Config',
        'Firebase'    => APPPATH . 'ThirdParty/Firebase',
    ];

    /**
     * -------------------------------------------------------------------
     * Class Map
     * -------------------------------------------------------------------
     * The class map provides a map of class names and their exact
     * location on the drive. Classes loaded in this manner will have
     * slightly faster performance because they will not have to be
     * searched for within one or more directories as they would if they
     * were being autoloaded through a namespace.
     *
     * Prototype:
     *```
     *   $classmap = [
     *       'MyClass'   => '/path/to/class/file.php'
     *   ];
     *```
     *
     * @var array<string, string>
     */
    public $classmap = [];

    /**
     * -------------------------------------------------------------------
     * Files
     * -------------------------------------------------------------------
     * The files array provides a list of paths to __non-class__ files
     * that will be autoloaded. This can be useful for bootstrap operations
     * or for loading functions.
     *
     * Prototype:
     * ```
     *	  $files = [
     *	 	   '/path/to/my/file.php',
     *    ];
     * ```
     *
     * @var array<int, string>
     */
    public $files = [];
}
```