<?php
$pageTitle = 'Contact Us';
$pageDescription = 'Get in touch with FluxTerra Simworks. Contact us for bookings, training, events, or any questions about our racing simulation services.';

require_once 'includes/header.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $subject = sanitizeInput($_POST['subject'] ?? '');
    $message = sanitizeInput($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'Please fill in all fields.';
    } elseif (!validateEmail($email)) {
        $error = 'Please enter a valid email address.';
    } else {
        // In a real application, you would send an email here
        // For now, we'll just show a success message
        $success = 'Thank you for your message! We will get back to you soon.';
    }
}
?>

<main>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary to-blue-800 text-white">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 fade-in">Contact Us</h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-200 fade-in">
                    Get in touch with our team
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Form and Info Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="fade-in">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                    
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
                    
                    <form method="POST" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                <input type="text" id="name" name="name" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
                                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" id="email" name="email" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
                                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                            </div>
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
                                   value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>">
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="6" required 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-primary text-white px-6 py-3 rounded-md font-semibold hover:bg-blue-700 transition-colors">
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="fade-in">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Get in Touch</h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                                <i data-lucide="map-pin" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Address</h3>
                                <p class="text-gray-600">
                                    123 Racing Street<br>
                                    Speed City, SC 12345<br>
                                    United States
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                                <i data-lucide="phone" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Phone</h3>
                                <p class="text-gray-600">+1 (555) 123-4567</p>
                                <p class="text-gray-600">+1 (555) 123-4568</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                                <i data-lucide="mail" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Email</h3>
                                <p class="text-gray-600">info@fluxterra.com</p>
                                <p class="text-gray-600">bookings@fluxterra.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                                <i data-lucide="clock" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Hours</h3>
                                <div class="text-gray-600 space-y-1">
                                    <p>Monday - Friday: 9:00 AM - 10:00 PM</p>
                                    <p>Saturday: 8:00 AM - 11:00 PM</p>
                                    <p>Sunday: 10:00 AM - 9:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Media -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Follow Us</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition-colors">
                                <i data-lucide="facebook" class="w-5 h-5"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition-colors">
                                <i data-lucide="twitter" class="w-5 h-5"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition-colors">
                                <i data-lucide="instagram" class="w-5 h-5"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition-colors">
                                <i data-lucide="youtube" class="w-5 h-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Find Us</h2>
                <p class="text-xl text-gray-600">Visit our racing simulation center</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="h-96 bg-gray-200 flex items-center justify-center">
                    <div class="text-center">
                        <i data-lucide="map" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                        <p class="text-gray-600">Interactive map would be embedded here</p>
                        <p class="text-sm text-gray-500 mt-2">123 Racing Street, Speed City, SC 12345</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-xl text-gray-600">Common questions about our services</p>
            </div>
            
            <div class="max-w-3xl mx-auto space-y-6">
                <div class="bg-gray-50 rounded-lg p-6 fade-in">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Do I need experience to use the simulators?</h3>
                    <p class="text-gray-600">No experience is required! Our staff will provide guidance and assistance to help you get started, regardless of your skill level.</p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6 fade-in">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">How far in advance should I book?</h3>
                    <p class="text-gray-600">We recommend booking at least 24 hours in advance, especially for weekend sessions. Popular time slots can fill up quickly.</p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6 fade-in">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What should I bring?</h3>
                    <p class="text-gray-600">Just bring yourself! We provide all necessary equipment including racing suits, helmets, and gloves. Comfortable clothing is recommended.</p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6 fade-in">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I cancel or reschedule my booking?</h3>
                    <p class="text-gray-600">Yes, you can cancel or reschedule your booking up to 2 hours before your session. Please contact us to make changes.</p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6 fade-in">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Do you offer group bookings?</h3>
                    <p class="text-gray-600">Absolutely! We offer group packages for parties, corporate events, and team building activities. Contact us for special rates.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>