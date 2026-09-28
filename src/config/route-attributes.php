<?php

return [
    /*
     * Enable automatic route registration
     */
    'enabled' => true,

    /*
     * Controllers in these directories that have routing attributes
     * will automatically be registered.
     * 
     * Optionally, you can specify group configuration by using key/values
     */
    'directories' => (function () {
        /**
         * Common configuration for all API Action directories
         * 
         * @var array<string, string|array<string>>
         */
        $commonConfig = [
            'prefix' => 'api',
            'middleware' => 'api',
            // only register routes in files that match the patterns
            'patterns' => ['*Controller.php'],
            // do not register routes in files that match the patterns
            'not_patterns' => ['*Test.php']
        ];

        /**
         * List of modules with Presentation/Action directories
         * 
         * @var array<string>
         */
        $directories = [
            'Account/Presentation',
        ];

        /**
         * Generated directory configurations
         * 
         * @var array<string, array<string, string|array<string>>>
         */
        $dirsConfig = [];
        
        foreach ($directories as $dir) {
            $dirsConfig[app_path($dir)] = $commonConfig;
        }

        return $dirsConfig;
    })(),

    /*
     * This middleware will be applied to all routes.
     */
    'middleware' => [
        \Illuminate\Routing\Middleware\SubstituteBindings::class
    ],

    /*
     * When enabled, implicitly scoped bindings will be enabled by default.
     * Override with `ScopeBindings(false)` attribute.
     * 
     * Possible values:
     *  - null: use the default behaviour
     *  - true: enable implicitly scoped bindings for all routes
     *  - false: disable implicitly scoped bindings for all routes
     */
    'scope-bindings' => null,
];
