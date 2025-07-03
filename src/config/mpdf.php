<?php

return [
    'mode' => 'utf-8',
    'format' => 'A4',
    'author' => '',
    'subject' => '',
    'keywords' => '',
    'creator' => 'Laravel',
    'display_mode' => 'fullpage',
    'tempDir' => storage_path('temp'),
    'pdf_a' => false,
    'pdf_a_auto' => false,
    'default_font' => 'ipag',
    'default_font_size' => 0,
    'default_font_config' => [
        'ipag' => [
            'R' => 'ipag.ttf',
        ],
        'ipagp' => [
            'R' => 'ipagp.ttf',
        ],
    ],
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 16,
    'margin_bottom' => 16,
    'margin_header' => 9,
    'margin_footer' => 9,
    'orientation' => 'P',
];
