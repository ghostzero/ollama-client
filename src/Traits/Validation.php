<?php

namespace GhostZero\Ollama\Traits;

use InvalidArgumentException;

trait Validation
{
    protected function ensureParameters(array $parameters, array $array): void
    {
        foreach ($array as $key) {
            if (!array_key_exists($key, $parameters)) {
                throw new InvalidArgumentException(sprintf('Missing parameter "%s"', $key));
            }
        }
    }
}