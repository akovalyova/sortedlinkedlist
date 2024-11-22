<?php

declare(strict_types=1);

namespace App\DataStructures;

class SortedLinkedList
{
    private ?Node $head = null;
    private int $size = 0;
    private ?string $type = null;

    /**
     * If array is provided in list parameter, then intializes with it by sorting it
     * @param array<int|string> $list An array of values to initialize the list from.
     * @param Type $type
     */
    public function __construct(array $list = [], Type $type = Type::STRING)
    {
        if ($list) {
            $this->initializeFromArray($list, $type);
        }
    }

    /**
     * Adds either int or string value to the sorted list in the proper position.
     * If list already has elements of different type returns null and logs invalid value.
     * @param int|string $value
     * @return int|null
     */
    public function insert(int|string $value): ?int
    {
        if ($this->isValueNonAcceptable($value)) {
            echo 'Value skipped: ' . $value . ' of type [' . gettype($value) . "] due to type mismatch\n";
            //TODO::Implement logging here
            return null;
        }

        if ($this->isEmpty() || $this->head?->getData() >= $value) {
            $newNode = new Node($value, $this->head);
            $this->head = $newNode;
        } else {
            $current = $this->head;
            while ($current?->getNext() !== null && $current->getNext()->getData() < $value) {
                $current = $current->getNext();
            }
            $newNode = new Node($value, $current?->getNext());
            $current?->setNext($newNode);
        }
        $this->size++;

        return $this->size;
    }

    /**
     * Resets the linked list to empty state, size is 0, head points to null, type is null
     */
    public function clear(): void
    {
        $this->head = null;
        $this->size = 0;
        $this->type = null;
    }

    /**
     * Creates the linked list from an array of values.
     * If there was existing list, it is erased and new one is created.
     *
     * The array must consist of either integers or strings.
     * Invalid values are skipped and returned in the resulting array.
     *
     * @param array<int|string> $values An array of values to initialize the list from.
     * @param Type $type A type to be used in a sorted linked list, values of other type will be skipped.
     * @return array<int|string> The array of invalid values that were skipped during initialization.
     */
    public function initializeFromArray(array $values, Type $type = Type::STRING): array
    {
        $this->clear();
        $this->setType($type->value);

        sort($values);

        $current = null;
        $invalidValues = [];

        foreach ($values as $value) {
            if ($this->isValueNonAcceptable($value)) {
                $invalidValues[] = $value;
                continue;
            }

            $newNode = new Node($value);

            if ($this->head === null) {
                $this->head = $newNode;
            } else {
                $current?->setNext($newNode);
            }

            $current = $newNode;
            $this->size++;
        }

        return $invalidValues;
    }

    /**
     * Removes all elements that are equal to the specified value.
     * @param int|string $value
     * @return int|null
     */
    public function removeAll(int|string $value): ?int
    {
        if ($this->isValueNonAcceptable($value)) {
            echo 'Value skipped: ' . $value . ' of type [' . gettype($value) . "] due to type mismatch\n";
            //TODO::Implement logging here
            return null;
        }
        $found = 0;

        while ($this->head !== null && $this->head->getData() === $value) {
            $this->head = $this->head->getNext();
            $this->size--;
            $found++;
        }
        if ($this->head === null) {
            return $found;
        }

        $prev = $this->head;
        $current = $this->head->getNext();
        while ($current !== null) {
            if ($current->getData() === $value) {
                $prev->setNext($current->getNext());
                $current = $current->getNext();
                $this->size--;
                $found++;
            } else {
                $prev = $current;
                $current = $current->getNext();
            }
        }
        return $found;
    }

    /**
     * Finds whether sorted linked list contains specified value.
     * @param string|int $value
     * @return bool|null
     */
    public function contains(string|int $value): ?bool
    {
        if ($this->isValueNonAcceptable($value)) {
            echo 'Value skipped: ' . $value . ' of type [' . gettype($value) . "] due to type mismatch\n";
            //TODO::Implement logging here
            return null;
        }

        $current = $this->head;
        while ($current !== null) {
            if ($current->getData() === $value) {
                return true;
            }
            $current = $current->getNext();
        }
        return false;
    }

    /**
     * Converts the sorted linked list to an array.
     * @return array<int|string> An array of integers or strings.
     */
    public function toArray(): array
    {
        $result = [];
        $current = $this->head;

        while ($current !== null) {
            $result[] = $current->getData();
            $current = $current->getNext();
        }

        return $result;
    }

    /**
     * Returns current number of elements in the list.
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Checks whether list contains at least one element of Node class.
     * @return bool
     */
    public function isEmpty(): bool
    {
        return !$this->head instanceof Node;
    }

    /**
     * Sets type of the list to be used for its contents
     * @param string|null $type
     * @return void
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Gets current type of the list. If list is empty returns null, otherwise string representation of type.
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type ??= $this->isEmpty() ? null : gettype($this->head?->getData());
    }

    /**
     * Checks whether value is non-acceptable for existing list.
     * @param int|string $value
     * @return bool
     */
    public function isValueNonAcceptable(int|string $value): bool
    {
        return ($this->getType() && gettype($value) !== $this->getType());
    }
}
