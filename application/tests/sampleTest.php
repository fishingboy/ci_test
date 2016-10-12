<?php
// 測試案例的 class
class addTest extends PHPUnit_Framework_TestCase
{
    public function test_add_first_1_second_2_should_be_3()
    {
        // arrange
        $target = new Calculate();
        $first = 1;
        $second = 2;
        $expected = 3;

        // act
        $actual = $target->add(1, 2);

        // assert
        $this->assertEquals($expected, $actual);
    }
}

/**
 * 加法器
 */
class Calculate
{
    public function add($a, $b)
    {
        return $a + $b;
    }
}