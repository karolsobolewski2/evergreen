<?php

require_once(
    dirname(__FILE__).
    DIRECTORY_SEPARATOR.
    '..'.DIRECTORY_SEPARATOR.
    '..'.DIRECTORY_SEPARATOR.
    '..'.DIRECTORY_SEPARATOR.
    'wp-load.php'
);

header('Content-Type: application/json');
echo json_encode(idg_cart_endpoint_universal());
