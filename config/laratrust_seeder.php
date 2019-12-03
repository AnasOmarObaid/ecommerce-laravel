<?php

return [
    'role_structure' => [
        'super_admin' => [
            'users' => 'c,r,u,d',
            'departments'   => 'c,r,u,d',
            'products'   => 'c,r,u,d',
            'clients'    => 'c,r,u,d',
            'orders'    => 'c,r,u,d',
        ], // -- static role
        'admin' => [], // -- dynamic role
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ]
];
