<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menu = Menu::with(['menuCategory.menuItems'])->first();

        return Inertia('order/Index', compact('menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function checkout(Request $request)
    {
        return Inertia('order/Checkout', []);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function cart(Request $request)
    {
        return Inertia('order/Cart', []);
    }
}
