<?php
$dir = $_SERVER['DOCUMENT_ROOT'] . "wp-content/themes/dev-rb/api-endpoints";

foreach (glob("{$dir}/*.php") as $filename)
{
    if (str_contains($filename, "api_endpoints.php")) continue;
    include $filename;
}

?>