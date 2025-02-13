# PHP_Shopping
PHP based shopping website

### **✅ Steps to Run the Client Site Locally on Ubuntu (Including Database Setup)**
Setting it up locally with a MySQL database.

---

## **1️⃣ Install Required Software**
Ensure you have PHP, MySQL, and required extensions installed.

### **🔹 Install PHP & MySQL**
Run:
```bash
sudo apt update
sudo apt install php php-cli php-mysqli php-curl php-xml php-mbstring unzip apache2 mysql-server
```

### **🔹 Verify PHP & MySQL Installation**
```bash
php -v  # Check PHP version
mysql --version  # Check MySQL version
```

---

## **2️⃣ Setup MySQL Database & Tables**
### **🔹 Start MySQL Service**
```bash
sudo systemctl start mysql
sudo systemctl enable mysql
```

### **🔹 Login to MySQL**
```bash
sudo mysql -u root -p
```
(Enter your MySQL root password when prompted.)

### **🔹 Create a Database**
Run:
```sql
CREATE DATABASE register;
```

### **🔹 Use the Database**
```sql
USE register;
```

### **🔹 Create Tables**
Based on your code (`db.php`, `register.php`, `cart.php`, `submit_contact.php`), create the required tables:

#### **🔸 Users Table**
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### **🔸 Cart Table**
```sql
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL
);
```

#### **🔸 Messages Table (Contact Form)**
```sql

CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    date_submitted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
#### **🔸 AdminUsers Table**
```sql
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
#### ** Create Admin user
```
Run admin_db.php file
```
#### ** Admin dashboard username password
'''
username: admin
password: admin@123
'''
---

## **3️⃣ Configure the Database in Your Code**
Your database connection file (`db.php`) should look like this:

```php
<?php
$servername = "localhost";
$username = "root"; // Default MySQL user
$password = ""; // Default MySQL password (change if needed)
$dbname = "register"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

Ensure all PHP files using the database (`register.php`, `cart.php`, `submit_contact.php`, etc.) include this at the top:
```php
include 'db.php';
```

---

## **4️⃣ Start PHP Local Server**
### **🔹 Navigate to Your Project Folder**
```bash
cd /path/to/client_site
```

### **🔹 Run PHP Built-in Server**
```bash
php -S localhost:8000
```

### **🔹 Open in Browser**
Go to:
```
http://localhost:8000/home.php
```

If your `index.php` is missing, manually open `home.php`.

---

## **5️⃣ Debugging Issues**
If you get **"The requested resource / was not found"**, try:
```bash
php -S localhost:8000 -t .
```
Or manually navigate to `http://localhost:8000/home.php`.

If MySQL errors appear, ensure:
```bash
sudo systemctl start mysql
```
And check `db.php` for correct credentials.

---
Error Handling:
===============
Error:
------
Database Connection Error: Access denied for user 'root'@'localhost'
[Thu Feb 13 20:43:04 2025] 127.0.0.1:34524 [200]: GET /login.php
[Thu Feb 13 20:43:04 2025] 127.0.0.1:34524 Closing


Solution:
=========
### **🔧 Fixing MySQL "Access Denied for User 'root'@'localhost'" Error**

This issue usually occurs due to incorrect MySQL credentials or missing privileges. Let's fix it step by step.

---

## **1️⃣ Verify MySQL User Credentials**
Try logging in to MySQL using:
```bash
sudo mysql -u root -p
```
If you can't log in, it means the root password may have been changed or MySQL is not set up correctly.

---

## **2️⃣ Reset MySQL Root Password (If Needed)**
If you're unable to log in, reset the root password:

```bash
sudo systemctl stop mysql  # Stop MySQL service
sudo mysqld_safe --skip-grant-tables &
mysql -u root
```

Now, reset the password:
```sql
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'your_new_password';
FLUSH PRIVILEGES;
EXIT;
```
Then restart MySQL:
```bash
sudo systemctl restart mysql
```
Try logging in again:
```bash
mysql -u root -p
```

---

## **3️⃣ Update `db.php` with Correct Credentials**
Modify your `db.php` file to use the correct password:

```php
<?php
$servername = "localhost";
$username = "root";
$password = "your_new_password"; // Use the correct password
$dbname = "register";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Error: " . $conn->connect_error);
}
?>
```

---

## **4️⃣ Grant Proper Privileges (If Needed)**
If you still get an access denied error, grant the necessary privileges:

```sql
GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' IDENTIFIED BY 'your_new_password' WITH GRANT OPTION;
FLUSH PRIVILEGES;
```

---

## **5️⃣ Restart MySQL and Test Again**
```bash
sudo systemctl restart mysql
php -S localhost:8000
```
Now, open:
```
http://localhost:8000/home.php
```
If you still have issues, let me know the exact error message.