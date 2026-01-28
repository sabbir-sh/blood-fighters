<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'রক্তদানই জীবনের সেরা উপহার')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    @include('frontend.layouts.header') <!-- Header Include -->

    <main class="py-4">
        @yield('content') <!-- Page Content -->
    </main>

    @include('frontend.layouts.footer') <!-- Footer Include -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="donation-container">
        <div id="donation-popup" class="donation-popup-bubble animate__animated animate__fadeInRight">
            <div class="popup-content">
                <span class="close-popup" onclick="closePopup()" title="বন্ধ করুন">&times;</span>
                <div class="d-flex align-items-start gap-2">
                    <div class="popup-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <div class="popup-text">
                        <h6>মানবতার পাশে দাঁড়ান</h6>
                        <p>আপনার অনুদান খরচ করা হবে এলাকার অসহায় ও হতদরিদ্র মানুষের কল্যাণে।</p>
                        <a href="{{ url('/help-for-donate') }}" class="btn-popup-link">এখনই দান করুন <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="popup-arrow"></div>
        </div>

        <a href="{{ url('/help-for-donate') }}" class="floating-donate-btn shadow-lg" title="ডোনেশন করুন">
            <div class="donate-icon-content">
                <i class="fas fa-heartbeat"></i>
                <span>Donate</span>
            </div>
        </a>
    </div>

    <style>
        /* মেইন কন্টেইনার */
        .donation-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            font-family: 'Hind Siliguri', sans-serif;
        }

        /* পপ-আপ বাবল ডিজাইন */
        .donation-popup-bubble {
            background: #ffffff;
            padding: 15px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            margin-bottom: 15px;
            max-width: 280px;
            position: relative;
            border-left: 5px solid #dc3545;
            /* display: block; শুরুতে দেখাবে */
        }

        .popup-icon {
            background: #fff0f1;
            color: #dc3545;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .popup-text h6 {
            margin: 0 0 5px 0;
            font-weight: 700;
            color: #333;
            font-size: 15px;
        }

        .popup-text p {
            margin: 0 0 10px 0;
            font-size: 12px;
            line-height: 1.5;
            color: #666;
        }

        .btn-popup-link {
            color: #dc3545;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-popup-link:hover {
            color: #a71d2a;
            text-decoration: underline;
        }

        .close-popup {
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
            color: #ccc;
            transition: 0.3s;
        }

        .close-popup:hover {
            color: #dc3545;
        }

        .popup-arrow {
            position: absolute;
            bottom: -10px;
            right: 25px;
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-top: 10px solid #ffffff;
        }

        /* ফ্লোটিং সার্কেল বাটন */
        .floating-donate-btn {
            background: linear-gradient(45deg, #dc3545, #ff4d5a);
            color: #fff;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none !important;
            transition: all 0.3s ease;
            border: 3px solid #fff;
            animation: pulse-red-infinite 2s infinite;
        }

        .donate-icon-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            line-height: 1;
        }

        .donate-icon-content i {
            font-size: 24px;
            margin-bottom: 4px;
        }

        .donate-icon-content span {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .floating-donate-btn:hover {
            transform: scale(1.1) rotate(5deg);
            color: #fff;
            background: linear-gradient(45deg, #ff4d5a, #dc3545);
        }

        /* এনিমেশনসমূহ */
        @keyframes pulse-red-infinite {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(220, 53, 69, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }

        /* মোবাইল রেসপন্সিভ */
        @media (max-width: 576px) {
            .donation-container {
                bottom: 20px;
                right: 20px;
            }

            .floating-donate-btn {
                width: 60px;
                height: 60px;
            }

            .donation-popup-bubble {
                max-width: 220px;
                padding: 12px;
            }

            .popup-text h6 {
                font-size: 14px;
            }

            .popup-text p {
                font-size: 11px;
            }
        }
    </style>

    <script>
        function startDonationLoop() {
            const popup = document.getElementById('donation-popup');

            // ১. পপ-আপটি দেখানোর ফাংশন
            function showPopup() {
                popup.style.display = 'block';
                popup.classList.remove('animate__fadeOutRight');
                popup.classList.add('animate__fadeInRight');

                // ১০ সেকেন্ড পর এটি লুকানোর জন্য কমান্ড
                setTimeout(hidePopup, 10000);
            }

            // ২. পপ-আপটি লুকানোর ফাংশন
            function hidePopup() {
                popup.classList.remove('animate__fadeInRight');
                popup.classList.add('animate__fadeOutRight');

                // এনিমেশন শেষ হওয়ার জন্য ৫০০ms সময় দিন, তারপর ডিসপ্লে none করুন
                setTimeout(() => {
                    popup.style.display = 'none';

                    // ২ সেকেন্ড পর আবার দেখানোর জন্য লুপ কল করুন
                    setTimeout(showPopup, 2000);
                }, 500);
            }

            // প্রথমবার ২ সেকেন্ড পর শুরু হবে
            setTimeout(showPopup, 2000);
        }

        // পেজ লোড হলে ফাংশনটি চালু হবে
        document.addEventListener("DOMContentLoaded", startDonationLoop);

        // ইউজার যদি ম্যানুয়ালি (X) বাটনে ক্লিক করে তবে লুপ বন্ধ হয়ে যাবে
        function closePopup() {
            const popup = document.getElementById('donation-popup');
            popup.classList.replace('animate__fadeInRight', 'animate__fadeOutRight');
            setTimeout(() => {
                popup.style.display = 'none';
            }, 500);
        }
    </script>

</body>

</html>
