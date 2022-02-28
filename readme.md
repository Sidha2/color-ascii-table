# Colored ASCII Table

![Screenshot_1](https://user-images.githubusercontent.com/24494815/155949986-779973b0-65a9-4d2a-93dd-40985511fbbf.png)
![Screenshot_2](https://user-images.githubusercontent.com/24494815/155949996-6e677bd1-a02d-4d72-bf49-c55195db74b2.png)

## use
```php
<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';

use ColoredTable\Table;

$x = new Table();

$header = [
    [
        [
            "text" => "exchange",
            "decoration" => 0,
        ],
        [
            "text" => "date",
            "decoration" => 0,
        ],
        [
            "text" => "price",
            "decoration" => 0,
        ],
        [
            "text" => "xxx",
            "decoration" => 0,
        ]
    ],
];

$body = [
    [
            [
                "text" => "bitfinex",
                "decoration" => 1,
            ],
            [
                "text" => "1.1.2000",
                "decoration" => 2,
            ],    
            [
                "text" => "2344353",
                "decoration" => 1,
            ],    
            [
                "text" => "aaa aa aaa  aa",
                "decoration" => 0,
            ],
    ],
    [
            [
                "text" => "binance",
                "decoration" => 0,
            ],
            [
                "text" => "24.5.2022",
                "decoration" => 0,
            ], 
            [
                "text" => "232",
                "decoration" => 0,
            ], 
            [
                "text" => "erer",
                "decoration" => 0,
            ],    
    ],
   
];


echo $x->tableSet(2)->createTable($header, $body);
```