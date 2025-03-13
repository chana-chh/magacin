<?php

define('APP_NAME', 'MAGACIN');

define('DS', DIRECTORY_SEPARATOR);
define('DIR', dirname(__DIR__) . DS);

require DIR . 'vendor/autoload.php';
require DIR . 'App/fje.php';
require DIR . 'App/cfg.php';

define('HOST', filter_input(INPUT_SERVER, 'REQUEST_SCHEME', FILTER_SANITIZE_SPECIAL_CHARS) . '://'
    . filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_SPECIAL_CHARS));

$app = new \Slim\App($config);
require DIR . 'App/dic.php';

define('URL', HOST . $container['request']->getUri()->getBasePath() . '/');

require DIR . 'App/mid.php';
require DIR . 'App/routes.php';

date_default_timezone_set('Europe/Belgrade');

ini_set('log_errors', true);
ini_set('log_errors_max_len', '10K');
ini_set('error_log', DIR . DS . 'App' . DS . 'runtime' . DS  . 'errors.log');

ini_set('default_charset', 'UTF-8');
ini_set('expose_php', false);
ini_set('allow_url_fopen', false);
ini_set('allow_url_include', false);

ini_set('memory_limit', '128MB');
ini_set('max_execution_time', 60);

ini_set('file_uploads', 0);
ini_set('upload_max_filesize', '2M');
ini_set('upload_tmp_dir', DIR . DS . 'App' . DS . 'runtime');

if (in_array('sha512', hash_algos())) {
    ini_set('session.hash_function', 'sha512');
}

ini_set('session.hash_bits_per_character', 5);
ini_set('session.use_trans_sid', 0);
ini_set('session.use_only_cookies', 1);
ini_set('session.save_path', DIR . DS . 'app' . DS . 'tmp' . DS . 'ses');

session_start();

// Session expiration time in minutes
$sess_expire = 30;

if (isset($_SESSION['LAST_ACTION'])) {
    $sec = time() - $_SESSION['LAST_ACTION'];
    $expire = $sess_expire * 60;

    if ($sec >= $expire) {
        session_unset();
        session_destroy();
    }
}

$_SESSION['LAST_ACTION'] = time();
