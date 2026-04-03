# EventMaster-Platform
This is an Event Management System Project for BRACU CSE370 Course done in Fall 2024 Semester.
# 🎉 EventMaster-Platform

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)

## 📖 Overview
**EventMaster-Platform** is a comprehensive, web-based Event Management System developed as a core project for the **BRACU CSE370 (Database Systems) course during the Fall 2024 Semester**. 

This platform simplifies the process of creating, managing, and attending events. It features dedicated portals for different user roles (Guests and Managers), ensuring a seamless experience from user registration to ticket generation and event reviews.

## ✨ Key Features
- **User Authentication:** Secure Sign-up, Login, and Logout functionality for all users.
- **Role-Based Dashboards:** - 👔 *Manager Dashboard:* For event creators/managers to draft, publish, and track events.
  - 👤 *Guest Dashboard:* For attendees to discover events, register, and manage their tickets.
- **Event Creation & Discovery:** Managers can create new events with specific details (`CreateEvent.php`), and guests can browse available events (`showevent.php`).
- **Ticketing System:** Built-in dynamic ticket generation for registered events (`ticket.php`).
- **Feedback & Reviews:** Post-event review submission to collect user feedback (`reviews.php`).
- **Database Architecture:** Robust relational database structure managing users, roles, events, and transactional data.

## 🛠️ Tech Stack
* **Frontend:** HTML5, CSS3 
* **Backend:** PHP
* **Database:** MySQL

## 📂 Repository Structure
```text
EventMaster-Platform/
├── About.html               # About page of the platform
├── CreateEvent.php          # Backend/UI for managers to host new events
├── EventMaster.html         # Main landing portal
├── Guest_dashboard.html     # Dashboard interface for attendees
├── Index.html               # Homepage entry point
├── Log_in.php / Sign_up.html# Authentication handling files
├── Manager_dashboard.html   # Dashboard interface for event managers
├── db_connect.php           # Database connection establishment
├── eventms.sql / dbb.sql    # Database schema and mock data files
├── event_details.php        # Detailed view for individual events
├── reviews.php              # Feedback and review management
├── showevent.php            # Event display listing
├── styles.css               # Global stylesheet
├── ticket.php               # Ticket generation logic
└── ...other utility files
## 🚀 Installation & Setup

To run this project locally, you will need a local server environment like **XAMPP**, **WAMP**, or **MAMP**.

1. **Clone the repository:** Run `git clone https://github.com/sillyfellow21/EventMaster-Platform.git` in your terminal.
2. **Move to local server directory:** Place the cloned folder into your server's root directory (`htdocs` for XAMPP or `www` for WAMP).
3. **Access Database Manager:** Open your local PHPMyAdmin interface (usually at `http://localhost/phpmyadmin`).
4. **Create Database:** Create a new database named `eventms`.
5. **Import Schema:** Import the provided SQL file (`eventms.sql` or `dbb.sql`) into the newly created database.
6. **Configure Connection:** Open `db_connect.php` and verify that the database credentials match your local setup (e.g., username `root`, no password).
7. **Run the Application:** Open your web browser and navigate to `http://localhost/EventMaster-Platform/Index.html`.

## 💡 Usage Workflow

* **New Users:** Start by navigating to the sign-up page to create an account as either a Guest or a Manager.
* **Managers:** Log in, access the Manager Dashboard, and begin creating new events with specific dates, descriptions, and capacities.
* **Guests:** Log in, browse the active events listing, register for an event you wish to attend, and retrieve your digital ticket.

## 🎓 Academic Context

This repository represents academic coursework for **CSE370** at **BRAC University**. The project emphasizes the practical application of database schema design, normalization, CRUD operations, and connecting frontend interfaces with a relational database via PHP.
