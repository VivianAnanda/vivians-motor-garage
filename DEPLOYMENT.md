# Free Deployment Guide - InfinityFree

## 🚀 Deploy Your Car Workshop System for FREE

This guide will help you deploy your application to InfinityFree hosting.

---

## Step 1: Sign Up for InfinityFree

1. Go to **https://infinityfree.net/**
2. Click **"Sign Up Now"**
3. Fill in the registration form:
   - Email address
   - Password
   - Complete verification

4. **Verify your email** (check spam folder if needed)

---

## Step 2: Create a Free Hosting Account

1. Log in to InfinityFree Client Area
2. Click **"Create Account"**
3. Fill in the details:
   - **Subdomain**: Choose a subdomain (e.g., `vivians-motor-garage`)
   - **Domain**: Select from free options (.rf.gd, .epizy.com, .42web.io)
   - Example: `vivians-motor-garage.rf.gd`
   - **Label**: vivians-motor-garage
   - **Password**: Create a strong password

4. Click **"Create Account"**
5. Wait 2-5 minutes for account activation

---

## Step 3: Access cPanel

1. From Client Area, click **"Control Panel"** or **"cPanel"**
2. Alternative: Go to `https://cpanel.infinityfree.net/`
3. Login with the credentials you just created

---

## Step 4: Create MySQL Database

1. In cPanel, find **"MySQL Databases"**
2. **Create a new database:**
   - Database Name: `workshop` (will become something like `epiz_xxxxx_workshop`)
   - Click **"Create Database"**

3. **Create a database user:**
   - Username: `workshop_user`
   - Password: Create a strong password (save it!)
   - Click **"Create User"**

4. **Add user to database:**
   - Select the user you created
   - Select the database you created
   - Grant **ALL PRIVILEGES**
   - Click **"Add"**

5. **Save these credentials** (you'll need them!):
   ```
   Database Name: epiz_xxxxx_workshop
   Database User: epiz_xxxxx_workshop_user
   Database Password: [your password]
   Database Host: localhost
   ```

---

## Step 5: Import Database Schema

1. In cPanel, find **"phpMyAdmin"**
2. Click on your database name (left sidebar)
3. Click **"Import"** tab
4. Click **"Choose File"** and select `database.sql`
5. Click **"Go"** at the bottom
6. Wait for success message

7. **(Optional) Add admin with email:**
   - Click **"SQL"** tab
   - Paste contents of `add_admin.sql`
   - Click **"Go"**

8. **(Optional) Update mechanic names:**
   - Click **"SQL"** tab
   - Paste contents of `update_mechanics.sql`
   - Click **"Go"**

---

## Step 6: Upload Files

### Option A: Using File Manager (Recommended for small projects)

1. In cPanel, find **"Online File Manager"** or **"File Manager"**
2. Navigate to **`htdocs`** folder
3. **Delete** any default files (index.html, etc.)
4. Click **"Upload"** button
5. Select all your project files:
   - index.php
   - admin.php
   - admin_login.php
   - config.php
   - All other .php files
   - styles.css
   - script.js
   - admin.js
   - welcome.html
   - background wallpaper.jpg
6. Wait for upload to complete

### Option B: Using FTP (Better for larger projects)

1. Download FileZilla: https://filezilla-project.org/
2. In cPanel, find **"FTP Accounts"**
3. Get your FTP credentials:
   - Host: `ftpupload.net`
   - Username: `epiz_xxxxx` (from your account)
   - Password: Your cPanel password
   - Port: 21

4. Connect with FileZilla
5. Upload all files to `/htdocs` folder

---

## Step 7: Update config.php

1. In File Manager, open `config.php` for editing
2. Update the database credentials:

```php
<?php
// Database configuration for InfinityFree
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'epiz_xxxxx_workshop_user');  // Your database user
define('DB_PASSWORD', 'your_database_password');     // Your database password
define('DB_NAME', 'epiz_xxxxx_workshop');           // Your database name

// Rest of the file remains the same...
```

3. **Save the file**

---

## Step 8: Test Your Application

1. Visit your website:
   - User Panel: `http://vivians-motor-garage.rf.gd/welcome.html`
   - Booking Form: `http://vivians-motor-garage.rf.gd/index.php`
   - Admin Login: `http://vivians-motor-garage.rf.gd/admin_login.php`

2. **Test user booking:**
   - Fill the appointment form
   - Submit and verify it works

3. **Test admin panel:**
   - Login with: `admin@carworkshop.com` / `admin123`
   - View appointments
   - Try editing an appointment

---

## Step 9: Enable SSL (HTTPS) - Optional but Recommended

1. In cPanel, find **"SSL/TLS"** or **"SSL Certificates"**
2. InfinityFree provides **free SSL** (may take 24-48 hours to activate)
3. Or use Cloudflare for instant SSL:
   - Sign up at https://cloudflare.com
   - Add your site
   - Update nameservers (follow Cloudflare instructions)

---

## 🎯 Your Live URLs

After deployment, your application will be accessible at:

- **Welcome Page**: `http://your-subdomain.rf.gd/welcome.html`
- **User Booking**: `http://your-subdomain.rf.gd/index.php`
- **Admin Login**: `http://your-subdomain.rf.gd/admin_login.php`

**Admin Credentials:**
- Email: `admin@carworkshop.com`
- Password: `admin123`

---

## ⚠️ Important Notes

### Database Prefix
InfinityFree adds a prefix to database names. Example:
- You create: `workshop`
- Actual name: `epiz_12345_workshop`

Always use the **full database name** in config.php!

### File Paths
- All files must be in `/htdocs` folder
- This is your public root directory
- Don't put files outside this folder

### Performance
- Free hosting has limitations
- Good for testing and portfolios
- For production, consider paid hosting

### Backups
- Download backups regularly
- InfinityFree doesn't guarantee data retention
- Keep your GitHub repo updated!

---

## 🔧 Troubleshooting

### "Database connection failed"
- Check database credentials in config.php
- Ensure you're using the FULL database name with prefix
- Verify database exists in phpMyAdmin

### "500 Internal Server Error"
- Check PHP syntax errors
- Review error logs in cPanel
- Ensure file permissions are correct (usually 644 for files, 755 for folders)

### "Page not found"
- Verify files are in `/htdocs` folder
- Check file names are correct (case-sensitive!)
- Ensure index.php exists

### "Cannot connect via FTP"
- Use `ftpupload.net` as host (not your domain)
- Use port 21
- Ensure you're using cPanel password

---

## 📊 Free Hosting Limitations

InfinityFree limitations to be aware of:
- **Hits**: 50,000 hits per day (plenty for most projects)
- **Storage**: Unlimited (but fair use applies)
- **Databases**: 400 MySQL databases
- **Support**: Community forum only
- **Uptime**: ~99% (good for free!)

---

## 🎓 Alternative Free Hosts

If you need alternatives:

### 000webhost
- URL: https://www.000webhost.com/
- 300 MB storage, 3 GB bandwidth
- PHP & MySQL support
- No ads

### Freehostia
- URL: https://www.freehostia.com/
- 250 MB storage, 6 GB bandwidth
- 3 domains, 5 databases
- Good control panel

### AwardSpace
- URL: https://www.awardspace.com/
- 1 GB storage, 5 GB bandwidth
- PHP & MySQL support
- Free domain included

---

## 🚀 Next Steps After Deployment

1. **Test everything thoroughly**
   - Try booking appointments
   - Test admin functions
   - Check all validations work

2. **Share your project**
   - Add the live URL to your GitHub README
   - Share with friends/professors
   - Add to your portfolio

3. **Monitor and maintain**
   - Check regularly for issues
   - Update content as needed
   - Respond to user feedback

4. **Consider upgrades**
   - If traffic grows, upgrade to paid hosting
   - Add more features
   - Improve security

---

## 📝 Quick Deployment Checklist

- [ ] Sign up for InfinityFree
- [ ] Create hosting account
- [ ] Create MySQL database and user
- [ ] Import database.sql via phpMyAdmin
- [ ] Upload all files to /htdocs
- [ ] Update config.php with new credentials
- [ ] Test user booking form
- [ ] Test admin login and features
- [ ] Enable SSL (optional)
- [ ] Update GitHub README with live URL

---

## 🎉 Congratulations!

Your Car Workshop Appointment System is now LIVE and accessible worldwide!

**Share your live URL:**
- With your professor for grading
- On your resume/portfolio
- With potential employers

Good luck with your deployment! 🚗✨
