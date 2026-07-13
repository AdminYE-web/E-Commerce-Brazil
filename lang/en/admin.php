<?php

return [
    'product_price_rules' => [
        'duplicate' => [
            'button' => 'Duplicate',
            'title' => 'Duplicate Product Price Rule',
            'description' => 'Copy the existing rule, select another product, and save it as a new rule.',
            'notice' => 'This is a copy of :name. You may change the product, rule name, options, and prices before saving. The original rule will not be changed.',
        ],
        'validation' => [
            'options_belong_to_product' => 'Required options must belong to the selected product.',
        ],
    ],
];
