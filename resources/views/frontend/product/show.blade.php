@extends('frontend.layouts.app')

@section('content')
<div class="bg-white min-h-screen py-6">
    <div class="container mx-auto px-4 max-w-6xl">
        
        {{-- Breadcrumb --}}
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-gray-400 font-medium tracking-wide">
                <li><a href="/" class="hover:text-gray-900 transition-colors">Home</a></li>
                <li><span>/</span></li>
                <li><a href="{{ route('product.front.index') }}" class="hover:text-gray-900 transition-colors">Shop</a></li>
                <li><span>/</span></li>
                <li class="text-gray-900 font-bold truncate max-w-[150px] md:max-w-none">
                    {{ Str::limit($product->name, 25) }}
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- Left: Image Gallery --}}
            <div class="lg:col-span-6">
                <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm p-4 ring-1 ring-gray-50">
                    <div class="relative aspect-square flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                             id="mainImage"
                             class="w-full h-full object-contain transition-transform duration-500 hover:scale-105" 
                             alt="{{ $product->name }}">
                    </div>
                </div>
                
                @if($product->images)
                <div class="flex gap-3 mt-5 overflow-x-auto pb-2 scrollbar-hide">
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                         class="thumb-item w-16 h-16 md:w-20 md:h-20 rounded-xl cursor-pointer border-2 border-red-500 object-cover flex-shrink-0 transition-all"
                         onclick="updateGallery(this, this.src)">
                    @foreach($product->images as $img)
                        <img src="{{ asset('storage/' . $img) }}" 
                             class="thumb-item w-16 h-16 md:w-20 md:h-20 rounded-xl cursor-pointer border-2 border-gray-100 object-cover flex-shrink-0 transition-all hover:border-red-200"
                             onclick="updateGallery(this, this.src)">
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Right: Product Details --}}
            <div class="lg:col-span-6">
                <div class="space-y-6">
                    <div>
                        <span class="inline-block px-3 py-1 bg-gray-900 text-white text-[10px] font-black uppercase rounded-md tracking-widest mb-4">
                            Premium Quality
                        </span>
                        <h1 class="text-2xl md:text-3xl font-black text-gray-900 leading-tight">
                            {{ $product->name }}
                        </h1>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="flex text-amber-400 text-sm">
                            @for($i=1; $i<=5; $i++) <i class="fas fa-star"></i> @endfor
                            <span class="text-gray-400 ml-2 font-bold">(4.8)</span>
                        </div>
                        <div class="h-4 w-[1px] bg-gray-200"></div>
                        <span class="text-sm font-bold {{ $product->stock > 0 ? 'text-emerald-500' : 'text-red-500' }}">
                            {{ $product->stock > 0 ? 'Available in Stock' : 'Out of Stock' }}
                        </span>
                    </div>

                    <div class="py-2 border-y border-gray-50">
                        @if($product->discount_price)
                            <div class="flex items-baseline gap-3">
                                <span class="text-3xl font-black text-red-600">৳{{ number_format($product->discount_price) }}</span>
                                <span class="text-lg text-gray-300 line-through font-medium">৳{{ number_format($product->price) }}</span>
                            </div>
                            <div class="text-red-500 text-xs font-bold mt-1 uppercase tracking-tighter">
                                Save ৳{{ number_format($product->price - $product->discount_price) }} today
                            </div>
                        @else
                            <span class="text-3xl font-black text-gray-900">৳{{ number_format($product->price) }}</span>
                        @endif
                    </div>

                    <div class="text-gray-500 text-sm leading-relaxed">
                        <div class="font-black text-gray-900 mb-2 uppercase text-xs tracking-widest">Quick Description</div>
                        {{ $product->short_description ?? 'Experience the perfect balance of comfort and style with our ' . $product->name }}
                    </div>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-8 pt-4">
                        @csrf
                        
                        {{-- Quantity Selector --}}
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Select Quantity</label>
                            <div class="flex items-center bg-gray-50 border border-gray-100 rounded-xl w-fit p-1">
                                <button type="button" onclick="updateQty(-1)" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-red-600 font-bold text-xl transition-colors">-</button>
                                <input type="number" name="qty" id="product-qty" value="1" min="1" readonly 
                                       class="w-12 bg-transparent text-center font-black text-gray-900 border-none focus:ring-0">
                                <button type="button" onclick="updateQty(1)" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-red-600 font-bold text-xl transition-colors">+</button>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <button type="submit" name="action" value="add_to_cart" 
                                    class="h-14 rounded-2xl font-black text-sm tracking-widest border-2 border-gray-900 bg-transparent hover:bg-gray-900 hover:text-white transition-all duration-300">
                                <i class="fas fa-shopping-cart mr-2"></i> ADD TO CART
                            </button>
                            <button type="submit" name="action" value="buy_now" 
                                    class="h-14 rounded-2xl font-black text-sm tracking-widest bg-red-600 text-white hover:bg-red-700 shadow-xl shadow-red-100 transition-all duration-300">
                                <i class="fas fa-bolt mr-2"></i> ORDER NOW
                            </button>
                        </div>
                    </form>

                    {{-- Trust Features --}}
                    <div class="grid grid-cols-2 gap-6 pt-8 border-t border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center text-red-500">
                                <i class="fas fa-truck text-sm"></i>
                            </div>
                            <div>
                                <div class="text-[11px] font-black text-gray-900 uppercase">Free Shipping</div>
                                <div class="text-[10px] text-gray-400 font-bold italic">Over ৳5000</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-500">
                                <i class="fas fa-undo text-sm"></i>
                            </div>
                            <div>
                                <div class="text-[11px] font-black text-gray-900 uppercase">Easy Returns</div>
                                <div class="text-[10px] text-gray-400 font-bold italic">7 Days Policy</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateGallery(element, src) {
        const mainImg = document.getElementById('mainImage');
        mainImg.style.opacity = '0.5';
        
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = '1';
        }, 150);

        document.querySelectorAll('.thumb-item').forEach(img => {
            img.classList.remove('border-red-500');
            img.classList.add('border-gray-100');
        });

        element.classList.remove('border-gray-100');
        element.classList.add('border-red-500');
    }

    function updateQty(val) {
        const input = document.getElementById('product-qty');
        let newVal = parseInt(input.value) + val;
        // স্টক লিমিট চেক (যদি থাকে)
        const maxStock = {{ $product->stock }};
        if(newVal < 1) newVal = 1;
        if(newVal > maxStock) newVal = maxStock;
        
        input.value = newVal;
    }
</script>
@endpush