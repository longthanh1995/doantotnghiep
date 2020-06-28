Steps to install & run project
-----------
Step 1: Install Docker (version: 19.03.8 or newer)
Step 2: open a terminal and go to downloaded source code. Run docker-compose up -d --build
Step 3: go to src folder from terminal at step 2
Step 4: [database] docker-compose exec php php /var/www/html/artisan migrate 
[Note] change location format from string to point in clinic table 
Step 5: copy data in db.sql and paste it to SQL tab in "appointment" database & click Go 
Step 6: open http://localhost:7000 to see the result
Step 7: [Account login] email: ryan.nguyen@manadr.com - pass: 123456
