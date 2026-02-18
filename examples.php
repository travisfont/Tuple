<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use DataStructures\Tuple;
use DataStructures\TypedTuple;

echo "=== PHP Tuple Implementation Examples ===\n\n";

// Example 1: Basic Tuple Creation
echo "1. Basic Tuple Creation:\n";
$coordinates = Tuple::make(10, 20, 30);
echo "Coordinates: {$coordinates}\n";
echo "Count: {$coordinates->count()}\n\n";

// Example 2: Using static factory method
echo "2. Using Tuple::make():\n";
$person = Tuple::make("Alice", 30, "Engineer");
echo "Person: {$person}\n";
echo "Name: {$person->get(0)}\n";
echo "Age: {$person->get(1)}\n";
echo "Job: {$person->get(2)}\n\n";

// Example 3: Using get() method (array-like access NOT allowed)
echo "3. Using get() Method:\n";
$colors = Tuple::make("red", "green", "blue");
echo "First color: {$colors->get(0)}\n";
echo "Second color: {$colors->get(1)}\n\n";

// Example 4: Destructuring
echo "4. Destructuring:\n";
$point = Tuple::make(5, 10);
[$x, $y] = $point->destructure();
echo "X: {$x}, Y: {$y}\n\n";

// Example 5: Iteration
echo "5. Iteration:\n";
$numbers = Tuple::make(1, 2, 3, 4, 5);
echo "Numbers: ";
foreach ($numbers as $num) {
    echo "{$num} ";
}
echo "\n\n";

// Example 6: First and Last
echo "6. First and Last Elements:\n";
$days = Tuple::make("Mon", "Tue", "Wed", "Thu", "Fri");
echo "First day: {$days->first()}\n";
echo "Last day: {$days->last()}\n\n";

// Example 7: Contains check
echo "7. Contains Check:\n";
$fruits = Tuple::make("apple", "banana", "orange");
echo "Contains 'banana': " . ($fruits->contains("banana") ? "yes" : "no") . "\n";
echo "Contains 'grape': " . ($fruits->contains("grape") ? "yes" : "no") . "\n\n";

// Example 8: Map transformation
echo "8. Map Transformation:\n";
$numbers = Tuple::make(1, 2, 3, 4);
$squared = $numbers->map(fn($n) => $n * $n);
echo "Original: {$numbers}\n";
echo "Squared: {$squared}\n\n";

// Example 9: Filter
echo "9. Filter:\n";
$mixed = Tuple::make(1, 2, 3, 4, 5, 6);
$evens = $mixed->filter(fn($n) => $n % 2 === 0);
echo "Original: {$mixed}\n";
echo "Evens: {$evens}\n\n";

// Example 10: Mixed types
echo "10. Mixed Types:\n";
$mixed = Tuple::make(42, "hello", 3.14, true, null);
echo "Mixed tuple: {$mixed}\n";
echo "Types: " . implode(", ", $mixed->types()) . "\n\n";

// Example 11: Typed Tuple with type safety
echo "11. Typed Tuple (Type Safety):\n";
$typedPerson = TypedTuple::create(
    ['string', 'int', 'string'],
    "Bob",
    25,
    "Developer"
);
echo "Typed person: {$typedPerson}\n\n";

// Example 12: JSON serialization
echo "12. JSON Serialization:\n";
$data = Tuple::make("item1", 100, true);
echo "JSON: " . json_encode($data) . "\n\n";

// Example 13: Database row as tuple
echo "13. Database Row Example:\n";
$dbRow = Tuple::make(1, "john@example.com", "John Doe", "2024-01-15");
[$id, $email, $name, $createdAt] = $dbRow->destructure();
echo "User #{$id}: {$name} ({$email}), created: {$createdAt}\n\n";

// Example 14: Return multiple values from function
echo "14. Function Returning Multiple Values:\n";
function getDimensions(): Tuple
{
    return Tuple::make(1920, 1080, 24); // width, height, fps
}

$dimensions = getDimensions();
[$width, $height, $fps] = $dimensions->destructure();
echo "Resolution: {$width}x{$height} @ {$fps}fps\n\n";

// Example 15: Immutability and access restriction test
echo "15. Immutability & Access Restriction Test:\n";
$immutable = Tuple::make(1, 2, 3);
echo "Original: {$immutable}\n";

// Test 1: Array access not allowed
try {
    $value = $immutable[0]; // This will cause an error
    echo "Value: {$value}\n";
} catch (\Error $e) {
    echo "Array access error (expected): Cannot use array syntax\n";
}

// Test 2: Proper access using get()
echo "Proper access: {$immutable->get(0)}\n";

// Test 3: Or using destructuring
[$first] = $immutable->destructure();
echo "Via destructure: {$first}\n";
echo "Still original: {$immutable}\n\n";

// Example 16: Type error demonstration
echo "16. Type Safety Test:\n";
try {
    $invalid = TypedTuple::create(
        ['string', 'int'],
        "Alice",
        "not an integer" // This will throw a TypeError
    );
} catch (\TypeError $e) {
    echo "Type error (expected): {$e->getMessage()}\n";
}
echo "\n";

// Example 17: Complex data structure
echo "17. Complex Data Structure:\n";
$user = Tuple::make(
    "user123",
    Tuple::make("John", "Doe"),
    Tuple::make("john@example.com", "555-1234"),
    Tuple::make(40.7128, -74.0060) // NYC coordinates
);

[$userId, $fullName, $contacts, $location] = $user->destructure();
[$firstName, $lastName] = $fullName->destructure();
[$email, $phone] = $contacts->destructure();
[$lat, $lng] = $location->destructure();

echo "User ID: {$userId}\n";
echo "Full name: {$firstName} {$lastName}\n";
echo "Email: {$email}\n";
echo "Location: {$lat}, {$lng}\n\n";

// Example 18: Using with classes
echo "18. Using with Classes:\n";
class Person
{
    public function __construct(
        public string $name,
        public int $age
    ) {
    }
}

$alice = new Person("Alice", 30);
$personTuple = Tuple::make($alice, "active", 5.0);
[$person, $status, $rating] = $personTuple->destructure();
echo "Person: {$person->name}, Status: {$status}, Rating: {$rating}\n\n";

echo "=== All Examples Completed Successfully ===\n";
