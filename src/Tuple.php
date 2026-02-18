<?php

declare(strict_types=1);

/**
 * Soft Implementation of Tuples for PHP 8.4
 * 
 * A tuple is an immutable, ordered collection of elements with fixed types.
 * This implementation provides type safety while maintaining flexibility.
 */

namespace DataStructures;

use Countable;
use Iterator;
use JsonSerializable;

/**
 * Generic Tuple class providing immutable, type-safe collections
 * Note: Does NOT implement ArrayAccess to enforce functional access patterns
 */
class Tuple implements Countable, Iterator, JsonSerializable
{
    private array $elements = [];
    private array $types = [];
    private int $position = 0;

    /**
     * Create a new Tuple instance (use Tuple::make() instead)
     */
    protected function __construct(mixed ...$elements)
    {
        $this->elements = array_values($elements);
        $this->types = array_map(fn($el) => get_debug_type($el), $this->elements);
    }

    /**
     * Factory method for creating tuples
     */
    public static function make(mixed ...$elements): Tuple
    {
        if (empty($elements)) {
            throw new \ArgumentCountError("Tuple::make() requires at least one argument");
        }
        return new self(...$elements);
    }

    /**
     * Get element at specific position
     */
    public function get(int $index): mixed
    {
        if (!isset($this->elements[$index])) {
            throw new \OutOfBoundsException("Index {$index} is out of bounds");
        }
        return $this->elements[$index];
    }

    /**
     * Get the first element
     */
    public function first(): mixed
    {
        if (empty($this->elements)) {
            throw new \RuntimeException("Cannot get first element of empty tuple");
        }
        return $this->elements[0];
    }

    /**
     * Get the last element
     */
    public function last(): mixed
    {
        if (empty($this->elements)) {
            throw new \RuntimeException("Cannot get last element of empty tuple");
        }
        return $this->elements[array_key_last($this->elements)];
    }

    /**
     * Check if tuple contains a value
     */
    public function contains(mixed $value): bool
    {
        return in_array($value, $this->elements, strict: true);
    }

    /**
     * Get all elements as array
     */
    public function toArray(): array
    {
        return $this->elements;
    }

    /**
     * Destructure tuple into variables
     * 
     * @return array Tuple elements for list() unpacking
     */
    public function destructure(): array
    {
        return $this->elements;
    }

    /**
     * Map function over tuple elements (returns new tuple)
     */
    public function map(callable $callback): Tuple
    {
        return self::make(...array_map($callback, $this->elements));
    }

    /**
     * Filter tuple elements (returns new tuple)
     */
    public function filter(callable $callback): Tuple
    {
        return self::make(...array_filter($this->elements, $callback));
    }

    /**
     * Get tuple size
     */
    public function size(): int
    {
        return count($this->elements);
    }

    /**
     * Get types of elements
     */
    public function types(): array
    {
        return $this->types;
    }

    // Countable implementation
    public function count(): int
    {
        return count($this->elements);
    }

    // Iterator implementation
    public function current(): mixed
    {
        return $this->elements[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->elements[$this->position]);
    }

    // JsonSerializable implementation
    public function jsonSerialize(): array
    {
        return $this->elements;
    }

    // String representation
    public function __toString(): string
    {
        $values = array_map(
            fn($v) => is_string($v) ? "'{$v}'" : var_export($v, true),
            $this->elements
        );
        return '(' . implode(', ', $values) . ')';
    }

    // Prevent cloning
    private function __clone()
    {
    }
}

/**
 * Typed Tuple with strict type checking
 */
class TypedTuple extends Tuple
{
    private array $expectedTypes;

    /**
     * Create a typed tuple (use TypedTuple::make() instead)
     * 
     * @param array $types Expected types for each position
     * @param mixed ...$elements Elements matching the types
     */
    protected function __construct(array $types, mixed ...$elements)
    {
        if (count($types) !== count($elements)) {
            throw new \InvalidArgumentException(
                "Number of types must match number of elements"
            );
        }

        foreach ($elements as $index => $element) {
            $expectedType = $types[$index];
            $actualType = get_debug_type($element);

            if (!$this->typeMatches($element, $expectedType)) {
                throw new \TypeError(
                    "Element at index {$index} must be of type {$expectedType}, {$actualType} given"
                );
            }
        }

        $this->expectedTypes = $types;
        parent::__construct(...$elements);
    }

    private function typeMatches(mixed $value, string $expectedType): bool
    {
        $actualType = get_debug_type($value);

        // Exact match
        if ($actualType === $expectedType) {
            return true;
        }

        // Handle class/interface types
        if (class_exists($expectedType) || interface_exists($expectedType)) {
            return $value instanceof $expectedType;
        }

        return false;
    }

    public static function create(array $types, mixed ...$elements): TypedTuple
    {
        return new self($types, ...$elements);
    }
}


