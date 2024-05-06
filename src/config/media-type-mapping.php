<?php

return [
    'product' => [
        // 驗證
        'verify' => App\Http\Requests\Product\UploadMediaRequest::class,
        // 商品主圖
        'main' => [
            'type'              => 'image',
            'multiple'          => FALSE,
            'directory'         => 'products/main',
            'collection'        => 'main',
            'manipulations'     => ['w' => 300, 'h' => 300],
            'custom_properties' => ['label' => 'Main Product Image'],
            'isPrivate'         => FALSE,
        ],
        // 商品附檔
        'additional' => [
            'type'              => 'any',
            'multiple'          => TRUE,
            'directory'         => 'products/additional',
            'collection'        => 'additional',
            'manipulations'     => ['w' => 300, 'h' => 300],
            'custom_properties' => ['label' => 'Additional Product Medias'],
            'isPrivate'         => FALSE,
        ],
    ],

    'order' => [
        // 驗證
        'verify' => App\Http\Requests\Order\UploadMediaRequest::class,
        // 身分證正面
        'frontOfIdCard' => [
            'type'              => 'image',
            'multiple'          => FALSE,
            'directory'         => 'orders/idCard',
            'collection'        => 'frontOfIdCard',
            'manipulations'     => ['w' => 300, 'h' => 300],
            'custom_properties' => ['label' => 'Front Of Id Card Image'],
            'isPrivate'         => TRUE,
        ],
        // 身分證反面
        'backOfIdCard' => [
            'type'              => 'image',
            'multiple'          => FALSE,
            'directory'         => 'orders/idCard',
            'collection'        => 'backOfIdCard',
            'manipulations'     => ['w' => 300, 'h' => 300],
            'custom_properties' => ['label' => 'Back Of Id Card Image'],
            'isPrivate'         => TRUE,
        ],
        // 身分證名正面 (ex:學生證、軍人證)
        'frontOfIdentity' => [
            'type'              => 'image',
            'multiple'          => FALSE,
            'directory'         => 'orders/identity',
            'collection'        => 'frontOfIdentity',
            'manipulations'     => ['w' => 300, 'h' => 300],
            'custom_properties' => ['label' => 'Front Of Identity Image'],
            'isPrivate'         => TRUE,
        ],
        // 身分證名反面 (ex:學生證、軍人證)
        'backOfIdentity' => [
            'type'              => 'image',
            'multiple'          => FALSE,
            'directory'         => 'orders/identity',
            'collection'        => 'backOfIdentity',
            'manipulations'     => ['w' => 300, 'h' => 300],
            'custom_properties' => ['label' => 'Back Of Identity Image'],
            'isPrivate'         => TRUE,
        ],
        // 補件
        'supplement' => [
            'type'              => 'any',
            'multiple'          => FALSE,
            'directory'         => 'orders/supplement',
            'collection'        => 'supplement',
            'manipulations'     => [],
            'custom_properties' => ['label' => 'Supplement Of Applicants Image'],
            'isPrivate'         => TRUE,
        ],
        // 本票
        'promissoryNote' => [
            'type'              => 'image',
            'multiple'          => FALSE,
            'directory'         => 'orders/promissoryNote',
            'collection'        => 'promissoryNote',
            'manipulations'     => ['w' => 300, 'h' => 300],
            'custom_properties' => ['label' => 'Promissory Note Image'],
            'isPrivate'         => TRUE,
        ],
        // 約定事項
        'agreement' => [
            'type'              => 'image',
            'multiple'          => FALSE,
            'directory'         => 'orders/agreement',
            'collection'        => 'agreement',
            'manipulations'     => ['w' => 300, 'h' => 300],
            'custom_properties' => ['label' => 'Agreement Image'],
            'isPrivate'         => TRUE,
        ],
        // 發票
        'invoice' => [
            'type'              => 'image',
            'multiple'          => FALSE,
            'directory'         => 'orders/invoice',
            'collection'        => 'invoice',
            'manipulations'     => ['w' => 300, 'h' => 300],
            'custom_properties' => ['label' => 'Order Invoice Image'],
            'isPrivate'         => TRUE,
        ],
    ],

    // 輪播
    'carousel' => [
        // 驗證
        'verify' => App\Http\Requests\Carousel\UploadMediaRequest::class,
        // 輪播圖片
        'carouselImage' => [
            'type'              => 'image',
            'multiple'          => FALSE,
            'directory'         => 'carouselImage',
            'collection'        => 'carouselImage',
            'manipulations'     => ['w' => 300, 'h' => 300],
            'custom_properties' => ['label' => 'Carousel Image'],
            'isPrivate'         => FALSE,
        ],
    ]
];
