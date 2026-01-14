# Leave Application System

A web-based leave management system built with Python Flask, HTML/CSS/JavaScript, and MySQL database. This project is designed for deployment on AWS EC2 and supports future scaling phases.

## Project Structure

```
TCC-Proj/
├── app.py                 # Main Flask application
├── requirements.txt       # Python dependencies
├── database.sql           # MySQL database setup script
├── templates/             # HTML templates
│   ├── index.html
│   ├── login.html
│   ├── register.html
│   ├── dashboard.html
│   ├── apply_leave.html
│   └── edit_leave.html
└── static/                # Static files
    ├── css/
    │   └── style.css
    └── js/
        └── script.js
```

## Features

- User registration and login
- Apply for leave
- View leave applications
- Edit leave applications
- Delete leave applications
- Responsive UI

## Prerequisites

- Python 3.8+
- MySQL Server (via XAMPP)
- phpMyAdmin (for database management)

## Local Setup Instructions

### 1. Install Python Dependencies

```bash
pip install -r requirements.txt
```

### 2. Setup MySQL Database

1. Start XAMPP and ensure MySQL and Apache are running.
2. Open phpMyAdmin (usually at http://localhost/phpmyadmin).
3. Create a new database named `leave_system`.
4. Import the `database.sql` file:
   - Go to the "Import" tab in phpMyAdmin.
   - Select the `database.sql` file from your project directory.
   - Click "Go" to execute the SQL script.

Alternatively, you can run the SQL script using MySQL command line:

```bash
mysql -u root -p < database.sql
```

### 3. Configure Database Connection

In `app.py`, update the `db_config` dictionary if your MySQL credentials differ:

```python
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': 'your_mysql_password',  # Update if you have a password
    'database': 'leave_system'
}
```

### 4. Run the Flask Application

```bash
python app.py
```

The application will run on `http://localhost:5000`.

### 5. Access the Application

- Open your browser and go to `http://localhost:5000`
- Register a new account or login with existing credentials
- For example users, first generate password hashes:
  ```bash
  pip install werkzeug
  python -c "from werkzeug.security import generate_password_hash; print('Admin:', generate_password_hash('admin123'))"
  python -c "from werkzeug.security import generate_password_hash; print('John:', generate_password_hash('password'))"
  python -c "from werkzeug.security import generate_password_hash; print('Jane:', generate_password_hash('password'))"
  ```
- Update the `database.sql` INSERT statements with the actual hashes
- Example login: admin@example.com / admin123

## AWS EC2 Deployment Preparation

### 1. Launch EC2 Instance

- Choose Amazon Linux 2 or Ubuntu AMI
- Configure security group to allow HTTP (port 80) and SSH (port 22)

### 2. Install Dependencies on EC2

```bash
# Update system
sudo yum update -y  # For Amazon Linux
# or
sudo apt update && sudo apt upgrade -y  # For Ubuntu

# Install Python
sudo yum install python3 python3-pip -y
# or
sudo apt install python3 python3-pip -y

# Install MySQL
sudo yum install mysql-server -y
sudo systemctl start mysqld
sudo systemctl enable mysqld
# Secure MySQL installation
sudo mysql_secure_installation
```

### 3. Setup Database on EC2

- Follow steps 2-3 from local setup, but connect to EC2 MySQL instance
- Update `db_config` in `app.py` with EC2 database credentials

### 4. Deploy Flask App

```bash
# Clone your repository
git clone https://github.com/yourusername/TCC-Proj.git
cd TCC-Proj

# Install dependencies
pip3 install -r requirements.txt

# Run the app (for testing)
python3 app.py

# For production, use Gunicorn or similar
pip3 install gunicorn
gunicorn -w 4 -b 0.0.0.0:8000 app:app
```

### 5. Configure Web Server (Nginx)

```bash
# Install Nginx
sudo yum install nginx -y
sudo systemctl start nginx
sudo systemctl enable nginx

# Configure Nginx (create /etc/nginx/conf.d/flask_app.conf)
server {
    listen 80;
    server_name your-ec2-public-ip;

    location / {
        proxy_pass http://127.0.0.1:8000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}
```

### 6. Domain and SSL (Optional)

- Point your domain to EC2 instance
- Use Let's Encrypt for SSL certificate

## Database Schema

### Users Table
- id (INT, Primary Key)
- name (VARCHAR)
- email (VARCHAR, Unique)
- password (VARCHAR, Hashed)
- role (ENUM: employee, manager)

### Leaves Table
- id (INT, Primary Key)
- user_id (INT, Foreign Key)
- start_date (DATE)
- end_date (DATE)
- reason (TEXT)
- status (ENUM: pending, approved, rejected)

## API Endpoints

- `/` - Homepage
- `/login` - User login
- `/register` - User registration
- `/dashboard` - User dashboard
- `/apply` - Apply for leave
- `/edit/<id>` - Edit leave application
- `/delete/<id>` - Delete leave application
- `/logout` - User logout

## Security Notes

- Passwords are hashed using Werkzeug security
- User sessions are managed by Flask
- Input validation is performed on both client and server side
- SQL injection is prevented using parameterized queries

## Future Enhancements

- Role-based access control (managers approve leaves)
- Email notifications
- Calendar view
- Leave balance tracking
- Admin panel
- API endpoints for mobile app
- Containerization with Docker
- Load balancing for scaling

## Troubleshooting

1. **Database connection error**: Ensure MySQL is running and credentials are correct.
2. **ImportError**: Make sure all dependencies are installed.
3. **Port already in use**: Change the port in `app.run(port=5001)`.
4. **Static files not loading**: Check Flask static folder configuration.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is for educational purposes.