<?php

namespace GhostZero\Ollama\Tests;

use PHPUnit\Framework\TestCase as Base;

class TestCase extends Base
{
    public function info($message): void
    {
        fwrite(STDERR, $message . PHP_EOL);
    }

    public function dump($message): void
    {
        fwrite(STDERR, print_r($message, true) . PHP_EOL);
    }
}