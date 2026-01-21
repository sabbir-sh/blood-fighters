<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sidebar - Premium Pro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

        :root {
            --sidebar-bg: #0f172a; 
            --sidebar-hover: rgba(255, 255, 255, 0.06);
            --accent-primary: #3b82f6; 
            --accent-danger: #ef4444;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --sidebar-width: 280px;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
        }

        /* Sidebar Main */
        #sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 1040;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Header / Logo */
        .sidebar-header {
            padding: 2rem 1.5rem;
            flex-shrink: 0;
        }

        .brand-logo {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.3);
        }

        .brand-name {
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: white;
            text-transform: uppercase;
        }

        /* Search Area */
        .sidebar-search {
            padding: 0 1.5rem 1.5rem;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            padding: 10px 15px 10px 40px;
            font-size: 14px;
            width: 100%;
            transition: 0.3s;
        }

        .search-box input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        /* Scrollable Menu */
        .sidebar-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 0 1rem;
        }

        .sidebar-content::-webkit-scrollbar { width: 4px; }
        .sidebar-content::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }

        /* Menu Section Label */
        .menu-label {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 1.5rem 0 0.75rem 0.75rem;
            opacity: 0.6;
        }

        /* Navigation Links */
        .nav-link {
            color: var(--text-muted) !important;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: 0.3s;
            border: 1px solid transparent;
        }

        .nav-link i:first-child {
            font-size: 1.25rem;
            transition: 0.3s;
        }

        .nav-link:hover {
            background: var(--sidebar-hover);
            color: white !important;
            border-color: rgba(255, 255, 255, 0.05);
        }

        .nav-link.active {
            background: rgba(59, 130, 246, 0.1) !important;
            color: var(--accent-primary) !important;
            border-color: rgba(59, 130, 246, 0.2);
            position: relative;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: -10px;
            width: 4px;
            height: 20px;
            background: var(--accent-primary);
            border-radius: 0 4px 4px 0;
        }

        /* Submenu */
        .submenu-container {
            padding-left: 20px;
            margin-bottom: 10px;
            border-left: 1px solid rgba(255,255,255,0.05);
            margin-left: 22px;
        }

        .submenu-container .nav-link {
            font-size: 0.88rem;
            padding: 8px 15px;
        }

        /* Footer / Logout */
        .sidebar-footer {
            padding: 1.5rem;
            background: rgba(0,0,0,0.2);
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.1);
            color: var(--accent-danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 12px;
            padding: 12px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: var(--accent-danger);
            color: white;
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
        }
    </style>
</head>
<body>

<button class="btn btn-primary d-md-none position-fixed" id="toggleMenu" style="top:15px; left:15px; z-index:2000; border-radius:10px;">
    <i class="bi bi-list fs-4"></i>
</button>

<div id="sidebar">
    
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="brand-logo">
            <div class="logo-icon">
                <i class="bi bi-droplet-fill"></i>
            </div>
            <div class="brand-name">
                <span style="color: var(--accent-primary)">Blood</span>Fighters
            </div>
        </a>
    </div>

    <div class="sidebar-search">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="menuSearch" placeholder="Quick find...">
        </div>
    </div>

    <div class="sidebar-content">
        <ul class="nav flex-column" id="menuList">


            <div class="menu-label">Product Management</div>
            <li class="nav-item">
                <a class="nav-link justify-content-between {{ request()->routeIs('product.*') ? 'active' : '' }}" 
                   data-bs-toggle="collapse" href="#productCollapse">
                    <div class="d-flex align-items-center gap-2">
                       <i class="bi bi-stack"></i> Product Operations
                    </div>
                    <i class="bi bi-chevron-down opacity-50 small"></i>
                </a>
                <div class="collapse {{ request()->routeIs('product.*') ? 'show' : '' }}" id="productCollapse">
                    <div class="submenu-container">
                        <a href="{{ route('product.list') }}" class="nav-link {{ request()->routeIs('product.*') ? 'active' : '' }}">Products</a>
                        {{-- <a href="{{ route('category.list') }}" class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">Categories</a> --}}
                    </div>
                </div>
            </li>

            <div class="menu-label">Blood Management</div>
            <li class="nav-item">
                <a class="nav-link justify-content-between {{ request()->routeIs('blood-group.*') || request()->routeIs('donor.*') ? 'active' : '' }}" 
                   data-bs-toggle="collapse" href="#bloodCollapse">
                    <div class="d-flex align-items-center gap-2">
                       <i class="bi bi-stack"></i> Blood Operations
                    </div>
                    <i class="bi bi-chevron-down opacity-50 small"></i>
                </a>
                <div class="collapse {{ request()->routeIs('blood-group.*') || request()->routeIs('donor.*') ? 'show' : '' }}" id="bloodCollapse">
                    <div class="submenu-container">
                        <a href="{{ route('blood-group.list') }}" class="nav-link {{ request()->routeIs('blood-group.*') ? 'active' : '' }}">Blood Groups</a>
                        <a href="{{ route('donor.list') }}" class="nav-link {{ request()->routeIs('donor.*') ? 'active' : '' }}">Donors List</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a href="{{ route('contact.list') }}" class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}">
                    <i class="bi bi-envelope-paper-fill"></i> Contact
                </a>
            </li>

            <div class="menu-label">Content & Blog</div>
            <li class="nav-item">
                <a href="{{ route('blog.list') }}" class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i> Articles
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('category.list') }}" class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">
                    <i class="bi bi-stack"></i> Categories
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('faq.list') }}" class="nav-link {{ request()->routeIs('faq.*') ? 'active' : '' }}">
                    <i class="bi bi-question-square-fill"></i> FAQ
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('author.list') }}" class="nav-link {{ request()->routeIs('author.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Authors List
                </a>
            </li>

            <div class="menu-label">System</div>
            <li class="nav-item">
                <a href="{{ route('setting.list') }}" class="nav-link {{ request()->routeIs('setting.*') ? 'active' : '' }}">
                    <i class="bi bi-sliders2-vertical"></i> Global Settings
                </a>
            </li>

            <div class="menu-label">Payment</div>
            <li class="nav-item">
                <a href="{{ route('payment.list') }}" class="nav-link {{ request()->routeIs('payment.*') ? 'active' : '' }}">
                    <i class="bi bi-currency-dollar"></i> Payments
                </a>
            </li>

        </ul>
    </div>

    <div class="sidebar-footer">
        <a href="{{ route('logout') }}" class="btn-logout">
            <i class="bi bi-power"></i> <span>Secure Logout</span>
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Mobile Toggle
    const toggleBtn = document.getElementById('toggleMenu');
    const sidebar = document.getElementById('sidebar');

    toggleBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        sidebar.classList.toggle('show');
    });

    document.addEventListener('click', (e) => {
        if (window.innerWidth < 768 && !sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
            sidebar.classList.remove('show');
        }
    });

    // Smart Search
    document.getElementById('menuSearch').addEventListener('input', function() {
        let val = this.value.toLowerCase();
        let items = document.querySelectorAll('#menuList .nav-item');
        let labels = document.querySelectorAll('.menu-label');

        items.forEach(item => {
            let text = item.innerText.toLowerCase();
            item.style.display = text.includes(val) ? 'block' : 'none';
        });
        
        // Hide labels if searching
        labels.forEach(label => {
            label.style.display = val.length > 0 ? 'none' : 'block';
        });
    });
</script>

</body>
</html>