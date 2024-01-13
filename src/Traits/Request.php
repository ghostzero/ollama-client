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
        $options['stream'] = true;  // Ensure the response is streamed
        $response = $this->client->request($method, $url, $options);

        $stream = $response->getBody()->detach();  // Detach the stream for manual handling

        while (!feof($stream)) {
            $line = fgets($stream);
            if (strlen($line) === 0) {
                continue;
            }

            $data = json_decode($line, true);
            if ($data === null) {
                continue;
            }

            if (isset($data['done']) && $data['done']) {
                $callback(new FinalPartialResult($response, $data));
                break;  // Exit the loop if 'done' is true
            } else {
                $callback(new PartialResult($response, $data));
            }
        }

        fclose($stream);  // Close the stream when done
    }
}