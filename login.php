<?php
$pageTitle = 'Login';
$pageDescription = 'Login to your FluxTerra Simworks account to access booking, leaderboards, and more.';

require_once 'includes/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } elseif (!validateEmail($email)) {
        $error = 'Please enter a valid email address.';
    } else {
        if (login($email, $password)) {
            header('Location: /index.php');
            exit();
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
?>

<main class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="flex justify-center">
                <i data-lucide="zap" class="w-12 h-12 text-primary"></i>
            </div>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">Sign in to your account</h2>
            <p class="mt-2 text-sm text-gray-600">
                Or <a href="/register.php" class="font-medium text-primary hover:text-blue-600">create a new account</a>
            </p>
        </div>
        
        <form class="mt-8 space-y-6" method="POST">
            <?php if ($error): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>
            
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm"
                           placeholder="Enter your email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm"
                           placeholder="Enter your password">
                </div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" 
                           class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                        Remember me
                    </label>
                </div>
                
                <div class="text-sm">
                    <a href="/forgot-password.php" class="font-medium text-primary hover:text-blue-600">
                        Forgot your password?
                    </a>
                </div>
            </div>
            
            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i data-lucide="lock" class="h-5 w-5 text-blue-500 group-hover:text-blue-400"></i>
                    </span>
                    Sign in
                </button>
            </div>
        </form>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>