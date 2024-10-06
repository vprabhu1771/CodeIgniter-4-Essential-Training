<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Category;

class HomeController extends BaseController
{
    public function index()
    {        
        $categoryModel = new Category();

        // Fetch all categories
        $categories = $categoryModel->findAll();

        $data = [
            'categories' => $categories
        ];        
        
        return view('frontend/home', $data);
    }
}
