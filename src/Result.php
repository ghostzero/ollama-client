<?php

namespace GhostZero\Ollama;

use Psr\Http\Message\ResponseInterface;

class Result extends Response
{
    private array $data;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);

        $this->data = json_decode($response->getBody()->getContents(), true);
    }

    public function getData(): array
    {
        return $this->data;
    }
}