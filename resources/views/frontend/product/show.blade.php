@extends('frontend.layouts.app')

@section('content')
    <style>
        .product-img-main {
            transition: transform 0.3s ease;
            cursor: zoom-in;
        }

        .product-img-main:hover {
            transform: scale(1.02);
        }

        .thumb-img {
            cursor: pointer;
            transition: 0.2s;
            border: 2px solid transparent;
            object-fit: cover;
        }

        .thumb-img:hover {
            border-color: #ff3366;
        }

        /* Buttons */
        .btn-cart {
            background-color: #212529;
            color: white;
            border: none;
            transition: 0.3s;
            border-radius: 10px;
        }

        .btn-cart:hover {
            background-color: #000;
            color: white;
        }

        .btn-checkout {
            background-color: #ff3366;
            color: white;
            border: none;
            transition: 0.3s;
            border-radius: 10px;
        }

        .btn-checkout:hover {
            background-color: #e62e5c;
            color: white;
            box-shadow: 0 4px 15px rgba(255, 51, 102, 0.3);
        }

        .quantity-input {
            max-width: 120px;
            border-radius: 10px;
            height: 50px;
            font-weight: bold;
        }
    </style>

    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active text-dark" aria-current="page">Product Details</li>
            </ol>
        </nav>

        <div class="row g-lg-5">
            {{-- Left Column: Images --}}
            <div class="col-md-6 mb-4">
                <div class="position-sticky" style="top: 20px;">
                    <div class="bg-white border rounded-4 overflow-hidden mb-3 shadow-sm">
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" id="mainImage"
                            class="img-fluid product-img-main w-100" alt="{{ $product->name }}">
                    </div>

                    @if($product->images)
                        <div class="d-flex gap-2 overflow-auto pb-2">
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" class="thumb-img rounded-3 border"
                                width="75" height="75" onclick="changeImage(this.src)">
                            @foreach($product->images as $img)
                                <img src="{{ asset('storage/' . $img) }}" class="thumb-img rounded-3 border" width="75" height="75"
                                    onclick="changeImage(this.src)">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Column: Product Info --}}
            <div class="col-md-6">
                <div class="ps-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-danger px-3 py-2">Flash Sale</span>
                        @if($product->stock > 0)
                            <span class="text-success small fw-bold"><i class="fas fa-circle" style="font-size: 8px;"></i> In
                                Stock</span>
                        @else
                            <span class="text-danger small fw-bold"><i class="fas fa-circle" style="font-size: 8px;"></i> Out of
                                Stock</span>
                        @endif
                    </div>

                    <h1 class="fw-bold h2 mb-3">{{ $product->name }}</h1>

                    <div class="d-flex align-items-center mb-4">
                        <div class="text-warning me-2">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-muted small">(4.9/5 Based on 48 Reviews)</span>
                    </div>

                    <div class="mb-4 bg-light p-3 rounded-3 border-start border-4 border-danger">
                        @if($product->discount_price)
                            <div class="d-flex align-items-baseline gap-2">
                                <h2 class="fw-bold mb-0" style="color:#ff3366;">৳{{ $product->discount_price }}</h2>
                                <span class="text-muted text-decoration-line-through fs-5">৳{{ $product->price }}</span>
                            </div>
                            <p class="text-danger small mb-0 fw-bold">You Save:
                                ৳{{ $product->price - $product->discount_price }}</p>
                        @else
                            <h2 class="fw-bold mb-0">৳{{ $product->price }}</h2>
                        @endif
                    </div>

                    <p class="text-secondary mb-4">
                        {{ $product->description ?? 'Experience superior quality and design with our latest ' . $product->name . '. Perfect for everyday use with premium materials.' }}
                    </p>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf

                        {{-- Quantity Input --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small">SELECT QUANTITY</label>
                            <input type="number" name="qty" value="1" min="1"
                                class="form-control quantity-input text-center shadow-sm border-2">
                        </div>

                        <div class="row g-3">
                            {{-- Add to Cart Button --}}
                            <div class="col-sm-6">
                                <button type="submit" name="action" value="add_to_cart"
                                    class="btn btn-cart w-100 py-3 fw-bold hstack justify-content-center">
                                    <i class="fas fa-cart-plus me-2"></i> ADD TO CART
                                </button>
                            </div>

                            {{-- Direct Checkout Button --}}
                            <div class="col-sm-6">
                                <button type="submit" name="action" value="buy_now"
                                    class="btn btn-checkout w-100 py-3 fw-bold hstack justify-content-center text-white">
                                    <i class="fas fa-bolt me-2"></i> CHECKOUT NOW
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Feature Icons --}}
                    <div class="mt-5 border-top pt-4">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-white shadow-sm border rounded p-2 text-primary">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <span class="small fw-medium">Fast Shipping</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-white shadow-sm border rounded p-2 text-primary">
                                        <i class="fas fa-headset"></i>
                                    </div>
                                    <span class="small fw-medium">24/7 Support</span>
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
        function changeImage(src) {
            document.getElementById('mainImage').src = src;
        }
    </script>
@endpush