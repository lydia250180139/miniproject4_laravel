<?php
namespace App\Http\Controllers;
use App\Models\Supplier; use Illuminate\Http\Request;
class SupplierController extends Controller {
 public function index(){$suppliers=Supplier::orderBy('name')->paginate(10);return view('suppliers.index',compact('suppliers'));}
 public function create(){return view('suppliers.form',['supplier'=>new Supplier]);}
 public function store(Request $r){$d=$r->validate(['name'=>'required|string|max:120','phone'=>'nullable|string|max:30','email'=>'nullable|email|max:120','address'=>'nullable|string|max:500']);Supplier::create($d);return redirect()->route('suppliers.index')->with('success','Supplier ditambahkan.');}
 public function edit(Supplier $supplier){return view('suppliers.form',compact('supplier'));}
 public function update(Request $r,Supplier $supplier){$d=$r->validate(['name'=>'required|string|max:120','phone'=>'nullable|string|max:30','email'=>'nullable|email|max:120','address'=>'nullable|string|max:500']);$supplier->update($d);return redirect()->route('suppliers.index')->with('success','Supplier diperbarui.');}
 public function destroy(Supplier $supplier){$supplier->delete();return back()->with('success','Supplier dihapus.');}
}
