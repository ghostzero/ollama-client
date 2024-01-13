<?php

namespace GhostZero\Ollama\Traits;

use GhostZero\Ollama\FinalPartialResult;
use GhostZero\Ollama\PartialResult;
use GhostZero\Ollama\Result;
use GuzzleHttp\Exception\GuzzleException;

trait Request
{
    /**
     * @throws GuzzleException
     */
    public function request(string $method, string $url, array $options = []): Result
    {
        $response = $this->client->request($method, $url, $options);

        return new Result($response);
    }

    /**
     * Handles server-sent events (SSE) from the server
     *
     * @throws GuzzleException
     */
    public function stream(
        callable $callback,
        string   $method,
        string   $url,
        array    $options = [],
    ): void
    {
        $response = $this->client->request($method, $url, $options);

        $stream = $response->getBody()->detach();

        while (!feof($stream)) {
            $line = fgets($stream);
            if (strlen($line) === 0) {
                continue;
            }

            $data = json_decode($line, true);
            if ($data === null) {
                continue;
            }

            if ($data['done']) {
                $callback(new FinalPartialResult($response, $data));
            } else {
                $callback(new PartialResult($response, $data));
            }
        }
    }
}