# Project Name: DapurKode, a Laravel-Based Service Management Platform

## Description
This project is a Laravel-based service management platform designed to facilitate interactions between vendors, users, installers, and affiliates. The platform provides features such as service creation, invoicing, affiliate management, project requests, and balance tracking, offering a comprehensive solution for managing service-related workflows.

---

## Features

### **User Roles**
- **Admin**: Manage users, services, invoices, and affiliate requests.
- **Vendor**: Create, manage, and track services.
- **Installer**: Submit and manage project requests.
- **Affiliator**: Promote services and track affiliate earnings.

### **Core Functionalities**
- **Service Management**:
  - Create and manage services.
  - Group services by categories.
  - Add custom fees for each service (installer fee, affiliator fee, etc.).

- **Invoice Management**:
  - Generate invoices for services.
  - Apply discount codes and track affiliate commissions.

- **Affiliate Management**:
  - Track purchases made through affiliate links.
  - Update affiliate balances and monitor commissions.

- **Installer Management**:
  - Submit project requests for services.
  - Update project progress and track status.

- **Admin Tools**:
  - Approve/reject project requests.
  - Update service fees and statuses.
  - Manage user accounts and affiliate requests.

### **Additional Features**
- Pagination and search for data tables.
- Secure login and registration with redirect functionality.
- File upload with validation (e.g., image size restrictions).
- User-friendly and modern UI.

---

## Installation Guide

### **Requirements**
- PHP >= 8.0
- Composer
- Laravel Framework >= 10
- MySQL or compatible database
- Node.js and npm (for asset compilation)

### **Steps**

1. **Clone the Repository**
   ```bash
   git clone https://github.com/BayuTirta-911/dapurkode
   cd dapurkode
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Setup Environment**
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update database credentials and other configurations in the `.env` file.

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations and Seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Start the Development Server**
   ```bash
   php artisan serve
   ```

7. **Access the Application**
   Open a browser and navigate to:
   ```
   http://127.0.0.1:8000
   ```

### **Optional Steps**
- **Setup Storage Link**:
  ```bash
  php artisan storage:link
  ```
- **Clear Cache**:
  ```bash
  php artisan config:clear
  php artisan cache:clear
  ```