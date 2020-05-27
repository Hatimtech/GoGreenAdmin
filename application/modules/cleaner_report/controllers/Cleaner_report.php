<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Cleaner_report extends MX_Controller {

	function __construct()
    {
		parent::__construct();
		$this->load->model('cleaner_report_model');
	}
	public function index()
	{
		die;
	}
	public function get($user_id)
	{
		$row = $this->cleaner_report_model->get_report($user_id);
		if(isset($row['report']) && $row['report'] != ''){
			$arr = json_decode($row['report'], true);
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=file.csv");
			header("Pragma: no-cache");
			header("Expires: 0");
			foreach ($arr as $key => $value) {
				echo $key.",".$value."\n";
			}
			die;
		}
	}

}
