<?php
$pageTitle = 'Admin Panel';
$pageDescription = 'Admin panel for managing FluxTerra Simworks content including simulators, tracks, vehicles, and events.';

require_once 'includes/header.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

// Require admin access
requireAdmin();

$currentUser = getCurrentUser();
$error = '';
$success = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_sim':
                $name = sanitizeInput($_POST['name']);
                $description = sanitizeInput($_POST['description']);
                
                if (empty($name)) {
                    $error = 'Simulator name is required.';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO sims (name, description) VALUES (?, ?)");
                    if ($stmt->execute([$name, $description])) {
                        $success = 'Simulator added successfully.';
                    } else {
                        $error = 'Failed to add simulator.';
                    }
                }
                break;
                
            case 'delete_sim':
                $id = (int)$_POST['id'];
                $stmt = $pdo->prepare("UPDATE sims SET is_active = 0 WHERE id = ?");
                if ($stmt->execute([$id])) {
                    $success = 'Simulator deactivated successfully.';
                } else {
                    $error = 'Failed to deactivate simulator.';
                }
                break;
                
            case 'add_track':
                $simId = (int)$_POST['sim_id'];
                $name = sanitizeInput($_POST['name']);
                $previewUrl = sanitizeInput($_POST['preview_url']);
                $description = sanitizeInput($_POST['description']);
                
                if (empty($name) || empty($simId)) {
                    $error = 'Track name and simulator are required.';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO tracks (sim_id, name, preview_url, description) VALUES (?, ?, ?, ?)");
                    if ($stmt->execute([$simId, $name, $previewUrl, $description])) {
                        $success = 'Track added successfully.';
                    } else {
                        $error = 'Failed to add track.';
                    }
                }
                break;
                
            case 'delete_track':
                $id = (int)$_POST['id'];
                $stmt = $pdo->prepare("UPDATE tracks SET is_active = 0 WHERE id = ?");
                if ($stmt->execute([$id])) {
                    $success = 'Track deactivated successfully.';
                } else {
                    $error = 'Failed to deactivate track.';
                }
                break;
                
            case 'add_category':
                $simId = (int)$_POST['sim_id'];
                $name = sanitizeInput($_POST['name']);
                $description = sanitizeInput($_POST['description']);
                
                if (empty($name) || empty($simId)) {
                    $error = 'Category name and simulator are required.';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO vehicle_classes (sim_id, name, description) VALUES (?, ?, ?)");
                    if ($stmt->execute([$simId, $name, $description])) {
                        $success = 'Vehicle category added successfully.';
                    } else {
                        $error = 'Failed to add vehicle category.';
                    }
                }
                break;
                
            case 'delete_category':
                $id = (int)$_POST['id'];
                $stmt = $pdo->prepare("UPDATE vehicle_classes SET is_active = 0 WHERE id = ?");
                if ($stmt->execute([$id])) {
                    $success = 'Vehicle category deactivated successfully.';
                } else {
                    $error = 'Failed to deactivate vehicle category.';
                }
                break;
                
            case 'add_car':
                $classId = (int)$_POST['class_id'];
                $name = sanitizeInput($_POST['name']);
                $previewUrl = sanitizeInput($_POST['preview_url']);
                $description = sanitizeInput($_POST['description']);
                
                if (empty($name) || empty($classId)) {
                    $error = 'Car name and vehicle class are required.';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO cars (class_id, name, preview_url, description) VALUES (?, ?, ?, ?)");
                    if ($stmt->execute([$classId, $name, $previewUrl, $description])) {
                        $success = 'Car added successfully.';
                    } else {
                        $error = 'Failed to add car.';
                    }
                }
                break;
                
            case 'delete_car':
                $id = (int)$_POST['id'];
                $stmt = $pdo->prepare("UPDATE cars SET is_active = 0 WHERE id = ?");
                if ($stmt->execute([$id])) {
                    $success = 'Car deactivated successfully.';
                } else {
                    $error = 'Failed to deactivate car.';
                }
                break;
                
            case 'add_event':
                $title = sanitizeInput($_POST['title']);
                $eventDate = sanitizeInput($_POST['event_date']);
                $eventTime = sanitizeInput($_POST['event_time']);
                $simulator = sanitizeInput($_POST['simulator']);
                $track = sanitizeInput($_POST['track']);
                $category = sanitizeInput($_POST['category']);
                $prize = sanitizeInput($_POST['prize']);
                $maxParticipants = (int)$_POST['max_participants'];
                $description = sanitizeInput($_POST['description']);
                
                if (empty($title) || empty($eventDate) || empty($eventTime)) {
                    $error = 'Event title, date, and time are required.';
                } else {
                    $stmt = $pdo->prepare("
                        INSERT INTO events (title, event_date, event_time, simulator, track, category, prize, max_participants, description) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    if ($stmt->execute([$title, $eventDate, $eventTime, $simulator, $track, $category, $prize, $maxParticipants, $description])) {
                        $success = 'Event added successfully.';
                    } else {
                        $error = 'Failed to add event.';
                    }
                }
                break;
        }
    }
}

// Get all data for display
$sims = getActiveSims($pdo);
$allTracks = $pdo->query("SELECT t.*, s.name as sim_name FROM tracks t JOIN sims s ON t.sim_id = s.id WHERE t.is_active = 1 ORDER BY s.name, t.name")->fetchAll();
$allCategories = $pdo->query("SELECT vc.*, s.name as sim_name FROM vehicle_classes vc JOIN sims s ON vc.sim_id = s.id WHERE vc.is_active = 1 ORDER BY s.name, vc.name")->fetchAll();
$allCars = $pdo->query("SELECT c.*, vc.name as class_name, s.name as sim_name FROM cars c JOIN vehicle_classes vc ON c.class_id = vc.id JOIN sims s ON vc.sim_id = s.id WHERE c.is_active = 1 ORDER BY s.name, vc.name, c.name")->fetchAll();
$events = $pdo->query("SELECT * FROM events ORDER BY event_date DESC LIMIT 10")->fetchAll();
?>

<main>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary to-blue-800 text-white">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 fade-in">Admin Panel</h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-200 fade-in">
                    Manage FluxTerra Simworks content
                </p>
            </div>
        </div>
    </section>

    <!-- Admin Content -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
            
            <!-- Tabs -->
            <div class="border-b border-gray-200 mb-8">
                <nav class="-mb-px flex space-x-8">
                    <button onclick="showTab('simulators')" id="tab-simulators" class="tab-button py-2 px-1 border-b-2 font-medium text-sm border-primary text-primary">
                        Simulators
                    </button>
                    <button onclick="showTab('tracks')" id="tab-tracks" class="tab-button py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Tracks
                    </button>
                    <button onclick="showTab('categories')" id="tab-categories" class="tab-button py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Vehicle Categories
                    </button>
                    <button onclick="showTab('cars')" id="tab-cars" class="tab-button py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Cars
                    </button>
                    <button onclick="showTab('events')" id="tab-events" class="tab-button py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Events
                    </button>
                </nav>
            </div>
            
            <!-- Simulators Tab -->
            <div id="content-simulators" class="tab-content">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Simulators</h2>
                    <button onclick="showAddForm('sim')" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Add Simulator
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($sims as $sim): ?>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($sim['name']); ?></h3>
                            <?php if ($sim['description']): ?>
                                <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars($sim['description']); ?></p>
                            <?php endif; ?>
                            <form method="POST" class="inline">
                                <input type="hidden" name="action" value="delete_sim">
                                <input type="hidden" name="id" value="<?php echo $sim['id']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to deactivate this simulator?')" 
                                        class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition-colors">
                                    Deactivate
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Tracks Tab -->
            <div id="content-tracks" class="tab-content hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Tracks</h2>
                    <button onclick="showAddForm('track')" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Add Track
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($allTracks as $track): ?>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($track['name']); ?></h3>
                            <p class="text-gray-600 text-sm mb-2">Simulator: <?php echo htmlspecialchars($track['sim_name']); ?></p>
                            <?php if ($track['description']): ?>
                                <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars($track['description']); ?></p>
                            <?php endif; ?>
                            <form method="POST" class="inline">
                                <input type="hidden" name="action" value="delete_track">
                                <input type="hidden" name="id" value="<?php echo $track['id']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to deactivate this track?')" 
                                        class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition-colors">
                                    Deactivate
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Vehicle Categories Tab -->
            <div id="content-categories" class="tab-content hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Vehicle Categories</h2>
                    <button onclick="showAddForm('category')" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Add Category
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($allCategories as $category): ?>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($category['name']); ?></h3>
                            <p class="text-gray-600 text-sm mb-2">Simulator: <?php echo htmlspecialchars($category['sim_name']); ?></p>
                            <?php if ($category['description']): ?>
                                <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars($category['description']); ?></p>
                            <?php endif; ?>
                            <form method="POST" class="inline">
                                <input type="hidden" name="action" value="delete_category">
                                <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to deactivate this category?')" 
                                        class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition-colors">
                                    Deactivate
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Cars Tab -->
            <div id="content-cars" class="tab-content hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Cars</h2>
                    <button onclick="showAddForm('car')" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Add Car
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($allCars as $car): ?>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($car['name']); ?></h3>
                            <p class="text-gray-600 text-sm mb-2">Class: <?php echo htmlspecialchars($car['class_name']); ?></p>
                            <p class="text-gray-600 text-sm mb-2">Simulator: <?php echo htmlspecialchars($car['sim_name']); ?></p>
                            <?php if ($car['description']): ?>
                                <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars($car['description']); ?></p>
                            <?php endif; ?>
                            <form method="POST" class="inline">
                                <input type="hidden" name="action" value="delete_car">
                                <input type="hidden" name="id" value="<?php echo $car['id']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to deactivate this car?')" 
                                        class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition-colors">
                                    Deactivate
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Events Tab -->
            <div id="content-events" class="tab-content hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Events</h2>
                    <button onclick="showAddForm('event')" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Add Event
                    </button>
                </div>
                
                <div class="space-y-4">
                    <?php foreach ($events as $event): ?>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($event['title']); ?></h3>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <div>Date: <?php echo date('M j, Y', strtotime($event['event_date'])); ?> at <?php echo date('g:i A', strtotime($event['event_time'])); ?></div>
                                        <div>Simulator: <?php echo htmlspecialchars($event['simulator']); ?> | Track: <?php echo htmlspecialchars($event['track']); ?> | Category: <?php echo htmlspecialchars($event['category']); ?></div>
                                        <div>Participants: <?php echo $event['participants'] . '/' . $event['max_participants']; ?> | Prize: <?php echo htmlspecialchars($event['prize']); ?></div>
                                    </div>
                                </div>
                                <span class="px-2 py-1 rounded text-xs font-semibold <?php echo $event['is_upcoming'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'; ?>">
                                    <?php echo $event['is_upcoming'] ? 'Upcoming' : 'Past'; ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Add Forms Modal -->
<div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900"></h3>
                <button onclick="hideAddForm()" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <div id="modalContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-primary', 'text-primary');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Add active class to selected tab button
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('border-transparent', 'text-gray-500');
    activeButton.classList.add('border-primary', 'text-primary');
}

function showAddForm(type) {
    const modal = document.getElementById('addModal');
    const title = document.getElementById('modalTitle');
    const content = document.getElementById('modalContent');
    
    let formHtml = '';
    
    switch (type) {
        case 'sim':
            title.textContent = 'Add Simulator';
            formHtml = `
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="add_sim">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"></textarea>
                    </div>
                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">Add</button>
                        <button type="button" onclick="hideAddForm()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">Cancel</button>
                    </div>
                </form>
            `;
            break;
            
        case 'track':
            title.textContent = 'Add Track';
            formHtml = `
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="add_track">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Simulator</label>
                        <select name="sim_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                            <option value="">Select Simulator</option>
                            <?php foreach ($sims as $sim): ?>
                                <option value="<?php echo $sim['id']; ?>"><?php echo htmlspecialchars($sim['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preview URL</label>
                        <input type="url" name="preview_url" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"></textarea>
                    </div>
                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">Add</button>
                        <button type="button" onclick="hideAddForm()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">Cancel</button>
                    </div>
                </form>
            `;
            break;
            
        case 'category':
            title.textContent = 'Add Vehicle Category';
            formHtml = `
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="add_category">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Simulator</label>
                        <select name="sim_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                            <option value="">Select Simulator</option>
                            <?php foreach ($sims as $sim): ?>
                                <option value="<?php echo $sim['id']; ?>"><?php echo htmlspecialchars($sim['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"></textarea>
                    </div>
                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">Add</button>
                        <button type="button" onclick="hideAddForm()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">Cancel</button>
                    </div>
                </form>
            `;
            break;
            
        case 'car':
            title.textContent = 'Add Car';
            formHtml = `
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="add_car">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Class</label>
                        <select name="class_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                            <option value="">Select Vehicle Class</option>
                            <?php foreach ($allCategories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['sim_name'] . ' - ' . $category['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preview URL</label>
                        <input type="url" name="preview_url" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"></textarea>
                    </div>
                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">Add</button>
                        <button type="button" onclick="hideAddForm()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">Cancel</button>
                    </div>
                </form>
            `;
            break;
            
        case 'event':
            title.textContent = 'Add Event';
            formHtml = `
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="add_event">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" name="event_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                            <input type="time" name="event_time" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Simulator</label>
                        <input type="text" name="simulator" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Track</label>
                        <input type="text" name="track" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <input type="text" name="category" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prize</label>
                        <input type="text" name="prize" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Participants</label>
                        <input type="number" name="max_participants" required min="1" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"></textarea>
                    </div>
                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">Add</button>
                        <button type="button" onclick="hideAddForm()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">Cancel</button>
                    </div>
                </form>
            `;
            break;
    }
    
    content.innerHTML = formHtml;
    modal.classList.remove('hidden');
}

function hideAddForm() {
    document.getElementById('addModal').classList.add('hidden');
}

// Initialize Lucide icons
lucide.createIcons();
</script>

<?php require_once 'includes/footer.php'; ?>