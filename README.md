# VaultBook — Overseer's Contact Directory

A Fallout-inspired contact management web application built on the LAMP stack. VaultBook allows authenticated users to manage a personal directory of vault dwellers (contacts) through a terminal-style interface inspired by the Fallout series.

---

## Team

| Team Member     | Project Role      | Contact                                        |
|-----------------|-------------------|------------------------------------------------|
| Evan Jania      | PM / Front End    | evanjania@gmail.com / 386-451-2488             |
| Logan Elkins    | API               | loganelkins0101@gmail.com / 321-312-7314       |
| Kevin Estrada   | Database          | kevinkevin2796@gmail.com / 407-953-6630        |
| Siddanth Rajan  | Backend           | sid.rajan1323@gmail.com                        |
| Erkan Altundal  | API / Front End   | erkankerem532@gmail.com                        |

---

## Description

VaultBook is a full-stack web application themed around the Fallout universe. After registering and logging in, users are taken to the **Overseer's Directory** — a dashboard where they can manage their personal list of contacts (vault dwellers). Each contact is assigned a vault number and can be searched, edited, or deleted at any time.

---

## Features

- **User Registration & Login** — Create an account with first name, last name, username, and password. Log in with username and password.
- **Add Contacts** — Add new contacts to your vault directory with required fields.
- **View Contacts** — Browse your full contact list from the dashboard.
- **Edit Contacts** — Update the details of any existing contact.
- **Delete Contacts** — Remove contacts from your directory.
- **Search** — Search contacts by name or vault number.
- **Logout** — Securely log out and be redirected to the login page.

---

## Technologies Used

- **Linux** — Server operating system
- **Apache** — Web server
- **MySQL** — Relational database for users and contacts
- **PHP** — Server-side API endpoints
- **HTML / CSS / JavaScript** — Frontend interface
- **Tailwind CSS** — Utility-first CSS framework for styling
- **GitHub** - Version control, development workflow and code review for the team
- **Discord** - Communication, team meetings, and document sharing
- **SwaggerHub** - API Documentation
- **Postman** - API testing
- **FileZilla** - Organization, downloading, and deleting files within the server.

---

## Project Structure

```
vaultbook/
├── api/                  # PHP backend API endpoints
│   ├── Login.php
│   ├── Signup.php
│   ├── EditContacts.php
│   ├── AddContacts.php
│   ├── DeleteContacts.php
│   └──  Search.php   
├── public/               # Frontend files served by Apache
│   ├── index.html        # Login / Register page
│   ├── dashboard.html    # Overseer's Directory
│   ├── photo assets
│   ├── css/
│   └── js/
│   ├── database.sql
├── README.md
├── LICENSE.md
└── .gitignore
```

---

## Setup Instructions

### Prerequisites
- A Linux server with Apache, MySQL, and PHP installed (LAMP stack)
- Git installed on your local machine

### 1. Clone the Repository
```bash
git https://github.com/evanjania/POOSD-Group-6-Small-Project
cd vaultbook
```

### 2. Database Setup
Log into MySQL and create the database and tables:
```bash
mysql -u root -p
```
Create a `COP4331` database with a `Users` table and a `Contacts` table. The `Users` table should include: `ID`, `FirstName`, `LastName`, `Login`, `Password`, and `DateCreated`. The `Contacts` table should include: `ID`, `FirstName`, `LastName`, `Phone`, `Email`, `UserID`, `DateCreated`, and `VaultNumber`.

Create a MySQL user with access to the database and note the credentials for the next step.

### 3. Configure API Credentials
In each PHP file inside `api/`, update the database connection line with your credentials:
```php
$connection = new mysqli("localhost", "YOUR_DB_USER", "YOUR_DB_PASSWORD", "COP4331");
```

### 4. Deploy to Server
Copy frontend files to your Apache web root:
```bash
cp -r public/* /var/www/html/
```
Copy API files to the LAMPAPI directory:
```bash
cp -r api/* /var/www/html/LAMPAPI/
```

### 5. Set Permissions
```bash
chmod -R 644 /var/www/html/
```

---

## Accessing the Application

Once deployed, open a browser and navigate to your server's IP address or domain:
```
https://vaultbook.org/
```
- Register a new account on the login page
- Log in to access the Overseer's Directory dashboard
- Add, view, edit, search, and delete contacts from the dashboard

---

## Assumptions & Limitations

- Passwords are stored in plain text. This is a course project and is **not intended for production use**. Password hashing should be implemented before any real-world deployment.
- The application is designed for a single-user-per-account contact list — contacts are linked to the logged-in user's ID.
- The app is optimized for desktop browsers.
- The vault numbers assigned to contacts are random and unrelated to the inputted information.

---

## AI Usage

This project was developed with assistance from Claude (Anthropic) and ChatGPT (OpenAI) for code review, debugging, and documentation, in accordance with class policy.
