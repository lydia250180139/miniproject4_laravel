<?php
namespace App\Http\Controllers;
use App\Models\Product; use App\Models\Category; use App\Models\Supplier; use App\Models\StockMovement;
class DashboardController extends Controller {
 public function index(){return view('dashboard',['products'=>Product::count(),'categories'=>Category::count(),'suppliers'=>Supplier::count(),'low'=>Product::whereColumn('stock','<=','minimum_stock')->count(),'recent'=>StockMovement::with('product','user')->latest()->take(5)->get()]);}
}
