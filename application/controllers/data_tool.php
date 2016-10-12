<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class data_tool extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header("Content-Type:text/html; charset=utf-8");
    }

    public function index()
    {
        $this->load->database("zuvio2");
        $query = $this->db->query("select * from clicker_evaluations");
        $result = $query->result_array();
        echo "<pre>result = " . print_r($result, TRUE). "</pre>";
    }

    public function zuvio_evaluation_clear()
    {
        $this->load->database("zuvio");
        $this->db->truncate("active_clickers");
        $this->db->truncate("clicker_timers");
        $this->db->truncate("clicker_evaluations");
        $this->db->truncate("clicker_questions");
        $this->db->truncate("clicker_options");
        $this->db->truncate("clicker_results");
        $this->db->truncate("evaluation_options");
        $this->db->truncate("evaluation_results");
        $this->db->truncate("essay_results");
        $this->db->truncate("groups");
        $this->db->truncate("evaluation_score_descriptions");
        $this->db->truncate("evaluation_detail_results");
        $this->db->truncate("multiple_choices_restrict");
        $this->db->truncate("clicker_quiz_results");
        $this->db->truncate("multiple_choices_results");

        echo "zuvio_evaluation_clear finish! <br>";
    }

    public function zuvio2_evaluation_clear()
    {
        $this->load->database("zuvio2");
        $this->db->truncate("active_clickers");
        $this->db->truncate("clicker_timers");
        $this->db->truncate("clicker_evaluations");
        $this->db->truncate("clicker_questions");
        $this->db->truncate("clicker_options");
        $this->db->truncate("clicker_results");
        $this->db->truncate("evaluation_options");
        $this->db->truncate("evaluation_results");
        $this->db->truncate("essay_results");
        $this->db->truncate("groups");
        // $this->db->truncate("evaluation_score_descriptions");
        $this->db->truncate("multiple_choices_restrict");
        $this->db->truncate("clicker_quiz_results");
        $this->db->truncate("multiple_choices_results");
        // $this->db->truncate("evaluation_score_descriptions");

        echo "zuvio2_evaluation_clear finish! <br>";
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */