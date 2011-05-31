<?php
require_once "context/WorkbenchContext.php";
require_once "cometd-resourses/PhpReverseProxy.php";
require_once "session.php";

if (!WorkbenchContext::isEstablished()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "SFDC Proxy only available if Workbench Context has been established.";
    exit;
}

$host = WorkbenchContext::get()->getHost();
$sessionId = WorkbenchContext::get()->getSessionId();
session_write_close();

$proxy = new PhpReverseProxy();
$proxy->host = $host;
$_COOKIE['sid'] = $sessionId;
$proxy->connect();
$proxy->output();
?>
