<?php

// App/Http/Controllers/Frontend/CartController.php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() {
        $cart = session()->get('cart', []);
        return view('frontend.cart.index', compact('cart'));
    }

public function store(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        $cart[$id]['qty']++;
    } else {
        $cart[$id] = [
            "id" => $product->id,
            "name" => $product->name,
            "qty" => 1,
            "price" => $product->discount_price ?? $product->price,
            "image" => $product->thumbnail
        ];
    }
    session()->put('cart', $cart);

    // AJAX রিকোয়েস্ট হলে কার্ট কাউন্ট এবং ড্রপডাউনের HTML পাঠানো
    if($request->ajax()){
        $headerCartHtml = view('frontend.layouts.partials.mini_cart')->render(); // একটি সেপারেট ব্লেড ফাইল
        return response()->json([
            'status' => 'success',
            'cart_count' => count($cart),
            'header_cart_html' => $headerCartHtml,
            'message' => 'Product added to cart successfully!'
        ]);
    }

    return redirect()->back();
}
    public function update(Request $request, $id) {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = max(1, (int)$request->qty);
            session()->put('cart', $cart);
        }
        return response()->json(['status' => 'success']);
    }

    public function remove($id) {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Item removed');
    }
}