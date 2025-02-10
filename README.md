# Hospital Management Information System (HMIS)

[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
![Version](https://img.shields.io/badge/Version-2.0-orange)

A complete hospital management system which includes a Reception, Pharmacy, Admin panel and doctors.
## 📖 Introduction

This HMIS aims at having each department as a role, to better handle a real world scenario for a patient, featuring:
- Complete backend restructuring
- Improved pharmacy management module
- Advanced and new reception management system
- Enhanced patient workflow integration
- Improved database architecture

## 🚀 Key Features

### Core HMIS Modules
- Patient Registration & Records
- Pharmacy system
- Laboratory Integration
- Billing Processing
- Payroll Processing
- Vendor Management
- **Original UI Preserved**

### New Enhancements
➕ **Imporoved Pharmacy Management System**
- Has their own layout
- Drug inventory tracking
- Prescription status integration 
- Supplier management
- Expiry date alerts (Coming Soon!)
  
➕ **Reception Dashboard**
- New and old patients are checked
- Doctor selection based on least patients
- Multi-department coordination
- Outpatient doctor management
- Scheduling patients
- Insurance verification (Coming Soon!)

### System Improvements
- Each role with the appropriate intefaces for their role
- Each Doctor can only see assigned patient
- Appointment Scheduling
- Role-Based Access Control (Not Fully Complete/Secure)

<!-- ## 🛠️ Installation -->
## 🧪 Testing with XAMPP
### Local Environment Setup
1. Install [XAMPP](https://www.apachefriends.org):
2. Start XAMPP Control Panel and run:
   - Apache
   - MySQL

2. Access phpMyAdmin:
   ```bash
   http://localhost/phpmyadmin

3. Clone repository to `htdocs` folder:
   ```bash
   cd C:/xampp/htdocs
   git clone [repository-url] hmis

4. Create new database with the same name as the .sql file
   
5. Import the .sql file to myphpadmin with the same name.
   
7. Access system:
   ```bash
   http://localhost/folder-name

<!-- ### Setup Instructions
1. Clone repository:
   ```bash
   git clone [repository-url] -->

##

## 🧪 Testing native
### Local Environment Setup
1. Install [Docker](https://www.docker.com/):
2. Download the source files and the necessary docker files.
   - Dockerfile
   - docker-compose.yml

3. Run the following command:
   ```bash
   docker compose -f docker-compose.yml up -d

3. Access the site locally:
   ```bash
   http://localhost:8000/ -> For the website itself
   http://localhost:8081/ -> For the phpmyadmin interface

4. Create new database called my_db (Name can be changed but make sure to change it in the compose file)
   
5. Import the .sql file to myphpadmin with the same name.
   
7. Enjoy!

- For the actual image or if you need to pull it, run the following command
   ```bash
docker push theopensuite/hmis-app:latest

<!-- ### Setup Instructions
1. Clone repository:
   ```bash
   git clone [repository-url] -->

##
Login Credentials for admin are:

Admin Module Email: admin@admin.com

Admin Module Password: admin

##
**Credits**: The core framework and initial UI was design by [MartMbithi](https://github.com/MartMbithi).
