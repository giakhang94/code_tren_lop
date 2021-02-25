<?php

$start = microtime(true);

include("ConnectDB.php");
include("Functions.php");
include("ReadCache.php");
include("LoadView.php");


include("SaveCache.php");
$end = microtime(true);
echo $end - $start;
