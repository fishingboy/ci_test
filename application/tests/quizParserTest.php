<?php

include_once("application/libraries/quiz_parser.php");

class QuizParserTest extends PHPUnit_Framework_TestCase
{
    public function test_parser_get_line()
    {
        // arrange
        $content = "1 【 3 】
question1？
(1) ans1
(2) ans2
(3) ans3
(4) ans4

2 【 4 】
question2？
(1) ans21
(2) ans22
(3) ans23
(4) ans24";
        $target = new Quiz_parser();
        $target->setContent($content);
        $expected = "1【3】";

        // act
        $actual = $target->getLine();

        // assert
        $this->assertEquals($expected, $actual);
    }

    public function test_parser_get_line_test2()
    {
        // arrange
        $content = "1 【 3 】
一二 三quest ion1？
(1) ans1
(2) ans2
(3) ans3
(4) ans4

2 【 4 】
question2？
(1) ans21
(2) ans22
(3) ans23
(4) ans24";
        $target = new Quiz_parser();
        $target->setContent($content);
        $expected = "一二三question1？";

        // act
        $actual = $target->getLine();
        $actual = $target->getLine();

        // assert
        $this->assertEquals($expected, $actual);
    }

    public function test_parser_get_block()
    {
        // arrange
        $content = "1 【 3 】
question1？
(1) ans1
(2) ans2
(3) ans3
(4) ans4

2 【 4 】
question2？
(1) ans21
(2) ans22
(3) ans23
(4) ans24";
        $target = new Quiz_parser();
        $target->setContent($content);
        $expected = "1【3】
question1？
(1)ans1
(2)ans2
(3)ans3
(4)ans4";

        // act
        $actual = $target->getBlock();

        // assert
        $this->assertEquals(trim($expected), trim($actual));
    }

    public function test_parser_get_block_test2()
    {
        // arrange
        $content = "1 【 3 】
question1？
(1) ans1
(2) ans2
(3) ans3
(4) ans4


2 【 4 】
question2？
(1) ans21
(2) ans22
(3) ans23
(4) ans24";
        $target = new Quiz_parser();
        $target->setContent($content);
        $expected = "2【4】
question2？
(1)ans21
(2)ans22
(3)ans23
(4)ans24";

        // act
        $actual = $target->getBlock();
        $actual = $target->getBlock();

        // assert
        $this->assertEquals(trim($expected), trim($actual));
    }

    public function test_parser_parse_question_correctness_should_be_3()
    {
        // arrange
        $target = new Quiz_parser();
        $content = "1 【 3 】
question1？
(1) ans1
(2) ans2
(3) ans3
(4) ans4";
        $expected = 3;

        // act
        $actual = $target->parseQuestion($content);

        // assert
        $this->assertEquals($expected, $actual['correctness']);
    }

    public function test_parser_parse_question_description_should_be_question1()
    {
        // arrange
        $target = new Quiz_parser();
        $content = "1 【 3 】
question1？
(1) ans1
(2) ans2
(3) ans3
(4) ans4";
        $expected = "question1？";

        // act
        $actual = $target->parseQuestion($content);

        // assert
        $this->assertEquals($expected, $actual['description']);
    }

    public function test_parser_parse_question_options()
    {
        // arrange
        $target = new Quiz_parser();
        $content = "1 【 3 】
question1？
(1) ans1
(2) ans2
(3) ans3
(4) ans4";
        $expected = ['ans1', 'ans2', 'ans3', 'ans4', ];

        // act
        $actual = $target->parseQuestion($content);

        // assert
        $this->assertEquals($expected, $actual['options']);
    }

    public function test_parser_get_data()
    {
        // arrange
        $content = "1 【 3 】
question1?
(1) ans1
(2) ans2
(3) ans3
(4) ans4

2 【 4 】
question2?
(1) ans21
(2) ans22
(3) ans23
(4) ans24";
        $target = new Quiz_parser();
        $target->setContent($content);
        $expected = [
            [
                'description' => "question1?",
                'correctness' => 3,
                'options'     => ['ans1', 'ans2', 'ans3', 'ans4'],
            ],
            [
                'description' => "question2?",
                'correctness' => 4,
                'options'     => ['ans21', 'ans22', 'ans23', 'ans24'],
            ],
        ];

        // act
        $actual = $target->getData();

        // assert
        $this->assertEquals($expected, $actual);
    }

}