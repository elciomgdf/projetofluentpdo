<?php

namespace App\Controllers\Web;

class IndexController extends Controller
{

    /**
     * Página de Login
     * @return void
     */
    public function index(): void
    {
        $this->view('index');
    }

    /**
     * Dashboard
     * @return void
     */
    public function dashboard(): void
    {
        $this->view('dashboard');
    }

}