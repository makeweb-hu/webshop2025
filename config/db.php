<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=dragcards',
    'username' => 'root',
    'password' => 'gabor1992',
    'charset' => 'utf8mb4',
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 86400, /// 1 nap
    'schemaCache' => 'cache',
];

