@extends('frontend.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        {{-- Billing Details (Left) --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
                <h4 class="fw-bold mb-4">🚚 Shipping Information</h4>
                <form id="checkoutForm" action="{{ route('checkout.place') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control py-2" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Phone Number</label>
                        <input type="text" name="phone" class="form-control py-2" placeholder="017xxxxxxxx" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Delivery Address</label>
                        <textarea name="address" rows="3" class="form-control" placeholder="House no, Road no, Area..." required></textarea>
                    </div>
                </form>
            </div>
        </div>

        {{-- Order Summary (Right) --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4 bg-light" style="border-radius: 15px;">
                <h5 class="fw-bold mb-4">Order Summary</h5>
                
                @php $total = 0; @endphp
                @foreach($cart as $item)
                    @php 
                        $sub = $item['price'] * $item['qty']; 
                        $total += $sub;
                    @endphp
                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                        <div class="d-flex align-items-center gap-3">
                            {{-- Product Image --}}
                            <img src="{{ asset('storage/' . $item['image']) }}" width="60" height="60" class="rounded-3 border object-fit-cover" alt="product">
                            <div>
                                <h6 class="mb-0 fw-bold small text-truncate" style="max-width: 150px;">{{ $item['name'] }}</h6>
                                <small class="text-muted">{{ $item['qty'] }} x ৳{{ $item['price'] }}</small>
                            </div>
                        </div>
                        <span class="fw-bold">৳{{ $sub }}</span>
                    </div>
                @endforeach

                <div class="mt-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">৳{{ $total }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Delivery Charge</span>
                        <span class="text-success fw-bold">Free</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fs-5 fw-bold mb-4">
                        <span>Total</span>
                        <span style="color: #ff3366;">৳{{ $total }}</span>
                    </div>

                    <button type="button" class="btn btn-dark w-100 py-3 fw-bold rounded-3" id="placeOrderBtn">
                        PLACE ORDER NOW
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert Logic --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('placeOrderBtn').addEventListener('click', function () {
        // Basic Validation check
        const name = document.querySelector('input[name="name"]').value;
        const phone = document.querySelector('input[name="phone"]').value;
        const address = document.querySelector('textarea[name="address"]').value;

        if(!name || !phone || !address) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill out all shipping details!',
            });
            return;
        }

        Swal.fire({
            title: 'Confirm Order?',
            text: "Total Payable: ৳{{ $total }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Place Order'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('checkoutForm').submit();
            }
        });
    });
</script>
@endsection