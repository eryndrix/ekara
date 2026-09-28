<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Database Connection
     |--------------------------------------------------------------------------
     |
     | Define database connection parameters. These values are pulled from
     | the environment file using env() helper for security.
     | 
     | Supported Doctrine ORM drivers:
     | - pdo_mysql   (MySQL)
     | - pdo_pgsql   (PostgreSQL)
     | - pdo_sqlite  (SQLite)
     | - pdo_sqlsrv  (SQL Server / MSSQL)
     | - oci8        (Oracle)
     |
     | Ensure DB_CONNECTION environment variable matches one of these drivers.
     |
    */
    'connection' => [
        'driver' => 'pdo_pgsql',
        'host' => env(key: 'DB_HOST', default: 'postgres'),
        'port' => env(key: 'DB_PORT', default: '5432'),
        'dbname' => env(key: 'DB_DATABASE'),
        'user' => env(key: 'DB_USERNAME'),
        'password' => env(key: 'DB_PASSWORD'),
        'options' => [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => true,
            1002 => 'disable',
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | ORM Configuration
     |--------------------------------------------------------------------------
     |
     | Doctrine ORM settings. Disables lazy ghost objects to prevent
     | symfony/var-exporter dependency issues during migrations.
     |
    */
    'orm' => [
        'enable_lazy_ghost_objects' => false,
        'enable_native_lazy_objects' => true,
    ],

    /*
     |--------------------------------------------------------------------------
     | Redis SSL Options
     |--------------------------------------------------------------------------
     |
     | Optional SSL configuration for Redis connections.
     | Uncomment and configure if SSL is required for Redis.
     |
    */
    'redis_ssl_options' => [
        'ssl' => [
            'cafile' => env(key: 'REDIS_CAFILE'),
            'local_cert' => env(key: 'REDIS_CLIENT_CERT'),
            'local_pk' => env(key: 'REDIS_CLIENT_KEY'),
            'verify_peer' => filter_var(
                value: env(key: 'REDIS_VERIFY_PEER'),
                options: FILTER_VALIDATE_BOOLEAN
            ),
            'verify_peer_name' => filter_var(
                value: env(key: 'REDIS_VERIFY_PEER_NAME'),
                options: FILTER_VALIDATE_BOOLEAN
            ),
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Metadata Directories
     |--------------------------------------------------------------------------
     |
     | Paths where Doctrine searches for entity metadata using attributes.
     | Points to application entity directories.
     |
    */
    'metadata_dirs' => [
        app_path(path: 'Account/Domain'),
    ],

    /*
     |--------------------------------------------------------------------------
     | Custom Doctrine Types
     |--------------------------------------------------------------------------
     |
     | Register custom Doctrine DBAL types for domain-specific value objects.
     | Each entry maps type name to its implementation class.
     |
    */
    'custom_types' => [
        [
            Ramsey\Uuid\Doctrine\UuidType::NAME,
            Ramsey\Uuid\Doctrine\UuidType::class
        ],
        [
            App\Shared\Infrastructure\Type\Id\UserIdType::NAME,
            App\Shared\Infrastructure\Type\Id\UserIdType::class
        ],
        [
            App\Account\Infrastructure\Type\AvatarType::NAME,
            App\Account\Infrastructure\Type\AvatarType::class
        ],
        [
            App\Account\Infrastructure\Type\PhoneType::NAME,
            App\Account\Infrastructure\Type\PhoneType::class
        ],
        [
            App\Shared\Infrastructure\Type\Id\RoleIdType::NAME,
            App\Shared\Infrastructure\Type\Id\RoleIdType::class
        ],
        [
            App\Shared\Infrastructure\Type\Slug\RoleSlugType::NAME,
            App\Shared\Infrastructure\Type\Slug\RoleSlugType::class
        ],
        [
            App\Shared\Infrastructure\Type\Id\PermissionIdType::NAME,
            App\Shared\Infrastructure\Type\Id\PermissionIdType::class
        ],
        [
            App\Shared\Infrastructure\Type\Slug\PermissionSlugType::NAME,
            App\Shared\Infrastructure\Type\Slug\PermissionSlugType::class
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Redis Connection URL
     |--------------------------------------------------------------------------
     |
     | Redis connection URL format (e.g., redis://localhost:6379).
     | Set via REDIS_URL environment variable.
     |
    */
    'redis_url' => env(key: 'REDIS_URL'),

    /*
     |--------------------------------------------------------------------------
     | Development Mode
     |--------------------------------------------------------------------------
     |
     | Enables dynamic proxy and metadata generation.
     | Active when APP_ENV is set to 'dev'.
     |
    */
    'dev_mode' => env(key: 'APP_ENV') === 'dev',
];
