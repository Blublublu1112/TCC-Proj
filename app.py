from flask import Flask, render_template, request, redirect, url_for, session, flash
import mysql.connector
from werkzeug.security import generate_password_hash, check_password_hash

app = Flask(__name__)
app.secret_key = 'your_secret_key_here'  # Change this to a random secret key

# Database configuration
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',  # Leave empty if no password for root
    'database': 'leave_system'
}

def get_db_connection():
    return mysql.connector.connect(**db_config)

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        email = request.form['email']
        password = request.form['password']
        conn = get_db_connection()
        cursor = conn.cursor(dictionary=True)
        cursor.execute('SELECT * FROM users WHERE email = %s', (email,))
        user = cursor.fetchone()
        cursor.close()
        conn.close()
        if user and check_password_hash(user['password'], password):
            session['user_id'] = user['id']
            session['role'] = user['role']
            return redirect(url_for('dashboard'))
        else:
            flash('Invalid email or password')
    return render_template('login.html')

@app.route('/register', methods=['GET', 'POST'])
def register():
    if request.method == 'POST':
        name = request.form['name']
        email = request.form['email']
        password = generate_password_hash(request.form['password'])
        role = 'employee'  # Default role
        conn = get_db_connection()
        cursor = conn.cursor()
        try:
            cursor.execute('INSERT INTO users (name, email, password, role) VALUES (%s, %s, %s, %s)', (name, email, password, role))
            conn.commit()
            flash('Registration successful! Please log in.')
            return redirect(url_for('login'))
        except mysql.connector.IntegrityError:
            flash('Email already exists')
        finally:
            cursor.close()
            conn.close()
    return render_template('register.html')

@app.route('/dashboard')
def dashboard():
    if 'user_id' not in session:
        return redirect(url_for('login'))
    conn = get_db_connection()
    cursor = conn.cursor(dictionary=True)
    cursor.execute('SELECT * FROM leaves WHERE user_id = %s', (session['user_id'],))
    leaves = cursor.fetchall()
    cursor.close()
    conn.close()
    return render_template('dashboard.html', leaves=leaves)

@app.route('/apply', methods=['GET', 'POST'])
def apply():
    if 'user_id' not in session:
        return redirect(url_for('login'))
    if request.method == 'POST':
        start_date = request.form['start_date']
        end_date = request.form['end_date']
        reason = request.form['reason']
        status = 'pending'
        conn = get_db_connection()
        cursor = conn.cursor()
        cursor.execute('INSERT INTO leaves (user_id, start_date, end_date, reason, status) VALUES (%s, %s, %s, %s, %s)', (session['user_id'], start_date, end_date, reason, status))
        conn.commit()
        cursor.close()
        conn.close()
        flash('Leave application submitted successfully')
        return redirect(url_for('dashboard'))
    return render_template('apply_leave.html')

@app.route('/edit/<int:id>', methods=['GET', 'POST'])
def edit(id):
    if 'user_id' not in session:
        return redirect(url_for('login'))
    conn = get_db_connection()
    cursor = conn.cursor(dictionary=True)
    cursor.execute('SELECT * FROM leaves WHERE id = %s AND user_id = %s', (id, session['user_id']))
    leave = cursor.fetchone()
    if not leave:
        cursor.close()
        conn.close()
        return 'Leave application not found', 404
    if request.method == 'POST':
        start_date = request.form['start_date']
        end_date = request.form['end_date']
        reason = request.form['reason']
        cursor.execute('UPDATE leaves SET start_date = %s, end_date = %s, reason = %s WHERE id = %s', (start_date, end_date, reason, id))
        conn.commit()
        cursor.close()
        conn.close()
        flash('Leave application updated successfully')
        return redirect(url_for('dashboard'))
    cursor.close()
    conn.close()
    return render_template('edit_leave.html', leave=leave)

@app.route('/delete/<int:id>')
def delete(id):
    if 'user_id' not in session:
        return redirect(url_for('login'))
    conn = get_db_connection()
    cursor = conn.cursor()
    cursor.execute('DELETE FROM leaves WHERE id = %s AND user_id = %s', (id, session['user_id']))
    conn.commit()
    cursor.close()
    conn.close()
    flash('Leave application deleted successfully')
    return redirect(url_for('dashboard'))

@app.route('/logout')
def logout():
    session.pop('user_id', None)
    session.pop('role', None)
    flash('Logged out successfully')
    return redirect(url_for('index'))

if __name__ == '__main__':
    app.run(debug=True)