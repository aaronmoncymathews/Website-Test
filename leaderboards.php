<?php
$pageTitle = 'Leaderboards';
$pageDescription = 'View racing leaderboards and track your performance across different simulators, tracks, and vehicle categories at FluxTerra Simworks.';

require_once 'includes/header.php';
require_once 'includes/db.php';

// Get filter parameters
$selectedSim = $_GET['sim'] ?? '';
$selectedCategory = $_GET['category'] ?? '';
$selectedTrack = $_GET['track'] ?? '';

// Get all sims for filter dropdown
$sims = getActiveSims($pdo);

// Get tracks and categories based on selected sim
$tracks = [];
$categories = [];
if ($selectedSim) {
    $simId = null;
    foreach ($sims as $sim) {
        if ($sim['name'] === $selectedSim) {
            $simId = $sim['id'];
            break;
        }
    }
    if ($simId) {
        $tracks = getTracksBySim($pdo, $simId);
        $categories = getVehicleClassesBySim($pdo, $simId);
    }
}

// Get leaderboard data if all filters are selected
$leaderboard = [];
$userContext = null;
if ($selectedSim && $selectedCategory && $selectedTrack) {
    $leaderboard = getLeaderboard($pdo, $selectedSim, $selectedCategory, $selectedTrack, 5);
    
    // Get user context if logged in
    if (isLoggedIn()) {
        $userContext = getUserContext($pdo, $_SESSION['user_id'], $selectedSim, $selectedCategory, $selectedTrack);
    }
}
?>

<main>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary to-blue-800 text-white">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 fade-in">Leaderboards</h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-200 fade-in">
                    Compete with the best and track your performance
                </p>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="py-8 bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="sim" class="block text-sm font-medium text-gray-700 mb-2">Simulator</label>
                    <select id="sim" name="sim" onchange="this.form.submit()" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                        <option value="">Select Simulator</option>
                        <?php foreach ($sims as $sim): ?>
                            <option value="<?php echo htmlspecialchars($sim['name']); ?>" 
                                    <?php echo $selectedSim === $sim['name'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($sim['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="category" name="category" onchange="this.form.submit()" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
                            <?php echo empty($categories) ? 'disabled' : ''; ?>>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['name']); ?>" 
                                    <?php echo $selectedCategory === $category['name'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="track" class="block text-sm font-medium text-gray-700 mb-2">Track</label>
                    <select id="track" name="track" onchange="this.form.submit()" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
                            <?php echo empty($tracks) ? 'disabled' : ''; ?>>
                        <option value="">Select Track</option>
                        <?php foreach ($tracks as $track): ?>
                            <option value="<?php echo htmlspecialchars($track['name']); ?>" 
                                    <?php echo $selectedTrack === $track['name'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($track['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
    </section>

    <!-- Leaderboard Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php if ($selectedSim && $selectedCategory && $selectedTrack): ?>
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">
                        <?php echo htmlspecialchars($selectedSim); ?> - <?php echo htmlspecialchars($selectedCategory); ?> - <?php echo htmlspecialchars($selectedTrack); ?>
                    </h2>
                    <p class="text-gray-600">Top 5 fastest lap times</p>
                </div>

                <?php if (!empty($leaderboard)): ?>
                    <!-- Top 5 Leaderboard -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 fade-in">
                        <div class="px-6 py-4 bg-primary text-white">
                            <h3 class="text-xl font-semibold">Top 5 Leaderboard</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Driver</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Best Time</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gap to Leader</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php 
                                    $leaderTime = null;
                                    foreach ($leaderboard as $index => $entry): 
                                        if ($index === 0) $leaderTime = $entry['best_time'];
                                        $gap = $index === 0 ? '-' : calculateTimeGap($leaderTime, $entry['best_time']);
                                    ?>
                                        <tr class="<?php echo $index < 3 ? 'bg-yellow-50' : ''; ?>">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <?php if ($index === 0): ?>
                                                        <i data-lucide="trophy" class="w-5 h-5 text-yellow-500 mr-2"></i>
                                                    <?php elseif ($index === 1): ?>
                                                        <i data-lucide="medal" class="w-5 h-5 text-gray-400 mr-2"></i>
                                                    <?php elseif ($index === 2): ?>
                                                        <i data-lucide="award" class="w-5 h-5 text-orange-500 mr-2"></i>
                                                    <?php endif; ?>
                                                    <span class="text-sm font-medium text-gray-900"><?php echo $index + 1; ?></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($entry['username']); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-mono text-gray-900"><?php echo $entry['best_time']; ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500"><?php echo $gap; ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500"><?php echo date('M j, Y', strtotime($entry['recorded_date'])); ?></div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- User Context (if logged in) -->
                    <?php if ($userContext && $userContext['user']): ?>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
                            <div class="px-6 py-4 bg-accent text-white">
                                <h3 class="text-xl font-semibold">Your Performance</h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Person Before -->
                                    <?php if (isset($userContext['before'])): ?>
                                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                                            <div class="text-sm text-gray-500 mb-1">Position <?php echo $userContext['user']['rank'] - 1; ?></div>
                                            <div class="font-semibold text-gray-900"><?php echo htmlspecialchars($userContext['before']['username']); ?></div>
                                            <div class="text-sm font-mono text-gray-600"><?php echo $userContext['before']['best_time']; ?></div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Current User -->
                                    <div class="text-center p-4 bg-primary text-white rounded-lg">
                                        <div class="text-sm mb-1">Your Position</div>
                                        <div class="text-2xl font-bold"><?php echo $userContext['user']['rank']; ?></div>
                                        <div class="font-semibold"><?php echo htmlspecialchars($userContext['user']['username']); ?></div>
                                        <div class="text-sm font-mono"><?php echo $userContext['user']['best_time']; ?></div>
                                    </div>
                                    
                                    <!-- Person After -->
                                    <?php if (isset($userContext['after'])): ?>
                                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                                            <div class="text-sm text-gray-500 mb-1">Position <?php echo $userContext['user']['rank'] + 1; ?></div>
                                            <div class="font-semibold text-gray-900"><?php echo htmlspecialchars($userContext['after']['username']); ?></div>
                                            <div class="text-sm font-mono text-gray-600"><?php echo $userContext['after']['best_time']; ?></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mt-6 text-center">
                                    <p class="text-gray-600">
                                        You recorded this time on <?php echo date('M j, Y', strtotime($userContext['user']['recorded_date'])); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php elseif (isLoggedIn()): ?>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
                            <div class="px-6 py-4 bg-gray-500 text-white">
                                <h3 class="text-xl font-semibold">Your Performance</h3>
                            </div>
                            <div class="p-6 text-center">
                                <p class="text-gray-600 mb-4">You haven't recorded a lap time for this combination yet.</p>
                                <a href="/booking.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                    Book a Session to Set Your Time
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
                        <div class="p-8 text-center">
                            <i data-lucide="clock" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Times Recorded</h3>
                            <p class="text-gray-600">No lap times have been recorded for this combination yet.</p>
                            <?php if (isLoggedIn()): ?>
                                <a href="/booking.php" class="mt-4 inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                    Be the First to Set a Time
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
                    <div class="p-8 text-center">
                        <i data-lucide="filter" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Select Filters</h3>
                        <p class="text-gray-600">Choose a simulator, category, and track to view the leaderboard.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- How to Participate Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">How to Participate</h2>
                <p class="text-xl text-gray-600">Get your times on the leaderboard</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-gray-50 rounded-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="calendar" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">1. Book a Session</h3>
                    <p class="text-gray-600">Book a racing session and choose your preferred simulator, track, and vehicle.</p>
                </div>
                
                <div class="text-center p-6 bg-gray-50 rounded-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="zap" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">2. Drive Your Best</h3>
                    <p class="text-gray-600">Push yourself to achieve the fastest lap time possible during your session.</p>
                </div>
                
                <div class="text-center p-6 bg-gray-50 rounded-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="trophy" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">3. See Your Rank</h3>
                    <p class="text-gray-600">Your best lap time will be automatically recorded and appear on the leaderboard.</p>
                </div>
            </div>
            
            <?php if (!isLoggedIn()): ?>
                <div class="text-center mt-8">
                    <a href="/register.php" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Sign Up to Compete
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
// Helper function to calculate time gap
function calculateTimeGap($leaderTime, $currentTime) {
    $leader = strtotime($leaderTime);
    $current = strtotime($currentTime);
    $gap = $current - $leader;
    
    if ($gap < 0) return '-';
    
    $minutes = floor($gap / 60);
    $seconds = $gap % 60;
    $milliseconds = ($gap - floor($gap)) * 1000;
    
    if ($minutes > 0) {
        return sprintf('+%d:%02d.%03d', $minutes, $seconds, $milliseconds);
    } else {
        return sprintf('+%02d.%03d', $seconds, $milliseconds);
    }
}

require_once 'includes/footer.php'; 
?>