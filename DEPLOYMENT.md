# FluxTerra Simworks - Hostinger Deployment Guide

This guide provides step-by-step instructions for deploying the FluxTerra Simworks application on Hostinger hosting.

## Prerequisites

- Hostinger hosting account with PHP 7.4+ support
- MySQL database access
- File Manager or FTP access
- Domain name configured

## Step 1: Prepare Your Hosting Environment

### 1.1 Check PHP Version
1. Log into your Hostinger control panel
2. Go to "Advanced" → "PHP Configuration"
3. Ensure PHP version is 7.4 or higher
4. Enable required PHP extensions:
   - PDO
   - PDO_MySQL
   - OpenSSL
   - cURL
   - JSON

### 1.2 Create Database
1. Go to "Databases" → "MySQL Databases"
2. Create a new database named `fluxterra`
3. Create a database user with a strong password
4. Assign the user to the database with all privileges

## Step 2: Upload Files

### 2.1 Via File Manager
1. Go to "File Manager" in your control panel
2. Navigate to `public_html` (or your domain's root directory)
3. Upload all project files maintaining the directory structure
4. Ensure all files are uploaded correctly

### 2.2 Via FTP (Alternative)
1. Use an FTP client like FileZilla
2. Connect to your hosting account
3. Upload files to the `public_html` directory
4. Maintain the exact directory structure

## Step 3: Database Setup

### 3.1 Import Database Schema
1. Go to "Databases" → "phpMyAdmin"
2. Select your `fluxterra` database
3. Click "Import" tab
4. Choose the `setup.sql` file from your project
5. Click "Go" to import the schema

### 3.2 Verify Database Import
1. Check that all tables are created:
   - users
   - licenses
   - bookings
   - events
   - friends
   - lap_times
   - sims
   - tracks
   - vehicle_classes
   - cars
2. Verify the default admin user is created

## Step 4: Configure Database Connection

### 4.1 Update Database Credentials
Edit `includes/db.php` with your Hostinger database details:

```php
<?php
$host = 'localhost'; // Usually localhost on Hostinger
$dbname = 'your_hostinger_username_fluxterra';
$username = 'your_hostinger_username_dbuser';
$password = 'your_database_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec("SET NAMES utf8mb4");
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
```

**Important**: Replace the placeholder values with your actual Hostinger database credentials.

## Step 5: Install Composer Dependencies

### 5.1 Via Hostinger Terminal (if available)
1. Go to "Advanced" → "Terminal"
2. Navigate to your project directory:
   ```bash
   cd public_html
   ```
3. Install dependencies:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

### 5.2 Manual Upload (Alternative)
1. Install Composer locally on your computer
2. Run `composer install` in your local project directory
3. Upload the generated `vendor` folder to your hosting account

## Step 6: Google Calendar API Setup (Optional)

### 6.1 Create Google Cloud Project
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable the Google Calendar API
4. Create a service account
5. Download the JSON credentials file

### 6.2 Configure Calendar Integration
1. Upload `config/google-credentials.json` to your hosting account
2. **Important**: Place this file outside `public_html` or protect it with `.htaccess`
3. Share your Google Calendar with the service account email
4. Update the calendar ID in `config/google-calendar.php` if needed

## Step 7: Security Configuration

### 7.1 File Permissions
Set appropriate file permissions:
```bash
chmod 644 *.php
chmod 644 includes/*.php
chmod 644 config/*.php
chmod 600 config/google-credentials.json
```

### 7.2 SSL Certificate
1. Go to "SSL" in your Hostinger control panel
2. Enable SSL certificate for your domain
3. Force HTTPS redirects (uncomment lines in `.htaccess`)

### 7.3 Security Headers
The `.htaccess` file includes security headers. Ensure they're working by checking:
- X-Content-Type-Options
- X-Frame-Options
- X-XSS-Protection

## Step 8: Performance Optimization

### 8.1 Enable Caching
1. Go to "Advanced" → "PHP Configuration"
2. Enable OPcache for better performance
3. The `.htaccess` file includes browser caching rules

### 8.2 CDN Integration (Optional)
1. Consider using Hostinger's CDN service
2. Update static asset URLs if using CDN
3. Enable Gzip compression (already configured in `.htaccess`)

## Step 9: Testing and Verification

### 9.1 Basic Functionality Test
1. Visit your domain to ensure the homepage loads
2. Test user registration and login
3. Verify database connections are working
4. Check that all pages load correctly

### 9.2 Admin Panel Test
1. Login with default admin credentials:
   - Email: `admin@fluxterra.com`
   - Password: `admin123`
2. **Important**: Change the default password immediately
3. Test adding/editing content in the admin panel

### 9.3 Booking System Test
1. Create a test user account
2. Try booking a session
3. Verify the booking is saved to the database
4. Test Google Calendar integration (if configured)

## Step 10: Production Configuration

### 10.1 Environment Settings
1. Update any hardcoded URLs to use your domain
2. Configure email settings for notifications
3. Set up proper error logging

### 10.2 Backup Strategy
1. Set up regular database backups
2. Backup uploaded files and configurations
3. Test backup restoration procedures

## Troubleshooting Common Issues

### Database Connection Issues
- Verify database credentials in `includes/db.php`
- Check that the database exists and user has proper permissions
- Ensure MySQL service is running

### File Permission Issues
- Check file permissions are set correctly
- Ensure web server can read all PHP files
- Verify `.htaccess` is not blocking access

### Composer Dependencies
- Ensure all dependencies are installed
- Check PHP version compatibility
- Verify autoloader is working

### Google Calendar API Issues
- Verify credentials file is uploaded correctly
- Check service account permissions
- Ensure calendar is shared with service account

## Post-Deployment Checklist

- [ ] Website loads correctly
- [ ] User registration works
- [ ] Login system functions
- [ ] Database connections established
- [ ] Admin panel accessible
- [ ] Booking system operational
- [ ] Google Calendar integration working (if configured)
- [ ] SSL certificate active
- [ ] Security headers in place
- [ ] Performance optimizations enabled
- [ ] Backup system configured
- [ ] Default admin password changed

## Support and Maintenance

### Regular Maintenance
1. Keep PHP and dependencies updated
2. Monitor database performance
3. Review security logs
4. Backup data regularly

### Monitoring
1. Set up uptime monitoring
2. Monitor error logs
3. Track performance metrics
4. Watch for security issues

## Contact Information

For deployment support:
- Email: support@fluxterra.com
- Documentation: Check README.md for detailed information
- Issues: Report problems through the project repository

## Additional Resources

- [Hostinger Knowledge Base](https://support.hostinger.com/)
- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Google Calendar API Documentation](https://developers.google.com/calendar)

---

**Note**: This deployment guide is specific to Hostinger hosting. For other hosting providers, adapt the instructions accordingly while maintaining the same core setup steps.