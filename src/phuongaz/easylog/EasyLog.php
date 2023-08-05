<?php

declare(strict_types=1);

namespace phuongaz\easylog;

use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use WeakMap;

class EasyLog {
    use SingletonTrait;

    private string $path;
    private string $folderName;
    private string $timeFormat = "H:i:s Y/m/d";
    private string $format = "[{time}] [{level}] [{message}]";

    private WeakMap $subFolders;

    public function init(string $folderName) : void {
        $this->path = Server::getInstance()->getDataPath() . "plugin_logs\\";
        $this->folderName = $folderName;
        $this->subFolders = new WeakMap();
        self::setInstance($this);
    }

    public function getPath() : string {
        return $this->path;
    }

    public function getFolderName() : string {
        return $this->folderName;
    }

    public function getFolder() : string {
        return $this->path . $this->folderName . "\\";
    }

    public function setTimeFormat(string $timeFormat) : void {
        $this->timeFormat = $timeFormat;
    }

    public function getTimeFormat() : string {
        return $this->timeFormat;
    }

    public function setFormat(string $format) : void {
        $this->format = $format;
    }

    public function getFormat() : string {
        return $this->format;
    }

    public function parseFormat(string $message, string $level) : string {
        $format = $this->format;
        $format = str_replace("{time}", date($this->timeFormat), $format);
        $format = str_replace("{level}", $level, $format);
        return str_replace("{message}", $message, $format);
    }

    public function log(string $message, LogLevel $level = LogLevel::INFO) : void {
        $folder = $this->getFolder();
        if(!is_dir($folder)) {
            mkdir($folder,0777, true);
        }
        $file = $folder . date("Y-m-d") . ".log";
        $handle = fopen($file, "a");
        fwrite($handle, $this->parseFormat($message, $level->getString()) . "\n");
        fclose($handle);
    }

    public function logSub(string $subFolderName, string $message, LogLevel $level = LogLevel::INFO) : SubFolder {
        $subFolder = $this->getSubFolder($subFolderName);
        if($subFolder === null) {
            $subFolder = $this->registerSubFolder($subFolderName);
        }
        $subFolder->logToSubFolder($message, $level);
        return $subFolder;
    }

    public function registerSubFolder(string $subFolderName) : SubFolder {
        if(!isset($this->subFolders)) {
            $this->subFolders = new WeakMap();
        }
        $subFolder = new SubFolder($this, $subFolderName);
        $this->subFolders[$subFolder] = $subFolderName;
        return $subFolder;
    }

    public function getSubFolder(string $subFolderName) : ?SubFolder {
        if(!isset($this->subFolders)) {
            $this->subFolders = new WeakMap();
        }
        foreach($this->subFolders as $subFolder) {
            if($subFolder->getSubFolderName() === $subFolderName) {
                return $subFolder;
            }
        }
        return null;
    }

}