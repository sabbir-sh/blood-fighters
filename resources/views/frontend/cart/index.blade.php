{{-- resources/views/frontend/cart/index.blade.php --}}
@extends('frontend.layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center space-x-4 mb-10">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Shopping Bag</h2>
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-gray-900 text-white shadow-sm">
                {{ count($cart) }} Items
            </span>
        </div>
        
        @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- Product List Section --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[600px]">
                            <thead class="bg-gray-50/80 border-b border-gray-100">
                                <tr>
                                    <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Product Details</th>
                                    <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center">Quantity</th>
                                    <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @php $grandTotal = 0; @endphp
                                @foreach($cart as $item)
                                @php $grandTotal += ($item['price'] * $item['qty']); @endphp
                                <tr class="group hover:bg-gray-50/50 transition-colors">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-6">
                                            <div class="relative h-24 w-24 flex-shrink-0 overflow-hidden rounded-2xl border border-gray-100 bg-gray-50">
                                                <img src="{{ asset('storage/' . $item['image']) }}" class="h-full w-full object-cover">
                                            </div>
                                            <div class="flex flex-col">
                                                <h6 class="text-base font-bold text-gray-900 mb-1 group-hover:text-red-600 transition-colors">{{ $item['name'] }}</h6>
                                                <p class="text-xs font-medium text-gray-400 mb-3">Unit: ৳{{ number_format($item['price']) }}</p>
                                                <a href="{{ route('cart.remove', $item['id']) }}" class="inline-flex items-center text-xs font-bold text-red-500 hover:text-red-700 transition-colors">
                                                    <i class="fas fa-trash-alt mr-1.5"></i> Remove
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex items-center justify-center">
                                            <input type="number" 
                                                   class="w-16 h-11 text-center font-bold text-gray-800 bg-gray-50 border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all outline-none" 
                                                   value="{{ $item['qty'] }}" 
                                                   min="1"
                                                   onchange="updateCart({{ $item['id'] }}, this.value)">
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-end">
                                        <span class="text-lg font-black text-gray-900 tracking-tight">৳{{ number_format($item['price'] * $item['qty']) }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="pt-4">
                    <a href="{{ route('product.front.index') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-gray-900 transition-all group">
                        <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i> Continue Shopping
                    </a>
                </div>
            </div>
            
            {{-- Summary Sidebar --}}
            <div class="lg:col-span-4">
                <div class="sticky top-10 bg-white rounded-[32px] p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
                    <h5 class="text-xl font-extrabold text-gray-900 mb-8">Order Summary</h5>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between items-center text-sm font-medium">
                            <span class="text-gray-400">Bag Subtotal</span>
                            <span class="text-gray-900 font-bold text-base">৳{{ number_format($grandTotal) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center text-sm font-medium">
                            <span class="text-gray-400">Shipping</span>
                            <span class="text-emerald-500 font-bold bg-emerald-50 px-3 py-1 rounded-lg text-[10px] uppercase tracking-wider">Free or Calculated</span>
                        </div>

                        <div class="pt-6 border-t border-dashed border-gray-200">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl group cursor-pointer border border-transparent hover:border-gray-200 transition-all">
                                <span class="text-xs font-bold text-gray-500">HAVE A COUPON?</span>
                                <i class="fas fa-plus text-gray-400 text-xs group-hover:rotate-90 transition-transform"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-10">
                        <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Total Payable</span>
                        <span class="text-3xl font-black text-gray-900">৳{{ number_format($grandTotal) }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" 
                       class="flex items-center justify-center w-full py-5 bg-gray-900 hover:bg-black text-white text-sm font-bold rounded-2xl shadow-lg shadow-gray-300 transform active:scale-[0.98] transition-all">
                       PROCEED TO CHECKOUT
                    </a>

                    <div class="mt-8 flex justify-center items-center space-x-4 opacity-30 grayscale hover:grayscale-0 transition-all">
                        <i class="fab fa-cc-visa text-2xl"></i>
                        <i class="fab fa-cc-mastercard text-2xl"></i>
                        <i class="fab fa-cc-apple-pay text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="max-w-md mx-auto text-center py-20 bg-white rounded-[40px] shadow-sm border border-gray-50 mt-10">
            <div class="relative w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                <i class="fas fa-shopping-bag text-gray-200 text-3xl"></i>
            </div>
            <h3 class="text-2xl font-black text-gray-900 mb-2">Your bag is empty</h3>
            <p class="text-gray-400 text-sm mb-8 px-8">Look like you haven't made your choice yet. Let's find something special for you!</p>
            <a href="{{ route('product.front.index') }}" class="inline-flex px-10 py-4 bg-gray-900 text-white font-bold rounded-2xl hover:shadow-xl hover:-translate-y-1 transition-all">
                Shop Now
            </a>
        </div>
        @endif
    </div>
</div>

<script>
    function updateCart(id, qty) {
        if(qty < 1) return;
        fetch(`/cart/update/${id}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            body: JSON.stringify({ qty: qty })
        }).then(() => location.reload());
    }
</script>
@endsection