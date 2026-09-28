<?php declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Log Level
    |--------------------------------------------------------------------------
    |
    | This option defines the default log level for exceptions that do not
    | have a #[Log] attribute and are not listed in the "exception_levels"
    | array below. You may use any of the PSR-3 log levels:
    |
    |   - debug
    |   - info
    |   - notice
    |   - warning
    |   - error
    |   - critical
    |   - alert
    |   - emergency
    |
    | Recommended: "error" for production, "debug" for development.
    |
    */

    'default_level' => env('DEFAULT_LOG_LEVEL', 'error'),

    /*
    |--------------------------------------------------------------------------
    | Exception Level Mapping
    |--------------------------------------------------------------------------
    |
    | Here you may map specific exception classes to log levels. This allows
    | you to override the default level for particular exceptions without
    | using the #[Log] attribute on the exception class itself.
    |
    | The keys are fully qualified exception class names and the values are
    | PSR-3 log levels (string). This is useful for exceptions you cannot
    | modify directly (e.g., from third-party packages).
    |
    */

    'exception_levels' => [
        \DomainException::class => 'warning',
        \InvalidArgumentException::class => 'warning',

        // Add your own mappings here:
        // \App\Exceptions\PaginationException::class => 'warning',
        // \App\Exceptions\UserNotFoundException::class => 'warning',
        // \App\Exceptions\UnexpectedException::class => 'critical',
    ],

    /*
    |--------------------------------------------------------------------------
    | Context Configuration by Level
    |--------------------------------------------------------------------------
    |
    | Define which exception details to include in the log context for each
    | log level. This allows you to have verbose context (including stack
    | traces) for critical errors and minimal context for info/debug logs.
    |
    | Available fields:
    |   - exception: Exception class name (e.g., "App\Exceptions\MyException")
    |   - code: Exception code (integer)
    |   - file: File where exception was thrown (string, full path)
    |   - line: Line number where exception was thrown (integer)
    |   - trace: Full stack trace (string, can be very verbose)
    |
    | Security note: In production, consider disabling "file", "line", and
    | "trace" to avoid exposing internal paths and code structure in logs.
    |
    */

    'context' => [
        /*
        |------------------------------------------------------------------
        | Emergency - System is unusable
        |------------------------------------------------------------------
        */
        'emergency' => [
            'exception' => true,
            'code' => true,
            'file' => true,
            'line' => true,
            'trace' => true,
        ],

        /*
        |------------------------------------------------------------------
        | Alert - Action must be taken immediately
        |------------------------------------------------------------------
        */
        'alert' => [
            'exception' => true,
            'code' => true,
            'file' => true,
            'line' => true,
            'trace' => true,
        ],

        /*
        |------------------------------------------------------------------
        | Critical - Critical conditions, component unavailable
        |------------------------------------------------------------------
        */
        'critical' => [
            'exception' => true,
            'code' => true,
            'file' => true,
            'line' => true,
            'trace' => true,
        ],

        /*
        |------------------------------------------------------------------
        | Error - Runtime errors, operation failed
        |------------------------------------------------------------------
        */
        'error' => [
            'exception' => true,
            'code' => true,
            'file' => true,
            'line' => true,
            'trace' => false,  // Disable trace to reduce log noise
        ],

        /*
        |------------------------------------------------------------------
        | Warning - Unusual condition, not necessarily an error
        |------------------------------------------------------------------
        */
        'warning' => [
            'exception' => true,
            'code' => true,
            'file' => false,  // Not needed for warnings
            'line' => false,
            'trace' => false,
        ],

        /*
        |------------------------------------------------------------------
        | Notice - Normal but significant event
        |------------------------------------------------------------------
        */
        'notice' => [
            'exception' => true,
            'code' => false,
            'file' => false,
            'line' => false,
            'trace' => false,
        ],

        /*
        |------------------------------------------------------------------
        | Info - Informational messages
        |------------------------------------------------------------------
        */
        'info' => [
            'exception' => true,
            'code' => false,
            'file' => false,
            'line' => false,
            'trace' => false,
        ],

        /*
        |------------------------------------------------------------------
        | Debug - Detailed information for debugging
        |------------------------------------------------------------------
        */
        'debug' => [
            'exception' => true,
            'code' => false,
            'file' => true,   // Helpful for debugging
            'line' => true,
            'trace' => false, // Enable if you need full stack traces
        ],
    ],
];
