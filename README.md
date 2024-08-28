# LibraryMS-Test
1. Clone repository -> git clone https://github.com/ahmedelragal/LibraryMS-Test
2. cd LibraryMS-Test
3. Connect to Sql and Apache servers (XAMP)
4. Import library_ms.sql to PHPmyadmin to create database and tables (can run migrations also)
5. Configure .env file to connect to database (should be already configured if you have default localhost username and pass)
6. Change directory to project in terminal -> cd Library-MS
7. run command to populate database -> php artisan db:seed
8. run command to start server -> php artisan serve
9. Test Using http://127.0.0.1:8000/api/documentation  or  using Postman
## Note: Add following headers in Postman if json responses arent being displayed
Content-Type:application/json

Accept:application/json
