<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// $config['upload_path'] = './uploads/';
// $config['max_size']     = '100';
// $this->load->library('upload', $config);

class Cleaner_api_v2 extends MY_Controller
{


	function __construct()
    {
        //echo"helllo";die;

		parent::__construct();
		$this->load->model('cleaner_api_model');
		$this->load->model('api_v2/api_model');
		//$this->load->model('standard_model');
		//responseconstant
		$this->load->model('responseconstant');
		if(isset($_POST['method']) && $_POST['method'] == 'collection_file'){
			if(isset($_FILES['collection_file']) && $_FILES['collection_file']['tmp_name'] != ''){
				//
				// $this->upload->data('collection_file');
				if(move_uploaded_file($_FILES['collection_file']['tmp_name'], UPLOADS.$_FILES['collection_file']['name'])){
					$this->update_collection_file($_FILES['collection_file']['name'], $_POST['user_id']);
					$Code = ResponseConstant::SUCCESS;
					$rescode = ResponseConstant::SUCCESS;
					$Message ='SUCCESS';
					$this->sendResponse($Code,$rescode,$Message,array(HOME."uploads/".$_FILES['collection_file']['name']));
				}else{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::UNSUCCESS;
					$Message = ResponseConstant::message('UNSUCCESS');
					$this->sendResponse($Code,$rescode,$Message);
				}
				// echo UPLOADS	;
			}else{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message = ResponseConstant::message('REQUIRED_PARAMETER');
				$this->sendResponse($Code,$rescode,'$Message');
			}
		}else{
		$postData =  file_get_contents('php://input');
		$postDataArray = json_decode($postData);
       	if(!empty($postDataArray->method))
       	{
            $method = $postDataArray->method;
            //echo $method; die;
            if(!empty($postDataArray->app_key))
            {
                //Verify AppKey
                 $checkAppKey = $this->checkAppKey($postDataArray->app_key);
                if (!$checkAppKey)
                {
                    $Code = ResponseConstant::UNSUCESS;
                    $rescode = ResponseConstant::HEADER_UNAUTHORIZED;
                    $Message = ResponseConstant::message('HEADER_UNAUTHORIZED');
                    $this->sendResponse($Code,$rescode, $Message); // return data
                }
            }
            else
            {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::APPKEY_NOT_FOUND;
                $Message = ResponseConstant::message('APPKEY_NOT_FOUND');
                $this->sendResponse($Code,$Message); // return data
            }
        }
        else
        {

            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::METHOD_NOT_FOUND;
            $Message = ResponseConstant::message('METHOD_NOT_FOUND');
            $this->sendResponse($Code,$Message); // return data
        }
        switch($method)
        {
            case 'cleaner_login':
            $this->cleaner_login($postDataArray);
            break;
            case 'get_id_by_number':
            $this->get_id_by_number($postDataArray);
            break;
            case 'update_password':
            $this->update_password($postDataArray);
            break;
            case 'update_info':
            $this->update_info($postDataArray);
            break;
            case 'change_password':
            $this->change_password($postDataArray);
            break;
						case 'collection_file':
            $this->change_password($postDataArray);
            break;
						case 'update_report':
            $this->update_report($postDataArray);
            break;
						case 'report_url':
            $this->report_url($postDataArray);
            break;
						case 'create_user':
            $this->create_user($postDataArray);
            break;

						case 'get_complaints':
            $this->get_complaints($postDataArray);
            break;

						case 'get_complaint_replies':
            $this->get_complaint_replies($postDataArray);
            break;

						case 'reply_to_complaint':
            $this->reply_to_complaint($postDataArray);
            break;

						case 'update_device_token':
            $this->update_device_token($postDataArray);
            break;


        }
			}
    }
    public function cleaner_login($postDataArray)
    {
    	$phone_number = (isset($postDataArray->phone_number) && !empty($postDataArray->phone_number)) ? $postDataArray->phone_number: '';
		$password = (isset($postDataArray->password) && !empty($postDataArray->password)) ? $postDataArray->password: '';

		if(empty($phone_number) || empty($password))
		{

			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);

		}
		else
		{
			$row_array = $this->cleaner_api_model->validate_login_cleaner($phone_number,$password);
			if($row_array)
			{
				$Code = ResponseConstant::SUCCESS;
				$rescode = ResponseConstant::SUCCESS;
				$Message ='Login Successfully';
				$this->sendResponse($Code,$rescode,$Message,array($row_array));
			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message ='INVALID CREDENTIALS';
				$this->sendResponse($Code,$rescode,$Message);
			}
		}
    }
    public function get_id_by_number($postDataArray)
    {
        $phone_number = (isset($postDataArray->phone_number) && !empty($postDataArray->phone_number)) ? $postDataArray->phone_number: '';
        if(empty($phone_number))
        {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code,$rescode,$Message);
        }
        else
        {
            $row = $this->cleaner_api_model->get_user_id($phone_number);
            if($row)
            {
                $Code = ResponseConstant::SUCCESS;
                $rescode = ResponseConstant::SUCCESS;
                $Message ='SUCCESS';
                $this->sendResponse($Code,$rescode,$Message,array($row));

            }
            else
            {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'PHONE NUMBER DOES NOT EXIST';
                $this->sendResponse($Code,$rescode,$Message);
            }
        }
    }
    public function update_password($postDataArray)
    {

        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
        $confirm_password = (isset($postDataArray->confirm_password) && !empty($postDataArray->confirm_password)) ? $postDataArray->confirm_password: '';
        if(empty($user_id) || empty($confirm_password))
        {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code,$rescode,$Message);
        }
        else
        {
            $row = $this->cleaner_api_model->check_user_id($user_id);
            if($row)
            {
                $bool = $this->cleaner_api_model->update_password($user_id,$confirm_password);
                if($bool)
                {
                    $Code = ResponseConstant::SUCCESS;
                    $rescode = ResponseConstant::SUCCESS;
                    $Message ='SUCCESS';
                    $this->sendResponse($Code,$rescode,$Message);
                }
                else
                {
                    $Code = ResponseConstant::UNSUCCESS;
                    $rescode = ResponseConstant::UNSUCCESS;
                    $Message = 'ERROR IN UPDATION';
                    $this->sendResponse($Code,$rescode,$Message);
                }
            }
            else
            {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'USER ID NOT EXIST';
                $this->sendResponse($Code,$rescode,$Message);
            }

        }

    }
    public function update_info($postDataArray)
    {
       // echo"hello";die;
        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
        $phone_number = (isset($postDataArray->phone_number) && !empty($postDataArray->phone_number)) ? $postDataArray->phone_number: '';
        $first_name = (isset($postDataArray->first_name) && !empty($postDataArray->first_name)) ? $postDataArray->first_name: '';
        $last_name = (isset($postDataArray->last_name) && !empty($postDataArray->last_name)) ? $postDataArray->last_name: '';
        $email = (isset($postDataArray->email) && !empty($postDataArray->email)) ? $postDataArray->email: '';
        $image_string =(isset($postDataArray->image_string) && !empty($postDataArray->image_string)) ? $postDataArray->image_string: '';
        if(empty($user_id) || empty($phone_number) || empty($first_name) || empty($last_name) || empty($email) )
        {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code,$rescode,$Message);
        }
        else
        {
           $row =  $this->cleaner_api_model->check_user_id($user_id);
           if($row)
           {

                $data = array(

                    'phone_number'=>$phone_number,
                    'first_name'=>$first_name,
                    'last_name'=>$last_name,
                    'email'=>$email,
                    'image_string'=>$image_string

                );
                $bool = $this->cleaner_api_model->update_user_info($data,$user_id);
                if($bool)
                {
                    $Code = ResponseConstant::SUCCESS;
                    $rescode = ResponseConstant::SUCCESS;
                    $Message = 'SUCCESSFULL';
                    $this->sendResponse($Code,$rescode,$Message);
                }
                else
                {
                    $Code = ResponseConstant::UNSUCCESS;
                    $rescode = ResponseConstant::UNSUCCESS;
                    $Message = 'Error';
                    $this->sendResponse($Code,$rescode,$Message);
                }

           }
           else
           {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'USER ID NOT EXIST';
                $this->sendResponse($Code,$rescode,$Message);
           }

        }
    }

		public function update_report($postDataArray)
    {
       // echo"hello";die;
        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
        $report = (isset($postDataArray->form_data) && !empty($postDataArray->form_data)) ? json_encode($postDataArray->form_data, JSON_UNESCAPED_SLASHES): '';

        if(empty($user_id) || empty($report))
        {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code,$rescode,$Message);
        }
        else
        {
           $row =  $this->cleaner_api_model->check_user_id($user_id);
           if($row)
           {

                $data = array(
                    'report'=>$report
                );
                $bool = $this->cleaner_api_model->update_user_info($data,$user_id);
                if($bool)
                {
                    $Code = ResponseConstant::SUCCESS;
                    $rescode = ResponseConstant::SUCCESS;
                    $Message = 'SUCCESSFULL';
                    $this->sendResponse($Code,$rescode,$Message);
                }
                else
                {
                    $Code = ResponseConstant::UNSUCCESS;
                    $rescode = ResponseConstant::UNSUCCESS;
                    $Message = 'Error';
                    $this->sendResponse($Code,$rescode,$Message);
                }

           }
           else
           {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'USER ID NOT EXIST';
                $this->sendResponse($Code,$rescode,$Message);
           }

        }
    }

		public function report_url($postDataArray)
    {
       // echo"hello";die;
        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';

        if(empty($user_id))
        {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code,$rescode,$Message);
        }
        else
        {
           $row =  $this->cleaner_api_model->check_user_id($user_id);
           if($row)
           {

						 	$report =  $this->cleaner_api_model->get_report($user_id);
							$report['report'];
							if($report['report'] != ''){
								$Code = ResponseConstant::SUCCESS;
						    $rescode = ResponseConstant::SUCCESS;
						    $Message = 'SUCCESSFULL';
						    $this->sendResponse($Code,$rescode,$Message, array(HOME."index.php/cleaner_report/get/".$user_id));
							}else{
								$Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'No Report Data Found';
                $this->sendResponse($Code,$rescode,$Message);
							}
                //$bool = $this->cleaner_api_model->update_user_info($data,$user_id);
                // if($bool)
                // {
                //     $Code = ResponseConstant::SUCCESS;
                //     $rescode = ResponseConstant::SUCCESS;
                //     $Message = 'SUCCESSFULL';
                //     $this->sendResponse($Code,$rescode,$Message);
                // }
                // else
                // {
                //     $Code = ResponseConstant::UNSUCCESS;
                //     $rescode = ResponseConstant::UNSUCCESS;
                //     $Message = 'Error';
                //     $this->sendResponse($Code,$rescode,$Message);
                // }

           }
           else
           {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'USER ID NOT EXIST';
                $this->sendResponse($Code,$rescode,$Message);
           }

        }
    }

		public function update_collection_file($path, $user_id)
		{


					 $row =  $this->cleaner_api_model->check_user_id($user_id);
					 if($row)
					 {

								$data = array(

										'last_collection_file'=>$path

								);
								$bool = $this->cleaner_api_model->update_user_info($data,$user_id);
								$da = date("Y-m-d H:i:s");
								$data = array(
									'collection_file' => $path,
									'cleaner_id' => $user_id,
									'created_at' => $da
								);
								$this->cleaner_api_model->insert_collection_file($data);
					 }


		}


    public function change_password($postDataArray)
    {
        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
        $old_password = (isset($postDataArray->old_password) && !empty($postDataArray->old_password)) ? $postDataArray->old_password: '';
        $new_password = (isset($postDataArray->new_password) && !empty($postDataArray->new_password)) ? $postDataArray->new_password: '';

        if(empty($user_id) || empty($old_password) || empty($new_password) )
        {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code,$rescode,$Message);
        }
        else
        {
            $is_exist =  $this->cleaner_api_model->check_user_id($user_id);
            if($is_exist)
            {
               $row =  $this->cleaner_api_model->check_old_password($user_id,$old_password);
               if($row)
               {
                 $bool = $this->cleaner_api_model->change_password($user_id,$new_password);
                 if($bool)
                    {
                        $Code = ResponseConstant::SUCCESS;
                        $rescode = ResponseConstant::SUCCESS;
                        $Message = 'SUCCESSFULL';
                        $this->sendResponse($Code,$rescode,$Message);
                    }
                    else
                    {
                        $Code = ResponseConstant::UNSUCCESS;
                        $rescode = ResponseConstant::UNSUCCESS;
                        $Message = 'Error';
                        $this->sendResponse($Code,$rescode,$Message);
                    }
               }
               else
               {
                    $Code = ResponseConstant::UNSUCCESS;
                    $rescode = ResponseConstant::UNSUCCESS;
                    $Message = 'OLD PASSWORD NOT MATCH';
                    $this->sendResponse($Code,$rescode,$Message);
               }
            }
            else
            {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'USER ID NOT EXIST';
                $this->sendResponse($Code,$rescode,$Message);
            }
        }


    }

		public function create_user($postDataArray)
		{
			//$this->sendResponse(0,0, $postDataArray);
		$date = date("Y-m-d");
		$name = (isset($postDataArray->name) && !empty($postDataArray->name)) ? $postDataArray->name: '';
		$email =  (isset($postDataArray->email) && !empty($postDataArray->email)) ? $postDataArray->email: '';
		$phone_number = (isset($postDataArray->phone_number) && !empty($postDataArray->phone_number)) ? $postDataArray->phone_number: '';
		$cleaner_id = (isset($postDataArray->cleaner_id) && !empty($postDataArray->cleaner_id)) ? $postDataArray->cleaner_id: '';
		if($postDataArray->phone_number){$phone_number = $postDataArray->phone_number;}
		// echo  $social_id; die;
		// 	Check For Common Parameters

		if(empty($name) || empty($email) || empty($phone_number)  || empty($cleaner_id))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = 0; // Common Parameter is missing
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			//$Message = "sign up api missing parameter";

			$this->sendResponse($Code,$rescode, $Message);
		}
		else
		{

				$row_data = $this->api_model->phone_or_email_existence($phone_number,$email);
				if(count($row_data) == 0)
				{

					$data = array(
					'name'=>$name,
					'email'=>$email,
					'phone_number'=>$phone_number,
					'cleaner_id'=>$cleaner_id,
					'created_at'=>$date
					);

					$result = $this->api_model->insert_data($data);
					if($result)
					{
					$Code = ResponseConstant::SUCCESS;
					$rescode = ResponseConstant::SUCCESS;// Email is already exist
					$Message = "USER INSERTED";
					$this->sendResponse($Code,$rescode, $Message,$Message);
				}else{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::UNSUCCESS;
					$Message = "SOMETHING WENT WRONG";
					$this->sendResponse($Code,$rescode, $Message);
				}

				}
				else
				{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::UNSUCCESS;// Email is already exist
					$Message = "Phone Number / Email Linked To Another Account";
					$this->sendResponse($Code,$rescode, $Message);
				}

		}
	}

	public function get_complaints($postDataArray)
	{
		$cleaner_id = $postDataArray->cleaner_id;
		//echo "hello";die;
		if(empty($cleaner_id))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = 0; // Common Parameter is missing
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			//$Message = "sign up api missing parameter";

			$this->sendResponse($Code,$rescode, $Message);
		}
		else
		{
		$result = $this->cleaner_api_model->get_complaints($cleaner_id);
		if($result)
		{
			$Code = ResponseConstant::SUCCESS;
			$rescode=ResponseConstant::SUCCESS;
			$Message = 'Successfully Got Compalints';
			$this->sendResponse($Code,$rescode,$Message,$result);
		}
		else
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode=ResponseConstant::UNSUCCESS;
			$Message = 'No Complaints Found';
			$this->sendResponse($Code,$rescode,$Message,$result);
		}
	}
	}

	public function get_complaint_replies($postDataArray)
	{
		$cleaner_id = $postDataArray->cleaner_id;
		$complaint_id = $postDataArray->complaint_id;
		//echo "hello";die;
		if(empty($cleaner_id) || empty($complaint_id))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = 0; // Common Parameter is missing
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			//$Message = "sign up api missing parameter";

			$this->sendResponse($Code,$rescode, $Message);
		}
		else
		{
		$result = $this->cleaner_api_model->get_complaint_replies($cleaner_id, $complaint_id);
		if($result)
		{
			$Code = ResponseConstant::SUCCESS;
			$rescode=ResponseConstant::SUCCESS;
			$Message = 'Successfully Got Compalints';
			$this->sendResponse($Code,$rescode,$Message,$result);
		}
		else
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode=ResponseConstant::UNSUCCESS;
			$Message = 'No Complaints Found';
			$this->sendResponse($Code,$rescode,$Message,$result);
		}
	}
	}

	public function reply_to_complaint($postDataArray)
	{
		$cleaner_id = $postDataArray->cleaner_id;
		$complaint_id = $postDataArray->complaint_id;
		$content = $postDataArray->content;


		if(empty($cleaner_id) || empty($complaint_id) || empty($content))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = 0; // Common Parameter is missing
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode, $Message);
		}

		else
		{
			$date = date("Y-m-d H:i:s");
			$data = array(
				"complaint_id" => $complaint_id,
				"content" => $content,
				"created_by" => $cleaner_id,
				"created_at" => $date
			);
		//
		$result = $this->cleaner_api_model->reply_to_complaint($data);
		if($result)
		{
			$Code = ResponseConstant::SUCCESS;
			$rescode=ResponseConstant::SUCCESS;
			$Message = 'Successfully Inserted';
			$this->sendResponse($Code,$rescode,$Message,$result);
		}
		else
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode=ResponseConstant::UNSUCCESS;
			$Message = 'Something Went Wrong';
			$this->sendResponse($Code,$rescode,$Message,$result);
		}
	}
	}

	public function update_device_token($postDataArray)
	{
	$cleaner_id = (isset($postDataArray->cleaner_id) && !empty($postDataArray->cleaner_id)) ? $postDataArray->cleaner_id: '';
	$device_type =  (isset($postDataArray->device_type) && !empty($postDataArray->device_type)) ? $postDataArray->device_type: '';
	$device_token = (isset($postDataArray->device_token) && !empty($postDataArray->device_token)) ? $postDataArray->device_token: '';

	if(empty($cleaner_id) || empty($device_type) || empty($device_token))
	{
		$Code = ResponseConstant::UNSUCCESS;
		$rescode = 0; // Common Parameter is missing
		$Message = ResponseConstant::message('REQUIRED_PARAMETER');
		//$Message = "sign up api missing parameter";

		$this->sendResponse($Code,$rescode, $Message);
	}
	else
	{

				$data = array(
				'device_type'=>$device_type,
				'device_token'=>$device_token
				);

				$result = $this->cleaner_api_model->update_user_info($data, $cleaner_id);
				if($result)
				{
				$Code = ResponseConstant::SUCCESS;
				$rescode = ResponseConstant::SUCCESS;// Email is already exist
				$Message = "UPDATED";
				$this->sendResponse($Code,$rescode, $Message,$Message);
			}else{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message = "SOMETHING WENT WRONG";
				$this->sendResponse($Code,$rescode, $Message);
			}

	}
}
}
