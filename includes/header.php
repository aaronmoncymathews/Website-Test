<?php
require_once 'auth.php';
$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>FluxTerra Simworks</title>
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Professional racing simulation center offering high-end simulators, competitive events, and expert training.'; ?>">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <!-- Flatpickr for date/time picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <style>
        :root {
            --primary-color: #003366;
            --secondary-color: #A9A9A9;
            --accent-color: #FF0000;
        }
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .bg-primary { background-color: var(--primary-color); }
        .text-primary { color: var(--primary-color); }
        .border-primary { border-color: var(--primary-color); }
        
        .bg-secondary { background-color: var(--secondary-color); }
        .text-secondary { color: var(--secondary-color); }
        
        .bg-accent { background-color: var(--accent-color); }
        .text-accent { color: var(--accent-color); }
        .border-accent { border-color: var(--accent-color); }
        
        .hover\:bg-primary:hover { background-color: var(--primary-color); }
        .hover\:text-primary:hover { color: var(--primary-color); }
        
        .hover\:bg-accent:hover { background-color: var(--accent-color); }
        .hover\:text-accent:hover { color: var(--accent-color); }
        
        /* Custom animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Mobile-first responsive design */
        @media (min-width: 640px) {
            .sm\:text-lg { font-size: 1.125rem; }
            .sm\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        }
        
        @media (min-width: 768px) {
            .md\:text-xl { font-size: 1.25rem; }
            .md\:px-8 { padding-left: 2rem; padding-right: 2rem; }
        }
        
        @media (min-width: 1024px) {
            .lg\:text-2xl { font-size: 1.5rem; }
            .lg\:px-12 { padding-left: 3rem; padding-right: 3rem; }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <!-- Navigation -->
    <nav class="bg-primary shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/index.php" class="flex items-center space-x-2 text-white hover:text-gray-200 transition-colors">
                        <i data-lucide="zap" class="w-8 h-8"></i>
                        <span class="text-xl font-bold">FluxTerra Simworks</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/index.php" class="text-white hover:text-gray-200 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'font-semibold' : ''; ?>">Home</a>
                    <a href="/about.php" class="text-white hover:text-gray-200 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'font-semibold' : ''; ?>">About</a>
                    <a href="/services.php" class="text-white hover:text-gray-200 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'font-semibold' : ''; ?>">Services</a>
                    <a href="/leaderboards.php" class="text-white hover:text-gray-200 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'leaderboards.php' ? 'font-semibold' : ''; ?>">Leaderboards</a>
                    <a href="/events.php" class="text-white hover:text-gray-200 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'events.php' ? 'font-semibold' : ''; ?>">Events</a>
                    <a href="/contact.php" class="text-white hover:text-gray-200 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'font-semibold' : ''; ?>">Contact</a>
                    
                    <?php if (isLoggedIn()): ?>
                        <a href="/booking.php" class="text-white hover:text-gray-200 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'booking.php' ? 'font-semibold' : ''; ?>">Book Session</a>
                        <?php if ($currentUser && $currentUser['role'] === 'admin'): ?>
                            <a href="/admin.php" class="text-white hover:text-gray-200 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'font-semibold' : ''; ?>">Admin</a>
                        <?php endif; ?>
                        <div class="relative group">
                            <button class="text-white hover:text-gray-200 transition-colors flex items-center space-x-1">
                                <i data-lucide="user" class="w-4 h-4"></i>
                                <span><?php echo htmlspecialchars($currentUser['username']); ?></span>
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <a href="/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/login.php" class="text-white hover:text-gray-200 transition-colors">Login</a>
                        <a href="/register.php" class="bg-accent text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors">Register</a>
                    <?php endif; ?>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white hover:text-gray-200 transition-colors">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="md:hidden bg-primary border-t border-gray-700 hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/index.php" class="block px-3 py-2 text-white hover:text-gray-200 transition-colors">Home</a>
                <a href="/about.php" class="block px-3 py-2 text-white hover:text-gray-200 transition-colors">About</a>
                <a href="/services.php" class="block px-3 py-2 text-white hover:text-gray-200 transition-colors">Services</a>
                <a href="/leaderboards.php" class="block px-3 py-2 text-white hover:text-gray-200 transition-colors">Leaderboards</a>
                <a href="/events.php" class="block px-3 py-2 text-white hover:text-gray-200 transition-colors">Events</a>
                <a href="/contact.php" class="block px-3 py-2 text-white hover:text-gray-200 transition-colors">Contact</a>
                
                <?php if (isLoggedIn()): ?>
                    <a href="/booking.php" class="block px-3 py-2 text-white hover:text-gray-200 transition-colors">Book Session</a>
                    <?php if ($currentUser && $currentUser['role'] === 'admin'): ?>
                        <a href="/admin.php" class="block px-3 py-2 text-white hover:text-gray-200 transition-colors">Admin</a>
                    <?php endif; ?>
                    <a href="/profile.php" class="block px-3 py-2 text-white hover:text-gray-200 transition-colors">Profile</a>
                    <a href="/logout.php" class="block px-3 py-2 text-white hover:text-gray-200 transition-colors">Logout</a>
                <?php else: ?>
                    <a href="/login.php" class="block px-3 py-2 text-white hover:text-gray-200 transition-colors">Login</a>
                    <a href="/register.php" class="block px-3 py-2 text-white hover:text-gray-200 transition-colors">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
        
        // Initialize Lucide icons
        lucide.createIcons();
    </script>