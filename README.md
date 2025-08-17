# E-commerce

A dynamic e-commerce website built using PHP and MySQL. Currently under development — includes responsive front-end, product categories, and cart functionality. Payment integration and email features coming soon.

## New Features & Updates
- **Dynamic Categories:** Added `Categories` table and foreign key in `PRODUCTS` table. Products can now be assigned to existing or new categories during upload.
- **Folder Structure:** Uploaded product files are stored in `Items/<CategoryName>/` directories, created automatically if they don't exist.
- **Database Updates:** `PRODUCTS` table now references `Categories(ID)` with `ON DELETE CASCADE` for relational integrity.
- **Cart & Orders:** Existing cart and orders functionality updated to support category-based product structure.
- **Secure Uploads:** Improved file handling and validation for product uploads.

## Setup Instructions
1. Run `Connection.php` and `Table_Creation.php` to automatically create database and tables (`Signup`, `Categories`, `PRODUCTS`, `CART`, `ORDERS`).
2. Place product files in `Items/<CategoryName>/` folders (folders created automatically on upload).
3. Access the website via `Home.php` and manage products via the upload page.

