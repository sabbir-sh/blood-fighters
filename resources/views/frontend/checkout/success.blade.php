@extends('frontend.layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 bg-gray-50/50">
    <div class="max-w-xl w-full">
        <div class="bg-white rounded-[40px] shadow-2xl shadow-gray-200/50 p-8 md:p-12 text-center border border-gray-50 relative overflow-hidden">
            
            {{-- Decorative Background Element --}}
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-emerald-50 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-red-50 rounded-full blur-3xl"></div>

            {{-- Success Icon --}}
            <div class="relative mb-8">
                <div class="w-24 h-24 bg-emerald-500 text-white rounded-full inline-flex items-center justify-center shadow-lg shadow-emerald-200 animate-bounce">
                    <i class="fas fa-check text-4xl"></i>
                </div>
                {{-- Pulse Effect --}}
                <div class="absolute inset-0 w-24 h-24 bg-emerald-500 rounded-full mx-auto animate-ping opacity-20"></div>
            </div>

            {{-- Order Status --}}
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-2 tracking-tight">অর্ডার সফল হয়েছে!</h2>
            <p class="text-gray-400 font-medium mb-8">আপনার অর্ডার আইডি: <span class="text-gray-900 font-bold">#{{ $order->id }}</span></p>

            {{-- Order Summary Card --}}
            <div class="bg-gray-50 rounded-3xl p-6 mb-8 border border-gray-100/50 text-left space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 font-medium">অর্ডারের নাম</span>
                    <span class="text-gray-900 font-bold uppercase tracking-wide">{{ $order->name }}</span>
                </div>
                <div class="h-px bg-gray-200/50 w-full"></div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 font-medium">মোট পরিমাণ</span>
                    <span class="text-2xl font-black text-red-600">৳{{ number_format($order->total) }}</span>
                </div>
            </div>

            <p class="text-sm text-gray-400 mb-10 leading-relaxed px-4">
                ধন্যবাদ আমাদের সাথে থাকার জন্য। খুব শীঘ্রই আমাদের একজন প্রতিনিধি আপনার দেওয়া নাম্বারে যোগাযোগ করবেন।
            </p>

            {{-- Action Buttons --}}
            <div class="space-y-4">
                <a href="{{ route('product.front.index') }}" 
                   class="group flex items-center justify-center w-full py-5 bg-gray-900 hover:bg-black text-white font-bold rounded-2xl shadow-xl shadow-gray-200 transition-all transform active:scale-[0.98]">
                    <span>আরও শপিং করুন</span>
                    <i class="fas fa-arrow-right ml-3 transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
        
        {{-- Back to Home Link --}}
        <div class="text-center mt-8">
            <a href="{{ url('/') }}" class="text-sm font-bold text-gray-400 hover:text-gray-900 transition-colors">
                হোম পেজে ফিরে যান
            </a>
        </div>
    </div>
</div>

{{-- Fire Confetti on Success --}}
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<script>
    window.onload = function() {
        confetti({
            particleCount: 150,
            spread: 70,
            origin: { y: 0.6 },
            colors: ['#10b981', '#ef4444', '#f59e0b', '#3b82f6']
        });
    };
</script>
@endsection