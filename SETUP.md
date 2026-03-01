# Quick Setup Guide

## ⚡ Quick Start (5 Minutes)

### 1. Prerequisites Check
- [ ] XAMPP/WAMP installed
- [ ] Apache and MySQL running

### 2. Setup Steps

#### A. Copy Files
```
Copy all project files to:
C:\xampp\htdocs\car-workshop\
```

#### B. Create Database
1. Open browser: http://localhost/phpmyadmin
2. Click "New" database
3. Name it: `car_workshop`
4. Click "Import" tab
5. Choose `database.sql` file
6. Click "Go"

#### C. Configure (if needed)
Open `config.php` and update:
```php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');  // Your password here
define('DB_NAME', 'car_workshop');
```

### 3. Access Application

**User Panel (Client Booking):**
```
http://localhost/car-workshop/index.php
```

**Admin Panel (Manage Appointments):**
```
http://localhost/car-workshop/admin.php
```

## 🧪 Test the System

### Test User Panel:
1. Fill in the form with sample data:
   - Name: John Doe
   - Address: 123 Main Street, Dhaka
   - Phone: 01712345678
   - Car License: DHK-METRO-11-1234
   - Engine Number: ENG123456
   - Date: Tomorrow's date
   - Mechanic: Select any available

2. Click "Book Appointment"
3. Should see success message with appointment ID

### Test Admin Panel:
1. Go to admin.php
2. See your test appointment in the table
3. Click "Edit" to modify
4. Click "Cancel" to cancel

## ✅ Check Everything Works

- [ ] User form validates inputs
- [ ] Availability shows for mechanics
- [ ] Can submit appointment successfully
- [ ] Admin panel shows appointments
- [ ] Can edit appointments
- [ ] Can cancel appointments
- [ ] Styling looks good

## 🎯 Key URLs

| Page | URL |
|------|-----|
| User Panel | http://localhost/car-workshop/index.php |
| Admin Panel | http://localhost/car-workshop/admin.php |
| phpMyAdmin | http://localhost/phpmyadmin |

## 🔧 Common Issues & Solutions

### Issue: "Cannot connect to database"
**Solution**: 
- Start MySQL in XAMPP Control Panel
- Check database name is `car_workshop`
- Verify credentials in config.php

### Issue: "Page shows PHP code"
**Solution**: 
- Start Apache in XAMPP Control Panel
- Access via localhost, not by opening file directly

### Issue: "Mechanics not showing"
**Solution**: 
- Check database.sql was imported correctly
- Verify 5 mechanics exist in `mechanics` table

## 📊 Default Data

After importing database.sql, you'll have:

**5 Mechanics:**
1. John Smith - Engine Specialist
2. Michael Brown - Transmission Expert
3. David Wilson - Electrical Systems
4. James Davis - Body Work & Paint
5. Robert Johnson - General Maintenance

Each can handle 4 appointments per day.

## 🎨 Features to Demonstrate

1. **Real-time Validation**: Fill form and see instant feedback
2. **Availability Check**: Change date/mechanic and watch slots update
3. **Duplicate Prevention**: Try booking same date twice
4. **Capacity Management**: Try booking 5th slot on same mechanic/date
5. **Admin Editing**: Modify appointments with validation
6. **Responsive Design**: Resize browser to see mobile view

## 📱 Mobile Testing

Open on mobile device:
```
http://YOUR_IP_ADDRESS/car-workshop/index.php
```

Replace YOUR_IP_ADDRESS with your computer's local IP (e.g., 192.168.1.100)

## ✨ Next Steps

1. **Test thoroughly**: Try all features
2. **Customize**: Adjust colors in styles.css
3. **Add data**: Create more test appointments
4. **Deploy**: Upload to your web hosting

## 🎓 Grading Checklist

### Part 1 (70 points):
- [x] Database fully implements appointment process
- [x] Client can submit appointments
- [x] Mechanic selection works
- [x] Availability checking works
- [x] Duplicate prevention works
- [x] Admin can view appointments
- [x] Admin can edit appointments
- [x] Help facilities provided

### Part 2 (30 points):
- [x] Nice look and feel
- [x] Clean code with standards
- [x] JavaScript validation (name, phone, engine, license, date)
- [x] PHP validation
- [x] Additional features (AJAX, real-time updates, etc.)

## 📞 Need Help?

Check README.md for detailed documentation!

---
**Ready to go!** 🚀 Open index.php and start booking!
