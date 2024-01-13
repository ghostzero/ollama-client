<?php

namespace GhostZero\Ollama;

use Psr\Http\Message\ResponseInterface;

abstract class Response
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    abstract public function getData(): array;
}