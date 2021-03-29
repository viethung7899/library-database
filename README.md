# library-database

The implementation of database management system for library

## How to run this project on your local machine

To contribute to this project, read the instruction [here](docs/README.md)

### Requirements

- Make sure you have `git` on the command line. Download it [here](https://git-scm.com/downloads)
- XAMPP v7.4.14 or above
- Make sure Apache and MySQL database are running
- Make sure PHP version 7.4.14 or above can run in the command line by running `php -v`

### Installation

1. Navigate to the xampp installation directory

2. Open the command line on `htdocs` directory and run

    ```bash
    git clone https://github.com/viethung7899/library-database
    ```

3. Copy file `.env.example` into a new file `.env` annd configure your database by changing your `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD`, `DB_NAME`

4. Run these commands

    ```bash
    # Install dependecies
    php bin/composer update

    # Migrate the database (creating database, table, and then populate data)
    php migration.php

    # Run the program
    php -S localhost:8080 -t public
    ```

5. The website is now running on `localhost:8080`
