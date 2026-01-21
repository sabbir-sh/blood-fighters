<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Add product to cart
    public function store(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $qty = $request->input('qty', 1); // default 1

        $cart = session()->get('cart', []);

        // যদি product আগেই cart এ থাকে
        if(isset($cart[$id])) {
            $cart[$id]['qty'] += $qty; 
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "qty" => $qty,
                "price" => $product->discount_price ?? $product->price,
                "image" => $product->thumbnail
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // Cart Page
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('frontend.cart.index', compact('cart'));
    }

    // Remove product from cart
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    // Update quantity
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            $qty = $request->input('qty', 1);
            $cart[$id]['qty'] = $qty;
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Cart updated!');
    }
}
