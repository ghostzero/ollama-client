<?php

namespace GhostZero\Ollama;

use DateTime;
use Exception;
use Psr\Http\Message\ResponseInterface;

class PartialResult extends Response
{
    protected array $data;

    public function __construct(ResponseInterface $response, array $data)
    {
        parent::__construct($response);

        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getContents(): string|array
    {
        return $this->data['response'] ?? $this->data['message'];
    }

    public function isDone(): bool
    {
        return $this->data['done'];
    }

    public function getModel(): string
    {
        return $this->data['model'];
    }

    /**
     * @throws Exception
     */
    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->data['created_at']);
    }
}