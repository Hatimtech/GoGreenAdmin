<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Dashboard extends MX_Controller {

	function __construct()
    {
		parent::__construct();
		$this->load->model('dashboard_model');
		$bool = $this->session->userdata('authorized');

		if($bool != 1)
		{
			//echo $bool;die;
			redirect('admin');
		}
	}
	public function index()
	{

		$dashboard_stat = $this->dashboard_model->get_dashboard_stat();
		$data['dashboard_data'] = $dashboard_stat;
		 $data['page'] = 'dashboard_view';
		//$this->template->load('dashboard_view', $data);
		   _layout($data);
	}
	public function validate_to()
	{
		$from = $this->input->get("from");
		list($m, $d, $y) = explode("/", $from);
		$from = strtotime($y."-".$m."-".$d);
		$to = $this->input->get("to");
		list($m, $d, $y) = explode("/", $to);
		$to = strtotime($y."-".$m."-".$d);
		if($to < $from){
			echo -1;
		}else{
			echo $from." ".$to;
		}
	}
	public function validate_from()
	{
		$from = $this->input->get("from");
		list($m, $d, $y) = explode("/", $from);
		$from = strtotime($y."-".$m."-".$d);
		$to = date("Y-m-d");
		$to = strtotime($to);
		if($from < $to){
			echo -1;
		}else{
			echo $from." ".$to;
		}
	}
}
