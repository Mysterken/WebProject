<?php
//site name
const SITE_NAME = 'WebProject';

//App Root
define('APP_ROOT', dirname(__FILE__, 2));
const URL_ROOT = '/';
const URL_SUBFOLDER = '';

//DB Params
const DB_HOST = 'webproject_db_1';
const DB_USER = 'root';
const DB_PASS = 'example';
const DB_NAME = 'web_db';
const DB_PORT = '3306';

const DSN = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=UTF8";