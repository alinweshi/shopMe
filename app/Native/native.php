<?php
function cartesianProduct(...$arrays) // Function is called with ([1, 2], ['A', 'B'], ['X', 'Y'])
{
    if (empty($arrays)) {
        return [[]]; // Base case: If there are no arrays left, return a single empty array.
    }

    $firstArray = array_shift($arrays);
    // Extract the first array: $firstArray = [1, 2]
    // Remaining arrays: $arrays = [['A', 'B'], ['X', 'Y']]

    $remainingProduct = cartesianProduct(...$arrays);
    /* 
        Recursive call with:
        cartesianProduct(['A', 'B'], ['X', 'Y'])
        
        Steps inside the recursive call:
        - First array extracted: ['A', 'B']
        - Remaining arrays: [['X', 'Y']]
        - Recursive call: cartesianProduct(['X', 'Y'])
        
        Steps inside cartesianProduct(['X', 'Y']):
        - First array extracted: ['X', 'Y']
        - Remaining arrays: []
        - Recursive call: cartesianProduct([]) → Returns [[]] (base case)
        
        Returning to cartesianProduct(['X', 'Y']):
        - Loop over ['X', 'Y']
        - Merge each element with [[]]: 
            ['X'] + [] → ['X']
            ['Y'] + [] → ['Y']
        - Returns [['X'], ['Y']]
        
        Returning to cartesianProduct(['A', 'B'], ['X', 'Y']):
        - Loop over ['A', 'B']
        - Merge with [['X'], ['Y']]: 
            ['A'] + ['X'] → ['A', 'X']
            ['A'] + ['Y'] → ['A', 'Y']
            ['B'] + ['X'] → ['B', 'X']
            ['B'] + ['Y'] → ['B', 'Y']
        - Returns [['A', 'X'], ['A', 'Y'], ['B', 'X'], ['B', 'Y']]
    */

    $result = []; // Initialize empty result array

    foreach ($firstArray as $element) { // Loop over first array elements (1, 2)
        foreach ($remainingProduct as $product) {
            // Merge current element with each sub-product of remaining arrays
            $result[] = array_merge([$element], $product);

            /* Iteration breakdown:
                - For element 1:
                    [1] + ['A', 'X'] → [1, 'A', 'X']
                    [1] + ['A', 'Y'] → [1, 'A', 'Y']
                    [1] + ['B', 'X'] → [1, 'B', 'X']
                    [1] + ['B', 'Y'] → [1, 'B', 'Y']
                - For element 2:
                    [2] + ['A', 'X'] → [2, 'A', 'X']
                    [2] + ['A', 'Y'] → [2, 'A', 'Y']
                    [2] + ['B', 'X'] → [2, 'B', 'X']
                    [2] + ['B', 'Y'] → [2, 'B', 'Y']
            */
        }
    }

    return $result; // Return the final Cartesian product

    /* Final Output:
        [
            [1, 'A', 'X'], [1, 'A', 'Y'],
            [1, 'B', 'X'], [1, 'B', 'Y'],
            [2, 'A', 'X'], [2, 'A', 'Y'],
            [2, 'B', 'X'], [2, 'B', 'Y']
        ]
    */
}
// print_r(cartesianProduct([1, 2], ['A', 'B'], ['X', 'Y'], ['l', 'o', 'p']));
// print_r(cartesianProduct([1, 2]));
// print_r(cartesianProduct([]));

/*-------------------------------------------------------------------------*/
/*----------------Adding a Callback Function for Customization-------------*/
function cartesianProductWithCallback(callable $callback, ...$arrays)
{
    $result = cartesianProduct(...$arrays);
    return array_map($callback, $result);
}
// print_r(cartesianProductWithCallback(fn($array) => implode('-', $array), [1, 2], ['A', 'B'], ['X', 'Y']));

/*-------------------------------------------------------------------------*/

/*-----------------------Using Generators for Performance------------------*/
function cartesianProductGenerator(...$arrays)
{
    if (empty($arrays)) {
        yield [];
        return;
    }

    $firstArray = array_shift($arrays);
    foreach ($firstArray as $item) {
        foreach (cartesianProductGenerator(...$arrays) as $subset) {
            yield array_merge([$item], $subset);
        }
    }
}
foreach (cartesianProductGenerator(range(1, 1000), range(1, 1000)) as $combination) {
    print_r($combination);
}

/*-------------------------------------------------------------------------*/
