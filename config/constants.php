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
            'productMainImage' => 2,
            'productSliderFile' => 3,
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
