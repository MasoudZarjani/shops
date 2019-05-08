<?php

return [
    'user' => [
        'status' => [
            'inactive' => 0,
            'active' => 1,
            'block' => 2,
        ],
        'role' => [
            'user' => 0,
            'admin' => 1,
        ],
        'type' => [
            'app' => 0,
            'campaign' => 1,
            'bot' => 2,
        ],
    ],
    'category' => [
        'type' => [
            'main' => 0,
            'special' => 1
        ],
        'status' => [
            'inactive' => 0,
            'active' => 1
        ]
    ],
    'product' => [
        'status' => [
            'inactive' => 0,
            'active' => 1
        ]
    ],
    'message' => [
        'status' => [
            'unread' => 0,
            'read' => 1,
            'submitted' => 2,
            'await' => 3,
            'rejected' => 4,
        ],
        'type' => [
            'message' => 0,
            'discuss' => 1,
            'comment' => 2,
        ]
    ],
    'attribute' => [
        'status' => [
            'inactive' => 0,
            'active' => 1
        ],
        'inputFieldType' => [
            'text' => 0,
            'number' => 1,
            'email' => 2,
            'textArea' => 3,
            'radioButton' => 4,
            'selectMenu' => 5,
            'checkBox' => 6
        ]
    ],
    'describe' => [
        'type' => [
            'text' => 0,
            'setting' => 1,
            'question' => 2,
            'layoutStatus' => 3,
            'group' => 4,
        ]
    ],
    'file' => [
        'type' => [
            'image' => 0,
            'video' => 1,
            'audio' => 2
        ],
        'position' => [
            'category' => 0,
            'mainSlider' => 1,
            'productMainImage' => 2,
            'productSliderFile' => 3,
            'avatar' => 4
        ]
    ],
    'action' => [
        'type' => [
            'bookmark' => 0,
            'like' => 1,
            'rate' => 2,
            'question' => 3
        ],
        'status' => [
            'inactive' => 0,
            'active' => 1
        ]
    ],
    'device' => [
        'status' => [
            'inactive' => 0,
            'active' => 1,
            'block' => 2,
        ],
        'os' => [
            'android' => 0,
            'ios' => 1,
        ]
    ],
    'price' => [
        'type' => [
            'noWarranty' => 0,
            'warranty' => 1,
            'discount' => 2
        ]
    ],
    'address' => [
        'type' => [
            'home' => 0,
            'work' => 1,
        ]
    ],
    'default' => [
        'category' => [
            ''
        ],
        'slider' => [
            'path' => 'http://lorempixel.com/output/sports-q-c-640-480-6.jpg',
            'title' => '',
            'link' => '',
            'type' => 0,
            'size' => 0
        ],
        'banner' => [
            'path' => 'http://lorempixel.com/output/sports-q-c-640-480-6.jpg',
            'title' => '',
            'link' => '',
            'type' => 0,
            'size' => 0
        ]
    ],
    'server' => [
        'message' => [
            'limitedIp' => 'به مدت 5 دقیقه امکان دریافت پیامک ندارید.',
            'blockUser' => 'کاربری شما مسدود شده است.',
            'limitedDevice' => 'تعداد دستگاه های شما بیش از حد مجاز است.',
            'verificationCode' => 'کد تایید معتبر نمی باشد.'
        ],
        'limitedDevice' => 2
    ],
    'error' => [
        'http' => [
            'ok' => 0,
            'noContent' => 1,
            'nonAuthoritative' => 2,
            'Unauthorized' => 3
        ],
        'message' => [
            'success' => 0,
            'unsuccessful' => 1,
            'response' => 2,
            'imageError' => 3,
        ],
        'file' => [
            'required' => 0,
            'size' => 1,
            'mime' => 2
        ],
    ],
    'activeIp' => [
        'register' => [
            'type' => 0,
            'count' => 15
        ]
    ],
];
