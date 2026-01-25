@extends('frontend.layouts.app')

@section('content')
    <div class="container py-5">

        <h2 class="fw-bold mb-4">🛒 Shopping Cart</h2>

        @if(count($cart) == 0)
            <div class="alert alert-info">Your cart is empty</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th width="120">Price</th>
                            <th width="140">Quantity</th>
                            <th width="120">Total</th>
                            <th width="80"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $grandTotal = 0; @endphp

                        @foreach($cart as $item)
                            @php
                                $total = $item['price'] * $item['qty'];
                                $grandTotal += $total;
                            @endphp

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('storage/' . $item['image']) }}" width="70" class="rounded-3">
                                        <strong>{{ $item['name'] }}</strong>
                                    </div>
                                </td>

                                <td>৳{{ $item['price'] }}</td>

                                <td>
                                    <form action="{{ route('cart.update', $item['id']) }}" method="POST">
                                        @csrf
                                        <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" class="form-control"
                                            onchange="this.form.submit()">
                                    </form>
                                </td>

                                <td class="fw-bold">৳{{ $total }}</td>

                                <td>
                                    <a href="{{ route('cart.remove', $item['id']) }}" class="btn btn-sm btn-danger">
                                        ✕
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <div class="bg-light p-4 rounded-4" style="min-width:300px;">
                    <h5 class="mb-3">Cart Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total</span>
                        <strong>৳{{ $grandTotal }}</strong>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-dark w-100 mt-3 py-2">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        @endif

    </div>
@endsection