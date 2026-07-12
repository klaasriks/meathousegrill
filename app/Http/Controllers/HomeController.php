<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        $menu = Menu::with(['menuCategory.menuItems'])->first();

        return Inertia('Index', compact('menu'));
    }
}
