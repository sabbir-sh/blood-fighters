@extends('frontend.layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4 md:px-6">
        
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight">Featured Products</h3>
            <div class="h-1 flex-grow mx-6 bg-gray-200 rounded-full hidden md:block"></div>
            <span class="text-sm font-bold text-red-600 uppercase tracking-widest">Shop All</span>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @forelse($products as $product)
                <div class="group bg-white rounded-[32px] border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-500 overflow-hidden flex flex-col relative">
                    
                    {{-- Discount Badge --}}
                    @if($product->discount_price)
                        @php 
                            $discount = round((($product->price - $product->discount_price) / $product->price) * 100);
                        @endphp
                        <div class="absolute top-4 left-4 z-10">
                            <span class="bg-red-600 text-white text-[11px] font-black px-3 py-1.5 rounded-full shadow-lg shadow-red-200">
                                {{ $discount }}% OFF
                            </span>
                        </div>
                    @endif

                    {{-- Product Image --}}
                    <div class="p-4 md:p-6 overflow-hidden aspect-square flex items-center justify-center relative">
                        <a href="{{ route('product.front.show', $product->slug) }}" class="block w-full h-full">
                            <img src="{{ asset('storage/'.$product->thumbnail) }}" 
                                 class="w-full h-full object-contain transition-transform duration-700 group-hover:scale-110" 
                                 alt="{{ $product->name }}">
                        </a>
                        
                        {{-- Wishlist Button --}}
                        <button class="absolute top-4 right-4 w-9 h-9 bg-white/80 backdrop-blur-md border border-gray-100 rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-white transition-all shadow-sm">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>

                    {{-- Product Details --}}
                    <div class="px-5 pb-6 flex flex-col flex-grow">
                        
                        {{-- Price Section --}}
                        <div class="flex items-baseline gap-2 mb-2">
                            @if($product->discount_price)
                                <span class="text-xl font-black text-gray-900 tracking-tighter">৳{{ number_format($product->discount_price) }}</span>
                                <span class="text-sm text-gray-400 line-through">৳{{ number_format($product->price) }}</span>
                            @else
                                <span class="text-xl font-black text-gray-900 tracking-tighter">৳{{ number_format($product->price) }}</span>
                            @endif
                            <span class="text-[10px] font-bold text-blue-500 uppercase">+VAT</span>
                        </div>

                        {{-- Title --}}
                        <h6 class="text-[15px] font-bold text-gray-800 leading-snug mb-3 line-clamp-2 h-10 group-hover:text-red-600 transition-colors">
                            <a href="{{ route('product.front.show', $product->slug) }}">{{ $product->name }}</a>
                        </h6>

                        {{-- Rating --}}
                        <div class="flex items-center gap-1 mb-5">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-[10px] text-amber-400"></i>
                            @endfor
                            <span class="text-[10px] font-bold text-gray-300 ml-1">(5.0)</span>
                        </div>

                        {{-- Add to Cart Button --}}
                        <button onclick="addToCart({{ $product->id }})" 
                                class="mt-auto w-full py-3 bg-amber-100 hover:bg-amber-400 text-amber-900 font-extrabold text-sm rounded-2xl transition-all duration-300 flex items-center justify-center gap-2 group/btn active:scale-95">
                            <i class="fas fa-shopping-basket text-xs transition-transform group-hover/btn:-translate-y-1"></i>
                            Add To Cart
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="bg-white p-10 rounded-[40px] shadow-sm inline-block">
                        <i class="fas fa-box-open text-5xl text-gray-200 mb-4"></i>
                        <p class="text-gray-500 font-bold">No products found.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-12 flex justify-center">
            <div class="bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<script>
function addToCart(productId) {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ qty: 1 })
    })
    .then(response => response.json())
    .then(data => {
        if(typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Added to cart!',
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            alert('Added to cart!');
        }
        
        // Update header cart count if element exists
        const cartCount = document.getElementById('cart-count');
        if(cartCount && data.cart_count) {
            cartCount.innerText = data.cart_count;
        }
    })
    .catch(err => console.error(err));
}
</script>
@endsection