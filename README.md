# Car Workshop Appointment System

## 📋 Project Overview

A complete web-based appointment management system for a car workshop built with PHP, MySQL, HTML, CSS, and JavaScript. The system allows clients to book appointments with their preferred mechanics and enables administrators to manage all appointments efficiently.

## ✨ Features

### User Panel
- **Online Appointment Booking**: Clients can book appointments without visiting the workshop
- **Mechanic Selection**: Choose from 5 available mechanics based on specialization
- **Real-time Availability**: See available slots for each mechanic on selected dates
- **Validation**: 
  - Client-side and server-side validation
  - Name validation (letters and spaces only)
  - Phone validation (10-15 digits, numbers only)
  - Car engine number validation (alphanumeric)
  - Date validation (no past dates allowed)
- **Duplicate Prevention**: System checks if client already has an appointment on the selected date
- **Capacity Management**: Each mechanic limited to 4 appointments per day

### Admin Panel
- **View All Appointments**: Complete list of all bookings with details
- **Dashboard Statistics**: Quick overview of total, today's, and confirmed appointments
- **Edit Appointments**: 
  - Change appointment dates
  - Reassign to different mechanics
  - Update appointment status
- **Cancel Appointments**: Mark appointments as cancelled
- **Real-time Validation**: Checks availability when editing appointments

## 🗂️ File Structure

```
Assignment-3/
├── index.php                  # User Panel - Main appointment form
├── admin.php                  # Admin Panel - Appointment management
├── config.php                 # Database connection and helper functions
├── submit_appointment.php     # Handle appointment submissions
├── update_appointment.php     # Handle appointment updates (admin)
├── delete_appointment.php     # Handle appointment cancellations
├── get_availability.php       # API to check mechanic availability
├── get_appointment.php        # API to fetch appointment details
├── database.sql               # Database schema and initial data
├── styles.css                 # Complete styling for all pages
├── script.js                  # JavaScript for user panel
├── admin.js                   # JavaScript for admin panel
└── README.md                  # This file
```

## 🚀 Installation & Setup

### Prerequisites
- XAMPP, WAMP, or any local server with PHP and MySQL
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Modern web browser

### Step-by-Step Installation

1. **Install XAMPP/WAMP**
   - Download and install from official website
   - Start Apache and MySQL services

2. **Copy Project Files**
   ```
   Copy all files to: C:\xampp\htdocs\car-workshop\
   (or your web server's document root)
   ```

3. **Create Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Click "New" to create a database
   - Import `database.sql` file:
     - Click on the newly created database
     - Go to "Import" tab
     - Choose `database.sql` file
     - Click "Go"
   
   Or run the SQL commands directly:
   ```sql
   -- Open SQL tab in phpMyAdmin and paste contents of database.sql
   ```

4. **Configure Database Connection**
   - Open `config.php`
   - Update database credentials if needed:
   ```php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');      // Your MySQL password
   define('DB_NAME', 'car_workshop');
   ```

5. **Access the Application**
   - User Panel: http://localhost/car-workshop/index.php
   - Admin Panel: http://localhost/car-workshop/admin.php

## 📊 Database Structure

### Tables

#### `mechanics`
- mechanic_id (Primary Key)
- mechanic_name
- specialization
- phone
- created_at

**Pre-loaded mechanics:**
1. John Smith - Engine Specialist
2. Michael Brown - Transmission Expert
3. David Wilson - Electrical Systems
4. James Davis - Body Work & Paint
5. Robert Johnson - General Maintenance

#### `appointments`
- appointment_id (Primary Key)
- client_name
- client_address
- client_phone
- car_license_number
- car_engine_number
- appointment_date
- mechanic_id (Foreign Key)
- status (pending/confirmed/completed/cancelled)
- created_at
- updated_at

## 🎯 Usage Guide

### For Clients (User Panel)

1. **Open the User Panel**: Navigate to `index.php`

2. **Fill in the Form**:
   - Name: Full name (letters and spaces only)
   - Address: Complete address (minimum 10 characters)
   - Phone: Contact number (10-15 digits)
   - Car License Number: Vehicle registration number
   - Car Engine Number: Alphanumeric engine number
   - Appointment Date: Select desired date (today or future)
   - Mechanic: Choose from available mechanics

3. **Check Availability**: 
   - Available slots shown in the info panel
   - Real-time availability updates when date/mechanic changes

4. **Submit**: Click "Book Appointment"
   - Success message displays appointment ID
   - Form resets for new booking

### For Administrators (Admin Panel)

1. **Open Admin Panel**: Navigate to `admin.php`

2. **View Dashboard**:
   - See statistics cards with appointment counts
   - View complete appointment list in table format

3. **Edit Appointment**:
   - Click "Edit" button on any appointment
   - Modify date, mechanic, or status
   - System validates availability before saving
   - Click "Update Appointment"

4. **Cancel Appointment**:
   - Click "Cancel" button
   - Confirm cancellation
   - Status updates to "Cancelled"

## ✅ Validation Rules

### Client-Side (JavaScript)
- **Name**: Letters and spaces only, minimum 3 characters
- **Phone**: 10-15 digits, numbers only
- **Address**: Minimum 10 characters
- **Car License**: Minimum 5 characters
- **Car Engine Number**: Alphanumeric, minimum 5 characters
- **Date**: Must be today or future date
- **Mechanic**: Must be selected

### Server-Side (PHP)
All client-side validations are repeated server-side for security:
- Input sanitization
- SQL injection prevention
- XSS protection
- Business logic validation:
  - No duplicate appointments per client per day
  - Maximum 4 appointments per mechanic per day
  - Valid date ranges

## 🎨 Design Features

- **Responsive Design**: Works on desktop, tablet, and mobile
- **Modern UI**: Gradient backgrounds, smooth transitions
- **Color-Coded Status**: Visual indication of appointment status
  - 🟡 Pending
  - 🟢 Confirmed
  - 🔵 Completed
  - 🔴 Cancelled
- **Modal Windows**: Clean editing interface
- **Real-time Feedback**: Instant validation messages
- **Accessibility**: Clear labels, keyboard navigation support

## 🔒 Security Features

- **SQL Injection Prevention**: Prepared statements for all queries
- **XSS Protection**: HTML special characters escaping
- **Input Sanitization**: All user inputs cleaned before processing
- **Server-Side Validation**: Never trust client-side only
- **Error Handling**: User-friendly error messages

## 🐛 Troubleshooting

### Database Connection Failed
- Check MySQL service is running
- Verify database credentials in `config.php`
- Ensure database `car_workshop` exists

### Form Not Submitting
- Check browser console for JavaScript errors
- Ensure all fields pass validation
- Verify PHP files have correct permissions

### Mechanics Not Loading
- Check `get_availability.php` returns valid JSON
- Verify mechanics exist in database
- Check browser network tab for API errors

### Styling Issues
- Clear browser cache
- Verify `styles.css` is loaded
- Check console for CSS loading errors

## 📈 Future Enhancements

Potential improvements for the system:
- User authentication and login system
- Email notifications for appointments
- SMS reminders
- Mechanic login to view their schedule
- Payment integration
- Service history tracking
- Rating and review system
- Export appointments to PDF/Excel
- Calendar view for appointments
- Multi-language support

## 📝 Assignment Requirements Met

### Part 1 (70 points) - ✅ Completed
- ✅ Full database implementation
- ✅ Appointment submission and validation
- ✅ Mechanic selection with availability
- ✅ Duplicate booking prevention
- ✅ Capacity management (4 per mechanic)
- ✅ Admin panel with appointment list
- ✅ Edit and update functionality
- ✅ Help facilities (info panel)

### Part 2 (30 points) - ✅ Completed
- ✅ Professional look and feel
- ✅ Clean, maintainable code
- ✅ Comprehensive validation:
  - Name validation
  - Phone validation (numbers only)
  - Engine number validation
  - License validation
  - Date validation
  - Required field checks
- ✅ JavaScript form validation
- ✅ PHP server-side validation
- ✅ Additional features:
  - Real-time availability checking
  - AJAX form submission
  - Modal dialogs
  - Status management
  - Responsive design

## 👨‍💻 Technical Stack

- **Frontend**: HTML5, CSS3, JavaScript (Vanilla ES6+)
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Architecture**: MVC-inspired structure
- **API**: RESTful JSON endpoints
- **Security**: Prepared statements, input sanitization

## 📞 Support

For issues or questions:
1. Check the troubleshooting section
2. Review the code comments
3. Verify all setup steps were followed correctly

## 📄 License

This project is created for educational purposes as part of CSE391 course assignment.

---

**Note**: Remember to update database credentials in `config.php` when deploying to a different server.

**Developed for**: CSE391 Assignment 3  
**Date**: March 2026
