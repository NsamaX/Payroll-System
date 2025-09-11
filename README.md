## Overview

This website is designed to manage employee salaries, calculating from taxes, social security, and provident funds, in accordance with the law and company regulations. The website also has a transaction feature to track various actions, such as salary corrections or salary approvals, and a report export feature for service providers.

## Features

  * **Salary Calculation**: Calculates wages, overtime, absenteeism, leave, tardiness, and diligence bonuses.
  * **Tax and Welfare Processing**: Accurately processes taxes, social security, and provident funds.
  * **Payment Management**: Supports direct bank transfers and can issue e-slips for employees to easily review their income and expenses.
  * **Reporting System**: Generates financial reports for employees, monthly financial summaries, and salary approval history in .csv and .docx formats.
  * **User Management**: Supports Administrator (Accounting) and Employee roles with a secure sign-in system.

## Installation

This project is built entirely using PHP and MySQL. It requires XAMPP (or a similar local server environment) to run. Follow these steps to set up and run the project locally:

1. **Clone the Repository**:  
   ```bash
   git clone https://github.com/NsamaX/Payroll-System.git
   ```  

2. **Install XAMPP**:  
   Download and install XAMPP from [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html). XAMPP includes Apache, MySQL, and PHP.

3. **Move the Project Folder**:
   Move the project folder to the `htdocs` directory in your XAMPP installation `C:\xampp\htdocs\Payroll-System` on Windows.

4. **Set Up the Database**:  
   - Start XAMPP and launch Apache and MySQL services.  
   - Open phpMyAdmin by visiting `http://localhost/phpmyadmin` in your browser.  
   - Create a new database name it `payroll_db`.  
   - Import the SQL schema file `sql\dataset.sql` into the new database.

5. **Configure Database Connection**:  
   Edit the database connection file `php\config.php` with your MySQL credentials. Here's an example:  
   ```php
   <?php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "payroll_db";
   
   $conn = new mysqli($servername, $username, $password, $dbname);
   
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   ?>
   ```

6. **Run the Application**:  
   - Ensure Apache and MySQL are running in XAMPP.  
   - Open your browser and navigate to `http://localhost/Payroll-System/`.
   - Log in using the default credentials or set up users in the database.

## License

This project is licensed under the **MIT License**.