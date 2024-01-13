<?php

namespace GhostZero\Ollama\Tests;

use GhostZero\Ollama\Client;
use GhostZero\Ollama\PartialResult;
use GhostZero\Ollama\Result;
use GuzzleHttp\Exception\GuzzleException;

final class OllamaClientTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function testCanBeGenerated(): void
    {
        $client = new Client([
            'base_uri' => 'http://172.24.244.146:11434'
        ]);

        $result = $client->generate([
            'model' => 'dolphin2.2-mistral:7b-q6_K',
            'prompt' => 'Why is the sky blue?'
        ]);

        $this->assertInstanceOf(Result::class, $result);
    }

    /**
     * @throws GuzzleException
     */
    public function testCanBeStreamed(): void
    {
        $client = new Client([
            'base_uri' => 'http://172.24.244.146:11434'
        ]);

        $message = '';

        $client->generateStream(function (PartialResult $result) use (&$message) {
            $message .= $result->getContents();
        }, [
            'model' => 'dolphin2.2-mistral:7b-q6_K',
            'prompt' => 'Why is the sky blue?'
        ]);

        $this->dump($message);
        $this->assertNotEmpty($message);
    }
}