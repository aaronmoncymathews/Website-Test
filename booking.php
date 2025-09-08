<?php
$pageTitle = 'Book Session';
$pageDescription = 'Book your racing simulation session at FluxTerra Simworks. Choose from various simulators, tracks, and vehicles for the ultimate racing experience.';

require_once 'includes/header.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

// Require login for booking
requireLogin();

$currentUser = getCurrentUser();
$error = '';
$success = '';

// Get available sims
$sims = getActiveSims($pdo);

// Initialize variables
$selectedSim = '';
$selectedTrack = '';
$selectedCategory = '';
$selectedCar = '';
$tracks = [];
$categories = [];
$cars = [];

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'select_sim':
                $selectedSim = sanitizeInput($_POST['sim']);
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
                break;
                
            case 'select_track':
                $selectedSim = sanitizeInput($_POST['sim']);
                $selectedTrack = sanitizeInput($_POST['track']);
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
                break;
                
            case 'select_category':
                $selectedSim = sanitizeInput($_POST['sim']);
                $selectedTrack = sanitizeInput($_POST['track']);
                $selectedCategory = sanitizeInput($_POST['category']);
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
                        
                        if ($selectedCategory) {
                            $classId = null;
                            foreach ($categories as $category) {
                                if ($category['name'] === $selectedCategory) {
                                    $classId = $category['id'];
                                    break;
                                }
                            }
                            if ($classId) {
                                $cars = getCarsByClass($pdo, $classId);
                            }
                        }
                    }
                }
                break;
                
            case 'select_car':
                $selectedSim = sanitizeInput($_POST['sim']);
                $selectedTrack = sanitizeInput($_POST['track']);
                $selectedCategory = sanitizeInput($_POST['category']);
                $selectedCar = sanitizeInput($_POST['car']);
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
                        
                        if ($selectedCategory) {
                            $classId = null;
                            foreach ($categories as $category) {
                                if ($category['name'] === $selectedCategory) {
                                    $classId = $category['id'];
                                    break;
                                }
                            }
                            if ($classId) {
                                $cars = getCarsByClass($pdo, $classId);
                            }
                        }
                    }
                }
                break;
                
            case 'confirm_booking':
                $simulator = sanitizeInput($_POST['simulator']);
                $track = sanitizeInput($_POST['track']);
                $car = sanitizeInput($_POST['car']);
                $sessionType = sanitizeInput($_POST['session_type']);
                $bookingDate = sanitizeInput($_POST['booking_date']);
                $startTime = sanitizeInput($_POST['start_time']);
                $duration = (int)$_POST['duration'];
                $assistanceServices = $_POST['assistance_services'] ?? [];
                
                // Calculate total cost
                $baseCost = 0;
                switch ($sessionType) {
                    case 'Practice':
                        $baseCost = 25;
                        break;
                    case 'Hotlap':
                        $baseCost = 35;
                        break;
                    case 'Race':
                        $baseCost = 45;
                        break;
                }
                
                $totalCost = $baseCost * ($duration / 60); // Convert minutes to hours
                
                // Add assistance services cost
                $assistanceCost = 0;
                foreach ($assistanceServices as $service) {
                    switch ($service) {
                        case 'coaching':
                            $assistanceCost += 15;
                            break;
                        case 'video_analysis':
                            $assistanceCost += 10;
                            break;
                        case 'setup_help':
                            $assistanceCost += 5;
                            break;
                    }
                }
                $totalCost += $assistanceCost;
                
                // Insert booking
                $stmt = $pdo->prepare("
                    INSERT INTO bookings (user_id, simulator, track, car, session_type, booking_date, start_time, duration, assistance_services, total_cost) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                
                if ($stmt->execute([
                    $currentUser['id'],
                    $simulator,
                    $track,
                    $car,
                    $sessionType,
                    $bookingDate,
                    $startTime,
                    $duration,
                    json_encode($assistanceServices),
                    $totalCost
                ])) {
                    // Update user hours driven
                    $stmt = $pdo->prepare("UPDATE users SET hours_driven = hours_driven + ? WHERE id = ?");
                    $stmt->execute([$duration / 60, $currentUser['id']]);
                    
                    $success = 'Booking confirmed! Your session has been scheduled.';
                } else {
                    $error = 'Failed to create booking. Please try again.';
                }
                break;
        }
    }
}
?>

<main>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary to-blue-800 text-white">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 fade-in">Book Your Session</h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-200 fade-in">
                    Choose your racing experience
                </p>
            </div>
        </div>
    </section>

    <!-- Booking Form Section -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php if ($error): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md mb-6">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md mb-6">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>
            
            <div class="bg-gray-50 rounded-lg p-8 fade-in">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Session Configuration</h2>
                
                <!-- Step 1: Select Simulator -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">1. Choose Simulator</h3>
                    <form method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <input type="hidden" name="action" value="select_sim">
                        <?php foreach ($sims as $sim): ?>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="sim" value="<?php echo htmlspecialchars($sim['name']); ?>" 
                                       class="sr-only" <?php echo $selectedSim === $sim['name'] ? 'checked' : ''; ?>
                                       onchange="this.form.submit()">
                                <div class="border-2 rounded-lg p-4 text-center transition-all <?php echo $selectedSim === $sim['name'] ? 'border-primary bg-blue-50' : 'border-gray-300 hover:border-gray-400'; ?>">
                                    <i data-lucide="monitor" class="w-8 h-8 mx-auto mb-2 text-primary"></i>
                                    <div class="font-semibold"><?php echo htmlspecialchars($sim['name']); ?></div>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </form>
                </div>
                
                <?php if ($selectedSim && !empty($tracks)): ?>
                <!-- Step 2: Select Track -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">2. Choose Track</h3>
                    <form method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <input type="hidden" name="action" value="select_track">
                        <input type="hidden" name="sim" value="<?php echo htmlspecialchars($selectedSim); ?>">
                        <?php foreach ($tracks as $track): ?>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="track" value="<?php echo htmlspecialchars($track['name']); ?>" 
                                       class="sr-only" <?php echo $selectedTrack === $track['name'] ? 'checked' : ''; ?>
                                       onchange="this.form.submit()">
                                <div class="border-2 rounded-lg p-4 text-center transition-all <?php echo $selectedTrack === $track['name'] ? 'border-primary bg-blue-50' : 'border-gray-300 hover:border-gray-400'; ?>">
                                    <?php if ($track['preview_url']): ?>
                                        <img src="<?php echo htmlspecialchars($track['preview_url']); ?>" 
                                             alt="<?php echo htmlspecialchars($track['name']); ?>" 
                                             class="w-full h-24 object-cover rounded mb-2">
                                    <?php endif; ?>
                                    <div class="font-semibold"><?php echo htmlspecialchars($track['name']); ?></div>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </form>
                </div>
                <?php endif; ?>
                
                <?php if ($selectedSim && $selectedTrack && !empty($categories)): ?>
                <!-- Step 3: Select Vehicle Category -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">3. Choose Vehicle Category</h3>
                    <form method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <input type="hidden" name="action" value="select_category">
                        <input type="hidden" name="sim" value="<?php echo htmlspecialchars($selectedSim); ?>">
                        <input type="hidden" name="track" value="<?php echo htmlspecialchars($selectedTrack); ?>">
                        <?php foreach ($categories as $category): ?>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="category" value="<?php echo htmlspecialchars($category['name']); ?>" 
                                       class="sr-only" <?php echo $selectedCategory === $category['name'] ? 'checked' : ''; ?>
                                       onchange="this.form.submit()">
                                <div class="border-2 rounded-lg p-4 text-center transition-all <?php echo $selectedCategory === $category['name'] ? 'border-primary bg-blue-50' : 'border-gray-300 hover:border-gray-400'; ?>">
                                    <i data-lucide="car" class="w-8 h-8 mx-auto mb-2 text-primary"></i>
                                    <div class="font-semibold"><?php echo htmlspecialchars($category['name']); ?></div>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </form>
                </div>
                <?php endif; ?>
                
                <?php if ($selectedSim && $selectedTrack && $selectedCategory && !empty($cars)): ?>
                <!-- Step 4: Select Car -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">4. Choose Car</h3>
                    <form method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <input type="hidden" name="action" value="select_car">
                        <input type="hidden" name="sim" value="<?php echo htmlspecialchars($selectedSim); ?>">
                        <input type="hidden" name="track" value="<?php echo htmlspecialchars($selectedTrack); ?>">
                        <input type="hidden" name="category" value="<?php echo htmlspecialchars($selectedCategory); ?>">
                        <?php foreach ($cars as $car): ?>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="car" value="<?php echo htmlspecialchars($car['name']); ?>" 
                                       class="sr-only" <?php echo $selectedCar === $car['name'] ? 'checked' : ''; ?>
                                       onchange="this.form.submit()">
                                <div class="border-2 rounded-lg p-4 text-center transition-all <?php echo $selectedCar === $car['name'] ? 'border-primary bg-blue-50' : 'border-gray-300 hover:border-gray-400'; ?>">
                                    <?php if ($car['preview_url']): ?>
                                        <img src="<?php echo htmlspecialchars($car['preview_url']); ?>" 
                                             alt="<?php echo htmlspecialchars($car['name']); ?>" 
                                             class="w-full h-24 object-cover rounded mb-2">
                                    <?php endif; ?>
                                    <div class="font-semibold"><?php echo htmlspecialchars($car['name']); ?></div>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </form>
                </div>
                <?php endif; ?>
                
                <?php if ($selectedSim && $selectedTrack && $selectedCategory && $selectedCar): ?>
                <!-- Step 5: Session Details -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">5. Session Details</h3>
                    <form method="POST" class="space-y-6">
                        <input type="hidden" name="action" value="confirm_booking">
                        <input type="hidden" name="simulator" value="<?php echo htmlspecialchars($selectedSim); ?>">
                        <input type="hidden" name="track" value="<?php echo htmlspecialchars($selectedTrack); ?>">
                        <input type="hidden" name="car" value="<?php echo htmlspecialchars($selectedCar); ?>">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Session Type</label>
                                <select name="session_type" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                                    <option value="">Select Session Type</option>
                                    <option value="Practice">Practice - $25/hour</option>
                                    <option value="Hotlap">Hotlap - $35/hour</option>
                                    <option value="Race">Race - $45/hour</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                                <select name="duration" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                                    <option value="">Select Duration</option>
                                    <option value="60">1 Hour</option>
                                    <option value="90">1.5 Hours</option>
                                    <option value="120">2 Hours</option>
                                    <option value="180">3 Hours</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Booking Date</label>
                                <input type="date" name="booking_date" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
                                       min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                                <select name="start_time" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                                    <option value="">Select Time</option>
                                    <?php for ($hour = 9; $hour <= 21; $hour++): ?>
                                        <option value="<?php echo sprintf('%02d:00', $hour); ?>"><?php echo sprintf('%02d:00', $hour); ?></option>
                                        <option value="<?php echo sprintf('%02d:30', $hour); ?>"><?php echo sprintf('%02d:30', $hour); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assistance Services (Optional)</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="assistance_services[]" value="coaching" class="mr-2">
                                    <span>Professional Coaching (+$15)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="assistance_services[]" value="video_analysis" class="mr-2">
                                    <span>Video Analysis (+$10)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="assistance_services[]" value="setup_help" class="mr-2">
                                    <span>Setup Help (+$5)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="bg-primary text-white p-4 rounded-lg">
                            <h4 class="font-semibold mb-2">Session Summary</h4>
                            <div class="text-sm space-y-1">
                                <div>Simulator: <?php echo htmlspecialchars($selectedSim); ?></div>
                                <div>Track: <?php echo htmlspecialchars($selectedTrack); ?></div>
                                <div>Category: <?php echo htmlspecialchars($selectedCategory); ?></div>
                                <div>Car: <?php echo htmlspecialchars($selectedCar); ?></div>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-accent text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-600 transition-colors">
                            Confirm Booking
                        </button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Pricing Information -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Session Pricing</h2>
                <p class="text-xl text-gray-600">Transparent pricing for all our services</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-lg p-6 text-center fade-in">
                    <h3 class="text-xl font-semibold mb-2">Practice Session</h3>
                    <div class="text-3xl font-bold text-primary mb-4">$25<span class="text-lg text-gray-600">/hour</span></div>
                    <ul class="text-gray-600 space-y-2">
                        <li>Full simulator access</li>
                        <li>Track and vehicle selection</li>
                        <li>Basic assistance</li>
                        <li>Performance tracking</li>
                    </ul>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg p-6 text-center fade-in border-2 border-primary">
                    <div class="bg-primary text-white px-3 py-1 rounded-full text-sm font-semibold mb-4 inline-block">Most Popular</div>
                    <h3 class="text-xl font-semibold mb-2">Hotlap Session</h3>
                    <div class="text-3xl font-bold text-primary mb-4">$35<span class="text-lg text-gray-600">/hour</span></div>
                    <ul class="text-gray-600 space-y-2">
                        <li>Everything in Practice</li>
                        <li>Performance analysis</li>
                        <li>Expert tips and feedback</li>
                        <li>Leaderboard tracking</li>
                    </ul>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg p-6 text-center fade-in">
                    <h3 class="text-xl font-semibold mb-2">Race Session</h3>
                    <div class="text-3xl font-bold text-primary mb-4">$45<span class="text-lg text-gray-600">/hour</span></div>
                    <ul class="text-gray-600 space-y-2">
                        <li>Everything in Hotlap</li>
                        <li>Multi-player racing</li>
                        <li>Race strategy coaching</li>
                        <li>Video replay analysis</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>