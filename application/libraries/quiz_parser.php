<?php
/**
 * 測驗題目解析
 */
class Quiz_parser
{
    private $content;

    private $lines;

    private $curr_index;

    private $max_length;

    public function setContent($content = "")
    {
        if ($content) {
            $this->content = $content;
        } else {
            $this->content = file_get_contents("data/quiz.txt");
        }

        $this->curr_index = 0;
        $this->lines      = explode("\n", $this->content);
        $this->max_length = count($this->lines);
    }

    public function getLine()
    {
        if ($this->curr_index == $this->max_length) {
            return null;
        }

        $line = trim($this->lines[$this->curr_index]);

        // 拿掉多餘空白
        $line = str_replace(" ", '', $line);
        
        $this->curr_index++;
        return $line;
    }

    public function getBlock()
    {
        $block = "";
        while (null !== ($line = $this->getLine())) {
            if ($line == "" && $block != "") {
                break;
            }
            $block .= "{$line}\n";
        }
        return ($block) ? $block : null;
    }

    public function parseQuestion($block)
    {
        $lines = explode("\n", $block);

        // 取得正確答案
        $line = $lines[0];
        preg_match("/^[0-9]+.*([0-9]+)/", $line, $matches);
        $correctness = (isset($matches[1])) ? $matches[1] : null;

        // 取得題目標題
        $description = $lines[1];

        // 取得選項
        $options = [];
        for ($i = 2; $i < count($lines); $i++) {
            $line = preg_match("/^\([0-9]\)[ ]*(.*)$/", $lines[$i], $matches);
            if (isset($matches[1])) {
                $options[] = $matches[1];
            }
        }

        return [
            'description' => $description,
            'correctness' => $correctness,
            'options'     => $options,
        ];
    }

    public function getData()
    {
        $questions = [];
        while (null !== ($block = $this->getBlock())) {
            $questions[] = $this->parseQuestion($block);
        }
        return $questions;
    }
}
