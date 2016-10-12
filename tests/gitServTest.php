<?php
include_once("application/libraries/git_serv.php");

// 測試 git serv
class GitServTest extends PHPUnit_Framework_TestCase
{
    public function test_get_current_version_hash_length_should_be_7()
    {
        // arrange
        $target = new Git_serv();

        // act
        $expected = 7;
        $actual = $target->getCurrentVersionHashShort();

        // assert
        $this->assertEquals($expected, strlen($actual));
    }

    public function test_get_prev_version_hash_length_should_be_7()
    {
        // arrange
        $target = new Git_serv();
        $expected = 7;

        // act
        $actual = $target->getPrevVersionHashShort();

        // assert
        $this->assertEquals($expected, strlen($actual));
    }

    public function test_refresh_version_hash_length_should_be_7()
    {
        // arrange
        $target = new Git_serv();
        $expected = 7;

        // act
        $actual = $target->refreshVersionHash();

        // assert
        $this->assertEquals($expected, strlen($actual));
    }
}

