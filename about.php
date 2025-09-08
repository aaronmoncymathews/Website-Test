<?php
$pageTitle = 'About Us';
$pageDescription = 'Learn about FluxTerra Simworks - our mission, team, and commitment to providing the ultimate racing simulation experience.';

require_once 'includes/header.php';
?>

<main>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary to-blue-800 text-white">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 fade-in">About FluxTerra Simworks</h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-200 fade-in">
                    Where passion meets precision in racing simulation
                </p>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="fade-in">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Our Mission</h2>
                    <p class="text-lg text-gray-600 mb-6">
                        At FluxTerra Simworks, we believe that everyone deserves access to professional-grade racing simulation. 
                        Our mission is to provide an authentic, immersive racing experience that bridges the gap between 
                        virtual and real-world motorsport.
                    </p>
                    <p class="text-lg text-gray-600 mb-6">
                        We combine cutting-edge technology with expert knowledge to create an environment where racing 
                        enthusiasts can hone their skills, compete at the highest level, and experience the thrill of 
                        professional motorsport.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/services.php" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors text-center">
                            Our Services
                        </a>
                        <a href="/contact.php" class="border-2 border-primary text-primary px-6 py-3 rounded-lg font-semibold hover:bg-primary hover:text-white transition-colors text-center">
                            Get in Touch
                        </a>
                    </div>
                </div>
                <div class="fade-in">
                    <img src="https://via.placeholder.com/600x400/003366/ffffff?text=Racing+Simulator" 
                         alt="Professional racing simulator" 
                         class="rounded-lg shadow-lg w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Values</h2>
                <p class="text-xl text-gray-600">The principles that drive everything we do</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-white rounded-lg shadow-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="target" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Excellence</h3>
                    <p class="text-gray-600">We strive for excellence in every aspect of our service, from equipment quality to customer experience.</p>
                </div>
                
                <div class="text-center p-6 bg-white rounded-lg shadow-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="heart" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Passion</h3>
                    <p class="text-gray-600">Our love for racing drives us to provide the most authentic and exciting simulation experience possible.</p>
                </div>
                
                <div class="text-center p-6 bg-white rounded-lg shadow-lg fade-in">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="users" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Community</h3>
                    <p class="text-gray-600">We foster a welcoming community where racers of all skill levels can learn, compete, and grow together.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
                <p class="text-xl text-gray-600">The experts behind your racing experience</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-gray-50 rounded-lg fade-in">
                    <img src="https://via.placeholder.com/200x200/003366/ffffff?text=Alex+Chen" 
                         alt="Alex Chen" 
                         class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                    <h3 class="text-xl font-semibold mb-2">Alex Chen</h3>
                    <p class="text-accent font-medium mb-2">Founder & CEO</p>
                    <p class="text-gray-600 text-sm">Former professional racing driver with 15+ years of experience in motorsport and simulation technology.</p>
                </div>
                
                <div class="text-center p-6 bg-gray-50 rounded-lg fade-in">
                    <img src="https://via.placeholder.com/200x200/003366/ffffff?text=Sarah+Johnson" 
                         alt="Sarah Johnson" 
                         class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                    <h3 class="text-xl font-semibold mb-2">Sarah Johnson</h3>
                    <p class="text-accent font-medium mb-2">Head of Training</p>
                    <p class="text-gray-600 text-sm">Certified racing instructor specializing in driver development and performance optimization.</p>
                </div>
                
                <div class="text-center p-6 bg-gray-50 rounded-lg fade-in">
                    <img src="https://via.placeholder.com/200x200/003366/ffffff?text=Mike+Rodriguez" 
                         alt="Mike Rodriguez" 
                         class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                    <h3 class="text-xl font-semibold mb-2">Mike Rodriguez</h3>
                    <p class="text-accent font-medium mb-2">Technical Director</p>
                    <p class="text-gray-600 text-sm">Expert in simulation hardware and software with a passion for creating the most realistic racing experience.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Technology Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="fade-in">
                    <img src="https://via.placeholder.com/600x400/A9A9A9/ffffff?text=Advanced+Technology" 
                         alt="Advanced racing technology" 
                         class="rounded-lg shadow-lg w-full">
                </div>
                <div class="fade-in">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Cutting-Edge Technology</h2>
                    <p class="text-lg text-gray-600 mb-6">
                        We use the latest in racing simulation technology to provide an unparalleled experience. 
                        Our simulators feature high-resolution displays, realistic force feedback systems, and 
                        motion platforms that replicate the feel of real racing.
                    </p>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Professional-grade racing wheels and pedals
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            High-resolution triple monitor setups
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Motion platforms for realistic G-forces
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check" class="w-5 h-5 text-accent mr-3"></i>
                            Latest simulation software and games
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Impact</h2>
                <p class="text-xl text-gray-200">Numbers that speak for themselves</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div class="fade-in">
                    <div class="text-4xl md:text-5xl font-bold text-accent mb-2">500+</div>
                    <div class="text-gray-200">Happy Customers</div>
                </div>
                <div class="fade-in">
                    <div class="text-4xl md:text-5xl font-bold text-accent mb-2">50+</div>
                    <div class="text-gray-200">Racing Events</div>
                </div>
                <div class="fade-in">
                    <div class="text-4xl md:text-5xl font-bold text-accent mb-2">10,000+</div>
                    <div class="text-gray-200">Hours Driven</div>
                </div>
                <div class="fade-in">
                    <div class="text-4xl md:text-5xl font-bold text-accent mb-2">5</div>
                    <div class="text-gray-200">Years Experience</div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>