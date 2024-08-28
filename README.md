# LibraryMS-Test
1. Connect to Sql and Apache servers (XAMP)
2. Import library_ms.sql to PHPmyadmin to create database and tables
3. Configure .env file to connect to database (should be already configured if you have default localhost username and pass)
4. Change directory to project in terminal -> cd Library-MS
5. run command to populate database -> php artisan db:seed
6. run command to start server -> php artisan serve
7. Test Using http://127.0.0.1:8000/api/documentation  or  using Postman