# RedditRecs Symfony

A Reddit recommendation aggregator built with Symfony 7.

## 🚀 Setup on a New Machine

When you clone this repository to a new computer, some files (dependencies and secrets) will be missing. Follow these steps to get it running.

### 1. Install Dependencies
The `vendor/` folder is ignored by git, so you need to install the PHP packages.

```bash
composer install
```

### 2. Configure Environment
The `.env` file contains safe defaults, but you need to configure your real database connection in a local overrides file.

1.  Create a file named `.env.local` in the project root.
2.  Add your database credentials:

```bash
# .env.local
DATABASE_URL="mysql://username:password@127.0.0.1:3306/redditrecs?serverVersion=8.0.32&charset=utf8mb4"
```

*   **If using MAMP**: `mysql://root:root@127.0.0.1:8889/...`
*   **If using Railway/Cloud**: Copy the `DATABASE_URL` from your provider.

### 3. Database Setup
If you are connecting to a **new** empty database (local), you need to create the schema:

```bash
php bin/console doctrine:migrations:migrate
```

*(Note: If connecting to a shared cloud database that already has data, you skip this step.)*

### 4. Run the Server

```bash
php -S 127.0.0.1:8000 -t public
```

Visit `http://127.0.0.1:8000`.
