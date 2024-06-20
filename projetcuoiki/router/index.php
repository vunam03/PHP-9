<?php
require __DIR__ . '/vendor/autoload.php';

use Slim\Factory\AppFactory;

// Khởi tạo ứng dụng Slim
$app = AppFactory::create();

// Tùy chỉnh cấu hình của ứng dụng, middleware, và các thiết lập khác ở đây.

// Định nghĩa các tuyến đường ở đây.
$app->get('/', function ($request, $response, $args) {
    // Xử lý yêu cầu và trả về phản hồi
    $response->getBody()->write('Welcome to Slim Framework');
    return $response;
  
});

// Khởi động ứng dụng
$app->run();
