<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Add_customer extends MX_Controller {

	function __construct()
    {
		parent::__construct();
		$this->load->model('add_customer_model');
		$bool = $this->session->userdata('authorized');
		if($bool != 1)
		{
			//echo $bool;die;
			redirect('admin');
		}
	}
	public function index()
	{

		//$users = $this->add_customer_model->get_all_users();
		// echo"<pre>";print_r($users); die;
		//$data['users'] = $users;
		$data['page'] = 'user_registration';
		_layout($data);
	}

	public function edit()
	{
		$id = $this->input->get("id");
		//$users = $this->add_customer_model->get_all_users();
		// echo"<pre>";print_r($users); die;
		$row = $this->add_customer_model->get_single_user($id);
		// $data['id'] = $id;
		$data['user'] = $row;
		$data['page'] = 'edit_user';
		_layout($data);
	}

	public function test(){
		$message = "<div><p>Dear Customer,</p>
			<p>You have successfully registered with Go Green Car Wash Services Mobile App.Your log-in credentials are:</p>
			<p> </p>
			<p>Download the App</p>
			<p>Android-(https://play.google.com/store/apps/details?id=com.gogreen.main&hl=en)</p>
			<p>Ios-(https://itunes.apple.com/ae/app/go-green-uae/id1440585352?mt=8)</p></div>";
		$this->send_mail("anand.india99@gmail.com", "Welcome to Go Green", $message);
	}

	public function add_user()
	{
		//print_r($_POST); die;
		$user_id = $this->input->post('hidden_user_id');
		if($user_id)
		{
			redirect('manual/add_cars?id='.$user_id.'');
		}
		else
		{

			$this->form_validation->set_rules('phone_number','Phone Number','required');
			if($this->form_validation->run()==TRUE)
			{
				$name = $this->input->post('name');
				$phone_number = $this->input->post('phone_number');
				//$phone_number = "+".$phone_number;
				//echo $phone_number; die;
				$countryCode = $this->input->post('countryCode');
				$phone_number = "+".$countryCode.$phone_number;
				//echo $phone_number; die;

				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$out_balance = $this->input->post('out_balance');
				$cred_flag = $this->input->post('cred_flag');
				//$password = rand(1,8);
				$data = array
				(
					'name'=>$name,
					'phone_number'=>$phone_number,
					'email'=>$email,
					'password'=>md5($password),
					'outstanding_balance'=>$out_balance,
					'status'=>1,
					'device_type'=>'website',
					'created_at'=>date('Y-m-d'),
					'login_type'=>'EM',
					'is_phone_verified'=>1,
					'is_payment'=>1,
				);
				$insert_id = $this->add_customer_model->insert_user($data);
				if($insert_id)
				{
					//$this->send_mail($email,$password);
					if($cred_flag)
					{
						$this->send_cred($email,$password,$phone_number);

					}else{
						$message = "Dear Customer,
							You have successfully registered with Go Green Car Wash Services Mobile App.
							Download the App
							Android-(https://play.google.com/store/apps/details?id=com.gogreen.main&hl=en)
							Ios-(https://itunes.apple.com/ae/app/go-green-uae/id1440585352?mt=8)
							";
							$message2 = "<div><p>Dear Customer,</p>
								<p>You have successfully registered with Go Green Car Wash Services Mobile App.Your log-in credentials are:</p>
								<p> </p>
								<p>Download the App</p>
								<p>Android-(https://play.google.com/store/apps/details?id=com.gogreen.main&hl=en)</p>
								<p>Ios-(https://itunes.apple.com/ae/app/go-green-uae/id1440585352?mt=8)</p></div>";
							$this->send_sms($phone_number, $message);
							$this->send_mail($email, "Welcome to Go Green", $message2);
					}
					$this->session->set_flashdata('customer_added','Customer has been added, add cars for this customer');
					redirect('manual/add_cars?id='.$insert_id.'');
					// $this->add_cars($insert_id);
				}
				else
				{
					alert('Error In Insertion');
				}
			}
			else
			{
				$this->session->set_flashdata('phone_invalid','Phone Number should be between 10-12 Digits');
				redirect(base_url('add_customer'));;
			}
		}
	}

	public function update_user()
	{
		//print_r($_POST); die;
		$user_id = $this->input->post('id');
		$this->form_validation->set_rules('phone_number','Phone Number','required');
			if($this->form_validation->run()==TRUE)
			{
				$name = $this->input->post('name');
				$phone_number = $this->input->post('phone_number');
				$countryCode = $this->input->post('countryCode');
				$phone_number = "+".$countryCode.$phone_number;
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$out_balance = $this->input->post('out_balance');
				$cred_flag = $this->input->post('cred_flag');
				//$password = rand(1,8);
				$data = array
				(
					'name'=>$name,
					'phone_number'=>$phone_number,
					'email'=>$email,
					'outstanding_balance'=>$out_balance
				);
				if($password != ''){
					$data['password'] = md5($password);
				}
				$insert_id = $this->add_customer_model->update_user($data, $user_id);
				// if($insert_id)
				// {
					$this->session->set_flashdata('customer_added','Customer has been updated, add cars for this customer');
					redirect('user');
				// }
				// else
				// {
				// 	alert('Error In Insertion');
				// }
		}
		else
		{
			$this->session->set_flashdata('phone_invalid','Phone Number should be between 10-12 Digits');
			redirect(base_url()."add_customer/edit?id=".$user_id);
		}

	}
	 // public function send_mail($email,$password)
   //  {
	 //
	 //
	 //
	 //
   //          $this->load->library('email');
   //          $config['protocol']    = 'smtp';
   //          $config['smtp_host']    = 'smtp.sendgrid.net';
		// 				$config['smtp_port']    = 587;
   //          $config['smtp_timeout'] = '10';
   //          $config['smtp_user']    = 'gogreen4app@gmail.com';
   //          $config['smtp_pass']    = 'Gogreen@1234';
   //          $config['charset']    = 'utf-8';
   //          $config['newline']    = "\r\n";
   //          $config['mailtype'] = 'html'; // or html
   //          $config['validation'] = TRUE; // bool whether to validate email or not
   //          $this->load->library('email', $config);
   //          $this->email->from("gogreen4app@gmail.com", 'Go Green');
   //          $this->email->to($email);
   //          $this->email->subject('Go Green');
   //          $message = "Your password  Is ".$password."";
   //          $this->email->message($message);
   //          // $this->email->send();
   //  }

    public function add_cars()
    {
    	$user_id = $this->input->get('id');
    	if(empty($user_id))
    	{
    		// echo"helllo"; die;
    		redirect('add_customer');

    	}
    	else
    	{
    		$all_cars = $this->add_customer_model->get_all_cars($user_id);


   //  		$all_cars = $this->add_customer_model->get_inactive_cars($user_id);
   //  		$data['cars'] = $all_cars;
			$all_brands = $this->add_customer_model->get_all_brands();
			$data['all_brands'] = $all_brands;
			$all_models = $this->add_customer_model->get_all_models();
	 		$data['all_models'] = $all_models;
    		$data['cars'] = $all_cars;
    		$data['page'] = 'add_car';
    		$data['user_id']=$user_id;
    		_layout($data);
    	}
    }

    public function get_brands_with_model_id()
	{
		$brand_id = $this->input->post('brand_id');
		$models = $this->add_customer_model->get_all_models_of_brand($brand_id);
		$output='';
		$output.='<option disabled value="" selected>Choose A Model </option>';
		foreach ($models as $key => $value)
		{
			$output.=' <option value="'.$value['id'].'">'.$value['name'].'</option>';
		}
		echo json_encode($output);
	}
	public function add_update_car()
	{

		$car_id  = $this->input->post('hidden_car_id');
		$user_id = $this->input->post('hidden_user_id');

		if(empty($user_id))
		{
			redirect('add_customer');
		}
		// echo $user_id; die;
		if(!empty($car_id) && !empty($user_id))
		{
			// update car_detail here
			$brand_id = $this->input->post('brand');
			$model_id = $this->input->post('model');
			$color = $this->input->post('color');
			$reg_no = $this->input->post('reg_no');
			$parking_number = $this->input->post('parking_number');
			$data=array(
				'brand'=>$brand_id,
				'model'=>$model_id,
				'color'=>$color,
				'reg_no'=>$reg_no,
				'parking_number'=>$parking_number,
			);
			$bool = $this->add_customer_model->update_car_detail($data,$car_id);

			if($bool)
			{
				$this->session->set_flashdata('car_updated','Car Updated Succesfully');
				redirect('manual/add_cars?id='.$user_id.'');
				// $this->add_cars($user_id);
			}
			else
			{
				$this->session->set_flashdata('car_updated','Error In Car Updation');
				redirect('manual/add_cars?id='.$user_id.'');
				// $this->add_cars($user_id);

			}
		}
		else
		{
			//add car_detail here
			$type = $this->input->post('type');
			$brand_id = $this->input->post('brand');
			$model_id = $this->input->post('model');
			$color = $this->input->post('color');
			$reg_no = $this->input->post('reg_no');
			$parking_number = $this->input->post('parking_number');
			$data=array(
				'user_id'=>$user_id,
				'type'=>$type,
				'brand'=>$brand_id,
				'model'=>$model_id,
				'color'=>$color,
				'reg_no'=>$reg_no,
				'parking_number'=>$parking_number,
				'is_package'=>1,
				'status'=>1
			);
			$insert_id = $this->add_customer_model->insert_car_detail($data);

			if($insert_id)
			{
				$this->session->set_flashdata('car_inserted','Car Added Succesfully');
				redirect('manual/add_cars?id='.$user_id.'');
				// $this->add_cars($user_id);
			}
			else
			{
				$this->session->set_flashdata('car_inserted','Error In Car Adding');
				redirect('manual/add_cars?id='.$user_id.'');
				// $this->add_cars($user_id);

			}
		}
	}

	public function check_phone_existence()
	{

		$phone_number = $this->input->post('phone_number');

		$row = $this->add_customer_model->is_phone_exist($phone_number);
		if($row)
		{
			$flag =2; //phone_number exist
		}
		else
		{
			$flag=1; // phone_number not_exist
		}
		echo json_encode($flag);
	}
	public function check_email_existence()
	{

		$email = $this->input->post('email');
		$id = $this->input->post('id');
		$row = $this->add_customer_model->is_email_exist($email, $id);
		if($row)
		{
			$flag =2; //phone_number exist
		}
		else
		{
			$flag=1; // phone_number not_exist
		}
		echo json_encode($flag);
	}
	public function check_reg_no_existence()
	{
		$reg_no = $this->input->post('reg_no');
		$car_id = $this->input->post('car_id');
		$row = $this->add_customer_model->check_reg_no($reg_no,$car_id);
		if($row)
		{
			$flag =2; //phone_number exist
		}
		else
		{
			$flag=1; // phone_number not_exist
		}
		echo json_encode($flag);

	}
	public function proceed_to_package()
	{
		$user_id = $this->input->get('id');
		$car_id = $this->input->get('c_id');
		if(empty($user_id))
		{
			redirect('add_customer');
		}
		else
		{
			$city_array = $this->add_customer_model->get_city();
			$data['cities'] = $city_array;
			$all_cars = $this->add_customer_model->get_inactive_cars($user_id);
    		$data['cars'] = $all_cars;
    		$data['user_id'] = $user_id;
    		$data['car_id'] = $car_id;
			$data['page'] ='activate_package';
			_layout($data);
		}
	}

	public function get_locality()
	{
		$city_id = $this->input->post('city_id');
		$locality_array =$this->add_customer_model->get_locality_by_ajax($city_id);
		//echo "<pre>";print_r($locality_array); die;
		$output = '<option value="" disabled selected>Choose Building</option>';

		foreach($locality_array as $key=>$value)
		{
			$output.='
			<option value='.$value['id'].'>'.$value['name'].'</option>
			';
		}
		echo json_encode($output);
	}
	public function get_streets()
	{
		$locality_id = $this->input->post('locality_id');
		$streets =$this->add_customer_model->get_streets_by_ajax($locality_id);
		//echo "<pre>";print_r($locality_array); die;
		$output = '<option value="" disabled selected>Choose Street</option>';

		foreach($streets as $key=>$value)
		{
			$output.='
			<option value='.$value['id'].'>'.$value['name'].'</option>
			';
		}
		echo json_encode($output);
	}
	public function book_packaage()
	{
		// print_r($_POST); die;
		// check is package exist on the selected locality and car_type
		$city_id = $this->input->post('city');
		$locality_id = $this->input->post('locality');
		$street_id = $this->input->post('street');
		$user_id = $this->input->post('hidden_user_id');
		$car_id = $this->input->post('car');
		//echo $car_id; die;
		$locality_id = $this->input->post('locality');
		$services = $this->input->post('services');
		$package_type = $this->input->post('type');
		$frequency = $this->input->post('frequency');
		$no_of_months = $this->input->post('no_of_months');
		if(empty($frequency))
		{
			$frequency=0;
		}
		$purchase_date = $this->input->post('date');
		$days = $this->input->post('days');
		if(!empty($days))
		{
			$days = implode(',', $days);
		}
		$purchase_date = date("Y-m-d", strtotime($purchase_date));
		$package_row = $this->add_customer_model->get_package_details_on_locality($locality_id,$car_id,$services);
		//echo $this->db->last_query(); die;
		//print_r($package_row); die;
		$monthly_discount = $package_row['month_'.$no_of_months.''];
		if(empty($package_row))
		{
			echo"<script>alert('package not exist');</script>";
			// $this->db->session->set_flashdata('package_not_exist','Package Not Exist On Selected locality');
			// redirect('manual/proceed_to_package?id='.$user_id.'');
		}
		else
		{
			if($package_type=='monthly')
			{
				if($services==2)//exterior service only
				{
					if($frequency==2)//twicw a week but in database its exterior once
					{
						$price = $package_row['exterior_once'];
					}
					elseif($frequency==3) // thirce a week
					{
						$price = $package_row['exterior_thrice'];
					}
					else   //6 times a week
					{
						$price = $package_row['exterior_five'];
					}
				}
				else     //interior and exterior both services
				{

					if($frequency==2)//twicw a week but in database its exterior once
					{
						$price = $package_row['exterior_once']+$package_row['interior_once'];
					}
					elseif($frequency==3) // thirce a week
					{
						$price = $package_row['exterior_thrice']+$package_row['interior_thrice'];
					}
					else   //6 times a week
					{
						$price = $package_row['exterior_five']+$package_row['interior_five'];
					}

				}

					$price = ($price * $no_of_months);
					$discount = ($price * $monthly_discount)/100;
					$price = $price - $discount;

			}
			else 			//package type is once here
			{

				if($services==2) // exteriror services only
				{
					$price = $package_row['price_exterior'];
				}
				else 		// 3 i.e enterior + exterior Service
				{
					$price = $package_row['price_interior']+$package_row['price_exterior'];

				}
			}

		}

		$price = $price + 5;
	 	$user_payment_data = array(
            'user_id' => $user_id,
            'transaction_id' => 'admin',
            'orders_id' => '',
            'net_paid' => $price,
            'actual_payment' => $price,
            'coupan_applied' => 'No',
            'payment_type' => 1
        );

        $insert_id = $this->add_customer_model->insert_user_payment_data($user_payment_data);
        if ($insert_id) {

            // update is payment on users tabel
            $this->add_customer_model->update_is_payment($user_id);


            //update  order id on user_payment tabel
            $order_id = 100000 + $insert_id;
            $this->add_customer_model->update_order_id($insert_id, $order_id);


            // foreach loop to insert details in booked_package tabel start from here
            $this->assiagn_team($user_id,$street_id,$insert_id);
            $car_id = $car_id;
            $package_type = $package_type;
            $purchase_date = $purchase_date;
            if(!empty($package_row['name']))
            {
                $package_name = $package_row['name'];
            }
            else
            {
                $package_name='';
            }
            if ($package_type == 'monthly') {
               $expiry_date = date('Y-m-d', strtotime($purchase_date . '+'.$no_of_months.' month'));
                $one_time_service_date = Null;
            } else {
                $one_time_service_date = $purchase_date;
                $expiry_date = date('Y-m-d', strtotime($one_time_service_date . '+1 day'));
                //echo $one_time_service_date; die;
            }
            $services = $services;
            $days = $days;
            $frequency = $frequency;
            $amount = $price;
            $data = array(
                'user_id' => $user_id,
                'payment_key' => $insert_id,
                'car_id' => $car_id,
                'transaction_id' => 'admin',
                'package_type' => $package_type,
                'purchase_date' => $purchase_date,
                'expiry_date' => $expiry_date,
                'package_name'=>$package_name,
                'one_time_service_date' => $one_time_service_date,
                'auto_renewal'=>2,
                'services' => $services,
                'days' => $days,
                'frequency' => $frequency,
                'amount' => $amount,
                'city_id'=>$city_id,
                'locality_id'=>$locality_id,
                'street_id'=>$street_id,
                'no_of_months'=>$no_of_months
            );
         	 //echo"hello";die;
            // if user_renew the package the new entry will go to tabel but the previous car packaege status change to 2
            $this->add_customer_model->update_package_status($car_id);

            $package_activated = $this->add_customer_model->update_is_packege_car_key($car_id);
            // echo $this->db->last_query(); die;
            $insert_id_of_booked_package = $this->add_customer_model->insert_book_package($data);
            if($insert_id_of_booked_package)
            {
            	$this->session->set_flashdata('package_activated', 'Package Activated Succesfully');
            	redirect('manual/add_cars?id='.$user_id.'');
            }
            else
            {
            	$this->session->set_flashdata('package_activated', 'Errorn  In Package Activation ');
            	redirect('manual/add_cars?id='.$user_id.'');

            }
        }

	}
	public function assiagn_team($user_id,$street_id,$insert_id)
    {
        $user_id = $user_id;
        $street_id_to_assiagn_team = $street_id;
        $team = $this->add_customer_model->get_team_id_by_street_id($street_id_to_assiagn_team);
        $team_id = $team['id'];
        //echo $team_id; die;
        if (!empty($team_id))
        {

            $data = array(
                'team_id' => $team_id,
                'user_id' => $user_id,
                'payment_key' => $insert_id,
            );
            $insert_id = $this->add_customer_model->insert_data_to_assiagned_team($data);
            //update increment job by one
            $this->add_customer_model->increment_job_by_one_in_teams_tabel($team_id);
        } else {
            $data = array(
                'team_id' => 0,
                'user_id' => $user_id,
                'payment_key' => $insert_id,
            );
            $insert_id = $this->add_customer_model->insert_data_to_assiagned_team($data);
            $paid_amount = $price;
            $this->send_mail_order_detial($insert_id);
        }
    }

     public function send_mail_order_detial($insert_id,$paid_amount)
    {

    	$row = $this->add_customer_model->get_mail_address_and_paid_amount($insert_id);
    	$email = $row['email'];
    	$amount = $row['net_paid'];
	     $order_id = 100000 + $insert_id;
	     $amount = $paid_amount;
	     $data['order_id'] = $order_id;

       $message = $this->load->view('email_template',$data,true);
            // $this->load->library('email');
            // $config['protocol']    = 'smtp';
            // $config['smtp_host']    = 'smtp.gmail.com';
            // $config['smtp_port']    = '567';
            // $config['smtp_timeout'] = '7';
            // $config['smtp_user']    = 'veee.kay258@gmail.com';
            // //$config['smtp_pass']    = 'Heyudude@0';
            // $config['charset']    = 'utf-8';
            // $config['newline']    = "\r\n";
            // $config['mailtype'] = 'html'; // or html
            // $config['validation'] = TRUE; // bool whether to validate email or not
            // $this->load->library('email', $config);
            // $this->email->from('noreply@gogreen-uae.com', 'GO GREEN');
            // $this->email->to($email);
            // $this->email->subject('Go Green');
            // $this->email->message($message);
            // $this->email->send();
						$this->send_mail($email, 'Go Green', $message);
    }

    public function delete_car()
    {
    	$car_id = $this->input->get('c_id');
    	$user_id = $this->input->get('u_id');

    	$bool = $this->add_customer_model->delete_car($car_id);
    	if($bool)
    	{
    		$this->session->set_flashdata('car_del','Car Deleted Succesfully');
    		//echo 'success'; die;

    	}
    	else
    	{
    		$this->session->set_flashdata('car_del','Error In Deletion');
    		echo 'failure'; die;

    	}
    	redirect(base_url('manual/add_cars?id='.$user_id.''));

    }
    public function send_cred($email,$password,$phone_number)
    {


    	// 	$key = "43b7c518-5060-4118-9348-f8316f9be5e0";
			// $secret = "K1zMMGiPG0WiA55nNd3xeA==";
			// $phone_number = $phone_number;
			// $user = "application\\" . $key . ":" . $secret;
			$message = "Dear Customer,
				You have successfully registered with Go Green Car Wash Services Mobile App.Your log-in credentials are:
				email: ".$email."
				password:".$password."
				Download the App
				Android-(https://play.google.com/store/apps/details?id=com.gogreen.main&hl=en)
				Ios-(https://itunes.apple.com/ae/app/go-green-uae/id1440585352?mt=8)
				";
				$message2 = "<div><p>Dear Customer,</p>
					<p>You have successfully registered with Go Green Car Wash Services Mobile App.Your log-in credentials are:</p>
					<p> </p>
					<p>Download the App</p>
					<p>Android-(https://play.google.com/store/apps/details?id=com.gogreen.main&hl=en)</p>
					<p>Ios-(https://itunes.apple.com/ae/app/go-green-uae/id1440585352?mt=8)</p></div>";
				$this->send_sms($phone_number, $message);
				$this->send_mail($email, "Welcome to Go Green", $message2);
			// gogreenpay.com?id=".$user_id."&amount=".$link_amount);
			//print_r($message); die;
			// $data = json_encode($message);
			// $ch = curl_init('https://messagingapi.sinch.com/v1/sms/' . $phone_number);
			// curl_setopt($ch, CURLOPT_POST, true);
			// curl_setopt($ch, CURLOPT_USERPWD,$user);
			// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			//
			// $result = curl_exec($ch);
			//
			// if(curl_errno($ch)) {
			// echo 'Curl error: ' . curl_error($ch);
			//
			// }
			//
			// curl_close($ch);


    }

		public function send_sms($phone, $sms, $type="ARN"){
      $phone = str_replace("+", "", $phone);
      if(strlen($phone) <= 10){
        $phone = '971'.$phone;
      }

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://rest-api.telesign.com/v1/messaging",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "message=".urlencode($sms)."&message_type=".$type."&phone_number=".$phone,
        CURLOPT_HTTPHEADER => array(
          "authorization: Basic NThEMkY1RDItM0QyQi00NTQ1LUIwRDEtOEFGNjBDMUMwNEU4OlF0V2FHTmdEbUY0azc5YkRyZGwvNmZMYlZCS3RIZUNKMksvMzRQRXRNdUdydXpiUjk4NEZZVm43Yk1pcWRoN2NXM203U2dqeWVYUkYycWg0N2t3U093PT0=",
          "content-type: application/x-www-form-urlencoded"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        return false;
      } else {
        return $response;
      }
    }
		public function send_mail($email, $subject = 'Welcome to Go Green', $message = '')
		{

			if(!empty($email))
			{
	      if($message == ''){
	        $message = "".$email." Registerd Succesfully With Go Green Team.";
	      }
				//$this->load->library('email');
	            $config['protocol']    = 'smtp';
	            $config['smtp_host']    = 'smtp.sendgrid.net';
	            $config['smtp_port']    = 587;
	            $config['smtp_timeout'] = '10';
	            $config['smtp_user']    = 'gogreen4app@gmail.com';
	            $config['smtp_pass']    = 'Gogreen@1234';
	            $config['charset']    = 'utf-8';
	            $config['newline']    = "\r\n";
	            $config['mailtype'] = 'html'; // or html
	            $config['validation'] = TRUE; // bool whether to validate email or not
	            $this->load->library('email', $config);
	            $this->email->from("gogreen4app@gmail.com", 'Go Green');
	            $this->email->to($email);
	            $this->email->subject($subject);

	            // $message .="<a href = ".base_url()."admin/confirm_password?id=$id>Link</a>";
	            $this->email->message($message);
							echo $message;
	            $o = $this->email->send();
	            return $o;
			}else{
	      return false;
	    }

		}
}
