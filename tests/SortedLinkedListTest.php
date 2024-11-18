<?php

use App\DataStructures\Type;
use PHPUnit\Framework\TestCase;
use App\DataStructures\SortedLinkedList;

class SortedLinkedListTest extends TestCase
{
    private SortedLinkedList $list;

    protected function setUp(): void
    {
        $this->list = new SortedLinkedList();
    }

    public function testToArray() : void
    {
        $this->assertEquals([], $this->list->toArray(), 'toArray should return an empty array when the list is empty');

        $this->list->insert(10);
        $this->assertEquals([10], $this->list->toArray(), 'toArray should return a single-element array after adding one element');

        $this->list->insert(5);
        $this->list->insert(13);
        $this->list->insert(15);
        $this->list->insert('to ignore');
        $this->list->insert(13);
        $this->assertEquals([5, 10, 13, 13, 15], $this->list->toArray(), 'toArray should return a sorted array of all added elements');

        $this->list->removeAll(10);
        $this->assertEquals([5, 13, 13, 15], $this->list->toArray(), 'toArray should reflect the correct state after removing an element');
    }

    public function testReset() : void
    {
        $this->list->clear();
        $this->assertTrue($this->list->isEmpty(), 'List should be empty after clear');
        $this->assertEquals(0, $this->list->getSize(), 'Size should be 0 after clear');

        $this->list->insert(10);
        $this->list->insert(20);
        $this->list->insert(5);

        $this->assertFalse($this->list->isEmpty(), 'List should not be empty after added values');
        $this->assertEquals(3, $this->list->getSize(), 'Size should reflect the number of elements');

        $this->list->clear();
        $this->assertTrue($this->list->isEmpty(), 'List should be empty after clear');
        $this->assertEquals(0, $this->list->getSize(), 'Size should be 0 after clear');

        $this->list->insert(15);
        $this->assertFalse($this->list->isEmpty(), 'List should not be empty after adding an element post-clear');
        $this->assertEquals(1, $this->list->getSize(), 'Size should be updated correctly after adding elements post-clear');
        $this->assertEquals([15], $this->list->toArray(), 'List contents should reflect new additions after clear');
    }


    public function testAddAndContainsWithIntegers(): void
    {
        $this->assertEquals(1, $this->list->insert(10), 'One element should be successfully added');

        $this->assertTrue($this->list->contains(10), 'Contains should find added element');

        $this->assertEquals(2, $this->list->insert(5), 'After adding another element, there are 2 in the list');
        $this->list->insert(20);
        $this->list->insert(21);
        $this->list->insert(2);
        $this->list->insert(4);
        $this->list->insert(20);

        $this->assertTrue($this->list->contains(21), 'Contain method gets element from tail');
        $this->assertTrue($this->list->contains(5), 'Contain method gets element from head');
        $this->assertTrue($this->list->contains(20), 'Contain method gets element  from the middle that  has  duplicates');

        $this->assertFalse($this->list->contains(15), "Contains method doesn't find non-existent element");
        $this->assertEquals(7, $this->list->getSize(), "Size should be updated correctly after adding elements");
        $expected = [2, 4, 5, 10, 20, 20, 21];
        $this->assertSame($expected, $this->list->toArray(), "Elements are in the corrected order after all operations");
    }

    public function testAddAndContainsWithStrings() : void
    {
        $this->assertEquals(1, $this->list->insert("javascript"), 'One element should be successfully added');

        $this->assertTrue($this->list->contains("javascript"), 'Contains return element from head');

        $this->assertEquals(2, $this->list->insert("python"), 'Another` element should be successfully added');

        $this->list->insert("php");
        $this->list->insert("c");
        $this->list->insert("php");
        $this->list->insert("basic");


        $this->assertTrue($this->list->contains("python"), 'Contain method gets element from tail');
        $this->assertTrue($this->list->contains("php"), 'Contains method finds one of duplicates');
        $this->assertTrue($this->list->contains("basic"), 'Contains method get element from head');

        $this->assertFalse($this->list->contains("ruby"), "Contains method doesn't find non-existent element");

        $expected = ['basic', 'c', 'javascript', 'php', 'php', 'python'];
        $this->assertSame($expected, $this->list->toArray(), 'Size should be updated correctly after adding elements');
        $this->assertEquals(6, $this->list->getSize(), 'Elements are in the corrected order after all operations');
    }


    public function testAddAndContainsWithMixedTypes() : void
    {
        $this->assertEquals(1, $this->list->insert(10), 'Adding an integer should return the size as 1');

        $this->assertEquals(null, $this->list->insert("wrong"), 'Adding a wrong type should return null');

        $this->assertTrue($this->list->contains(10), 'Contains should find the added integer');
        $this->assertEquals(null, $this->list->contains('10'), 'Contains should return null for an incompatible type');
        $this->assertEquals(null, $this->list->contains("wrong"), 'Contains should return null for a non-existent and incompatible type');

        $expected = [10];
        $this->assertSame($expected, $this->list->toArray(), 'toArray should return an array with the single added integer');
    }

    public function testRemoveAllWithIntegers() : void
    {
        $initArrayInteger = [20, 4, 2, 21, 35, 2, 5, 10, 2, 35, 16, 7];
        $this->assertEquals([], $this->list->initializeFromArray($initArrayInteger, Type::INT), 'Should populate the list with integers');

        $this->assertEquals(3, $this->list->removeAll(2), 'Should return the count of removed elements for a value for duplicated element at head');

        $this->assertEquals(1, $this->list->removeAll(20), 'Should return 1 when one occurrence of a value is removed, element in the middle');

        $expected = [4, 5, 7, 10, 16, 21, 35, 35];
        $this->assertSame($expected, $this->list->toArray(), 'Should reflect the correct state after removing duplicated elements at tail');

        $this->assertEquals(2, $this->list->removeAll(35), 'Should return the count of removed elements for a value with duplicates');

        $expected = [4, 5, 7, 10, 16, 21];
        $this->assertSame($expected, $this->list->toArray(), 'Should reflect the correct state after all removals');
    }

    public function testInitializeFromArray(): void
    {
        $initArrayInteger = [20, 4, 21, 2, 5, 10, 20];
        $this->assertEquals([], $this->list->initializeFromArray($initArrayInteger, Type::INT), 'Should initialize the list with integers');

        $expectedIntegers = [2, 4, 5, 10, 20, 20, 21];
        $this->assertSame($expectedIntegers, $this->list->toArray(), 'Should reflect the sorted state of the integer array');

        $initArrayStrings = ['javascript', 'c', 5, 'basic', 'php', 3, 'python', 'php'];
        $this->assertEquals([3, 5], $this->list->initializeFromArray($initArrayStrings, Type::STRING), 'Should return non-string elements for strings initialization');

        $expectedStrings = ['basic', 'c', 'javascript', 'php', 'php', 'python'];
        $this->assertSame($expectedStrings, $this->list->toArray(), 'Should reflect the sorted state of the integer array');
    }
}