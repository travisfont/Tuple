# Tuple Cookbook Examples

This cookbook demonstrates **18 different real-world usage scenarios** for the Tuple library. It covers everything from basic creation to complex data structures and strict type enforcement.

## 1. Basic Tuple Creation

```php
$coordinates = Tuple::make(10, 20, 30);
echo "Coordinates: {$coordinates}"; // (10, 20, 30)
```

## 2. Using Factory Method

```php
$person = Tuple::make("Alice", 30, "Engineer");
echo "Name: {$person->get(0)}"; // Alice
echo "Age: {$person->get(1)}";  // 30
```

## 3. Using `get()` Method

Standard array access (`$tuple[0]`) is forbidden to enforce functional patterns.

```php
$colors = Tuple::make("red", "green", "blue");
echo $colors->get(0); // red
echo $colors->get(1); // green
```

## 4. Destructuring

The cleanest way to unpack values.

```php
$point = Tuple::make(5, 10);
[$x, $y] = $point->destructure();
echo "X: {$x}, Y: {$y}";
```

## 5. Iteration

Tuples are iterable, working seamlessly with `foreach`.

```php
$numbers = Tuple::make(1, 2, 3, 4, 5);
foreach ($numbers as $num) {
    echo "{$num} ";
}
```

## 6. First and Last Elements

```php
$days = Tuple::make("Mon", "Tue", "Wed", "Thu", "Fri");
echo $days->first(); // Mon
echo $days->last();  // Fri
```

## 7. Checks

Check if a value exists within the tuple.

```php
$fruits = Tuple::make("apple", "banana", "orange");
if ($fruits->contains("banana")) {
    echo "Found banana!";
}
```

## 8. Map Transformation

Creates a **new** tuple with transformed values.

```php
$numbers = Tuple::make(1, 2, 3, 4);
$squared = $numbers->map(fn($n) => $n * $n);
// $squared is (1, 4, 9, 16)
```

## 9. Filter

Creates a **new** tuple only containing elements that pass the truth test.

```php
$mixed = Tuple::make(1, 2, 3, 4, 5, 6);
$evens = $mixed->filter(fn($n) => $n % 2 === 0);
// $evens is (2, 4, 6)
```

## 10. Mixed Types

Tuples can hold any combination of types.

```php
$mixed = Tuple::make(42, "hello", 3.14, true, null);
echo $mixed->types(); // [int, string, float, bool, null]
```

## 11. Typed Tuple (Type Safety)

Enforce strict types for each position.

```php
$typedPerson = TypedTuple::create(
    ['string', 'int', 'string'],
    "Bob",
    25,
    "Developer"
);
```

## 12. JSON Serialization

Tuples serialize directly to JSON arrays.

```php
$data = Tuple::make("item1", 100, true);
echo json_encode($data); // ["item1",100,true]
```

## 13. Database Row Example

Perfect for representing immutable database rows.

```php
$dbRow = Tuple::make(1, "john@example.com", "John Doe", "2024-01-15");
[$id, $email, $name, $createdAt] = $dbRow->destructure();
```

## 14. Returning Multiple Values

A superior alternative to returning associative arrays or generic objects.

```php
function getDimensions(): Tuple {
    // width, height, fps
    return Tuple::make(1920, 1080, 24); 
}

[$width, $height, $fps] = getDimensions()->destructure();
```

## 15. Immutability & Access Restriction

Demonstrating that array access fails by design.

```php
$immutable = Tuple::make(1, 2, 3);
try {
    $val = $immutable[0]; // Throws Error
} catch (\Error $e) {
    echo "Cannot use array syntax!";
}
```

## 16. Type Safety Enforcement

Demonstrating that valid types are enforced.

```php
try {
    $invalid = TypedTuple::create(
        ['string', 'int'],
        "Alice",
        "not an integer" // Throws TypeError
    );
} catch (\TypeError $e) {
    echo "Type mismatch!";
}
```

## 17. Complex Data Structures

Tuples nested within tuples for rich data modeling.

```php
$user = Tuple::make(
    "user123",
    Tuple::make("John", "Doe"),
    Tuple::make("john@example.com", "555-1234"),
    Tuple::make(40.7128, -74.0060)
);

[$userId, $fullName, $contacts, $location] = $user->destructure();
```

## 18. Using with Objects

Tuples can hold objects just like any other value.

```php
$alice = new Person("Alice", 30);
$personTuple = Tuple::make($alice, "active", 5.0);
[$person, $status, $rating] = $personTuple->destructure();
```
