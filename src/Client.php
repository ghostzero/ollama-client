<?php

namespace GhostZero\Ollama;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;

class Client
{
    use Traits\Request;
    use Traits\Validation;

    private HttpClient $client;

    public function __construct(array $options = [])
    {
        $this->client = new HttpClient([
            'base_uri' => $options['base_uri'] ?? 'http://localhost:11434'
        ]);
    }

    /**
     * Generate a completion
     *
     * Parameters:
     *  - model: The model to use for completion
     *  - prompt: The prompt to use for completion
     *  - images (optional): A list of base-64 encoded images (for multimodal models such as llava)
     *
     * Advanced parameters:
     *  - format: The format to return a response in. Currently, the only accepted value is "json".
     *  - options: Additional model parameters listed in the documentation for the Modelfile.
     *  - system: System message (to overrides what is set in the Modelfile)
     *  - template: The prompt template to use (to overrides what is set in the Modelfile)
     *  - context: The context parameter returned from a previous request to /generate, this can be used to keep a short conversational memory.
     *  - raw: If true, no formatting will be applied to the prompt.
     *
     * @throws GuzzleException
     */
    public function generate(array $parameters): Result
    {
        $this->ensureParameters($parameters, ['model', 'prompt']);

        return $this->request('POST', '/api/generate', [
            'json' => array_merge($parameters, [
                'stream' => false,
            ]),
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);
    }

    /**
     * Same as generate, but returns a stream of partial results.
     *
     * @throws GuzzleException
     */
    public function generateStream(callable $callback, array $parameters): void
    {
        $this->ensureParameters($parameters, ['model', 'prompt']);

        $this->stream($callback, 'POST', '/api/generate', [
            'json' => array_merge($parameters, [
                'stream' => true,
            ]),
            'headers' => [
                'Accept' => 'application/x-ndjson'
            ]
        ]);
    }
}