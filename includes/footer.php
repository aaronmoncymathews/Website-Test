    <!-- Footer -->
    <footer class="bg-primary text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <i data-lucide="zap" class="w-8 h-8"></i>
                        <span class="text-xl font-bold">FluxTerra Simworks</span>
                    </div>
                    <p class="text-gray-300 mb-4">
                        Professional racing simulation center offering high-end simulators, 
                        competitive events, and expert training for racing enthusiasts.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i data-lucide="facebook" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i data-lucide="twitter" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i data-lucide="instagram" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i data-lucide="youtube" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="/index.php" class="text-gray-300 hover:text-white transition-colors">Home</a></li>
                        <li><a href="/about.php" class="text-gray-300 hover:text-white transition-colors">About</a></li>
                        <li><a href="/services.php" class="text-gray-300 hover:text-white transition-colors">Services</a></li>
                        <li><a href="/leaderboards.php" class="text-gray-300 hover:text-white transition-colors">Leaderboards</a></li>
                        <li><a href="/events.php" class="text-gray-300 hover:text-white transition-colors">Events</a></li>
                        <li><a href="/contact.php" class="text-gray-300 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Info</h3>
                    <div class="space-y-2 text-gray-300">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            <span>123 Racing Street, Speed City, SC 12345</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                            <span>+1 (555) 123-4567</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            <span>info@fluxterra.com</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                            <span>Mon-Sun: 9AM-10PM</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; <?php echo date('Y'); ?> FluxTerra Simworks. All rights reserved.</p>
                <p class="mt-2 text-sm">
                    <a href="/privacy.php" class="hover:text-white transition-colors">Privacy Policy</a> | 
                    <a href="/terms.php" class="hover:text-white transition-colors">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Add fade-in animation to elements
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                            entry.target.style.transition = 'opacity 0.5s ease-in, transform 0.5s ease-in';
                        }
                    });
                });
                
                observer.observe(element);
            });
        });
    </script>
</body>
</html>