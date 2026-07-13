<?php

return [
    'product_price_rules' => [
        'duplicate' => [
            'button' => '複製',
            'title' => '商品価格ルールを複製',
            'description' => '既存のルールをコピーし、別の商品を選択して新しいルールとして保存します。',
            'notice' => ':name のコピーです。保存する前に商品、ルール名、オプション、価格を変更できます。元のルールは変更されません。',
        ],
        'validation' => [
            'options_belong_to_product' => '必須オプションは、選択した商品に属している必要があります。',
        ],
    ],
];
