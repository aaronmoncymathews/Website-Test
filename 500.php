<?php
$pageTitle = 'Server Error';
$pageDescription = 'An internal server error occurred.';

require_once 'includes/header.php';
?>

<main class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center">
        <div class="mb-8">
            <i data-lucide="server" class="w-24 h-24 text-gray-400 mx-auto mb-4"></i>
            <h1 class="text-6xl font-bold text-gray-900 mb-4">500</h1>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Server Error</h2>
            <p class="text-gray-600 mb-8">
                Something went wrong on our end. Please try again later.
            </p>
        </div>
        
        <div class="space-y-4">
            <a href="/index.php" class="block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                Go Home
            </a>
            <a href="/contact.php" class="block border-2 border-primary text-primary px-6 py-3 rounded-lg font-semibold hover:bg-primary hover:text-white transition-colors">
                Contact Support
            </a>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>