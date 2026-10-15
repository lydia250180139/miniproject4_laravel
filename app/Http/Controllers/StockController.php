<?php
namespace App\Http\Controllers;
use App\Models\Product; use App\Models\StockMovement; use Illuminate\Http\Request; use Illuminate\Support\Facades\DB; use Illuminate\Validation\ValidationException;
class StockController extends Controller {
 public function index(){$movements=StockMovement::with('product','user')->latest()->paginate(12);return view('stock.index',compact('movements'));}
 public function create(){$products=Product::orderBy('name')->get();return view('stock.form',compact('products'));}
 public function store(Request $r){$d=$r->validate(['product_id'=>'required|exists:products,id','type'=>'required|in:IN,OUT','quantity'=>'required|integer|min:1','note'=>'nullable|string|max:500']);DB::transaction(function()use($d,$r){$p=Product::whereKey($d['product_id'])->lockForUpdate()->firstOrFail();if($d['type']==='OUT'&&$p->stock<$d['quantity'])throw ValidationException::withMessages(['quantity'=>'Stok tidak cukup. Stok tersedia: '.$p->stock]);$p->stock += $d['type']==='IN'?$d['quantity']:-$d['quantity'];$p->save();StockMovement::create($d+['user_id'=>$r->user()->id]);});return redirect()->route('stock.index')->with('success','Transaksi stok disimpan.');}
}
