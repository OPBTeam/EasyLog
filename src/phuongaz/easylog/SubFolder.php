<?php

declare(strict_types=1);

namespace phuongaz\easylog;

use Exception;

class SubFolder {

    private EasyLog $logger;
    private string $subFolderName;

    public function __construct(EasyLog $logger, string $subFolderName) {
        $this->logger = $logger;
        $this->subFolderName = $subFolderName;
    }

    public function getLogger() : EasyLog {
        return $this->logger;
    }

    public function getSubFolderName() : string {
        return $this->subFolderName;
    }

    public function getSubFolder() : string {
        return $this->logger->getFolder() . $this->subFolderName . "/";
    }

    public function logToSubFolder(string $message, LogLevel $level = LogLevel::INFO) : void {
        $folder = $this->getSubFolder();
        if(!is_dir($folder)) {
            mkdir($folder, 0777,  true);
        }
        $file = $folder . date("Y-m-d") . ".log";
        $handle = fopen($file, "a");
        fwrite($handle, $this->logger->parseFormat($message, $level->getString()) . "\n");
        fclose($handle);
    }
}