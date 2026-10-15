<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource with search, filter, sorting, and pagination.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search: nama atau SKU
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter: Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'stock_asc' => $query->orderBy('stock', 'asc'),
            'stock_desc' => $query->orderBy('stock', 'desc'),
            default => $query->latest(),
        };

        // Pagination
        $products = $query->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.form', [
            'product' => new Product(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|max:50|unique:products,sku',
            'name' => 'required|string|max:150',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $product = Product::create($validated);

        if ($product->stock > 0 && $request->user()) {
            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => $request->user()->id,
                'type' => 'IN',
                'quantity' => $product->stock,
                'note' => 'Stok awal penambahan produk',
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category', 'movements.user');

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.form', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sku' => ['required', 'string', 'max:50', Rule::unique('products', 'sku')->ignore($product->id)],
            'name' => 'required|string|max:150',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $oldStock = $product->stock;
        $product->update($validated);

        $difference = $product->stock - $oldStock;
        if ($difference !== 0 && $request->user()) {
            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => $request->user()->id,
                'type' => $difference > 0 ? 'IN' : 'OUT',
                'quantity' => abs($difference),
                'note' => 'Penyesuaian stok saat update data produk',
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->movements()->exists()) {
            return back()->withErrors(['product' => 'Produk tidak dapat dihapus karena sudah memiliki riwayat transaksi/stok.']);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
