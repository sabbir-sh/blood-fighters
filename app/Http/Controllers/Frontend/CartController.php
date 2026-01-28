<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('frontend.cart.index', compact('cart'));
    }

public function store(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $qty = max(1, (int)$request->qty);

    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['qty'] += $qty;
    } else {
        $cart[$id] = [
            'id'    => $product->id,
            'name'  => $product->name,
            'price' => $product->discount_price ?? $product->price,
            'qty'   => $qty,
            'image' => $product->thumbnail,
        ];
    }

    session()->put('cart', $cart);

    // ✅ Buy Now button → Checkout
    if ($request->action == 'buy_now') {
        return redirect()->route('checkout.index');
    }

    // ✅ Add to Cart button → Stay same page + Toast Message
    return redirect()->back()->with('success', '🛒 Product added to cart successfully!');
}



    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = max(1, (int)$request->qty);
            session()->put('cart', $cart);
        }
        return back();
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item removed');
    }
}
