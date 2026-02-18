<?php

declare(strict_types=1);

namespace DataStructures\Tests;

use DataStructures\Tuple;
use DataStructures\TypedTuple;
use PHPUnit\Framework\TestCase;

class TupleTest extends TestCase
{
    public function testCanCreateTuple(): void
    {
        $tuple = Tuple::make(1, 'string', 3.14);

        $this->assertCount(3, $tuple);
        $this->assertEquals(1, $tuple->get(0));
        $this->assertEquals('string', $tuple->get(1));
        $this->assertEquals(3.14, $tuple->get(2));
    }

    public function testCannotCreateEmptyTuple(): void
    {
        $this->expectException(\ArgumentCountError::class);
        Tuple::make();
    }

    public function testTupleIsImmutable(): void
    {
        $tuple = Tuple::make(1, 2, 3);

        // Tuples don't provide methods to modify content, but we can verify
        // that operations like map return a new instance
        $newTuple = $tuple->map(fn($x) => $x * 2);

        $this->assertNotSame($tuple, $newTuple);
        $this->assertEquals(1, $tuple->get(0));
        $this->assertEquals(2, $newTuple->get(0));
    }

    public function testTypedTupleEnforcesTypes(): void
    {
        $this->expectException(\TypeError::class);

        TypedTuple::create(['int', 'string'], 'not an int', 'string');
    }

    public function testTypedTupleAllowsCorrectTypes(): void
    {
        $tuple = TypedTuple::create(['int', 'string'], 123, 'hello');

        $this->assertEquals(123, $tuple->get(0));
        $this->assertEquals('hello', $tuple->get(1));
    }

    public function testToArray(): void
    {
        $tuple = Tuple::make(1, 2, 3);
        $this->assertEquals([1, 2, 3], $tuple->toArray());
    }

    public function testDestructuring(): void
    {
        $tuple = Tuple::make('a', 'b');
        [$a, $b] = $tuple->destructure();

        $this->assertEquals('a', $a);
        $this->assertEquals('b', $b);
    }
}
