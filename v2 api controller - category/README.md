1. **Generate the Migration File**  
   Use the CodeIgniter CLI to create a migration file for the `categories` table.

   ```bash
   php spark make:migration create_categories_table
   ```

2. **Edit the Migration File**  
   Open the generated migration file located in `app/Database/Migrations/` and define the schema for the `categories` table.

   ```php
   <?php

   namespace App\Database\Migrations;

   use CodeIgniter\Database\Migration;

   class CreateCategoriesTable extends Migration
   {
       public function up()
       {
           $this->forge->addField([
               'id'          => [
                   'type'           => 'INT',
                   'unsigned'       => true,
                   'auto_increment' => true,
               ],
               'name'        => [
                   'type'       => 'VARCHAR',
                   'constraint' => '255',
               ],
               'description' => [
                   'type'       => 'TEXT',
                   'null'       => true,
               ],
               'created_at'  => [
                   'type' => 'DATETIME',
                   'null' => true,
               ],
               'updated_at'  => [
                   'type' => 'DATETIME',
                   'null' => true,
               ],
           ]);
           $this->forge->addKey('id', true);
           $this->forge->createTable('categories');
       }

       public function down()
       {
           $this->forge->dropTable('categories');
       }
   }
   ```

### Step 2: Run the Migration

Run the migration to create the `categories` table in your database:

```bash
php spark migrate
```

```
php spark make:model Category
```

`Category.php`

```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class Category extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description', 'created_at', 'updated_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
```

```
php spark make:seeder CategorySeeder
```

`CategorySeeder.php`

```php
<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Electronics',
                'description' => 'Devices, gadgets, and accessories',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Furniture',
                'description' => 'Tables, chairs, and home furniture',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Books',
                'description' => 'Fiction, non-fiction, and educational books',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Clothing',
                'description' => 'Apparel and accessories for men and women',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Sports',
                'description' => 'Sports equipment and accessories',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert the data into the 'categories' table
        $this->db->table('categories')->insertBatch($data);
    }
}
```

Seed Data

```
php spark db:seed
```

Generate Controller

```
php spark make:controller api/v2/CategoryController
```

To create an API that returns all categories, you can modify the `index()` method in your `CategoryController` to fetch all records from the `categories` table and return them in a JSON response. Using `ResponseTrait` will simplify the process of returning API responses.

Here’s an implementation of the `index()` method that returns all categories:

```php
<?php

namespace App\Controllers\Api\V2;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use CodeIgniter\API\ResponseTrait;

use App\Models\Category;

class CategoryController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $categoryModel = new Category();

        // Fetch all categories
        $categories = $categoryModel->findAll();

        // Return response with categories
        return $this->respond([
            'status' => ResponseInterface::HTTP_OK,
            'message' => 'Categories retrieved successfully',
            'data' => $categories
        ], ResponseInterface::HTTP_OK);
    }
}
```

In CodeIgniter, to create an API group for versioning (like `v2`), you can define a route group in the `app/Config/Routes.php` file. Here’s how you can create a group for your `Api\V2` controllers.

### Example of API Route Group for Version 2 (`v2`):

1. Open `app/Config/Routes.php`.
2. Add the following group definition for `v2` under the existing routes.

```php
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


// API V1
$routes->group('api/v1', ['namespace' => 'App\Controllers\Api\V1'], function($routes) {
    
});


// API V2
$routes->group('api/v2', ['namespace' => 'App\Controllers\Api\V2'], function($routes) {
    // Define a route for the CategoryController index method
    $routes->get('categories', 'CategoryController::index');    
});

```

### Explanation:
- **`group('api/v2')`**: This groups all the API routes under `/api/v2`.
- **`namespace`**: Specifies the namespace for the controllers inside this group. In this case, it's `App\Controllers\Api\V2`, which is where your `CategoryController` is located.
- **`get('categories', 'CategoryController::index')`**: This defines a route for `GET /api/v2/categories`, which will call the `index()` method in the `CategoryController`.

### Result:
When you access the URL `/api/v2/categories`, it will trigger the `index()` method of `CategoryController` and return the list of categories.

This makes it easy to version your API, and you can later add other routes in the same group for different controllers.

### Explanation:
1. **Model Usage**: The `Category` model is used to fetch all records from the `categories` table.
2. **findAll() Method**: `findAll()` is a built-in method provided by CodeIgniter’s Model to retrieve all rows from the database.
3. **ResponseTrait**: The `ResponseTrait` provides convenient methods like `respond()` to send structured JSON responses.
4. **HTTP Response**: The response includes a status code (200 for OK), a message, and the list of categories.

### Sample Response:
```json
{
    "status": 200,
    "message": "Categories retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Electronics",
            "description": "Devices, gadgets, and accessories",
            "created_at": "2024-10-01 12:00:00",
            "updated_at": "2024-10-01 12:00:00"
        },
        {
            "id": 2,
            "name": "Furniture",
            "description": "Tables, chairs, and home furniture",
            "created_at": "2024-10-01 12:00:00",
            "updated_at": "2024-10-01 12:00:00"
        }
    ]
}
```

This will return the data in JSON format with a structured response, making it easy to handle in any frontend or client.