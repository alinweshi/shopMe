<?php

namespace Tests\Feature\Api;


use PHPUnit\Framework\TestCase;

class CartesianProductTest extends TestCase
{
    public function test_cartesian_product()
    {
        $result = cartesianProduct([1, 2], ['a', 'b']);
        $expected = [
            [1, 'a'],
            [1, 'b'],
            [2, 'a'],
            [2, 'b']
        ];
        $this->assertEquals($expected, $result);
    }

    public function testEdgeCases()
    {
        $this->assertEquals([], cartesianProduct([1, 2], [])); // Empty array case
        $this->assertEquals([[1], [2]], cartesianProduct([1, 2])); // Single array case
    }

    public function testWithCallback()
    {
        $result = cartesianProductWithCallback(
            fn($combination) => implode('-', $combination),
            [1, 2],
            ['a', 'b']
        );
        $expected = ['1-a', '1-b', '2-a', '2-b'];
        $this->assertEquals($expected, $result);
    }
}
