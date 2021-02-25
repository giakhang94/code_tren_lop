<?php
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);
$layout_name = 'layout.php';
$page_kind = 'userside';
if(!empty($uri_segments[1]) && $uri_segments[1] == 'cms'){
  $page_kind = 'cms';
}

$pages =  "index";
if (isset($_GET["pages"])) {
  $pages = $_GET["pages"];
}
$_Content = "./Pages/{$page_kind}/functions/{$pages}.php";

if (isset($_SERVER['HTTP_HOST']) && preg_match('/^((\[[0-9a-f:]+\])|(\d{1,3}(\.\d{1,3}){3})|[a-z0-9\-\.]+)(:\d+)?$/i', $_SERVER['HTTP_HOST']))
{
  $base_url = (empty($_SERVER['HTTPS']) OR strtolower($_SERVER['HTTPS']) === 'off') ? 'http' : 'https';
  $base_url .= '://'. $_SERVER['HTTP_HOST'];
  $base_url .= substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])));
}

else
{
  $base_url = 'http://localhost/';
}

include("./Pages/{$page_kind}/views/layout.php");

?>
