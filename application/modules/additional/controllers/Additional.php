<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Additional extends MX_Controller {
public $ftres;
	function __construct()
    {
		parent::__construct();
		$this->load->model('additional_model');
		$this->load->helper('filter');
		$bool = $this->session->userdata('authorized');
		if($bool != 1)
		{
		  redirect('admin');
		}
		$ft = $this->input->get("ft");
		$from = $this->input->get("ftfr");
		$to = $this->input->get("ftto");
		$this->ftres = ftprocess($ft, $from, $to);
	}
	public function index()
	{

		$city = $this->additional_model->get_city();
		$data['city'] =$city;
		$localities_id = $this->input->post('locality_id');
		$cleaners = $this->additional_model->get_all_additional($localities_id);

		$data['additional'] =$cleaners;
		//$this->template->load('template', 'additional_view',$data);
		$data['page'] ='additional_view';
		_layout($data);
	}

	public function booked()
	{
		$cleaners = $this->additional_model->get_booked_additional($this->ftres);

		$data['additional'] =$cleaners;
		$data['page'] ='booked_view';
		_layout($data);
	}
	public function add_new()
	{
		$city_array = $this->additional_model->get_city();
		$data['cities'] = $city_array;
		$data['page'] = 'add_additional_view';
		_layout($data);
	}
	public function get_report($user_id)
	{
		$row = $this->additional_model->get_report($user_id);
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

	public function get_locality()
	{
		$city_id = $this->input->post('city_id');
		$locality_array =$this->additional_model->get_locality_by_ajax($city_id);
		//echo "<pre>";print_r($locality_array); die;
		$output = '';
		foreach($locality_array as $key=>$value)
		{
			$output.='
			<option value='.$value['id'].'>'.$value['name'].'</option>
			';
		}
		echo json_encode($output);
	}
	public function insert_additional()
	{
		$service_name = $this->input->post('service_name');
		$price = $this->input->post('price');
		$city = $this->input->post('city');
		$locality = $this->input->post('locality');

			$data = array(

				'service_name'=>$service_name,
				'price'=>$price,
				'city_id'=>$city,
				'locality_id'=>$locality
			);
			$bool = $this->additional_model->insert_additional_data($data);
			if($bool)
			{
				$this->session->set_flashdata('additional_added','Additional added');
			}
			else{
				$this->session->set_flashdata('additional_error','Additional added');
			}

		redirect('additional');
	}
	public function edit_additional()
	{
		$additional_id = $this->input->get('id');
		if($_POST)
		{
			// echo"here die;";
			$service_name = $this->input->post('service_name');
			$price = $this->input->post('price');
			$city = $this->input->post('city');
			$locality = $this->input->post('locality');


				$data = array(
					'service_name'=>$service_name,
					'price'=>$price,
					'city_id'=>$city,
					'locality_id'=>$locality
				);
				$bool = $this->additional_model->update_additional_data($data,$additional_id);
				if($bool)
				{
					$this->session->set_flashdata('additional_added','additional added');
					redirect('additional');
				}
				else{

					$this->session->set_flashdata('additional_error','additional added');
				}

		}



		$additional_id = $this->input->get('id');
		$row = $this->additional_model->get_additional_to_edit($additional_id);
		$data['additional']=$row;
		$city_array = $this->additional_model->get_city();
		$data['cities'] = $city_array;
		$data['page']='edit_additional';
		_layout($data);
	}
	public function inactive_additional()
	{
		$additional_id = $this->input->get('id');
		// echo $additional_id; die;
		$bool = $this->additional_model->inactivate_additional($additional_id);
		if($bool)
		{
			$this->session->set_flashdata('additional_delleted','Additional Service deleted successfully');
		}
		else
		{
			echo"<script>alert('Error IN Deletion');</script>";
		}
		redirect('additional');
	}
	public function additional_job_detail()
	{
		$additional_id = $this->input->get('id');

		$work_history = $this->additional_model->get_additional_job_done_detail($additional_id);
		// echo"<pre>";print_r($work_history); die;
		$data['history'] = $work_history;
		$data['page'] = 'additional_job_history';
		_layout($data);
	}
	public function get_locality_for_street()
	{
		 $city_id = $this->input->post('city_id');
		// $city_id=3;
		 $localities = $this->additional_model->get_locality_ajax($city_id);
		 $output = '';
		 foreach ($localities as $key => $value)
		 {
		 	$output .='<label for="one">
        <input name="locality_id[]" type="checkbox" value="'.$value['id'].'" id="'.$value['id'].'" />'.$value['name'].'</label>';
		 }
		 $data = array(
			'option'=>$output,
		 );
		 //print_r($data); die;
		 echo json_encode($data);
	}
}
