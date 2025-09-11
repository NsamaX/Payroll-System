/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/GUIForms/JFrame.java to edit this template
 */
package Assignment;

import java.security.SecureRandom;
import java.time.LocalDate;
import java.time.LocalTime;
import java.util.Calendar;
import java.util.HashMap;
import java.util.Map;
import java.util.Random;

/**
 *
 * @author 640710759 Vijuksama Hongthongdaeng
 */
public class GenerateData extends javax.swing.JFrame {

    /**
     * Creates new form NewJFrame
     */
    public GenerateData() {
        initComponents();
    }
    
    // This class models the properties and behaviors of employees
    class employees {

        // Declare instance variables
        private int salary;
        private double tax;
        private double social_security_fund;
        private double provident_fund;
        private int start;
        private int end;

        // Constructor to initialize all the instance variables
        employees(int salary, double tax, double social_security_fund, double provident_fund, int start, int end) {
            this.salary = salary;
            this.tax = tax;
            this.social_security_fund = social_security_fund;
            this.provident_fund = provident_fund;
            this.start = start;
            this.end = end;
        }

        // Method to get the salary of the employee
        int getSalary() {
            return salary;
        }

        // Method to set the salary of the employee
        int setSalary(int salary) {
            return this.salary = salary;
        }

        // Method to get the tax rate of the employee
        double getTax() {
            return tax;
        }

        // Method to set the tax rate of the employee
        double setTax(double tax) {
            return this.tax = tax;
        }

        // Method to get the social security fund of the employee
        double getSocialSecurityFund() {
            return social_security_fund;
        }

        // Method to set the social security fund of the employee
        double setSocialSecurityFund(double social_security_fund) {
            return this.social_security_fund = social_security_fund;
        }

        // Method to get the provident fund of the employee
        double getProvidentFund() {
            return provident_fund;
        }

        // Method to set the provident fund of the employee
        double setProvidentFund(double provident_fund) {
            return this.provident_fund = provident_fund;
        }

        // Method to get the start year of employment
        int getStartYear() {
            return start;
        }

        // Method to get the end year of employment
        int getEndYear() {
            return end;
        }
    }

    class RandomDataGenerator {
        Random r = new Random();
        
        // Employee name array
        private final String[] employee = {
            "Sato Harumi",
            "Suzuki Shigeru",
            "Takahashi Isamu",
            "Tanaka Misaki",
            "Watanabe Aya",
            "Ito Hiroko",
            "Nakamura Shinichi",
            "Kobayashi Shota",
            "Yamamoto Chiharu",
            "Miura Miki",
            "Okada Yuji",
            "Noguchi Satoshi",
            "Yoshida Asuka",
            "Yamada Tomoko",
            "Sasaki Kumiko",
            "Yamaguchi Emi",
            "Matsumoto Miwa",
            "Inoue Daichi",
            "Kimura Makoto",
            "Saito Hanako",
            "Shimizu Miho",
            "Hayashi Shunichi",
            "Abe Kaoru",
            "Ikeda Masako",
            "Hashimoto Tomoaki",
            "Maeda Riko",
            "Sugiyama Mao",
            "Fukuda Mizuki",
            "Otsuka Tomoya",
            "Kato Masaya",
        };
        // Fetches an employee name based on the index
        String getEmployee(int i) {
            if (i <= 0 || i > employee.length) {
                return "Invalid index"; // Error handling
            }
            return employee[i - 1];
        }
        
        // Fetches a random accounting employee
        String getAccounting() {
            return employee[r.nextInt(6)];
        }
        
        // Generates a secure password
        String getPassword() {
            SecureRandom random = new SecureRandom();
            StringBuilder password = new StringBuilder(8);
            String characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (int i = 0; i < 8; i++) {
                int index = random.nextInt(characters.length());
                password.append(characters.charAt(index));
            }
            return password.toString();
        }
        
        // Generates a random salary based on a given probability distribution
        int getSalary() {
        final int MIN_SALARY = 25_000; // Using constants
        final int MAX_SALARY = 300_000;
            double chance = r.nextDouble();
            if (chance <= 0.30) {
                return MIN_SALARY;
            } else if (chance <= 0.50) {
                return r.nextInt(100_000 - MIN_SALARY + 1) + MIN_SALARY;
            } else if (chance <= 0.70) {
                return r.nextInt(200_000 - MIN_SALARY + 1) + MIN_SALARY;
            } else if (chance <= 0.90) {
                return r.nextInt(300_000 - MIN_SALARY + 1) + MIN_SALARY;
            } else {
                return MAX_SALARY;
            }
        }
        
        // Calculates tax based on annual salary
        double getTax(int salary) {
            int annualSalary = salary * 12;
            if (annualSalary <= 150_000) {
                return 0.00;
            } else if (annualSalary <= 300_000) {
                return 5.00;
            } else if (annualSalary <= 500_000) {
                return 10.00;
            } else if (annualSalary <= 750_000) {
                return 15.00;
            } else if (annualSalary <= 1_000_000) {
                return 20.00;
            } else if (annualSalary <= 2_000_000) {
                return 25.00;
            } else if (annualSalary <= 5_000_000) {
                return 30.00;
            } else {
                return 35.00;
            }
        }
        
        // Generates a random percentage for Social Security Fund
        double getSocialSecurityFund() {
            double percentage = 3.0 + (5.0 - 3.0) * r.nextDouble();
            return percentage;
        }

        // Generates a random percentage for Provident Fund
        double getProvidentFund() {
            double percentage = 2.0 + (15.0 - 2.0) * r.nextDouble();
            return percentage;
        }
    
        // Generates a random start year
        int getStartYear() {
            int year = r.nextInt(4);
            return year + 2020;
        }
        
        // Returns the end year, can be made dynamic
        int getEndYear() {
            return 2023;
        }
        
        // Returns the end year, can be made dynamic
        String getDate(int year, int month) {
            int day;
            switch (month) {
                case 2 -> {
                    if (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0)) {
                        day = 29 - r.nextInt(2 + 1);
                    } else {
                        day = 28 - r.nextInt(2 + 1);
                    }
                }
                case 4, 6, 9, 11 -> day = 30 - r.nextInt(2 + 1);
                default -> day = 31 - r.nextInt(2 + 1);
            }
            return String.format("%d-%02d-%02d", year, month, day);
        }
        
        // Gets the maximum number of days in a month
        public int getDay(int year, int month) {
            Calendar calendar = Calendar.getInstance();
            calendar.set(year, month - 1, 1);
            return calendar.getActualMaximum(Calendar.DAY_OF_MONTH);
        }
        
        // Generates a random arrival time based on the probability
        String getArrivalTime() {
            int hour;
            int minute = r.nextInt(60);
            double chance = r.nextDouble();
            if (chance <= 0.1) {
                hour = 6;
            } else if (chance <= 0.8) {
                hour = 7;
            } else {
                hour = 8 + r.nextInt(2);
            }

            return String.format("%02d:%02d", hour, minute);
        }
        
        // Generates a random departure time
        String getDepartureTime() {
            int departureHour = 17 + r.nextInt(2);
            int departureMinute = r.nextInt(60);
            return String.format("%02d:%02d", departureHour, departureMinute);
        }
        
        // Generates a random overtime time
        String getOvertime() {
            int overtimeHour = 17 + r.nextInt(6);
            int overtimeMinute = r.nextInt(60);
            return String.format("%02d:%02d", overtimeHour, overtimeMinute);
        }
        
        // Calculates the total number of overtime hours
        double calculateOvertimeHours(String endTime) {
            String[] endParts = endTime.split(":");
            int endHour = Integer.parseInt(endParts[0]);
            int endMinute = Integer.parseInt(endParts[1]);
            int otStartHour = 17;
            int otStartMinute = 0;
            int totalOTStartMinutes = otStartHour * 60 + otStartMinute;
            int totalEndMinutes = endHour * 60 + endMinute;
            if(totalEndMinutes <= totalOTStartMinutes) return 0;
            int totalOTMinutes = totalEndMinutes - totalOTStartMinutes;
            float otHours = (float) totalOTMinutes / 60;
            return otHours;
        }
        
        // Calculates bonus based on the salary
        int getBonus(int salary) {
            return (int) (salary * (r.nextDouble() * 0.2));
        }
        
        // Calculates the net amount after deductions
        int getAmount(int salary, double social_security_fund, double provident_fund) {
            double social_security_fund_deduction = salary * (social_security_fund / 100);
            if (social_security_fund_deduction > 750) {
                social_security_fund_deduction = 750;
            }
            double amount = social_security_fund_deduction + (salary * (provident_fund / 100));
            return (int) (salary - amount);
        }
    }
    
    static employees[] employee = new employees[30];

    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jScrollPane1 = new javax.swing.JScrollPane();
        jTextArea1 = new javax.swing.JTextArea();
        jLabel1 = new javax.swing.JLabel();
        jButton1 = new javax.swing.JButton();
        jButton2 = new javax.swing.JButton();
        jButton3 = new javax.swing.JButton();
        jButton4 = new javax.swing.JButton();
        jButton5 = new javax.swing.JButton();
        jButton6 = new javax.swing.JButton();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);
        setResizable(false);

        jTextArea1.setColumns(20);
        jTextArea1.setRows(5);
        jScrollPane1.setViewportView(jTextArea1);

        jLabel1.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        jLabel1.setText("Generate Data");

        jButton1.setText("User");
        jButton1.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButton1ActionPerformed(evt);
            }
        });

        jButton2.setText("Account");
        jButton2.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButton2ActionPerformed(evt);
            }
        });

        jButton3.setText("Work time");
        jButton3.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButton3ActionPerformed(evt);
            }
        });

        jButton4.setText("Japan holidays");
        jButton4.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButton4ActionPerformed(evt);
            }
        });

        jButton5.setText("Payment");
        jButton5.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButton5ActionPerformed(evt);
            }
        });

        jButton6.setText("Last Update");
        jButton6.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButton6ActionPerformed(evt);
            }
        });

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap()
                .addComponent(jScrollPane1, javax.swing.GroupLayout.DEFAULT_SIZE, 366, Short.MAX_VALUE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                        .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                                .addComponent(jLabel1, javax.swing.GroupLayout.PREFERRED_SIZE, 116, javax.swing.GroupLayout.PREFERRED_SIZE)
                                .addComponent(jButton6, javax.swing.GroupLayout.PREFERRED_SIZE, 116, javax.swing.GroupLayout.PREFERRED_SIZE)
                                .addComponent(jButton3, javax.swing.GroupLayout.Alignment.TRAILING, javax.swing.GroupLayout.PREFERRED_SIZE, 116, javax.swing.GroupLayout.PREFERRED_SIZE))
                            .addComponent(jButton1, javax.swing.GroupLayout.Alignment.TRAILING, javax.swing.GroupLayout.PREFERRED_SIZE, 116, javax.swing.GroupLayout.PREFERRED_SIZE))
                        .addComponent(jButton2, javax.swing.GroupLayout.PREFERRED_SIZE, 116, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addComponent(jButton4, javax.swing.GroupLayout.Alignment.TRAILING, javax.swing.GroupLayout.PREFERRED_SIZE, 116, javax.swing.GroupLayout.PREFERRED_SIZE))
                    .addComponent(jButton5, javax.swing.GroupLayout.PREFERRED_SIZE, 116, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addContainerGap())
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(jScrollPane1)
                    .addGroup(layout.createSequentialGroup()
                        .addComponent(jLabel1)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(jButton1)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(jButton2)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(jButton3)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(jButton4)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(jButton5)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(jButton6)
                        .addGap(0, 57, Short.MAX_VALUE)))
                .addContainerGap())
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    private void jButton2ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButton2ActionPerformed
        // Account
        RandomDataGenerator rdg = new RandomDataGenerator();
        String result = "";
        for (int i = 1; i <= 30; i++) {
            int salary = rdg.getSalary();
            double tax = rdg.getTax(salary);
            double social_security_fund = rdg.getSocialSecurityFund();
            double provident_fund = rdg.getProvidentFund();
            int start = rdg.getStartYear();
            int end = rdg.getEndYear();
            employee[i - 1] = new employees(salary, tax, social_security_fund, provident_fund, start, end);
            result += String.format(
                "INSERT INTO salary (employee_id, salary, tax, social_security_fund, provident_fund) "
                + "VALUES (%d, %d, %.2f, %.2f, %.2f);",
            i, 
            salary,
            tax,
            social_security_fund,
            provident_fund
                ) + "\n";
        }
        jTextArea1.setText(result);
    }//GEN-LAST:event_jButton2ActionPerformed

    private void jButton3ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButton3ActionPerformed
        // Work time
        RandomDataGenerator rdg = new RandomDataGenerator();
        Random random = new Random();
        String result = "";
        for (int i = 1; i <= 30; i++) {
            int start = employee[i - 1].getStartYear();
            int end = employee[i - 1].getEndYear();
            for (int year = start; year <= end; year++) {
                for (int month = 1; month <= 12; month++) {
                    int days = rdg.getDay(year, month);
                    for (int day = 1; day <= days; day++) {
                        Calendar cal = Calendar.getInstance();
                        cal.set(year, month-1, day);
                        int dayOfWeek = cal.get(Calendar.DAY_OF_WEEK);
                        if (dayOfWeek != Calendar.SATURDAY && dayOfWeek != Calendar.SUNDAY) {
                            double work_time_chance = random.nextDouble();
                            if (work_time_chance <= 0.01) {
                                result += String.format(
                                    "INSERT INTO work_time (employee_id, work_date, arrival_time, departure_time, is_on_time, is_late, is_leave, overtime_hours, wage) "
                                    + "VALUES (%d, '%s', null, null, 0, 0, 1, 0.00, 0.00);", 
                                i, 
                                rdg.getDate(year, month)
                                    ) + "\n";
                            } else {
                                String arrivalTime = rdg.getArrivalTime();
                                String departureTime = rdg.getDepartureTime();
                                int isOnTime, isLate;
                                if (LocalTime.parse(arrivalTime).isAfter(LocalTime.parse("08:01"))) {
                                    isOnTime = 0;
                                    isLate = 1;
                                } else {
                                    isOnTime = 1;
                                    isLate = 0;
                                }
                                double overtime_case = random.nextDouble();
                                double overtime_hours = 0.00;
                                if (overtime_case <= 0.1) {
                                    departureTime = rdg.getOvertime();
                                    overtime_hours = rdg.calculateOvertimeHours(departureTime);
                                }
                                int wage = (int) (overtime_hours * 200);
                                result += String.format(
                                    "INSERT INTO work_time (employee_id, work_date, arrival_time, departure_time, is_on_time, is_late, is_leave, overtime_hours, wage) "
                                    + "VALUES (%d, '%s', '%s', '%s', %d, %d, 0, %.2f, %d);", 
                                i, 
                                String.format("%d-%02d-%02d", year, month, day), 
                                arrivalTime, 
                                departureTime, 
                                isOnTime, 
                                isLate,
                                overtime_hours,
                                wage
                                    ) + "\n";
                            }
                        }
                    }
                }
            }
        }
        jTextArea1.setText(result);
    }//GEN-LAST:event_jButton3ActionPerformed

    private void jButton5ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButton5ActionPerformed
        // Payment
        RandomDataGenerator rdg = new RandomDataGenerator();
        String result = "";
        int count = 1;
        for (int i = 1; i <= 30; i++) {
            int start = employee[i - 1].getStartYear();
            int end = employee[i - 1].getEndYear();
            for (int year = start; year <= end; year++) {
                int salary = employee[i - 1].getSalary();
                double tax = employee[i - 1].getTax();
                double social_security_fund = employee[i - 1].getSocialSecurityFund();
                double provident_fund = employee[i - 1].getProvidentFund();
                for (int month = 1; month <= 12; month++){
                    result += String.format(
                    "INSERT INTO payment_history (employee_id, salary, overtime, bonus, late_leave, tax, social_security_fund, provident_fund, amount, payment_date, transaction_by, status) "
                    + "VALUES (%d, %d, 0.00, %d, 0.00, %.2f, %.2f, %.2f, %d, '%s', '%s', 1);", 
                i, 
                salary,
                rdg.getBonus(salary),
                tax,
                social_security_fund,
                provident_fund,
                rdg.getAmount(salary, social_security_fund, provident_fund),
                rdg.getDate(year, month),
                rdg.getAccounting()
                    ) + "\n";
                    result += String.format(
                    "INSERT INTO transactions (transaction_id, employee_id, transaction_date, transaction_description) "
                    + "VALUES (%d, %d, '%s', '%s');", 
                count, 
                i, 
                rdg.getDate(year, month),
                    rdg.getAccounting() + " approved the salary of " + rdg.getEmployee(i)
                    ) + "\n";
                    count ++;
                }
                int new_salary = (int) Math.round(salary * 1.05);
                employee[i - 1].setSalary(new_salary);
                employee[i - 1].setTax(rdg.getTax(new_salary));
                employee[i - 1].setSocialSecurityFund(rdg.getSocialSecurityFund());
                employee[i - 1].setProvidentFund(rdg.getProvidentFund());
                result += String.format(
                "INSERT INTO transactions (transaction_id, employee_id, transaction_date, transaction_description) "
                + "VALUES (%d, %d, '%s', '%s');", 
            count, 
            i, 
            rdg.getDate(year, 12),
                rdg.getAccounting() + " update the salary of " + rdg.getEmployee(i)
                ) + "\n";
                count ++;
            }
        }
        for (int i = 1; i <= 30; i++) {
            result += String.format(
            "UPDATE salary SET salary = %d, tax = %.2f, social_security_fund = %.2f, provident_fund = %.2f WHERE employee_id = %d;", 
        employee[i - 1].getSalary(),
        employee[i - 1].getTax(),
        employee[i - 1].getSocialSecurityFund(),
        employee[i - 1].getProvidentFund(),
        i
            ) + "\n";
        }
        jTextArea1.setText(result);
    }//GEN-LAST:event_jButton5ActionPerformed

    private void jButton1ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButton1ActionPerformed
        // User
        RandomDataGenerator rdg = new RandomDataGenerator();
        String result = "";
        for (int i = 1; i <= 30; i++) {
            result += String.format(
            "INSERT INTO users (user_id, username, password) "
            + "VALUES (%d, '%s', '%s');", 
        i, 
        rdg.getEmployee(i).replace(' ', '_'), 
            rdg.getPassword()
            ) + "\n";
        }
        jTextArea1.setText(result);
    }//GEN-LAST:event_jButton1ActionPerformed

    private void jButton4ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButton4ActionPerformed
        // Japan holidays
        String result = "";
        for (int year = 2020; year <= 2023; year++) {
            Map<LocalDate, String> holidays = new HashMap<>();
            holidays.put(LocalDate.of(year, 1, 1), "元日 (New Year's Day)");
            holidays.put(LocalDate.of(year, 2, 11), "建国記念の日 (Foundation Day)");
            holidays.put(LocalDate.of(year, 4, 29), "昭和の日 (Showa Day)");
            holidays.put(LocalDate.of(year, 5, 3), "憲法記念日 (Constitution Day)");
            holidays.put(LocalDate.of(year, 11, 3), "文化の日 (Culture Day)");
            holidays.put(LocalDate.of(year, 12, 23), "天皇誕生日 (Emperor's Birthday)");
            for (Map.Entry<LocalDate, String> entry : holidays.entrySet()) {
                LocalDate date = entry.getKey();
                result += String.format(
                    "DELETE FROM work_time WHERE work_date = '%d-%02d-%02d';\n", 
                    date.getYear(), date.getMonthValue(), date.getDayOfMonth()
                );
            }
        }
        jTextArea1.setText(result);
    }//GEN-LAST:event_jButton4ActionPerformed

    private void jButton6ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButton6ActionPerformed
        // Last Update
        String result = 
            """
            DELETE FROM work_time WHERE YEAR(work_date) = 2023 AND MONTH(work_date) in (11, 12);
            DELETE FROM transactions WHERE YEAR(transaction_date) = 2023 AND MONTH(transaction_date) in (10, 11, 12);
            DELETE FROM payment_history WHERE YEAR(payment_date) = 2023 AND MONTH(payment_date) in (11, 12);
            UPDATE payment_history AS ph
            JOIN (
                SELECT
                    e.employee_id,
                    DATE_FORMAT(w.work_date, '%Y-%m') AS work_month_year,
                    SUM(w.wage) AS month_wage,
                    CASE 
                        WHEN COUNT(CASE WHEN w.is_late = 1 THEN 1 END) > 3 THEN (COUNT(CASE WHEN w.is_late = 1 THEN 1 END) - 3) * 1.5
                        WHEN COUNT(CASE WHEN w.is_leave = 1 THEN 1 END) > 2 THEN (COUNT(CASE WHEN w.is_leave = 1 THEN 1 END) - 2) * 2.5
                        ELSE 0
                    END AS deduction
                FROM employees e
                JOIN work_time w ON e.employee_id = w.employee_id
                GROUP BY e.employee_id, work_month_year
            ) AS data
            ON ph.employee_id = data.employee_id
            SET 
                ph.late_leave = data.deduction,
                ph.overtime = data.month_wage,
                ph.amount = ph.salary + data.month_wage + ph.bonus - (ph.salary * (data.deduction / 100)) - 750 - (ph.salary * (ph.provident_fund / 100));
            UPDATE payment_history
                SET
                salary = NULL,
                overtime = NULL,
                bonus = NULL,
                late_leave = NULL,
                tax = NULL,
                social_security_fund = NULL,
                provident_fund = NULL,
                amount = NULL,
                transaction_by = NULL,
                status = 0
            WHERE
                YEAR(payment_date) = 2023 AND MONTH(payment_date) = 10;
            """;
        jTextArea1.setText(result);
    }//GEN-LAST:event_jButton6ActionPerformed

    /**
     * @param args the command line arguments
     */
    public static void main(String args[]) {
        /* Set the Nimbus look and feel */
        //<editor-fold defaultstate="collapsed" desc=" Look and feel setting code (optional) ">
        /* If Nimbus (introduced in Java SE 6) is not available, stay with the default look and feel.
         * For details see http://download.oracle.com/javase/tutorial/uiswing/lookandfeel/plaf.html 
         */
        try {
            for (javax.swing.UIManager.LookAndFeelInfo info : javax.swing.UIManager.getInstalledLookAndFeels()) {
                if ("Nimbus".equals(info.getName())) {
                    javax.swing.UIManager.setLookAndFeel(info.getClassName());
                    break;
                }
            }
        } catch (ClassNotFoundException ex) {
            java.util.logging.Logger.getLogger(GenerateData.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (InstantiationException ex) {
            java.util.logging.Logger.getLogger(GenerateData.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            java.util.logging.Logger.getLogger(GenerateData.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (javax.swing.UnsupportedLookAndFeelException ex) {
            java.util.logging.Logger.getLogger(GenerateData.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
        //</editor-fold>
        //</editor-fold>

        /* Create and display the form */
        java.awt.EventQueue.invokeLater(new Runnable() {
            public void run() {
                new GenerateData().setVisible(true);
            }
        });
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton jButton1;
    private javax.swing.JButton jButton2;
    private javax.swing.JButton jButton3;
    private javax.swing.JButton jButton4;
    private javax.swing.JButton jButton5;
    private javax.swing.JButton jButton6;
    private javax.swing.JLabel jLabel1;
    private javax.swing.JScrollPane jScrollPane1;
    private javax.swing.JTextArea jTextArea1;
    // End of variables declaration//GEN-END:variables
}
