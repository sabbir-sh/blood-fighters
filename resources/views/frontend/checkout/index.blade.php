{{-- resources/views/frontend/checkout/index.blade.php --}}
@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen bg-[#fdfdfd] py-12 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto">
        <form id="checkoutForm" action="{{ route('checkout.place') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                {{-- Left Side: Shipping Info --}}
                <div class="lg:col-span-7 space-y-8">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg">1</div>
                        <h4 class="text-2xl font-bold text-gray-800">Shipping Information</h4>
                    </div>

                    <div class="bg-white rounded-[20px] p-6 sm:p-8 shadow-sm border border-gray-100">
                        <div class="grid grid-cols-1 gap-y-6">
                            {{-- Full Name --}}
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Full Name</label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <i class="far fa-user"></i>
                                    </span>
                                    <input type="text" name="name" 
                                           class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border-transparent rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-red-500/10 focus:border-red-600 transition-all outline-none" 
                                           placeholder="e.g. Sabbir Hasan" required>
                                </div>
                            </div>

                            {{-- Phone Number --}}
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Phone Number</label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <i class="fas fa-phone-alt"></i>
                                    </span>
                                    <input type="text" name="phone" 
                                           class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border-transparent rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-red-500/10 focus:border-red-600 transition-all outline-none" 
                                           placeholder="017XXXXXXXX" required>
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Full Delivery Address</label>
                                <textarea name="address" rows="4" 
                                          class="w-full p-4 bg-gray-50 border-transparent rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-red-500/10 focus:border-red-600 transition-all outline-none" 
                                          placeholder="House no, Road no, Area..." required></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div class="flex items-center p-4 bg-blue-50 rounded-xl text-blue-700 border border-blue-100">
                        <i class="fas fa-info-circle mr-3 text-lg"></i>
                        <span class="text-sm font-medium">Cash on delivery available. Delivery usually takes 2-3 business days.</span>
                    </div>
                </div>

                {{-- Right Side: Order Summary --}}
                <div class="lg:col-span-5">
                    <div class="sticky top-24 space-y-8">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold shadow-lg">2</div>
                            <h4 class="text-2xl font-bold text-gray-800">Order Summary</h4>
                        </div>

                        <div class="bg-white rounded-[20px] shadow-lg border border-gray-50 overflow-hidden">
                            <div class="p-6 sm:p-8">
                                {{-- Cart Items List --}}
                                <div class="max-h-72 overflow-y-auto pr-2 space-y-4 custom-scrollbar">
                                    @php $subtotal = 0; @endphp
                                    @foreach($cart as $item)
                                    @php $subtotal += ($item['price'] * $item['qty']); @endphp
                                    <div class="flex justify-between items-center group">
                                        <div class="flex items-center space-x-4">
                                            <div class="relative flex-shrink-0">
                                                <img src="{{ asset('storage/' . $item['image']) }}" 
                                                     class="w-16 h-16 rounded-xl object-cover border border-gray-100 shadow-sm" alt="product">
                                                <span class="absolute -top-2 -right-2 w-6 h-6 bg-gray-900 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">
                                                    {{ $item['qty'] }}
                                                </span>
                                            </div>
                                            <div class="min-w-0">
                                                <h6 class="text-sm font-bold text-gray-800 truncate">{{ Str::limit($item['name'], 25) }}</h6>
                                                <p class="text-xs text-gray-400 font-medium">৳{{ number_format($item['price']) }}</p>
                                            </div>
                                        </div>
                                        <span class="text-sm font-bold text-gray-900">৳{{ number_format($item['price'] * $item['qty']) }}</span>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="my-6 border-t border-dashed border-gray-200"></div>

                                {{-- Calculations --}}
                                <div class="space-y-3">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500 font-medium">Subtotal</span>
                                        <span class="font-bold text-gray-800">৳{{ number_format($subtotal) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500 font-medium">Shipping Fee</span>
                                        <span class="text-green-600 font-bold italic">Calculated at delivery</span>
                                    </div>
                                </div>

                                {{-- Grand Total --}}
                                <div class="mt-6 p-4 bg-gray-50 rounded-2xl flex justify-between items-center">
                                    <span class="text-base font-bold text-gray-800">Total Amount</span>
                                    <span class="text-2xl font-black text-red-600">৳{{ number_format($subtotal) }}</span>
                                </div>

                                {{-- Action Button --}}
                                <button type="button" id="submitBtn" 
                                        class="w-full mt-6 py-4 bg-red-600 hover:bg-red-700 active:scale-95 text-white font-bold rounded-xl shadow-xl shadow-red-200 transition-all flex items-center justify-center space-x-2">
                                    <i class="fas fa-check-circle"></i>
                                    <span>CONFIRM ORDER</span>
                                </button>
                                
                                <p class="mt-4 text-center text-[10px] text-gray-400 font-medium leading-relaxed">
                                    By clicking 'Confirm Order', you agree to our <a href="#" class="underline hover:text-gray-600">terms and conditions</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('submitBtn').addEventListener('click', function() {
        const form = document.getElementById('checkoutForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Confirm Your Order?',
            text: "Ready to place your order with Cash on Delivery?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc2626', // Tailwind red-600
            cancelButtonColor: '#4b5563',  // Tailwind gray-600
            confirmButtonText: 'Yes, Confirm!',
            cancelButtonText: 'Wait, let me check',
            customClass: {
                popup: 'rounded-[20px]',
                confirmButton: 'rounded-lg px-6 py-2.5 font-bold',
                cancelButton: 'rounded-lg px-6 py-2.5 font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Securing your order, please wait.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });
    });
</script>

<style>
    /* Custom Scrollbar for Order Summary */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
</style>
@endsection