# Payroll System

A web-based payroll management system for calculating employee salaries, taxes, and welfare deductions, with e-slip generation and financial report export.

## Screenshots

![Screenshot](payroll.png)

## Features

- **Salary Calculation**: Calculates wages, overtime, absenteeism, tardiness, and diligence bonuses.
- **Tax and Welfare Processing**: Accurately processes taxes, social security, and provident funds.
- **Payment Management**: Issues e-slips for employees to review their income and deductions.
- **Reporting System**: Exports financial reports and salary approval history in .csv and .docx formats.
- **User Management**: Supports Accounting (admin) and Employee roles with a role-based sign-in system.

## Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/NsamaX/Payroll-System.git
   ```

2. **Install XAMPP**
   Download from [apachefriends.org](https://www.apachefriends.org) and start Apache and MySQL.

3. **Move the Project Folder**
   Place the project folder in your XAMPP `htdocs` directory:
   - Windows: `C:/xampp/htdocs/Payroll-System`
   - macOS: `/Applications/XAMPP/htdocs/Payroll-System`

4. **Set Up the Database**
   - Open phpMyAdmin at `http://localhost/phpmyadmin`
   - Create a new database named `payroll_db`
   - Import `sql/table.sql` first, then `sql/dataset.sql`

5. **Configure Database Connection**
   Edit `php/connect.php` with your MySQL credentials:
   ```php
   $servername = "localhost";
   $username   = "root";
   $password   = "";
   $dbname     = "payroll_db";
   ```

6. **Run the Application**
   Open `http://localhost/Payroll-System/role.php`, select a role, then sign in.

## Demo

| Field    | Value        |
|----------|--------------|
| Username | Sato_Harumi  |
| Password | 0x8xkiqG    |
| Role     | Accounting   |

## License

This project is licensed under the **MIT License**.
