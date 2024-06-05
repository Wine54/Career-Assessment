This is an instruction incase you want to run our system on your device
-Please do note that this system will not work on android and ios.
-The system will only work on Windows and Mac

-First thing first, go on your web browser and search for Xampp download.
-click the first link and download 
-after that run .exe file and just next all the instructions, do not change the file allocation for xampp just go for default
 settings
-after you finish executing the installation package or the .exe file, just go and open xampp control panel.
- then start the apache and MySql
-after that if you already download this zip, Im assuming that you have already extracted it.
-if you already extracted the folder, right click the folder and hit the ctrl + x on your keyboard.
-then go to This pc then go to Acer(C:) the Acer(C:) may be different depending on the brand of your device.
-then go to xampp then htdocs, then paste the file just click ctrl + v
-after that open the xampp control panel, make sure that the Apache, and Mysql is already running
-then beside the start button of Mysql there is an admin button, click it, then you will be directed to phpmyadmin
-then click new then name the database: main_db
-after that click create
-then go main_db then under that click new, go to SQl Section
then paste this
     CREATE TABLE myLogin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_admin BOOLEAN DEFAULT FALSE,
    is_superadmin BOOLEAN DEFAULT FALSE
);
-then click the go button
-after that go to main_db again and click new
-then paste this
CREATE TABLE assessment_responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    realistic INT DEFAULT 0,
    investigative INT DEFAULT 0,
    artistic INT DEFAULT 0,
    social INT DEFAULT 0,
    enterprising INT DEFAULT 0,
    conventional INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-after all of that, to run the system, go browser search localhost/Online Career Assessment v.0.8.0
-then go to login package
- after that your all good to go, the system will properly now.