<?php

namespace phuongaz\easylog;

enum LogLevel {
    case INFO;
    case WARNING;
    case ERROR;
    case CRITICAL;
    case DEBUG;

    public function getString() : string {
        return match($this) {
            self::INFO => "INFO",
            self::WARNING => "WARNING",
            self::ERROR => "ERROR",
            self::CRITICAL => "CRITICAL",
            self::DEBUG => "DEBUG"
        };
    }
}
