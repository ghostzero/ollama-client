<?php

namespace GhostZero\Ollama;

use Exception;
use Psr\Http\Message\ResponseInterface;

class FinalPartialResult extends PartialResult
{
    public function getContext(): ?array
    {
        return $this->data['context'] ?? null;
    }

    public function getTotalDuration(): float
    {
        return $this->data['total_duration'];
    }

    public function getLoadDuration(): float
    {
        return $this->data['load_duration'];
    }

    public function getPromptEvalCount(): int
    {
        return $this->data['prompt_eval_count'];
    }

    public function getPromptEvalDuration(): float
    {
        return $this->data['prompt_eval_duration'];
    }

    public function getEvalCount(): int
    {
        return $this->data['eval_count'];
    }

    public function getEvalDuration(): float
    {
        return $this->data['eval_duration'];
    }
}