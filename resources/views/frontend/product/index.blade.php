@extends('frontend.layouts.app')

@section('content')
<div class="container py-5 bg-light">
    <h3 class="mb-4 fw-bold">Featured Products</h3>

    <div class="row g-3">
        @forelse($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 position-relative overflow-hidden">
                    
                    {{-- 10% OFF Badge --}}
                    @if($product->discount_price)
                        @php 
                            $discount = round((($product->price - $product->discount_price) / $product->price) * 100);
                        @endphp
                        <span class="position-absolute top-0 start-0 badge rounded-pill m-2 py-2 px-3" 
                              style="background-color: #ff3366; font-weight: 500;">
                            {{ $discount }}% OFF
                        </span>
                    @endif

                    {{-- Image --}}
                    <div class="p-3 text-center">
                        <a href="{{ route('product.front.show', $product->slug) }}">
                            <img src="{{ asset('storage/'.$product->thumbnail) }}" 
                                 class="img-fluid" style="height: 180px; object-fit: contain;" 
                                 alt="{{ $product->name }}">
                        </a>
                    </div>

                    <div class="card-body pt-0">
                        {{-- Price Section --}}
                        <div class="mb-2">
                            @if($product->discount_price)
                                <span class="text-muted text-decoration-line-through me-1" style="font-size: 1.1rem;">
                                    ৳{{ $product->price }}
                                </span>
                                <span class="fw-bold" style="color: #ff3366; font-size: 1.3rem;">
                                    ৳{{ $product->discount_price }}
                                </span>
                                <small class="text-primary" style="font-size: 0.75rem;">(+VAT)</small>
                            @else
                                <span class="fw-bold fs-5">৳{{ $product->price }}</span>
                            @endif
                        </div>

                        {{-- Title --}}
                        <h6 class="card-title text-dark mb-2" style="font-size: 0.95rem; line-height: 1.4;">
                            {{ Str::limit($product->name, 45) }}
                        </h6>

                        {{-- Stars --}}
                        <div class="text-warning mb-3 small">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex gap-2">
                            <button type="button" onclick="addToCart({{ $product->id }})" class="btn border-0 w-100 fw-bold text-dark" style="background-color: #ffe599;">
                                Add To Cart
                            </button>
                            <button class="btn border rounded-circle d-flex align-items-center justify-content-center" 
                                    style="width: 42px; height: 42px; color: #333;">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>No products found.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
<script>
function addToCart(productId) {
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        alert('Added successfully!');
        // Update your cart count header here if you have one
    });
}
</script>
@endsection