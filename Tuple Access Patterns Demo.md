# Tuple Access Patterns Demo

This document demonstrates the strict, functional access patterns enforced by the `Tuple` implementation.

## 1. ❌ Array Syntax is NOT Allowed

The `Tuple` class intentionally does NOT implement `ArrayAccess`. This prevents loose array-like behavior and enforces functional programming patterns.

```php
$point = Tuple::make(100, 200);

try {
    // This will fail - array access not supported
    $x = $point[0];
} catch (\Error $e) {
    echo "✗ Error (expected): " . get_class($e);
    // Message: Cannot use bracket syntax on Tuple
}
```

## 2. ✅ Use `get()` Method Instead

To access elements by index, use the explicit `get()` method.

```php
$x = $point->get(0);
$y = $point->get(1);

echo "Point: ({$x}, {$y})";
```

## 3. ✅ Use Destructuring

Destructuring is the preferred way to look inside a tuple, as it names the elements clearly.

```php
[$x, $y] = $point->destructure();
echo "Point: ({$x}, {$y})";
```

## 4. ✅ Use Iteration

Tuples implement `Iterator`, so `foreach` works as expected.

```php
foreach ($point as $value) {
    echo "{$value} ";
}
```

## 5. ✅ Use Functional Methods

Methods like `map()` and `filter()` return **new** Tuple instances, preserving immutability.

```php
// Returns a NEW tuple, original $point is unchanged
$scaled = $point->map(fn($v) => $v * 2);

echo "Original: {$point}";   // (100, 200)
echo "Scaled 2x: {$scaled}"; // (200, 400)
```

## 6. ✅ First and Last

Helper methods for common access patterns.

```php
echo "First: {$point->first()}";
echo "Last: {$point->last()}";
```

## 7. ✅ Nested Tuples

Tuples can contain other Tuples, creating structured data.

```php
$user = Tuple::make(
    "alice",
    Tuple::make("Alice", "Smith"),
    Tuple::make(25, "Developer")
);

// Destructure layer by layer
[$username, $fullName, $details] = $user->destructure();
[$firstName, $lastName] = $fullName->destructure();
[$age, $role] = $details->destructure();

echo "User: {$firstName} {$lastName} (@{$username})";
```

## 8. ✅ Pattern Matching

Tuples work well with PHP's `match` expression for pattern matching based on structure or size.

```php
function processPoint(Tuple $point): string {
    return match(true) {
        $point->count() === 2 => (function() use ($point) {
            [$x, $y] = $point->destructure();
            return "2D Point at ({$x}, {$y})";
        })(),
        $point->count() === 3 => (function() use ($point) {
            [$x, $y, $z] = $point->destructure();
            return "3D Point at ({$x}, {$y}, {$z})";
        })(),
        default => "Unknown point type"
    };
}
```

## Key Benefits

- **Forces explicit access patterns**
- **Encourages functional programming style**
- **Makes code more readable and intentional**
- **Prevents mixing tuples with arrays accidentally**
- **Maintains immutability guarantees**
