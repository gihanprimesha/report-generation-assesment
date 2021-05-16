# gapstars-assessment

# Overview

This is the csv reports generation tool for the Otrium .
This is working as a rest api. After setup the application, you can generate the csv files
calling api endpoints.

## Prerequisites

- php-version = 7.4.14
- nginx or aparche server
- To test use Postman

1. git clone https://github.com/gihanprimesha/gapstars-assesment.git
2. cd gapstars-assesment
3. git fetch
4. git checkout reports-generations

Update configurations in gapstars-assesment/Configs/local.php

    'user_name' => '<mySql database username>',
    'password' => '<mySql database password>',
    'server_name' => '<mysql running ip - eg :- 127.0.0.1>',
    'db_name' => '<database name - eg :- otrium_challenge2>'

Path of index.php = gapstars-assesment/index.php

To check the assignment use the postman or any tool like postman

## Reports downloadable end points

### Turnover per brand

    - <domain-name>/reports/turn-over-per-brand eg :- http://localhost:2217/reports/turn-over-per-brand
    - Request :-
        {
            "startDate":"2018-05-01",
            "endDate":"2018-06-07",
            "pageNumber":"1",
            "rowsPerPage":"2"
        }
    - Response :-
        {
            "status": "success",
            "data": {
                "fileName": "report-19:31:34 16-May-2021.csv",
                "fileLocation": "http://localhost:2217/files/report-19:31:34 16-May-2021.csv"
            },
            "message": null
        }

### Turnover per day

    - <domain-name>/reports/turn-over-per-day eg :- http://localhost:2217/reports/turn-over-per-day
    - Request :-
        {
            "startDate":"2018-05-01",
            "endDate":"2018-06-07",
            "pageNumber":"1",
            "rowsPerPage" : "2"
        }
    - Response :-
        {
            "status": "success",
            "data": {
                "fileName": "report-19:31:34 16-May-2021.csv",
                "fileLocation": "http://localhost:2217/files/report-19:31:34 16-May-2021.csv"
            },
            "message": null
        }

### Turnover per day and per brand

    - <domain-name>/reports/turn-over-per-day-per-brand eg :- http://localhost:2217/reports/turn-over-per-day-per-brand
    - Request :-
            {
                "startDate":"2018-05-01",
                "endDate":"2018-06-07",
                "pageNumber":"1",
                "rowsPerPage" : "2"
            }
    - Response :-
            {
                "status": "success",
                "data": {
                    "fileName": "report-19:31:34 16-May-2021.csv",
                    "fileLocation": "http://localhost:2217/files/report-19:31:34 16-May-2021.csv"
                },
                "message": null
            }

## Sample error responses

        {
            "status": "error",
            "data": null,
            "message": {
                "type": "VALIDATION_ERROR",
                "description": "Validation Failed! Required property startDate"
            }
        }

        {
            "status": "error",
            "data": null,
            "message": {
                "type": "NO_DATA_FOUND_ERROR",
                "description": "No report data found"
            }
        }

### To run unit test

- open command prompt
- cd gapstars-assesment
- run this command -> vendor/bin/phpunit
