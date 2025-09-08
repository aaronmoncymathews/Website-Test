<?php
$pageTitle = 'Events';
$pageDescription = 'Join exciting racing events and championships at FluxTerra Simworks. Compete for prizes and glory in our competitive racing series.';

require_once 'includes/header.php';
require_once 'includes/db.php';

// Get upcoming events
$upcomingEvents = getUpcomingEvents($pdo, 20);

// Get past events
$stmt = $pdo->prepare("SELECT * FROM events WHERE is_upcoming = 0 AND event_date < CURDATE() ORDER BY event_date DESC LIMIT 10");
$stmt->execute();
$pastEvents = $stmt->fetchAll();
?>

<main>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary to-blue-800 text-white">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 fade-in">Racing Events</h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-200 fade-in">
                    Compete in exciting championships and racing events
                </p>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Upcoming Events</h2>
                <p class="text-xl text-gray-600">Don't miss out on our exciting racing events</p>
            </div>
            
            <?php if (!empty($upcomingEvents)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($upcomingEvents as $event): ?>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow fade-in border border-gray-200">
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
                                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars(substr($event['description'], 0, 120)) . '...'; ?></p>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i data-lucide="monitor" class="w-4 h-4 mr-2"></i>
                                        <?php echo htmlspecialchars($event['simulator']); ?>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i>
                                        <?php echo htmlspecialchars($event['track']); ?>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                                        <?php echo date('g:i A', strtotime($event['event_time'])); ?>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                                        <?php echo $event['participants'] . '/' . $event['max_participants']; ?> participants
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <span class="text-accent font-semibold">Prize: <?php echo htmlspecialchars($event['prize']); ?></span>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <?php if (isLoggedIn()): ?>
                                        <?php if ($event['participants'] < $event['max_participants']): ?>
                                            <button class="flex-1 bg-primary text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                                Join Event
                                            </button>
                                        <?php else: ?>
                                            <button class="flex-1 bg-gray-400 text-white px-4 py-2 rounded-lg font-semibold cursor-not-allowed" disabled>
                                                Event Full
                                            </button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="/register.php" class="flex-1 bg-primary text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors text-center">
                                            Sign Up to Join
                                        </a>
                                    <?php endif; ?>
                                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                                        Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
                    <div class="p-8 text-center">
                        <i data-lucide="calendar" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Upcoming Events</h3>
                        <p class="text-gray-600">Check back soon for new racing events and championships.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Event Types Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Event Types</h2>
                <p class="text-xl text-gray-600">Different types of racing events we host</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6 bg-white rounded-lg shadow-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="zap" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Hotlap Challenges</h3>
                    <p class="text-gray-600 text-sm">Compete for the fastest single lap time with prizes for the top performers.</p>
                </div>
                
                <div class="text-center p-6 bg-white rounded-lg shadow-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="trophy" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Championships</h3>
                    <p class="text-gray-600 text-sm">Multi-round racing series with points and season-long prizes.</p>
                </div>
                
                <div class="text-center p-6 bg-white rounded-lg shadow-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="clock" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Endurance Races</h3>
                    <p class="text-gray-600 text-sm">Long-distance races testing both speed and consistency over extended periods.</p>
                </div>
                
                <div class="text-center p-6 bg-white rounded-lg shadow-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="users" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Team Events</h3>
                    <p class="text-gray-600 text-sm">Collaborative racing events where teams work together to achieve victory.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Past Events Section -->
    <?php if (!empty($pastEvents)): ?>
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Recent Results</h2>
                <p class="text-xl text-gray-600">Results from our recent racing events</p>
            </div>
            
            <div class="space-y-6">
                <?php foreach ($pastEvents as $event): ?>
                    <div class="bg-gray-50 rounded-lg p-6 fade-in">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="mb-4 md:mb-0">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2"><?php echo htmlspecialchars($event['title']); ?></h3>
                                <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                    <span><?php echo date('M j, Y', strtotime($event['event_date'])); ?></span>
                                    <span><?php echo htmlspecialchars($event['simulator']); ?></span>
                                    <span><?php echo htmlspecialchars($event['track']); ?></span>
                                    <span><?php echo htmlspecialchars($event['category']); ?></span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500 mb-1">Participants</div>
                                <div class="text-lg font-semibold text-gray-900"><?php echo $event['participants']; ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- How to Participate Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">How to Participate</h2>
                <p class="text-xl text-gray-600">Join our racing events in a few simple steps</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-white rounded-lg shadow-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-white">1</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Create Account</h3>
                    <p class="text-gray-600">Sign up for a free account to access all our racing events and features.</p>
                </div>
                
                <div class="text-center p-6 bg-white rounded-lg shadow-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-white">2</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Join Event</h3>
                    <p class="text-gray-600">Browse upcoming events and join the ones that interest you.</p>
                </div>
                
                <div class="text-center p-6 bg-white rounded-lg shadow-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-white">3</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Compete & Win</h3>
                    <p class="text-gray-600">Show up on event day and compete for prizes and glory!</p>
                </div>
            </div>
            
            <?php if (!isLoggedIn()): ?>
                <div class="text-center mt-8">
                    <a href="/register.php" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Sign Up to Participate
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Race?</h2>
            <p class="text-xl mb-8 text-gray-200">Join our community of racing enthusiasts and compete in exciting events</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php if (isLoggedIn()): ?>
                    <a href="/booking.php" class="bg-accent text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-red-600 transition-colors">
                        Book Training Session
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