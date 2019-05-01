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
    'describe' => [
        'type' => [
            'text' => 0,
            'setting' => 1
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
            'mainImage' => 2,
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
    ]
];
