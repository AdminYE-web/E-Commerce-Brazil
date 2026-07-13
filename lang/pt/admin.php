<?php

return [
    'product_price_rules' => [
        'duplicate' => [
            'button' => 'Duplicar',
            'title' => 'Duplicar regra de preço do produto',
            'description' => 'Copie a regra existente, selecione outro produto e salve-a como uma nova regra.',
            'notice' => 'Esta é uma cópia de :name. Você pode alterar o produto, o nome da regra, as opções e os preços antes de salvar. A regra original não será alterada.',
        ],
        'validation' => [
            'options_belong_to_product' => 'As opções obrigatórias devem pertencer ao produto selecionado.',
        ],
    ],
];
