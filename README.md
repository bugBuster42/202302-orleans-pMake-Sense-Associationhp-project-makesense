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

## Steps

1. **Clone the Repository**
    ```
    git clone git@github.com:bugBuster42/Make-Sense-Association.git
    ```

2. **Run composer install**

    Navigate to the cloned repository directory 
    `cd Make-Sense-Association`
   
   and run
    `composer install`

### Database Configuration
Create a MySQL database for the project. Duplicate the `.env` file to `.env.local` and update it with your database credentials.

### Run the Application
Start the Symfony server:
symfony server:start

Access the application at `http://localhost:8000` or the URL provided by Symfony.
