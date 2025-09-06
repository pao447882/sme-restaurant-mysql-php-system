# SME Restaurant Management System

## Overview
This project is a **role-based web application** for managing sales, stock, and operations of a small restaurant business.  
It integrates a **MySQL relational database** with a **PHP-based web application**, designed to help store and manage data efficiently while generating reports for business decisions.

## Features
- **Sales & Stock Management**: Centralized database to record daily transactions and inventory.  
- **Role-based Access**: Different roles for admin, staff, and managers.  
- **Web-based Application**: Built with PHP, CSS, and JavaScript.  
- **Database Scripts**: SQL scripts to create schema, tables, and insert sample data.  
- **Demo Video**: Walkthrough of main application features.


## Installation Guide
1. **Install Required Software**
   - [XAMPP](https://www.apachefriends.org/) (Apache, MySQL, phpMyAdmin)  
   - Visual Studio Code (or any text editor)

2. **Setup Web Application**
   - Copy all files from `source/DS510_Project/` to:  
     ```
     C:\xampp\htdocs\store
     ```
   - Update database credentials in:
     ```
     /store/php/connect_db.php
     ```

3. **Setup Database**
   - Open phpMyAdmin and create a database:
     ```
     restaurant_db
     ```
   - Import schema and sample data using:
     ```
     sql/restaurant_db_script.sql
     ```

4. **Run Application**
   - Start Apache and MySQL in **XAMPP Control Panel**  
   - Open browser and visit:
     ```
     http://localhost/store
     ```
   - Login with the default test credentials (configurable in DB).

5. **Demo**
   - A walkthrough video of system functions can be found in the `vdo_demo/` folder.

## My Contributions
- **Database Design**: Designed schema, relationships, and SQL scripts.  
- **System Development**: Assisted in PHP application development and integration with MySQL.  

## Team Members
This project was developed collaboratively with:
- Thanan Kangsawiwat  
- Piyanut Thepsueb  
- Sarun Chotpradit  
- Yossarin Monplub  

## Notes
- Sensitive data, real business names, and private credentials are **not included** in this repository.  
- The SQL scripts and demo use **sample data only** for demonstration.  
