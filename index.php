<?php



$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/php-framework', '', $requestUri);


switch ($requestUri) {
    case '/':
        echo 'Test page 1';
        break;
    case '/about':
        echo 'Test page 2';
        break;
   



    default:
        http_response_code(404);
        echo '404 Not Found :D';
        break;
}
