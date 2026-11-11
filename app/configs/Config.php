<?php

define('BASE_URL', 'http://localhost/RentalGear-MVC');
define('BASEURL', BASE_URL . '/public');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_rental_gear');

define(
    'GEAR_UPLOAD_DIR',
    dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'gear' . DIRECTORY_SEPARATOR . 'uploads'
);
