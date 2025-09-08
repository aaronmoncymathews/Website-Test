<?php
$pageTitle = 'Services';
$pageDescription = 'Explore FluxTerra Simworks services including session booking, training programs, competitive events, and professional racing simulation.';

require_once 'includes/header.php';
require_once 'includes/db.php';

// Get available sims for display
$sims = getActiveSims($pdo);
?>

<main>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary to-blue-800 text-white">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 fade-in">Our Services</h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-200 fade-in">
                    Professional racing simulation services tailored to your needs
                </p>
            </div>
        </div>
    </section>

    <!-- Main Services Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">What We Offer</h2>
                <p class="text-xl text-gray-600">Comprehensive racing simulation services for all skill levels</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Session Booking -->
                <div class="bg-gray-50 rounded-lg p-8 fade-in">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mr-4">
                            <i data-lucide="calendar" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Session Booking</h3>
                    </div>
                    <p class="text-gray-600 mb-6">
                        Book your racing sessions with our advanced booking system. Choose from various simulators, 
                        tracks, and vehicles to create your perfect racing experience.
                    </p>
                    <ul class="space-y-2 text-gray-600 mb-6">
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Flexible scheduling with real-time availability
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Multiple simulator options
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Wide selection of tracks and vehicles
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Assistance services available
                        </li>
                    </ul>
                    <?php if (isLoggedIn()): ?>
                        <a href="/booking.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Book Now
                        </a>
                    <?php else: ?>
                        <a href="/register.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Sign Up to Book
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Training Programs -->
                <div class="bg-gray-50 rounded-lg p-8 fade-in">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mr-4">
                            <i data-lucide="graduation-cap" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Training Programs</h3>
                    </div>
                    <p class="text-gray-600 mb-6">
                        Improve your racing skills with our professional training programs. Learn from experienced 
                        instructors and develop techniques used by professional drivers.
                    </p>
                    <ul class="space-y-2 text-gray-600 mb-6">
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            One-on-one coaching sessions
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Group training workshops
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Performance analysis and feedback
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Customized training plans
                        </li>
                    </ul>
                    <a href="/contact.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Learn More
                    </a>
                </div>

                <!-- Competitive Events -->
                <div class="bg-gray-50 rounded-lg p-8 fade-in">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mr-4">
                            <i data-lucide="trophy" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Competitive Events</h3>
                    </div>
                    <p class="text-gray-600 mb-6">
                        Join our racing championships and compete against other drivers. Participate in regular 
                        events, seasonal championships, and special tournaments with prizes and recognition.
                    </p>
                    <ul class="space-y-2 text-gray-600 mb-6">
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Weekly racing events
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Seasonal championships
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Prize pools and trophies
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Live streaming and commentary
                        </li>
                    </ul>
                    <a href="/events.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        View Events
                    </a>
                </div>

                <!-- Leaderboards -->
                <div class="bg-gray-50 rounded-lg p-8 fade-in">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mr-4">
                            <i data-lucide="bar-chart-3" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Leaderboards</h3>
                    </div>
                    <p class="text-gray-600 mb-6">
                        Track your performance and compete with other drivers on our comprehensive leaderboards. 
                        See how you rank across different simulators, tracks, and vehicle categories.
                    </p>
                    <ul class="space-y-2 text-gray-600 mb-6">
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Real-time lap time tracking
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Multiple category rankings
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Personal performance history
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Achievement system
                        </li>
                    </ul>
                    <a href="/leaderboards.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        View Leaderboards
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Available Simulators Section -->
    <?php if (!empty($sims)): ?>
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Available Simulators</h2>
                <p class="text-xl text-gray-600">Choose from our selection of professional racing simulators</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($sims as $sim): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow fade-in">
                    <div class="p-6">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="monitor" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-center mb-2"><?php echo htmlspecialchars($sim['name']); ?></h3>
                        <?php if ($sim['description']): ?>
                            <p class="text-gray-600 text-center text-sm"><?php echo htmlspecialchars($sim['description']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Pricing Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Pricing</h2>
                <p class="text-xl text-gray-600">Affordable rates for professional racing simulation</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 rounded-lg p-8 text-center fade-in">
                    <h3 class="text-2xl font-bold mb-4">Practice Session</h3>
                    <div class="text-4xl font-bold text-primary mb-4">$25<span class="text-lg text-gray-600">/hour</span></div>
                    <ul class="space-y-2 text-gray-600 mb-6">
                        <li>Full simulator access</li>
                        <li>Track and vehicle selection</li>
                        <li>Basic assistance</li>
                        <li>Performance tracking</li>
                    </ul>
                    <?php if (isLoggedIn()): ?>
                        <a href="/booking.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors w-full block">
                            Book Now
                        </a>
                    <?php else: ?>
                        <a href="/register.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors w-full block">
                            Sign Up
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="bg-primary text-white rounded-lg p-8 text-center fade-in relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-accent text-white px-4 py-1 rounded-full text-sm font-semibold">Most Popular</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Hotlap Session</h3>
                    <div class="text-4xl font-bold mb-4">$35<span class="text-lg text-gray-200">/hour</span></div>
                    <ul class="space-y-2 text-gray-200 mb-6">
                        <li>Everything in Practice</li>
                        <li>Performance analysis</li>
                        <li>Expert tips and feedback</li>
                        <li>Leaderboard tracking</li>
                    </ul>
                    <?php if (isLoggedIn()): ?>
                        <a href="/booking.php" class="bg-accent text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-600 transition-colors w-full block">
                            Book Now
                        </a>
                    <?php else: ?>
                        <a href="/register.php" class="bg-accent text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-600 transition-colors w-full block">
                            Sign Up
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-8 text-center fade-in">
                    <h3 class="text-2xl font-bold mb-4">Race Session</h3>
                    <div class="text-4xl font-bold text-primary mb-4">$45<span class="text-lg text-gray-600">/hour</span></div>
                    <ul class="space-y-2 text-gray-600 mb-6">
                        <li>Everything in Hotlap</li>
                        <li>Multi-player racing</li>
                        <li>Race strategy coaching</li>
                        <li>Video replay analysis</li>
                    </ul>
                    <?php if (isLoggedIn()): ?>
                        <a href="/booking.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors w-full block">
                            Book Now
                        </a>
                    <?php else: ?>
                        <a href="/register.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors w-full block">
                            Sign Up
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Experience Professional Racing?</h2>
            <p class="text-xl mb-8 text-gray-200">Book your session today and discover the thrill of racing simulation</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php if (isLoggedIn()): ?>
                    <a href="/booking.php" class="bg-accent text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-red-600 transition-colors">
                        Book Your Session
                    </a>
                <?php else: ?>
                    <a href="/register.php" class="bg-accent text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-red-600 transition-colors">
                        Get Started
                    </a>
                <?php endif; ?>
                <a href="/contact.php" class="border-2 border-white text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-white hover:text-primary transition-colors">
                    Contact Us
                </a>
            </div>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>