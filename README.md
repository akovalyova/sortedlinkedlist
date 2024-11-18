# Sorted Linked List

---
The SortedLinkedList class is a data structure that maintains a list of elements sorted in ascending order. It supports both integers and strings, ensuring that all elements in the list are of the same type. This class also provides utility methods to manipulate and query the list.

### Features

- Elements are always inserted in a sorted order.
- The list supports only one type of element (either integers or strings) at a time. 
- Populate the list from an array of values while handling invalid types. 
- Allows duplicate values in the list. 

---
### Operations
- Insert elements. 
- Remove specific elements (including all duplicates).
- Check if an element exists.
- Convert the list to an array.
- Reset: Clear the list and reset its state.

---
### Installation
To use the SortedLinkedList, include it in your project by copying the source files into your project structure. Ensure your environment supports PHP 8.1+ for proper handling of union types (int|string) and enums.

---
### Usage

#### Adding one by one
````
$list = new SortedLinkedList();
$list->add(10);
$list->add(5);
$list->add(20);

print_r($list->toArray()); // Output: [5, 10, 20]
````
#### Batch initialization
````
$list->initializeBatchFromArray([3, 1, 5, "invalid"], Type::INT);
// Skips "invalid"
// Output: [1, 3, 5]
````

#### Working with strings

````
$list = new SortedLinkedList();

// Initialize with string values
$list->initializeBatchFromArray(['us-east-1', 'ap-southeast-2', 'eu-central-1', 'us-west-2',
   "ca-central-1"], Type::STRING);

// Adding more strings
$list->add('af-south-1');
$list->add('us-east-1');
$list->add('ap-northeast-1');

// Checking the contents
print_r($list->toArray()); // Output: ['af-south-1', 'ap-northeast-1', 'ap-southeast-2', 'ca-central-1', 'eu-central-1', 'us-east-1', 'us-east-1', 'us-west-2']

// Removing a value - all occurences
$list->removeAll('us-east-1');
print_r($list->toArray()); // Output: ['af-south-1', 'ap-northeast-1', 'ap-southeast-2', 'ca-central-1', 'eu-central-1', 'us-west-2']
````

---

### Testing
Tests are written using PHPUnit. The following test cases are covered:

- Adding elements.
- Removing elements.
- Converting to array
- Checking presence.
- Initializing from arrays.
- Mixed-type operations.
- Clearing the list.

---

### Possible Enhancements
- Add logging support for invalid operations, ability to inject logger. 
- Adding method to bulk insert  to existing list, array to be added should be first sorted(by native php search) and then merged into existing list, which should be more effective than adding one by one to the list. 
- Extend functionality to support custom comparison logic, possibly extending types to include objects and sorting the same list by different fields of those object , for example, adding tasks to the list to be sorted either by priority level (string) or by date (timestamp).