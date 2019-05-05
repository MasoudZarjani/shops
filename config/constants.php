<?php

return [
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
            'question' => 2
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
        ]
    ],
    'action' => [
        'type' => [
            'bookmark' => 0,
            'like' => 1,
            'score' => 2,
            'question' => 3
        ],
        'status' => [
            'inactive' => 0,
            'active' => 1
        ]
    ],
    'default' => [
        'category' => [
            ''
        ],
        'slider' => [
            'path' => 'http://lorempixel.com/output/sports-q-c-640-480-6.jpg',
            'title' => '',
            'description' => ''
        ]
    ],
];
