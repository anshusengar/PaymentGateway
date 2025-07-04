<?php

return [

    'models' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your permissions. Of course,
         * it is often just the "Permission" model but you may use whatever you like.
         *
         * The model you want to use as a Permission model needs to implement the
         * `Spatie\Permission\Contracts\Permission` contract.
         */

        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your roles. Of course, it
         * is often just the "Role" model but you may use whatever you like.
         *
         * The model you want to use as a Role model needs to implement the
         * `Spatie\Permission\Contracts\Role` contract.
         */

        'role' => Spatie\Permission\Models\Role::class,

    ],

    'table_names' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your permissions. You may change this
         * if you want.
         */

        'roles' => 'roles',

        'permissions' => 'permissions',

        'model_has_permissions' => 'model_has_permissions',

        'model_has_roles' => 'model_has_roles',

        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [

        /*
         * Change this if you want to name the related model primary key other than
         * `model_id`.
         *
         * For example, this would be nice for multi-tenant:
         * 'model_morph_key' => 'tenant_id',
         */

        'model_morph_key' => 'model_id',
    ],

    /*
     * When set to true, the package will register its permissions with the Laravel
     * Gate class for you.
     *
     * This means you can perform authorization checks using Laravel's `can` function:
     *
     * ```php
     * $user->can('view-posts');
     * ```
     */

    'register_permission_check_method' => true,

    /*
     * By default permission and role names are stored on the pivot table as normal
     * Eloquent attributes, but if you want to store them using JSON, set this to
     * true. Then a 'name' column will be stored as a JSON array.
     */

    'teams' => false,

    /*
     * By default the package looks for a `guard_name` attribute on your roles and
     * permissions, which means you can easily run multiple guards (like 'web' and
     * 'api') side by side. If you don't need that, you can set this to a fixed
     * guard name to speed up lookups.
     */

    'guard_name' => 'web',

    /*
     * Cache permission settings
     */
    'cache' => [

        /*
         * By default all permissions are cached for 24 hours to speed up performance.
         * When permissions or roles are updated the cache is flushed automatically.
         */

        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * The key to use when tagging permission cache.
         */

        'key' => 'spatie.permission.cache',

        /*
         * When checking for permissions, the package will check first the cache
         * and only query the database if the permission is not found in the cache.
         * Set this to false if you want to disable caching completely.
         */
        'store' => 'default',
    ],
];
