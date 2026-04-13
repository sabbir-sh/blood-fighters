<nav class="sticky top-0 z-[1050] bg-white border-b border-gray-100 shadow-sm py-3 transition-all">
    <div class="container mx-auto px-4 md:px-6">
        <div class="flex items-center justify-between">
            
            <a class="flex items-center no-underline group" href="/">
                @if($setting?->logo)
                    <img src="{{ $setting->logo_url }}" alt="Logo" class="h-12 w-auto object-contain">
                @else
                    <div class="flex items-center font-black tracking-tight leading-none">
                        @if(isset($setting->site_name))
                            <span class="text-2xl text-red-600">{{ $setting->site_name }}</span>
                        @else
                            <span class="text-2xl text-red-600">BLOOD</span>
                            <span class="text-2xl text-gray-900 ml-1.5 font-light">FIGHTERS</span>
                        @endif
                    </div>
                @endif
            </a>

            <button class="lg:hidden text-gray-500 focus:outline-none">
                <i class="bi bi-list text-3xl"></i>
            </button>

            <div class="hidden lg:flex items-center space-x-2">
                @php 
                    $navLinkClass = "text-[15px] font-bold px-4 py-2 rounded-xl transition-all duration-300";
                    $activeClass = "text-red-600 bg-red-50";
                    $inactiveClass = "text-gray-600 hover:text-red-600 hover:bg-gray-50";
                @endphp

                <a href="/" class="{{ $navLinkClass }} {{ request()->is('/') ? $activeClass : $inactiveClass }}">হোম</a>
                <a href="/blog" class="{{ $navLinkClass }} {{ request()->is('blog*') ? $activeClass : $inactiveClass }}">ব্লগ</a>
                <a href="/about-us" class="{{ $navLinkClass }} {{ request()->is('about-us') ? $activeClass : $inactiveClass }}">আমাদের সম্পর্কে</a>
                <a href="/contact-us" class="{{ $navLinkClass }} {{ request()->is('contact-us') ? $activeClass : $inactiveClass }}">যোগাযোগ</a>
                <a href="/product" class="{{ $navLinkClass }} {{ request()->is('product') ? $activeClass : $inactiveClass }}">পণ্য</a>

                <div class="pl-4">
                    <a href="/be-a-fighter-register" 
                       class="flex items-center px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-full font-extrabold text-sm shadow-lg shadow-red-200 hover:shadow-red-300 hover:scale-[1.02] active:scale-[0.98] transition-all no-underline">
                        <i class="bi bi-droplet-fill mr-2"></i> দাতা হন
                    </a>
                </div>

                <div class="relative group ml-4">
                    <a href="{{ route('cart.index') }}" class="relative block p-2.5 text-gray-800 hover:bg-gray-50 rounded-full transition-colors">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="cart-count" class="absolute -top-0.5 -right-0.5 bg-red-600 text-white text-[10px] font-black w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">
                            {{ count(session('cart', [])) }}
                        </span>
                    </a>

                    <div class="absolute right-0 top-full pt-4 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-2 group-hover:translate-y-0 transition-all duration-300 z-[1100]">
                        <div class="w-[320px] bg-white rounded-[28px] shadow-2xl border border-gray-100 p-6">
                            @if(session('cart') && count(session('cart')) > 0)
                                <div class="max-h-[300px] overflow-y-auto pr-2 space-y-4 custom-scrollbar">
                                    @php $subtotal = 0; @endphp
                                    @foreach(session('cart') as $id => $details)
                                        @php $subtotal += $details['price'] * $details['qty'] @endphp
                                        <div class="flex items-center gap-4 pb-4 border-b border-gray-50 last:border-0 group/item">
                                            <div class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-xl border border-gray-100">
                                                <img src="{{ asset('storage/' . $details['image']) }}" class="h-full w-full object-cover">
                                            </div>
                                            <div class="flex-grow">
                                                <h6 class="text-sm font-bold text-gray-900 truncate w-32 mb-0.5">{{ $details['name'] }}</h6>
                                                <span class="text-xs font-semibold text-gray-400">{{ $details['qty'] }} × ৳{{ number_format($details['price']) }}</span>
                                            </div>
                                            <a href="{{ route('cart.remove', $id) }}" class="text-gray-300 hover:text-red-500 transition-colors">
                                                <i class="fas fa-times-circle"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-6 pt-5 border-t border-gray-100">
                                    <div class="flex justify-between items-center mb-6">
                                        <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Subtotal</span>
                                        <span class="text-xl font-black text-gray-900">৳{{ number_format($subtotal) }}</span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <a href="{{ route('cart.index') }}" class="text-center py-3 bg-gray-50 text-gray-900 text-[13px] font-bold rounded-xl hover:bg-gray-100 transition-all no-underline border border-gray-100">View Cart</a>
                                        <a href="{{ route('checkout.index') }}" class="text-center py-3 bg-gray-900 text-white text-[13px] font-bold rounded-xl hover:bg-black shadow-lg transition-all no-underline">Checkout</a>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-10">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-shopping-basket text-gray-200 text-2xl"></i>
                                    </div>
                                    <p class="text-sm font-bold text-gray-400 m-0">Your cart is empty</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Custom Scrollbar for mini cart */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #fee2e2; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #ef4444; }
</style>