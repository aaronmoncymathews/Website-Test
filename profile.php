<?php
$pageTitle = 'Profile';
$pageDescription = 'View and manage your FluxTerra Simworks profile, including your racing statistics and booking history.';

require_once 'includes/header.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

// Require login
requireLogin();

$currentUser = getCurrentUser();

// Get user's booking history
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE user_id = ? ORDER BY booking_date DESC, start_time DESC LIMIT 10");
$stmt->execute([$currentUser['id']]);
$bookings = $stmt->fetchAll();

// Get user's lap times
$stmt = $pdo->prepare("SELECT * FROM lap_times WHERE user_id = ? ORDER BY recorded_date DESC LIMIT 10");
$stmt->execute([$currentUser['id']]);
$lapTimes = $stmt->fetchAll();

// Get user's licenses
$stmt = $pdo->prepare("SELECT * FROM licenses WHERE user_id = ? ORDER BY earned DESC");
$stmt->execute([$currentUser['id']]);
$licenses = $stmt->fetchAll();
?>

<main>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary to-blue-800 text-white">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 fade-in">My Profile</h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-200 fade-in">
                    Welcome back, <?php echo htmlspecialchars($currentUser['username']); ?>!
                </p>
            </div>
        </div>
    </section>

    <!-- Profile Stats -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center p-6 bg-gray-50 rounded-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="clock" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2"><?php echo number_format($currentUser['hours_driven'], 1); ?></h3>
                    <p class="text-gray-600">Hours Driven</p>
                </div>
                
                <div class="text-center p-6 bg-gray-50 rounded-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="calendar" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2"><?php echo count($bookings); ?></h3>
                    <p class="text-gray-600">Sessions Booked</p>
                </div>
                
                <div class="text-center p-6 bg-gray-50 rounded-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="trophy" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2"><?php echo count($lapTimes); ?></h3>
                    <p class="text-gray-600">Lap Times Recorded</p>
                </div>
                
                <div class="text-center p-6 bg-gray-50 rounded-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="award" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2"><?php echo count($licenses); ?></h3>
                    <p class="text-gray-600">Licenses Earned</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Bookings -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Recent Bookings</h2>
                <a href="/booking.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Book New Session
                </a>
            </div>
            
            <?php if (!empty($bookings)): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Simulator</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Track</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($bookings as $booking): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900"><?php echo date('M j, Y', strtotime($booking['booking_date'])); ?></div>
                                            <div class="text-sm text-gray-500"><?php echo date('g:i A', strtotime($booking['start_time'])); ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($booking['simulator']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($booking['track']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($booking['car']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($booking['session_type']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $booking['duration']; ?> min</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                <?php 
                                                switch ($booking['status']) {
                                                    case 'confirmed':
                                                        echo 'bg-green-100 text-green-800';
                                                        break;
                                                    case 'completed':
                                                        echo 'bg-blue-100 text-blue-800';
                                                        break;
                                                    case 'cancelled':
                                                        echo 'bg-red-100 text-red-800';
                                                        break;
                                                    default:
                                                        echo 'bg-yellow-100 text-yellow-800';
                                                }
                                                ?>">
                                                <?php echo ucfirst($booking['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <i data-lucide="calendar" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Bookings Yet</h3>
                    <p class="text-gray-600 mb-4">You haven't booked any sessions yet.</p>
                    <a href="/booking.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Book Your First Session
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Recent Lap Times -->
    <?php if (!empty($lapTimes)): ?>
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Recent Lap Times</h2>
                <a href="/leaderboards.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    View Leaderboards
                </a>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Simulator</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Track</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lap Time</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($lapTimes as $lapTime): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo date('M j, Y', strtotime($lapTime['recorded_date'])); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($lapTime['sim']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($lapTime['category']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($lapTime['track']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900"><?php echo $lapTime['lap_time']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Licenses -->
    <?php if (!empty($licenses)): ?>
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Earned Licenses</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($licenses as $license): ?>
                    <div class="bg-white rounded-lg shadow-lg p-6 fade-in">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                                <i data-lucide="award" class="w-6 h-6 text-white"></i>
                            </div>
                            <span class="text-sm text-gray-500"><?php echo date('M Y', strtotime($license['earned'])); ?></span>
                        </div>
                        <h3 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($license['sim']); ?></h3>
                        <p class="text-gray-600 text-sm mb-1">Category: <?php echo htmlspecialchars($license['category']); ?></p>
                        <p class="text-gray-600 text-sm">Track: <?php echo htmlspecialchars($license['track']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php require_once 'includes/footer.php'; ?>