<?php

return [
    'SIDEBAR' => [
        'Dashboard' => [
            'route' => 'dashboard',
            'iconClass' => 'fa-solid fa-gauge-high',
        ],
        'Users' => [
            'route' => 'users',
            'iconClass' => 'fa-solid fa-users',
        ],
        'Category' => [
            'route' => 'category',
            'iconClass' => 'fa-solid fa-shapes',
        ],
        'Blogs' => [
            'route' => 'blogs',
            'iconClass' => 'fa-solid fa-blog',
        ],
        'Profile' => [
            'route' => 'profile',
            'iconClass' => 'fa-regular fa-user',
        ],
        'Static Pages' => [
            'active-route' => 'admin/static-page/*',
            'iconClass' => 'fa-solid fa-paperclip',
            'pages' => [
                'Aboutus' => [
                    'route' => 'static-page',
                    'iconClass' => 'fa fa-file-contract',
                    'param' => ['slug' => 'about-us'],
                ],
                'Terms & Condition' => [
                    'route' => 'static-page',
                    'iconClass' => 'fa fa-lock',
                    'param' => ['slug' => 'terms-condition'],
                ],
                'Privacy Policy' => [
                    'route' => 'static-page',
                    'iconClass' => 'fa fa-lock',
                    'param' => ['slug' => 'privacy-policy'],
                ],
            ]
        ],

    ],
];