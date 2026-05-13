A backend API for a dummy top up system.

## Installation

1. Clone the project
```bash
git clone https://github.com/Ikhwanu-Robik/technical-test-task-hostdataid.git
cd technical-test-task-hostdataid
```

2. Install dependencies
```bash
composer install
```

3. Copy .env.example
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Configure database
```dotenv title=".env"
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=technical-test-task-hostdataid
DB_USERNAME=root
DB_PASSWORD=
```

6. Start database server

7. Run migration and seeder
```bash
php artisan migrate --seed
```
or import the **database/technical_test_task_hostdataid.sql** in your database

8. Start php server
```bash
php artisan serve
```