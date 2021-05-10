# gapstars-assesment

php-version = 7.4.14

1. git clone https://github.com/gihanprimesha/gapstars-assesment.git
2. cd gapstars-assesment
3. git fetch 
4. git checkout reports-generations

Update configurations in gapstars-assesment/Configs/local.php

	'user_name' => '<mySql databse usename>', 
    'password' => '<mySql databse password>',
    'server_name' => '<mysql running ip - eg :- 127.0.0.1>',
    'db_name' => '<data base name - eg :- otrium_challenge2>'

Path of index.php = gapstars-assesment/index.php

To check the assignment use chrome or firefox.

## Reports dowloadable urls
- Report one - domain-name/reports/report-one eg :- http://localhost:2217/reports/report-one
- Report two - domain-name/reports/report-one eg :- http://localhost:2217/reports/report-two
	
### To run unit test 
- open command prompt 
- cd gapstars-assesment
- run this command -> vendor/bin/phpunit
  
  
