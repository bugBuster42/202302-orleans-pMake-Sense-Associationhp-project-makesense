# Make Sense Project

## Description
This project is an internal ideation platform developed for the Make Sense association. 
It enables employees to propose, view, and vote on ideas, aiding the transformation of these ideas into concrete projects.
- **Key Features**:
  - **Idea Submission**: Employees can propose their ideas.
  - **Viewing and Voting**: Access and vote on submitted ideas.
  - **Idea Progress Tracking**: Status updates from initial consideration to final decision.
  - **Notifications**: Alerts for impacts on submitted ideas or expert nominations.
  - **Category Management**: Admins can create and modify idea categories.
  - **Profile Management**: Admins control user roles and platform access.
  - **Security**: Implemented CSRF protection for data and access security.

## Getting Started

These instructions will guide you on how to get a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites
- PHP 7.4 or higher
- MySQL
- Composer
- npm

## Steps

1. **Clone the Repository**
    ```
    git clone git@github.com:bugBuster42/Make-Sense-Association.git
    ```

2. **Install PHP Dependencies**
    Navigate to the cloned repository directory:
    ```
    cd Make-Sense-Association
    ```
    and run:
    ```
    composer install
    ```

3. **Install and Build Front-End Dependencies**
    - Still in the project directory, install the front-end dependencies using Yarn
      ```
      npm install
      ```
    - Build Assets
      ```
      npm run build
      ```

4. **Database Configuration**

    To set up the database for the project, follow these steps

    **Create a MySQL Database :**
   
   First, create a new MySQL database for the project. You can name it as you like, for example, `makesense_db`
  
     **Open your Terminal :**
   
   Type the following command
   ```
    mysql -u root -p
   ```
   
     You will be prompted to enter the password for the MySQL `root` user.
    Enter it, and press Enter.
       
     **Create the Database :**
   
     Once connected to MySQL, create the database by executing
   ```
   CREATE DATABASE makesense_db;
   ```
     **Exit MySQL :**
   
     To leave the MySQL interface, type
   ```
   exit;
    ```
   **Configure Database Credentials**
   - Duplicate the `.env` file at the root of your project and rename the copy to `.env.local`
   - Open the `.env.local`and find the line that starts with `DATABASE_URL="mysql:`
   - Modify this line with your database credentials:

     Replace `db_user`, `db_password`, and `db_name` with your MySQL username, password, and the name of the database you created.
     
     For example:
     ```
     DATABASE_URL="mysql://myusername:mypassword@127.0.0.1:3306/makesense_db?serverVersion=5.7&charset=utf8mb4"
     ```
   - Make sure to use the correct server version for MySQL.

   **Apply the Database Configuration**
   - Once you have updated the `.env.local` file, save your changes.
     
     Note : The application will now use these settings to connect to your MySQL database.
     The `.env.local` file should not be committed to your version control system as it contains sensitive information.
  
    **Apply Database Migrations**
    - After setting up your database and credentials, apply migrations to create the necessary database structure:
      ```
      symfony console d:m:m
      ```
      This command will execute the migration files and set up the database structure according to your entity configurations.
      
    - Once the database is set up and migrations are applied, load the data fixtures to populate the database with necessary initial data:
        ```
         symfony console d:f:l
        ```
   
       This will load the data defined in your fixtures files into the database, which may include necessary user accounts and other initial data.
      
5. **Default User Accounts**
   - To log in to the application for the first time, use the credentials defined in the `UserFixtures` file.
   - You can find this file at `src/DataFixtures/UserFixtures.php`.
   - The file contains the default usernames and passwords for initial user accounts.

        
6. **Run the Application**
    Start the Symfony server:
    ```
    symfony server:start
    ```
7. **Access the application at**
    `http://localhost:8000` or the URL provided by Symfony.
