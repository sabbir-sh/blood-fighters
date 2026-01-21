@extends('frontend.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row g-5">

        {{-- Product Images --}}
        <div class="col-md-6">
            <div class="bg-white border rounded-4 p-4 text-center mb-3">
                <img src="{{ asset('storage/'.$product->thumbnail) }}"
                     class="img-fluid"
                     style="max-height: 450px;">
            </div>

            @if($product->images)
                <div class="d-flex gap-2">
                    @foreach($product->images as $img)
                        <img src="{{ asset('storage/'.$img) }}"
                             class="img-thumbnail rounded-3"
                             width="80">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="col-md-6">
            <h2 class="fw-bold mb-3">{{ $product->name }}</h2>

            {{-- Stars --}}
            <div class="text-warning mb-3">
                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <span class="text-muted ms-2 small">(24 Reviews)</span>
            </div>

            {{-- Price --}}
            <div class="mb-4">
                @if($product->discount_price)
                    <h3 class="fw-bold mb-0" style="color:#ff3366;">
                        ৳{{ $product->discount_price }}
                        <del class="text-muted fs-5 ms-2">৳{{ $product->price }}</del>
                    </h3>
                @else
                    <h3 class="fw-bold">৳{{ $product->price }}</h3>
                @endif
            </div>

            {{-- Description --}}
            <p class="text-secondary lh-lg mb-4">
                {{ $product->description ?? 'Premium quality product with intensive formula for best results.' }}
            </p>

            {{-- ADD TO CART FORM --}}
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf

                {{-- Quantity --}}
                <div class="d-flex align-items-center gap-3 mb-4">
                    <input type="number"
                           name="qty"
                           value="1"
                           min="1"
                           class="form-control text-center"
                           style="width: 90px;">

                    <span class="text-muted small">
                        Stock:
                        {{ $product->stock > 0 ? 'Available' : 'Out of Stock' }}
                    </span>
                </div>

                {{-- Buttons --}}
                <div class="row g-2">
                    <div class="col-6">
                        <button type="submit"
                                class="btn btn-lg w-100 fw-bold py-3"
                                style="background-color:#ffe599;border-radius:12px;">
                            ADD TO CART
                        </button>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('cart.index') }}"
                           class="btn btn-primary btn-lg w-100 py-3"
                           style="border-radius:12px;">
                            PROCEED TO CHECKOUT
                        </a>
                    </div>
                </div>
            </form>

            {{-- Wishlist --}}
            <div class="mt-3">
                <button type="button"
                        onclick="addToWishlist({{ $product->id }})"
                        class="btn btn-outline-dark w-100 py-3"
                        style="border-radius:12px;">
                    <i class="far fa-heart"></i> Add to Wishlist
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function addToWishlist(productId) {
    fetch(`/wishlist/add/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Added to wishlist');
        }
    });
}
</script>
@endpush
