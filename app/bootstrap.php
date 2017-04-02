<?php
use app\lib\Route;

require_once 'config/config.php';

include 'lib/core.php';

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();

Route::match();