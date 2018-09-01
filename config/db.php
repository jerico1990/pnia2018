<?php

/*
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlsrv:Server=192.82.250.166,1533;Database=PNIA_SSA_TEST;',//PNIA_SSA;',
    'username' => 'dev1pnia',
    'password' => 'dev1pnia',
    'charset' => 'utf8',
];// */

/*
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlsrv:Server=localhost,1433;Database=Pnia;',//PNIA_SSA;',
    'username' => 'sa',
    'password' => 'Pokeyan23',
    'charset' => 'UTF-8',
];// */


// con Postgres, la buen a=)
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=localhost;dbname=pnia;',
    'username' => 'postgres',
    'password' => '123456',
    'charset' => 'utf8',
];// */

/*
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=newPnia;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock',
    'username' => 'my_username',
    'password' => 'my_password',
    'charset' => 'utf8',
	// Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];// */
