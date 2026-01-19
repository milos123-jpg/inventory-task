<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // Prikaz svih proizvoda (Browse products)
    public function index()
    {
        $products = Product::all();
        return view('dashboard', compact('products'));
    }

    // Kupovina/Dodavanje u korpu vezano za ulogovanog korisnika
    public function buy($id)
    {
        // 1. Provera da li je korisnik ulogovan (Maxov zahtev)
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Must be logged in!');
        }

        $product = Product::findOrFail($id);
        $user = Auth::user();

        // 2. Logika za smanjenje zaliha
        if ($product->stock_quantity > 0) {
            $product->decrement('stock_quantity');

            // 3. Low Stock Notification (Maxov zahtev)
            if ($product->stock_quantity <= 5) {
                Log::warning("LOW STOCK: Product {$product->name} is down to {$product->stock_quantity}");
                // Ovde ćemo kasnije dodati onaj Job za slanje pravog mejla
            }

            return back()->with('success', "Product {$product->name} added to your account!");
        }

        return back()->with('error', 'Out of stock!');
    }
}