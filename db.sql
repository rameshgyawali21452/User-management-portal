$table_sql = "CREATE TABLE IF NOT EXISTS user_details (
    Id  int(100) NOT NUll PRIMARY KEY,
    email VARCHAR(100) NOT NULL ,
    username VARCHAR(50) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    address TEXT NOT NULL
)";