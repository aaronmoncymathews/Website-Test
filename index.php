<?php
$pageTitle = 'Home';
$pageDescription = 'FluxTerra Simworks - Professional racing simulation center with high-end simulators, competitive events, and expert training.';

require_once 'includes/header.php';
require_once 'includes/db.php';

// Get upcoming events
$upcomingEvents = getUpcomingEvents($pdo, 3);
?>

<main>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary to-blue-800 text-white">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 fade-in">
                    Welcome to <span class="text-accent">FluxTerra</span> Simworks
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-200 fade-in">
                    Experience the thrill of professional racing with our state-of-the-art simulators
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center fade-in">
                    <?php if (isLoggedIn()): ?>
                        <a href="/booking.php" class="bg-accent text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-red-600 transition-colors">
                            Book Your Session
                        </a>
                    <?php else: ?>
                        <a href="/register.php" class="bg-accent text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-red-600 transition-colors">
                            Get Started
                        </a>
                    <?php endif; ?>
                    <a href="/about.php" class="border-2 border-white text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-white hover:text-primary transition-colors">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Why Choose FluxTerra?</h2>
                <p class="text-xl text-gray-600">Professional-grade racing simulation experience</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 rounded-lg bg-gray-50 hover:shadow-lg transition-shadow fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="monitor" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">High-End Simulators</h3>
                    <p class="text-gray-600">Professional-grade racing simulators with realistic force feedback and motion systems.</p>
                </div>
                
                <div class="text-center p-6 rounded-lg bg-gray-50 hover:shadow-lg transition-shadow fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="trophy" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Competitive Events</h3>
                    <p class="text-gray-600">Join our racing championships and compete against other drivers for prizes and glory.</p>
                </div>
                
                <div class="text-center p-6 rounded-lg bg-gray-50 hover:shadow-lg transition-shadow fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="users" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Expert Training</h3>
                    <p class="text-gray-600">Learn from professional drivers and improve your racing skills with personalized coaching.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <?php if (!empty($upcomingEvents)): ?>
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Upcoming Events</h2>
                <p class="text-xl text-gray-600">Don't miss out on our exciting racing events</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($upcomingEvents as $event): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow fade-in">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-accent text-white px-3 py-1 rounded-full text-sm font-semibold">
                                <?php echo htmlspecialchars($event['category']); ?>
                            </span>
                            <span class="text-gray-500 text-sm">
                                <?php echo date('M j, Y', strtotime($event['event_date'])); ?>
                            </span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($event['title']); ?></h3>
                        <p class="text-gray-600 mb-4"><?php echo htmlspecialchars(substr($event['description'], 0, 100)) . '...'; ?></p>
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                <i data-lucide="clock" class="w-4 h-4 inline mr-1"></i>
                                <?php echo date('g:i A', strtotime($event['event_time'])); ?>
                            </div>
                            <div class="text-sm text-gray-500">
                                <i data-lucide="users" class="w-4 h-4 inline mr-1"></i>
                                <?php echo $event['participants'] . '/' . $event['max_participants']; ?>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-accent font-semibold">Prize: <?php echo htmlspecialchars($event['prize']); ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-8">
                <a href="/events.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    View All Events
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Services Preview Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Services</h2>
                <p class="text-xl text-gray-600">Everything you need for the ultimate racing experience</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6 rounded-lg border-2 border-gray-200 hover:border-primary transition-colors fade-in">
                    <i data-lucide="calendar" class="w-12 h-12 text-primary mx-auto mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Session Booking</h3>
                    <p class="text-gray-600 text-sm">Book your racing sessions with our advanced booking system.</p>
                </div>
                
                <div class="text-center p-6 rounded-lg border-2 border-gray-200 hover:border-primary transition-colors fade-in">
                    <i data-lucide="bar-chart-3" class="w-12 h-12 text-primary mx-auto mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Leaderboards</h3>
                    <p class="text-gray-600 text-sm">Compete and track your performance against other drivers.</p>
                </div>
                
                <div class="text-center p-6 rounded-lg border-2 border-gray-200 hover:border-primary transition-colors fade-in">
                    <i data-lucide="graduation-cap" class="w-12 h-12 text-primary mx-auto mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Training</h3>
                    <p class="text-gray-600 text-sm">Professional coaching to improve your racing skills.</p>
                </div>
                
                <div class="text-center p-6 rounded-lg border-2 border-gray-200 hover:border-primary transition-colors fade-in">
                    <i data-lucide="award" class="w-12 h-12 text-primary mx-auto mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Events</h3>
                    <p class="text-gray-600 text-sm">Join competitive racing events and championships.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Start Racing?</h2>
            <p class="text-xl mb-8 text-gray-200">Join FluxTerra Simworks today and experience professional racing simulation</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php if (isLoggedIn()): ?>
                    <a href="/booking.php" class="bg-accent text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-red-600 transition-colors">
                        Book Now
                    </a>
                <?php else: ?>
                    <a href="/register.php" class="bg-accent text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-red-600 transition-colors">
                        Sign Up Now
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