-- สร้างตาราง Departments
CREATE TABLE departments (
    department_id int auto_increment, -- รหัสแผนก ที่เป็น unique และเพิ่มขึ้นเองอัตโนมัติเป็น Primary key
    department_name varchar(255) not null, -- ชื่อแผนก
    primary key (department_id)
);
-- แทรกข้อมูลสำหรับแผนกต่างๆ
INSERT INTO departments (department_name) VALUES 
    ('Accounting'),      -- Department ID 1
    ('Human Resources'), -- Department ID 2
    ('IT Development'), -- Department ID 3
    ('Marketing');       -- Department ID 4
-- สร้างตาราง Employees
CREATE TABLE employees (
    employee_id int auto_increment, -- รหัสพนักงาน ที่เป็น unique และเพิ่มขึ้นเองอัตโนมัติเป็น Primary key
    department_id int not null, -- รหัสแผนกที่พนักงานอยู่ ซึ่งเป็น Foreign Key จากตาราง Departments
    first_name varchar(255) not null, -- ชื่อและนามสกุล
    last_name varchar(255) not null,
    primary key (employee_id),
    foreign key (department_id) references departments(department_id) ON DELETE CASCADE
);
-- สร้างตาราง Users
CREATE TABLE users (
    user_id int, -- รหัสผู้ใช้ ซึ่งเป็น Foreign Key จากตาราง Employees
    username varchar(255) not null, -- ชื่อผู้ใช้และรหัสผ่านสำหรับเข้าสู่ระบบ
    password varchar(255) not null,
    foreign key (user_id) references employees(employee_id)
);
-- สร้างตาราง Salary
CREATE TABLE salary (
    employee_id int not null, -- รหัสพนักงาน ซึ่งเป็น Foreign Key จากตาราง Employees
    salary decimal(10, 2) not null, -- เงินเดือน ภาษี กองทุนสำรองเลี้ยงชีพ และกองทุนประกันสังคม
    tax decimal(10, 2),
    social_security_fund decimal(10, 2),
    provident_fund decimal(10, 2),
    foreign key (employee_id) references employees(employee_id)
);
-- สร้างตาราง Work Time
CREATE TABLE work_time (
    employee_id int not null, -- รหัสพนักงาน ซึ่งเป็น Foreign Key จากตาราง Employees
    work_date date not null, -- วันที่ทำงาน เวลาเข้างาน เวลาออกงาน สถานะเวลาเข้างาน และรวมถึงเวลาโอที
    arrival_time time,
    departure_time time,
    is_on_time boolean,
    is_late boolean,
    is_leave boolean not null,
    overtime_hours decimal(5, 2),
    wage int,
    foreign key (employee_id) references employees(employee_id)
);
-- สร้างตาราง Payment History
CREATE TABLE payment_history (
    payment_id int auto_increment, -- รหัสสลิป ที่เป็น unique และเพิ่มขึ้นเองอัตโนมัติเป็น Primary key
    employee_id int not null, -- รหัสพนักงาน ซึ่งเป็น Foreign Key จากตาราง Employees
    salary decimal(10, 2), -- เงินเดือน เงินโอที เงินโบนัส เงินหักมาสายและไม่มา ภาษี กองทุนสำรองเลี้ยงชีพ และกองทุนประกันสังคม เงินเงินสุทธิ วันที่จ่ายเงินเดือน ผูที่อนุมัติ สถานะการจ่ายเงินเดือน
    overtime decimal(10, 2),
    bonus decimal(10, 2),
    late_leave decimal(10, 2),
    tax decimal(10, 2),
    social_security_fund decimal(10, 2),
    provident_fund decimal(10, 2),
    amount decimal(10, 2),
    payment_date date not null,
    transaction_by varchar(255),
    status boolean not null,
    primary key (payment_id),
    foreign key (employee_id) references employees(employee_id)
);
-- สร้างตาราง Transactions
CREATE TABLE transactions (
    transaction_id INT AUTO_INCREMENT, -- รหัสธุรกรรมที่เป็น unique และเพิ่มขึ้นเองอัตโนมัติเป็น Primary key
    employee_id INT NOT NULL, -- รหัสพนักงาน ซึ่งเป็น Foreign Key จากตาราง Employees
    transaction_date DATE NOT NULL, -- วันที่ทำรายการ คำอธิบายธุรกรรม
    transaction_description VARCHAR(255),
    PRIMARY KEY (transaction_id),
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id)
);
-- สร้างตาราง Late&leave policy
CREATE TABLE late_leave_policy (
    id INT PRIMARY KEY AUTO_INCREMENT, -- รหัสนโยบายการหักเงิน ที่เป็น unique และเพิ่มขึ้นเองอัตโนมัติเป็น Primary key
    late_count INT, -- จำนวนครั้งที่มาสายและไม่มา %ที่หัก
    late_deduction_percent FLOAT,
    leave_count INT,
    leave_deduction_percent FLOAT
);
-- แทรกข้อมูลนโยบายการหักเงิน
INSERT INTO late_leave_policy (late_count, late_deduction_percent, leave_count, leave_deduction_percent) VALUES
    (1, 1.0, 1, 2.0),
    (2, 1.5, 2, 2.5),
    (3, 2.0, 3, 3.0);