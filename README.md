# EasyLog
A Pocketmine Library create separate logs for plugins

# Usage
```php
use phuongaz\easylog\EasyLog;
use phuongaz\easylog\LevelLog;

$logger = new EasyLog("PluginName");

$logger->log("Hello World!"); // Default level is INFO
$logger->log("Hello World!", LevelLog::INFO);
$logger->log("Hello World!", LevelLog::WARNING);
$logger->log("Hello World!", LevelLog::ERROR);
$logger->log("Hello World!", LevelLog::DEBUG);

$logger->setFormat("{time} [{level}] {message}");
$logger->setTimeFormat("H:i:s");

$logger->log("Hello World!"); // 12:00:00 [INFO] Hello World!
```
This log will be saved in `server\plugin_logs\PluginName\logs\Y-m-d.log`

##  Sub Folders
```php

use phuongaz\easylog\EasyLog;
use phuongaz\easylog\LevelLog;
$logger = new EasyLog("PluginName");

$logger->registerSubFolder("sub1");
$logger->registerSubFolder("sub2");

$logger->logSub("sub1", "Test log 1", LogLevel::DEBUG); // [10:51:45 2023/08/05] | DEBUG] Test log 1
$logger->logSub("sub2", "Test log 2", LogLevel::DEBUG); // [10:51:45 2023/08/05] | DEBUG] Test log 2
```
This log will be saved in `server\plugin_logs\PluginName\sub1\Y-m-d.log` and `server\plugin_logs\PluginName\sub2\Y-m-d.log`
