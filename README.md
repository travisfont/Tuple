# PHP Tuple Implementation

A soft implementation of tuples for PHP 8.4+ providing immutable, type-safe collections.

## Features

- **Immutability** - Once created, tuples cannot be modified
- **Type Safety** - Optional strict type checking with TypedTuple
- **Functional Access** - No array syntax; use get(), map(), or destructure()
- **Iteration** - Full Iterator support for foreach loops
- **Destructuring** - Easy unpacking with list() syntax
- **Functional Methods** - map(), filter(), and more
- **JSON Serialization** - Works seamlessly with json_encode()
- **Modern PHP** - Uses PHP 8.4 features like named arguments

## Installation

Simply include the `Tuple.php` file in your project:

```php
require_once 'Tuple.php';

use DataStructures\Tuple;
use DataStructures\TypedTuple;
```

## Basic Usage

### Creating Tuples

```php
// Using the static factory method
$point = Tuple::make(10, 20);

// Multiple types
$person = Tuple::make("Alice", 30, "Engineer");
```

### Accessing Elements

```php
$colors = Tuple::make("red", "green", "blue");

// Using get() method
echo $colors->get(0);  // "red"
echo $colors->get(1);  // "green"

// First and last
echo $colors->first(); // "red"
echo $colors->last();  // "blue"

// Note: Array syntax like $colors[0] is NOT supported
// This enforces functional access patterns
```

### Destructuring

```php
$point = Tuple::make(100, 200);
[$x, $y] = $point->destructure();

echo "X: $x, Y: $y";  // X: 100, Y: 200
```

### Iteration

```php
$numbers = Tuple::make(1, 2, 3, 4, 5);

foreach ($numbers as $num) {
    echo $num . " ";
}
// Output: 1 2 3 4 5
```

## Type Safety with TypedTuple

```php
// Enforce specific types at each position
$person = TypedTuple::make(
    ['string', 'int', 'string'],
    "Bob",
    25,
    "Developer"
);

// This will throw a TypeError:
try {
    $invalid = TypedTuple::make(
        ['string', 'int'],
        "Alice",
        "not an integer"  // TypeError!
    );
} catch (TypeError $e) {
    echo "Type error: " . $e->getMessage();
}
```

## Functional Methods

### Map

```php
$numbers = Tuple::make(1, 2, 3, 4);
$squared = $numbers->map(fn($n) => $n * $n);

echo $squared;  // (1, 4, 9, 16)
```

### Filter

```php
$numbers = Tuple::make(1, 2, 3, 4, 5, 6);
$evens = $numbers->filter(fn($n) => $n % 2 === 0);

echo $evens;  // (2, 4, 6)
```

## Advanced Usage

### Returning Multiple Values

```php
function getDimensions(): Tuple {
    return Tuple::make(1920, 1080, 24);
}

[$width, $height, $fps] = getDimensions()->destructure();
```

### Nested Tuples

```php
$user = Tuple::make(
    "user123",
    Tuple::make("John", "Doe"),
    Tuple::make("john@example.com", "555-1234")
);

// Access via destructuring
[$id, $name, $contacts] = $user->destructure();
[$firstName, $lastName] = $name->destructure();
[$email, $phone] = $contacts->destructure();

echo $firstName;  // "John"
echo $email;      // "john@example.com"

// Or use get() method
echo $user->get(0);  // "user123"
echo $user->get(1)->get(0);  // "John"
```

### Database Rows

```php
$row = Tuple::make(1, "john@example.com", "John Doe", "2024-01-15");
[$id, $email, $name, $createdAt] = $row->destructure();
```

## API Reference

### Tuple Methods

| Method | Description | Returns |
|--------|-------------|---------|
| `make(...$elements)` | Static factory method | `Tuple` |
| `get(int $index)` | Get element at index | `mixed` |
| `first()` | Get first element | `mixed` |
| `last()` | Get last element | `mixed` |
| `contains($value)` | Check if value exists | `bool` |
| `toArray()` | Convert to array | `array` |
| `destructure()` | Get array for unpacking | `array` |
| `map(callable $fn)` | Transform elements | `Tuple` |
| `filter(callable $fn)` | Filter elements | `Tuple` |
| `size()` | Get number of elements | `int` |
| `count()` | Get number of elements | `int` |
| `types()` | Get element types | `array` |

### Interfaces

- `Countable` - count() support
- `Iterator` - foreach support
- `JsonSerializable` - JSON encoding support

**Note:** ArrayAccess is intentionally NOT implemented to enforce functional access patterns and prevent array-like syntax.

## Immutability & Access Restrictions

Tuples are immutable and enforce functional access patterns:

```php
$tuple = Tuple::make(1, 2, 3);

// Array access is NOT supported (not even for reading)
// $value = $tuple[0];  // Error! Not allowed

// Use these instead:
$value = $tuple->get(0);           // ✅ Correct
[$a, $b, $c] = $tuple->destructure();  // ✅ Correct
foreach ($tuple as $val) { }       // ✅ Correct

// Cloning is prevented
$clone = clone $tuple;  // Error!
```

This design enforces functional programming patterns and makes your code more explicit about data access.

See [Tuple Access Patterns Demo.md](Tuple%20Access%20Patterns%20Demo.md) for a detailed demonstration of allowed and forbidden patterns.

For a comprehensive list of real-world usage scenarios, see [Tuple Cookbook Examples.md](Tuple%20Cookbook%20Examples.md).

## Why Use Tuples?

1. **Type Safety** - Ensure data integrity with typed tuples
2. **Immutability** - Prevent accidental modifications
3. **Readability** - Clear intent when returning multiple values
4. **Documentation** - Self-documenting code with destructuring
5. **Pattern Matching** - Easy destructuring for clean code

## Comparison with Arrays

| Feature | Tuple | Array |
|---------|-------|-------|
| Immutable | ✅ | ❌ |
| Type Safety | ✅ (optional) | ❌ |
| Fixed Size | ✅ | ❌ |
| Array Syntax | ❌ (intentional) | ✅ |
| get() Method | ✅ | ❌ |
| Destructuring | ✅ | ✅ |
| Iteration | ✅ | ✅ |
| JSON Serialization | ✅ | ✅ |

**Why no array syntax?** This enforces functional access patterns, making code more explicit and preventing accidental misuse.

## Performance Considerations

- Tuples have minimal overhead compared to arrays
- Best for small, fixed collections (2-10 elements)
- Map/filter operations create new tuples (no mutation)
- Consider arrays for large or frequently modified collections

## Requirements

- PHP 8.4 or higher
- No external dependencies

## License

This is a demonstration implementation for educational purposes.
