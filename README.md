# Simple Online Item Management System

A very simple, beginner-friendly PHP web application for a Cloud Computing course. It performs basic CRUD (Create, Read, Update, Delete) operations on an `items` database.

## 📋 Project Requirements & Tech Stack
- **Languages:** PHP (Native, no frameworks), HTML, CSS.
- **Database:** MySQL.
- **Server:** Apache (Linux/Windows).
- **Goal:** Minimalist design, easy to deploy on AWS EC2.

## 📂 Project Structure
```
/project-root
├── index.php        // Homepage, view all items
├── add.php          // Form to add a new item
├── edit.php         // Form to edit an existing item
├── delete.php       // Logic to delete an item
├── db.php           // Database connection configuration
├── header.php       // HTML header template
├── footer.php       // HTML footer template
├── database.sql     // SQL script to set up the DB
└── css/
    └── style.css    // Minimal CSS styling
```

## 🚀 How to Run Locally (XAMPP on Windows)

1.  **Install XAMPP**: Download and install XAMPP.
2.  **Start Services**: Open XAMPP Control Panel and start **Apache** and **MySQL**.
3.  **Setup Database**:
    *   Open your browser and go to `http://localhost/phpmyadmin`.
    *   Click usually on specific "Import" tab (or create DB manually).
    *   You can create a DB named `tcc_db` manually or just import the provided script.
    *   Ideally: Go to "Import", choose `database.sql` from this project folder, and click "Import". This creates the database `tcc_db` and the `items` table.
4.  **Deploy Code**:
    *   Copy the entire project folder to `C:\xampp\htdocs\`.
    *   Rename the folder if you want (e.g., `tcc-proj`).
    *   Final path should look like: `C:\xampp\htdocs\tcc-proj\index.php`.
5.  **Check Configuration**:
    *   Open `db.php`.
    *   Ensure `$user` is `'root'` and `$pass` is `''` (empty), which is the XAMPP default.
6.  **Run**:
    *   Visit `http://localhost/tcc-proj/index.php` in your browser.

## 🐧 How to Run on Linux (AWS EC2 / Ubuntu)

1.  **Update System**: `sudo apt update && sudo apt upgrade -y`
2.  **Install Web Server & PHP**:
    ```bash
    sudo apt install apache2 php libapache2-mod-php php-mysqli -y
    ```
3.  **Install MySQL (if running DB locally on EC2)**:
    ```bash
    sudo apt install mysql-server -y
    ```
    *(If using AWS RDS, skip installing mysql-server locally and just install `mysql-client` to connect).*
4.  **Setup Database**:
    *   Log in to MySQL: `sudo mysql` or `mysql -u root -p`.
    *   Run the SQL commands from `database.sql`.
    *   Create a user for the web app if needed.
5.  **Deploy Code**:
    *   Place files in `/var/www/html/`.
    *   Remove default index: `sudo rm /var/www/html/index.html`.
    *   Copy your PHP files there.
6.  **Configure DB Connection**:
    *   Edit `db.php`: `sudo nano /var/www/html/db.php`.
    *   Update `$host`, `$user`, `$pass`, `$dbname` to match your RDS endpoint or local MySQL credentials.
7.  **Restart Apache**: `sudo systemctl restart apache2`.
8.  **Access**: Visit `http://<your-ec2-public-ip>/`.

## ☁️ AWS Deployment Notes
*   **Database**: For production on AWS, uses **Amazon RDS** (MySQL) instead of a local database on the EC2 instance.
*   **Scalability**: The application is stateless (no local file storage for user data), making it compatible with **Auto Scaling Groups** and **Elastic Load Balancers (ELB)**.
*   **Security**: Ensure your Security Groups allow traffic on Port 80 (HTTP) for the web server and Port 3306 (MySQL) between the EC2 and RDS.
