# 🏫 Web-Based Student Leave Management System

A PHP & MySQL-based web application for managing student leave requests and approvals.  
This system allows **students** to submit leave applications and **administrators** to review, approve, or reject them.  
It includes email notifications, data export to Excel, and a clean dashboard interface.

---

## 📌 Features

### 👨‍🎓 Student
- Register & login using Roll Number and Password
- Submit leave applications with date range & reason
- View leave request status (Pending, Approved, Rejected)
- Track leave history

### 🛠️ Admin
- Secure admin login
- View all leave requests with student details
- Approve or reject leave requests
- Export leave data to Excel
- Send email notifications to students
- Dashboard with leave statistics (via Chart.js)

---

## 🏗️ Tech Stack
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5
- **Backend:** PHP 7.4+
- **Database:** MySQL
- **Libraries:** 
  - [PHPMailer](https://github.com/PHPMailer/PHPMailer) (Email notifications)
  - [PhpSpreadsheet](https://phpspreadsheet.readthedocs.io/) (Excel export)
  - Chart.js (Dashboard charts)

---

## 📂 Project Structure
```
leave_management/
│
├── admin_dashboard.php       # Admin dashboard page
├── apply_leave.php           # Student leave request form
├── approve_leave.php         # Approve/Reject leave requests
├── assets/                   # CSS, JS, images
│   ├── css/style.css
│   ├── css/js/chart.js
├── composer.json             # Composer dependencies
├── db.php                    # Database connection file
├── export_excel.php          # Export leave data to Excel
├── index.php                 # Student login page
├── login.php                 # Login logic
├── logout.php                # Logout script
├── register.php              # Student registration page
├── send_email.php            # Email sending logic
├── sql/leave_management.sql  # Database schema & sample data
├── student_dashboard.php     # Student dashboard
└── vendor/                   # Composer installed dependencies
```

---

## ⚙️ Installation & Setup

### 1️⃣ Prerequisites
- PHP >= 7.4
- MySQL >= 5.7
- Composer
- Web server (Apache/Nginx)
- XAMPP / WAMP / MAMP for local development

### 2️⃣ Steps
1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/leave-management.git
   ```
2. **Move to project folder**
   ```bash
   cd leave-management
   ```
3. **Install Composer dependencies**
   ```bash
   composer install
   ```
4. **Import Database**
   - Create a new MySQL database (e.g., `leave_management`)
   - Import the SQL file: `sql/leave_management.sql`
5. **Configure Database Connection**
   - Open `db.php`
   - Set your database host, username, password, and DB name
6. **Start Local Server**
   - If using XAMPP, place files in `htdocs/leave-management`
   - Run Apache & MySQL
   - Visit: `http://localhost/leave-management`

---

## 🔑 Default Login Credentials

### Admin:
- **Username:** `admin@panimalar.com`
- **Password:** `panimalar`
- **Username:** `administrator`
- **Password:** `pecai`

### Student (Sample):
- **Roll No:** `STU001`
- **Password:** `12345`

---

## 📸 Screenshots

*(Add screenshots here)*

---

## 🚀 Future Enhancements
- Email notifications for leave approval/rejection (currently implemented with PHPMailer)
- Role-based access control (faculty, HOD, admin)
- Mobile-friendly responsive UI improvements
- Analytics for leave trends

---

## 📜 License
This project is licensed under the MIT License.

---

## 👨‍💻 Author
Developed by **[Your Name]**  
📧 Contact: your.email@example.com
