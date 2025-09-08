# FluxTerra Simworks - Professional Racing Simulation Center

A traditional multi-page web application built with PHP, HTML, CSS (Tailwind), and vanilla JavaScript for a professional racing simulation center.

## Features

- **User Authentication**: Secure login/register system with PHP sessions
- **Session Booking**: Advanced booking system with Google Calendar integration
- **Leaderboards**: Real-time lap time tracking and competitive rankings
- **Admin Panel**: Complete content management for simulators, tracks, and vehicles
- **Events Management**: Racing events and championships
- **Responsive Design**: Mobile-first design with Tailwind CSS
- **Database Integration**: MySQL database with PDO for secure data handling

## Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3 (Tailwind), Vanilla JavaScript
- **Icons**: Lucide Icons
- **Date Picker**: Flatpickr
- **Google APIs**: Calendar API for booking management
- **Package Manager**: Composer

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer
- Web server (Apache/Nginx)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd fluxterra-simworks
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Database Setup**
   - Create a MySQL database named `fluxterra`
   - Import the database schema:
   ```bash
   mysql -u username -p fluxterra < setup.sql
   ```

4. **Configure Database Connection**
   - Edit `includes/db.php` with your database credentials:
   ```php
   $host = 'localhost';
   $dbname = 'fluxterra';
   $username = 'your_username';
   $password = 'your_password';
   ```

5. **Google Calendar API Setup** (Optional)
   - Create a Google Cloud Project
   - Enable the Calendar API
   - Create a service account and download credentials
   - Copy `config/google-credentials.json.example` to `config/google-credentials.json`
   - Add your service account credentials to the file
   - Share your calendar with the service account email

6. **Web Server Configuration**
   - Point your web server document root to the project directory
   - Ensure PHP has write permissions for any upload directories

## Deployment on Hostinger

### Step 1: Prepare Your Files

1. Upload all project files to your Hostinger hosting account
2. Ensure all files are in the `public_html` directory (or your domain's root directory)

### Step 2: Database Setup

1. **Create Database**
   - Log into your Hostinger control panel
   - Go to "Databases" → "MySQL Databases"
   - Create a new database named `fluxterra`
   - Create a database user and assign it to the database

2. **Import Schema**
   - Go to "Databases" → "phpMyAdmin"
   - Select your `fluxterra` database
   - Click "Import" and upload the `setup.sql` file

### Step 3: Configure Database Connection

1. Edit `includes/db.php` with your Hostinger database details:
   ```php
   $host = 'localhost'; // Usually localhost on Hostinger
   $dbname = 'your_hostinger_username_fluxterra';
   $username = 'your_hostinger_username_dbuser';
   $password = 'your_database_password';
   ```

### Step 4: Install Composer Dependencies

1. **Via Hostinger File Manager**
   - Upload the `composer.json` file
   - Use Hostinger's terminal/SSH access to run:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

2. **Alternative: Manual Upload**
   - Download the `vendor` folder from your local development
   - Upload it to your hosting directory

### Step 5: Google Calendar API (Optional)

1. **Upload Credentials**
   - Upload your `config/google-credentials.json` file
   - Ensure the file is not accessible via web browser (outside public_html or with .htaccess protection)

2. **Configure Calendar**
   - Update the calendar ID in `config/google-calendar.php` if needed
   - Share your Google Calendar with the service account email

### Step 6: File Permissions

1. Set appropriate file permissions:
   ```bash
   chmod 644 *.php
   chmod 644 includes/*.php
   chmod 644 config/*.php
   chmod 600 config/google-credentials.json
   ```

### Step 7: SSL and Security

1. **Enable SSL**
   - Activate SSL certificate in Hostinger control panel
   - Force HTTPS redirects in your `.htaccess` file

2. **Security Headers**
   - Add security headers to your `.htaccess` file:
   ```apache
   Header always set X-Content-Type-Options nosniff
   Header always set X-Frame-Options DENY
   Header always set X-XSS-Protection "1; mode=block"
   ```

### Step 8: Performance Optimization

1. **Enable Caching**
   - Enable PHP OPcache in Hostinger control panel
   - Add browser caching rules to `.htaccess`

2. **CDN Integration**
   - Consider using Hostinger's CDN for static assets
   - Update CDN URLs in your HTML files

## Configuration

### Environment Variables

Create a `.env` file (optional) for environment-specific settings:
```
DB_HOST=localhost
DB_NAME=fluxterra
DB_USER=your_username
DB_PASS=your_password
GOOGLE_CALENDAR_ID=your_calendar_id
```

### Admin Access

- Default admin account is created during database setup
- Email: `admin@fluxterra.com`
- Password: `admin123`
- **Important**: Change the default password after first login

## File Structure

```
/
├── includes/
│   ├── auth.php          # Authentication functions
│   ├── db.php            # Database connection and helpers
│   ├── header.php        # Common header
│   └── footer.php        # Common footer
├── config/
│   ├── google-calendar.php    # Google Calendar integration
│   ├── google-credentials.json.example
│   └── google-credentials.json
├── index.php             # Homepage
├── about.php             # About page
├── services.php          # Services page
├── contact.php           # Contact page
├── login.php             # Login page
├── register.php          # Registration page
├── booking.php           # Session booking
├── leaderboards.php      # Racing leaderboards
├── events.php            # Racing events
├── admin.php             # Admin panel
├── profile.php           # User profile
├── setup.sql             # Database schema
├── composer.json         # Composer dependencies
└── README.md             # This file
```

## Features Overview

### User Features
- **Registration/Login**: Secure user authentication
- **Session Booking**: Book racing sessions with calendar integration
- **Leaderboards**: View and compete on lap time leaderboards
- **Profile Management**: Track personal statistics and history
- **Event Participation**: Join racing events and championships

### Admin Features
- **Content Management**: Add/edit simulators, tracks, vehicles
- **Event Management**: Create and manage racing events
- **User Management**: View user statistics and bookings
- **System Configuration**: Manage system settings

### Technical Features
- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **Security**: Input validation, SQL injection prevention, XSS protection
- **Performance**: Optimized database queries, caching support
- **Accessibility**: WCAG compliant design
- **SEO**: Search engine optimized pages

## Browser Support

- Chrome 70+
- Firefox 65+
- Safari 12+
- Edge 79+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Security Considerations

1. **Input Validation**: All user inputs are sanitized and validated
2. **SQL Injection**: PDO prepared statements prevent SQL injection
3. **XSS Protection**: HTML entities are escaped in all outputs
4. **Session Security**: Secure session handling with proper timeouts
5. **File Upload**: Restricted file types and validation
6. **HTTPS**: SSL/TLS encryption for all communications

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check database credentials in `includes/db.php`
   - Verify database exists and user has proper permissions

2. **Google Calendar API Error**
   - Verify credentials file is properly uploaded
   - Check service account permissions
   - Ensure calendar is shared with service account

3. **Composer Dependencies**
   - Run `composer install` to install missing dependencies
   - Check PHP version compatibility

4. **File Permissions**
   - Ensure web server has read access to all files
   - Check write permissions for upload directories

### Support

For technical support or questions:
- Email: support@fluxterra.com
- Documentation: Check this README and inline code comments
- Issues: Report bugs through the project repository

## License

This project is proprietary software for FluxTerra Simworks. All rights reserved.

## Changelog

### Version 1.0.0
- Initial release
- Complete booking system
- Admin panel
- Leaderboards
- User authentication
- Google Calendar integration
- Responsive design