<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'রক্তদানই জীবনের সেরা উপহার')</title>
    
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Tailwind এর সাথে মানানসই ফন্ট সেটআপ */
        body { font-family: 'Hind Siliguri', sans-serif; }
        
        @keyframes pulse-red-infinite {
            0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(220, 53, 69, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
        }
        .animate-pulse-custom { animation: pulse-red-infinite 2s infinite; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    @include('frontend.layouts.header')

    <main class="py-10 min-h-[80vh]">
        @yield('content')
    </main>

    @include('frontend.layouts.footer')

    <div class="fixed bottom-6 right-6 z-[99999] flex flex-col items-end space-y-4">
        
        <div id="donation-popup" class="hidden bg-white p-4 rounded-[20px] shadow-2xl max-w-[280px] relative border-l-4 border-red-600 transition-all duration-500">
            <button onclick="closePopup()" class="absolute top-2 right-3 text-gray-300 hover:text-red-600 text-xl transition-colors">&times;</button>
            
            <div class="flex items-start gap-3 mt-1">
                <div class="bg-red-50 text-red-600 w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-hand-holding-heart text-lg"></i>
                </div>
                <div class="popup-text">
                    <h6 class="text-[15px] font-bold text-gray-800 mb-1">মানবতার পাশে দাঁড়ান</h6>
                    <p class="text-[12px] text-gray-500 leading-relaxed mb-2">আপনার অনুদান খরচ করা হবে এলাকার অসহায় ও হতদরিদ্র মানুষের কল্যাণে।</p>
                    <a href="{{ url('/help-for-donate') }}" class="text-[12px] font-bold text-red-600 hover:underline inline-flex items-center">
                        এখনই দান করুন <i class="fas fa-arrow-right ml-1.5 text-[10px]"></i>
                    </a>
                </div>
            </div>
            
            <div class="absolute -bottom-2 right-6 w-0 h-0 border-l-[10px] border-l-transparent border-r-[10px] border-r-transparent border-t-[10px] border-t-white"></div>
        </div>

        <a href="{{ url('/help-for-donate') }}" 
           class="bg-gradient-to-br from-red-600 to-red-500 text-white w-[70px] h-[70px] rounded-full flex items-center justify-center shadow-xl border-4 border-white transition-all duration-300 hover:scale-110 hover:rotate-6 animate-pulse-custom group">
            <div class="flex flex-col items-center leading-none">
                <i class="fas fa-heartbeat text-2xl mb-1 group-hover:scale-110 transition-transform"></i>
                <span class="text-[10px] font-black uppercase tracking-tighter">Donate</span>
            </div>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Donation Popup Logic
        let donationLoopActive = true;

        function startDonationLoop() {
            const popup = document.getElementById('donation-popup');
            if (!popup || !donationLoopActive) return;

            function show() {
                if (!donationLoopActive) return;
                popup.classList.remove('hidden', 'translate-x-full', 'opacity-0');
                popup.classList.add('flex', 'translate-x-0', 'opacity-100');
                setTimeout(hide, 10000); // ১০ সেকেন্ড পর হাইড হবে
            }

            function hide() {
                popup.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    popup.classList.add('hidden');
                    if (donationLoopActive) setTimeout(show, 3000); // ৩ সেকেন্ড পর আবার আসবে
                }, 500);
            }

            setTimeout(show, 2000); // পেজ লোড হওয়ার ২ সেকেন্ড পর শুরু হবে
        }

        function closePopup() {
            donationLoopActive = false; // ইউজার একবার ক্লোজ করলে লুপ বন্ধ হয়ে যাবে
            const popup = document.getElementById('donation-popup');
            popup.classList.add('opacity-0', 'translate-x-full');
            setTimeout(() => popup.style.display = 'none', 500);
        }

        document.addEventListener("DOMContentLoaded", startDonationLoop);

        // Add to Cart Function
        function addToCart(productId) {
            const token = "{{ csrf_token() }}";
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
                if(data.status === 'success') {
                    document.getElementById('cart-count').innerText = data.cart_count;
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>