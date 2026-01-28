@extends('frontend.layouts.app')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0 small" style="letter-spacing: 0.5px;">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product.front.index') }}" class="text-decoration-none text-muted">Shop</a></li>
            <li class="breadcrumb-item active fw-bold text-dark">{{ Str::limit($product->name, 25) }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- Left: Image Gallery (Medium Size) --}}
        <div class="col-lg-6 col-md-12">
            <div style="background: #fff; border-radius: 16px; border: 1px solid #f0f0f0; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.03);">
                <div style="position: relative; aspect-ratio: 1/1; display: flex; align-items: center; overflow: hidden; background: #fff;">
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" id="mainImage"
                         style="width: 100%; height: 100%; object-fit: contain; transition: transform 0.4s ease;" 
                         alt="{{ $product->name }}">
                </div>
            </div>
            
            @if($product->images)
            <div style="display: flex; gap: 10px; margin-top: 15px; overflow-x: auto; padding-bottom: 5px; scrollbar-width: none;">
                <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                     class="thumb-item" 
                     style="width: 70px; height: 70px; border-radius: 10px; cursor: pointer; border: 2px solid #ff3366; object-fit: cover; flex-shrink: 0;"
                     onclick="updateGallery(this, this.src)">
                @foreach($product->images as $img)
                    <img src="{{ asset('storage/' . $img) }}" 
                         class="thumb-item" 
                         style="width: 70px; height: 70px; border-radius: 10px; cursor: pointer; border: 2px solid #eee; object-fit: cover; flex-shrink: 0; transition: 0.3s;"
                         onclick="updateGallery(this, this.src)">
                @endforeach
            </div>
            @endif
        </div>

        {{-- Right: Product Details --}}
        <div class="col-lg-6 col-md-12">
            <div style="padding: 5px 0;">
                <div class="mb-2">
                    <span style="font-size: 11px; background: #212529; color: #fff; padding: 4px 12px; border-radius: 4px; font-weight: 600; text-transform: uppercase;">
                        Premium Quality
                    </span>
                </div>

                <h1 style="font-size: 1.75rem; font-weight: 700; color: #111; margin-bottom: 12px; line-height: 1.3;">
                    {{ $product->name }}
                </h1>
                
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="color: #ffc107; font-size: 14px;">
                        @for($i=1; $i<=5; $i++) <i class="fas fa-star"></i> @endfor
                        <span class="text-muted ms-1" style="font-size: 13px;">(4.8)</span>
                    </div>
                    <div style="height: 15px; width: 1px; background: #ddd;"></div>
                    <span style="font-size: 13px; font-weight: 600; color: {{ $product->stock > 0 ? '#28a745' : '#dc3545' }}">
                        {{ $product->stock > 0 ? 'Available in Stock' : 'Out of Stock' }}
                    </span>
                </div>

                <div style="margin-bottom: 25px;">
                    @if($product->discount_price)
                        <div class="d-flex align-items-baseline gap-2">
                            <span style="font-size: 1.8rem; font-weight: 800; color: #ff3366;">৳{{ $product->discount_price }}</span>
                            <span style="text-decoration: line-through; color: #adb5bd; font-size: 1.1rem;">৳{{ $product->price }}</span>
                        </div>
                        <div style="color: #ff3366; font-size: 13px; font-weight: 600;">Save ৳{{ $product->price - $product->discount_price }} today</div>
                    @else
                        <span style="font-size: 1.8rem; font-weight: 800; color: #111;">৳{{ $product->price }}</span>
                    @endif
                </div>

                <div style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 25px; border-top: 1px solid #eee; pt-3;">
                    <div class="pt-3 fw-bold text-dark mb-1">Quick Description:</div>
                    {{ $product->description ?? 'Experience the perfect balance of comfort and style with our ' . $product->name . '. Designed for the modern lifestyle.' }}
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    
                    {{-- Quantity Selector --}}
                    <div class="mb-4">
                        <label style="font-size: 12px; font-weight: 700; color: #333; margin-bottom: 8px; display: block;">Select Quantity</label>
                        <div style="display: flex; align-items: center; border: 1px solid #ddd; border-radius: 10px; width: fit-content; background: #fdfdfd; padding: 4px;">
                            <button type="button" onclick="updateQty(-1)" style="width: 35px; height: 35px; border: none; background: transparent; font-size: 18px; color: #666;">-</button>
                            <input type="number" name="qty" id="product-qty" value="1" min="1" readonly style="width: 50px; border: none; text-align: center; font-weight: 700; background: transparent;">
                            <button type="button" onclick="updateQty(1)" style="width: 35px; height: 35px; border: none; background: transparent; font-size: 18px; color: #666;">+</button>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <button type="submit" name="action" value="add_to_cart" 
                                    style="height: 52px; border-radius: 12px; font-weight: 700; border: 2px solid #111; background: transparent; transition: 0.3s; width: 100%;">
                                <i class="fas fa-shopping-cart me-2"></i> ADD TO CART
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <button type="submit" name="action" value="buy_now" 
                                    style="height: 52px; border-radius: 12px; font-weight: 700; border: none; background: #ff3366; color: #fff; width: 100%; transition: 0.3s; box-shadow: 0 4px 12px rgba(255, 51, 102, 0.25);">
                                <i class="fas fa-bolt me-2"></i> ORDER NOW
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Trust Features --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; border-top: 1px solid #eee; padding-top: 20px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 40px; height: 40px; background: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ff3366;">
                            <i class="fas fa-truck" style="font-size: 16px;"></i>
                        </div>
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #111;">Free Shipping</div>
                            <div style="font-size: 11px; color: #777;">On orders over ৳5000</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 40px; height: 40px; background: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #28a745;">
                            <i class="fas fa-undo" style="font-size: 16px;"></i>
                        </div>
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #111;">Easy Returns</div>
                            <div style="font-size: 11px; color: #777;">7 days return policy</div>
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
        document.getElementById('mainImage').src = src;
        // Thumbnail border reset
        document.querySelectorAll('.thumb-item').forEach(img => {
            img.style.borderColor = '#eee';
        });
        // Active border
        element.style.borderColor = '#ff3366';
    }

    function updateQty(val) {
        const input = document.getElementById('product-qty');
        let newVal = parseInt(input.value) + val;
        if(newVal < 1) newVal = 1;
        input.value = newVal;
    }
</script>
@endpush