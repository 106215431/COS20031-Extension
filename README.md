# COS20031-Extension
Cybersecurity extension task + Frontend for the Database Design project

**I. What is this?**
This is the repository responsible for holding Group 2's extension task, aka the Major-specfic improvements, made by the Cybersecurity majors of the group. This repository is used publically as a submission for further grading.

**II. What does this contain?**
This repository contains many php pages, but I'll summary this onto 3 main viewable pages:
1. Login page: Administrators are forced to enter their credentials in order to log into the main page itself. The login form is SQL-injection proof and is easy to operate.
2. Dashboard page: Administrators can view many general information as well as security-related information. Informations are displayed as individual values, tables or as graphs of many kinds. Currently the following information are viewable: Vehicles, Drivers, Mechanics, Safety events index, Vehicles by depot, Vehicle status distribution, Safety incident severity, Driver workforce status, Recent login activity and Authentication trends.
3. Administrator creation page: Administrators can create new accounts for many purposes. Currently this page is still in progress and security aspects are quite primitive, with only a password security check enabled.

**III. How do I replicate this?**
Instruction to replicate content:

1. Make sure all required dependencies are installed: XAMPP, MySQL, Apache, phpmyadmin,... (If you're on linux, please make sure services like: httpd, php, mysql, phpmyadmin - if not using mysql workbench)
2. Put the "SmartFleet" folder into the htdocs folder (if you're on Windows) or /var/www/html (if you're on Linux, in some cases access would be denied because Linux prevents you from putting change into this directory, please just use sudo to mv), and check if the database is working by using: "https://localhost/SmartFleet/login.php"
3. Copy and paste the creation statements and sample statements in the Week10+11 page on Confluence on phpmyadmin (or import directly onto mysql workbench if you would, but I intended this database to be able to run on Windows and Linux).
4. Open the "login.php" page and enter the following credentials: Username - admin, Password: Admin@123. If the site does not log you in, check the errors (your phpmyadmin or sql credentials may be incorrect, check *)

*WARNING: The repository owner has made some changes regarding the configuration of credentials within the initial phpmyadmin and sql settings. The following configurations were made: 
1. phpmyadmin credentials: Username - root, Password - "" (empty string)
2. MySQL + phpmyadmin socket creation destination port is **3307**, NOT 3306 (This is due to the owner's conflicting mysql services affecting initial deployment). This port change is reflected in both the phpmyadmin config settings and the SmartFleet's db.php code.

To revert back to factory default settings, please: Check if XAMPP's MySQL is running/listening on 3306. After that, go to db.php and delete the line "$port = 3307;" and "$port" on line 7 and 14.

**IV. Additional informations**
These are links that I added for the sake of convienience:
SQL creation: https://drive.google.com/file/d/1VnBDw-WullCS2AiZj5ke1E8LhXBaNz3N/view
SQL sample: https://drive.google.com/file/d/1gj5BS_v-dESyTdqfPIKFm-ed7Vc2WGRS/view
Please do not mistake this with Week06's scripts, they are for the **main** database, these new scripts help support the cybersecurity extension task by adding 2 new tables, functionally they are still the same, but we prefer you use the Week10+11 scripts instead to not conflict with our original work.
