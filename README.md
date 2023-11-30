# Make Sense Project

## Description
This project is an internal ideation platform developed for the Make Sense association. 
It enables employees to propose, view, and vote on ideas, aiding the transformation of these ideas into concrete projects.

## Getting Started

These instructions will guide you on how to get a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites
- PHP 7.4 or higher
- MySQL
- Composer
- Yarn 

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
    - Still in the project directory, install the front-end dependencies using Yarn:
      ```
      yarn install
      ```
    - Build the assets using Webpack:
      ```
      yarn watch
      ```

4. **Database Configuration**

    To set up the database for the project, follow these steps:

    **Create a MySQL Database**
   - First, create a new MySQL database for the project. You can name it as you like, for example, `makesense_db`

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
   - The application will now use these settings to connect to your MySQL database.
   - Note : the `.env.local` file should not be committed to your version control system as it contains sensitive information.
     

5. **Run the Application**
    Start the Symfony server:
    ```
    symfony server:start
    ```
6. **Access the application at**
    `http://localhost:8000` or the URL provided by Symfony.
