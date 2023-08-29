<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'admin');
define('DB_PASS', '1234');
define('DB_NAME', 'blog-system-db');

// insert classes
require_once __DIR__.'../../classes/Database.php';
require_once __DIR__.'../../classes/Sanitizer.php';
require_once __DIR__.'../../classes/Tokenize.php';
require_once __DIR__.'../../classes/Authentication.php';
require_once __DIR__.'../../classes/Category.php';
require_once __DIR__.'../../classes/Like.php';
require_once __DIR__.'../../classes/Post.php';
require_once __DIR__.'../../classes/Upload.php';
require_once __DIR__.'../../classes/User.php';
require_once __DIR__.'../../classes/Validation.php';
?>