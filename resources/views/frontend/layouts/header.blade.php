<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-2">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            @if($setting?->logo)
                <img src="{{ $setting->logo_url }}" alt="Logo" height="50" class="d-inline-block">
            @else
                <div class="brand-container">
                   <span style="font-family: 'Poppins', sans-serif; font-weight: 800; letter-spacing: 1px; display: flex; align-items: center; justify-content: center;">
                        @if(isset($setting->site_name))
                            {{ $setting->site_name }}
                        @else
                            <span class="brand-main">BLOOD</span><span class="brand-sub">FIGHTERS Foundation</span>
                        @endif
                    </span>
                    {{-- <span class="brand-main">BLOOD</span><span class="brand-sub">FIGHTERS Foundation</span> --}}
                </div>
            @endif
        </a>

        <button class="navbar-toggler collapsed d-flex d-lg-none flex-column justify-content-around" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="toggler-icon top-bar"></span>
            <span class="toggler-icon middle-bar"></span>
            <span class="toggler-icon bottom-bar"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">হোম</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('blog*') ? 'active' : '' }}" href="/blog">ব্লগ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about-us') ? 'active' : '' }}" href="/about-us">আমাদের সম্পর্কে</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contact-us') ? 'active' : '' }}" href="/contact-us">যোগাযোগ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('product') ? 'active' : '' }}" href="/product">পণ্য</a>
                </li>

                <li class="nav-item ms-lg-4 mt-3 mt-lg-0">
                    <a class="btn-fighter" href="/be-a-fighter-register">
                        <i class="bi bi-droplet-fill me-2"></i>দাতা হন
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
/* --- ব্র্যান্ড ডিজাইন --- */
.brand-main {
    font-size: 1.8rem;
    font-weight: 900;
    color: #dc3545; /* Blood Red */
    letter-spacing: -1px;
}
.brand-sub {
    font-size: 1.8rem;
    font-weight: 400;
    color: #212529;
    letter-spacing: -1px;
}

/* --- নেভিগেশন লিংকস --- */
.navbar-nav .nav-link {
    color: #444 !important;
    font-size: 1rem;
    font-weight: 600;
    padding: 10px 18px !important;
    position: relative;
    transition: all 0.3s ease;
}

.navbar-nav .nav-link:hover, 
.navbar-nav .nav-link.active {
    color: #dc3545 !important;
}

/* হোভার আন্ডারলাইন এনিমেশন */
.navbar-nav .nav-link::before {
    content: '';
    position: absolute;
    bottom: 5px;
    left: 18px;
    width: 0;
    height: 3px;
    background: #dc3545;
    transition: width 0.3s ease;
    border-radius: 10px;
}

.navbar-nav .nav-link:hover::before,
.navbar-nav .nav-link.active::before {
    width: 30px;
}

/* --- দাতা হন বাটন (Premium Fighter Button) --- */
.btn-fighter {
    background: linear-gradient(45deg, #dc3545, #ff4d4d);
    color: white !important;
    padding: 12px 28px;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    transition: all 0.3s ease;
    border: none;
}

.btn-fighter:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
    color: white !important;
}

/* --- মোবাইল মেনু টগলার এনিমেশন --- */
.toggler-icon {
    width: 25px;
    height: 3px;
    background-color: #dc3545;
    display: block;
    transition: all 0.3s ease-in-out;
}
.navbar-toggler {
    height: 20px;
    padding: 0;
}
.navbar-toggler:not(.collapsed) .top-bar { transform: rotate(45deg) translate(5px, 5px); }
.navbar-toggler:not(.collapsed) .middle-bar { opacity: 0; }
.navbar-toggler:not(.collapsed) .bottom-bar { transform: rotate(-45deg) translate(7px, -7px); }

/* --- রেসপন্সিভ মোবাইল ভিউ --- */
@media (max-width: 991px) {
    .navbar-collapse {
        background: #fff;
        margin-top: 15px;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .navbar-nav .nav-link::before { display: none; }
    .navbar-nav .nav-link {
        padding: 12px 0 !important;
        border-bottom: 1px solid #f8f9fa;
        width: 100%;
    }
    .btn-fighter {
        width: 100%;
        justify-content: center;
        margin-top: 10px;
    }
}
</style>