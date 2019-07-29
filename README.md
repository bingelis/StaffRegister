DEMO CLI-application for staff register

Installation:
    composer install

Usage:
    php app.php [command] [argument]

    Available commands:
        register PERSONAL_DATA      Register a new person. PERSONAL_DATA should be represented in format:
                                    "firstname;lastname;email;phonenumber1;phonenumber2;comment;"
                                    Required field: firstname, lastname, email. Optional fields can be skipped by
                                    leaving empty value between semicolons.

        delete EMAIL                Delete a person from the register.

        find SEARCH_TERM            Find a person in the register.

        import FILE_PATH            Import persons using a CSV-file.
