<?php

declare(strict_types=1);

namespace App\Core;

final class Validator
{
    /** @var array<string, string> */
    private array $errors = [];

    /** @param array<string, mixed> $data */
    public function __construct(private array $data)
    {
    }

    public function required(string $field, ?string $label = null): self
    {
        if ($this->value($field) === '') {
            $this->add($field, ($label ?? $this->pretty($field)) . ' is required.');
        }
        return $this;
    }

    public function email(string $field): self
    {
        $value = $this->value($field);
        if ($value !== '' && filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            $this->add($field, 'Enter a valid email address.');
        }
        return $this;
    }

    public function minLength(string $field, int $min): self
    {
        $value = $this->value($field);
        $length = function_exists('mb_strlen') ? mb_strlen($value) : strlen($value);
        if ($value !== '' && $length < $min) {
            $this->add($field, 'Must be at least ' . $min . ' characters.');
        }
        return $this;
    }

    public function range(string $field, float $min, float $max): self
    {
        $value = $this->value($field);
        if ($value === '') {
            return $this;
        }
        if (!is_numeric($value) || (float) $value < $min || (float) $value > $max) {
            $this->add($field, 'Must be between ' . $min . ' and ' . $max . '.');
        }
        return $this;
    }

    /** @param list<string> $allowed */
    public function enum(string $field, array $allowed): self
    {
        $value = $this->value($field);
        if ($value === '') {
            return $this;
        }
        if (!in_array($value, $allowed, true)) {
            $this->add($field, 'Choose a valid option.');
        }
        return $this;
    }

    public function fails(): bool
    {
        return $this->errors !== [];
    }

    /** @return array<string, string> */
    public function errors(): array
    {
        return $this->errors;
    }

    public function error(string $field): ?string
    {
        return $this->errors[$field] ?? null;
    }

    public function value(string $field): string
    {
        $value = $this->data[$field] ?? '';
        return trim((string) $value);
    }

    private function add(string $field, string $message): void
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = $message;
        }
    }

    private function pretty(string $field): string
    {
        return ucfirst(str_replace('_', ' ', $field));
    }
}
