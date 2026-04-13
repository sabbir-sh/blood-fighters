<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        return view('frontend.checkout.index', compact('cart'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'phone'   => 'required',
            'address' => 'required',
        ]);

        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty');
        }

        // Database transaction start korle bhalo hoy
        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['qty'];
            }

            // Order Save
            $order = Order::create([
                'name'    => $request->name,
                'phone'   => $request->phone,
                'address' => $request->address,
                'total'   => $total,
                'status'  => 'pending',
            ]);

            // Order Items Save
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['id'],
                    'product_name' => $item['name'],
                    'price'        => $item['price'],
                    'qty'          => $item['qty'],
                    'subtotal'     => $item['price'] * $item['qty'],
                ]);
            }

            DB::commit();

            // Cart clean kora
            session()->forget('cart');

            // ✅ Success URL-e niye jaoa (Order ID shoho jate confirm kora jay)
            return redirect()->route('checkout.success', $order->id)
                            ->with('order_complete', 'ধন্যবাদ! আপনার অর্ডারটি সফলভাবে সম্পন্ন হয়েছে।');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function success($id)
    {
        $order = Order::findOrFail($id);
        return view('frontend.checkout.success', compact('order'));
    }
}
