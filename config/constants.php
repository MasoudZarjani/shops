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
            'color' => 5,
            'categoryComment' => 6,
            'categorySpecification' => 7,
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
            'avatar' => 4,
            'discussUser' => 5,
            'discussAdmin' => 6,
            'CommentUser' => 7
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
        ],
        'likeType' => [
            'like' => 1,
            'dislike' => -1,
            'nothing' => 0
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
            'path' => 'http://shop.noonmikhay.ir/uploads/images/banner.png',
            'title' => '',
            'link' => '',
            'type' => 0,
            'size' => 0
        ],
        'banner' => [
            'path' => 'http://shop.noonmikhay.ir/uploads/images/banner.png',
            'title' => '',
            'link' => '',
            'type' => 0,
            'size' => 0
        ],
        'pagination' => [
            'limited' => 10
        ]
    ],
    'server' => [
        'addWalletForReagentCode' => 1000,
        'limitedDevice' => 2,
        'message' => [
            'blockUser' => 'کاربری شما مسدود شده است.',
            'limitedIp' => 'تعداد درخواست های شما بیش از حد مجاز می باشد.',
            'blockDevice' => 'دستگاه شما مسدود شده است.',
            'limitedDevice' => 'تعداد دستگاه های شما بیش از حد مجاز است.',
            'verificationCode' => 'کد تایید معتبر نمی باشد.',
            'mobileNumberWrong' => 'شماره موبایل معتبر نمی باشد.',
            'reagentCodeFailed' => 'کد معرف اشتباه می باشد.'
        ]
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
    'session' => [
        'register' => [
            'type' => 0,
            'count' => 15
        ]
    ],
];
