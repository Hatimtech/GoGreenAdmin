<?php
  Class Car_packages_model extends CI_Model
  {


    public function insert_car_details($data)
    {
      $query = $this->db->insert('car_detail' , $data);
      $result = $this->db->insert_id();
      return $result;
    }
    public function check_reg_no($user_id,$reg_no)
    {

      $this->db->select('*');
      $this->db->where('user_id', $user_id);
      $this->db->where('reg_no', $reg_no);
       $this->db->where("status !=",2);
      $query = $this->db->get('car_detail');
      $row = $query->row_array();
      if($row)
      {
        return 1;
      }
      else{
        return 0;
      }
    }

    public function get_cars($user_id)
    {
      $where = '(bp.status=1 or bp.status IS NULL) AND cd.user_id="'.$user_id.'"';
      $this->db->select('cd.id,cd.is_package,cd.parking_number,cb.name as brand,cd.reg_no,cm.name as model,cd.type,cd.color,bp.expiry_date');
      $this->db->join('car_model as cm','cm.id=cd.model','left');
      $this->db->join('car_brand as cb','cb.id=cd.brand','left');
       $this->db->join('booked_packages as bp','bp.car_id=cd.id','left');
       $this->db->where($where);
      $query = $this->db->get('car_detail as cd');
      //echo $this->db->last_query(); die;
      return $query->result_array();
    }
    public function get_cars_updated($user_id)
    {
      $this->db->select('car_detail.id,car_detail.is_package,car_detail.parking_number,car_brand.name as brand,car_detail.reg_no,car_model.name as model,car_detail.type,car_detail.color,car_brand.id as brand_id,car_model.id as model_id');
      $this->db->join('car_model','car_model.id=car_detail.model','left');
      $this->db->join('car_brand','car_brand.id=car_detail.brand','left');
      // $this->db->join('booked_packages','booked_packages.car_id=car_detail.id','left');
      $this->db->where('car_detail.user_id',$user_id);
      $this->db->where('car_detail.status',1);
      $query = $this->db->get('car_detail');
      //echo $this->db->last_query(); die;
      return $query->result_array();
    }
    public function get_models($brand_id)
    {
      $this->db->select('*');
      $this->db->where('brand_id',$brand_id);
      $query = $this->db->get('car_model');
      return $query->result_array();
    }
    public function get_brand()
    {
      $this->db->select('*');
      $query = $this->db->get('car_brand');
      return $query->result_array();
    }
    public function check_brand_name($name)
    {
      $this->db->select('*');
      $this->db->where('name',$name);
      $query = $this->db->get('car_brand');
      //echo $this->db->last_query(); die;
      return $query->row_array();

    }
    public function check_model_name($name)
    {
      $this->db->select('*');
      $this->db->where('name',$name);
      $query = $this->db->get('car_brand');
      //echo $this->db->last_query(); die;
      return $query->row_array();

    }
    public function insert_brand($data)
    {
        $this->db->insert('car_brand',$data);
       $insert_id = $this->db->insert_id();
       return  $insert_id;

    }
    public function insert_model($data)
    {
       $bool = $this->db->insert('car_model',$data);
       if($bool)
       {
        return 1;
       }
       else{
        return 0;
       }
    }
    public function get_package($locality_id,$car_type)
    {
      $this->db->select('packages.*,pl.locality_id,pl.city_id');
      $this->db->join('package_locations as pl','pl.package_id=packages.id');
      $this->db->where('pl.locality_id',$locality_id);
      $this->db->where('packages.type',$car_type);
      $query = $this->db->get('packages');
      //echo $this->db->last_query(); die;
      return $query->result_array();

    }
    public function insert_book_package($data)
    {
      $query = $this->db->insert('booked_packages',$data);
      $insert_id = $this->db->insert_id();
      return  $insert_id;
    }
    public function insert_additional_services($data)
    {
      $query = $this->db->insert('booked_additional_services',$data);
      $insert_id = $this->db->insert_id();
      return  $insert_id;
    }
    public function check_car_existence($car_id)
    {
      $this->db->select('*');
      $this->db->where('car_id',$car_id);
      $query = $this->db->get('booked_packages');
      $bool = $query->row_array();
      if($bool)
      {
        return 1;
      }
      else{
        return 0;
      }
    }
    public function insert_user_payment_data($user_payment_data)
    {
      $query = $this->db->insert('user_payment',$user_payment_data);
      $insert_id = $this->db->insert_id();
      return  $insert_id;
    }
    public function is_package_on_car($car_id)
    {
      $this->db->select('*');
      $this->db->where('car_id',$car_id);
      $query = $this->db->get('booked_packages');
      return $query->row_array();
    }
    public function update_is_packege_car_key($car_id)
    {
      $this->db->set('is_package',2);
      $this->db->where('id',$car_id);
      $query = $this->db->update('car_detail');
      if($query)
      {
        return 1;
      }
      else{
        return 0;
      }
    }
    public function update_is_package_as_expire($id)
    {
      $this->db->set('is_package',1);
      $this->db->where('id',$id);
      $query = $this->db->update('car_detail');
      //echo $this->db->last_query(); die;
      if($query)
      {
        return 1;
      }
      else{
        return 0;
      }

    }

    public function update_is_package_as_active($id)
    {
      $this->db->set('is_package',2);
      $this->db->where('id',$id);
      $query = $this->db->update('car_detail');
      //echo $this->db->last_query(); die;
      if($query)
      {
        return 1;
      }
      else{
        return 0;
      }

    }
    public function update_is_payment($user_id)
    {
      $this->db->set('is_payment',2);
      $this->db->where('id',$user_id);
      $query = $this->db->update('users');
      if($query)
      {
        return 1;
      }
      else{
        return 0;
      }
    }
    public function get_week_before_data($user_id,$today,$next_week)
    {
      $this->db->select('booked_packages.payment_key, booked_packages.services, booked_packages.car_id, booked_packages.frequency, booked_packages.package_name, booked_packages.no_of_months, booked_packages.user_id,booked_packages.one_time_service_date,booked_packages.expiry_date,booked_packages.amount,booked_packages.days,booked_packages.package_type,booked_packages.purchase_date,cd.parking_number,cd.type,cd.reg_no,md.name as model,cb.name as brand');
      $this->db->where('expiry_date>',$today);
     // $this->db->where('expiry_date<',$next_week);
      $this->db->where('booked_packages.user_id',$user_id);
      $this->db->join('car_detail as cd','cd.id=booked_packages.car_id','left');
      $this->db->join('car_brand as cb','cb.id=cd.brand','left');
      $this->db->join('car_model as md','md.id=cd.model','left');
      $query = $this->db->get('booked_packages');
     // echo $this->db->last_query(); die;
      return $query->result_array();
    }
    public function check_car_id_existence($id)
    {
      $this->db->select('*');
      $this->db->where('car_id',$id);
      $query = $this->db->get('booked_packages');
      return $query->row_array();
    }
    public function update_car_package($car_id,$data)
    {
      $this->db->where('car_id',$car_id);
      $query = $this->db->update('booked_packages',$data);
      if($query)
      {
        return 1;
      }
      else{
        return 0;
      }
    }
    public function check_user_id_and_car_id($user_id,$car_id)
    {
        $this->db->select('*');
        $this->db->where('user_id',$user_id);
        $this->db->where('id',$car_id);
        $query = $this->db->get('car_detail');
        //echo $this->db->last_query(); die;
        return $query->row_array();

    }
    public function update_car_detail($data,$car_id)
    {
      $this->db->where('id',$car_id);
      $query = $this->db->update('car_detail',$data);
      if($query)
      {
        return 1;
      }
      else
      {
          return 0;
      }
    }
    public function delete_car($user_id,$car_id)
    {
      $this->db->where('id',$car_id);
      $this->db->where('user_id',$user_id);
      $this->db->where('is_package',1);
      $this->db->set('status',2);
      $query = $this->db->update('car_detail');
      if($query)
      {
        return 1;
      }
      else
      {
          return 0;
      }
    }
    public function get_all_coupans()
    {
      $this->db->select('id,offer_name,coupan_code,img_name');
      $this->db->where('valid_from<=' , 'CURDATE()',FALSE);
      $this->db->where('valid_upto>=' , 'CURDATE()',FALSE);
      $query = $this->db->get('coupans');
      //echo $this->db->last_query(); die;
      return $query->result_array();

    }
    public function get_additional_coupans($additional_id)
    {
      $this->db->select('id,offer_name,coupan_code,img_name');
      $this->db->where('valid_from<=' , 'CURDATE()',FALSE);
      $this->db->where('valid_upto>=' , 'CURDATE()',FALSE);
      $this->db->where('additional_services_id' , $additional_id);
      $query = $this->db->get('additional_coupans');
      //echo $this->db->last_query(); die;
      return $query->result_array();

    }
    public function is_user_active($user_id)
    {
      $this->db->where('id',$user_id);
      $this->db->where('is_payment',2);
      $query = $this->db->get('users');
      return $query->row_array();
    }
    public function check_user_id($user_id)
    {
      $this->db->where('id',$user_id);
      $query = $this->db->get('users');
      return $query->row_array();
    }

  public function get_coupan_code_detail($data, $additional)
  {
    $this->db->select('id,offer_name,coupan_code,discount,minimum_order,max_discount');
    $this->db->where($data);
    $this->db->where('valid_upto >=','CURDATE()',FALSE);
    $this->db->or_where("user_type", 3);
    $query = $this->db->get('coupans');
    $row = $query->row_array();

    if(count($row) == 0){
      $this->db->select('id,offer_name,coupan_code,discount,minimum_order,max_discount');
      $this->db->where($data);
      $this->db->where('valid_upto >=','CURDATE()',FALSE);
      $w = array();
      foreach ($additional as $key => $value) {
        // $this->db->or_where("additional_services_id", $value);
        $w[] = "additional_services_id = '$value'";
      }
      $ww = implode(" OR ", $w);
      $this->db->where("($ww)");
      $this->db->or_where("user_type", 3);
      $query = $this->db->get('additional_coupans');
      $row = $query->row_array();
    }
   // echo $this->db->last_query(); die;
    return $row;
  }
  public function get_expired_packages_detail($user_id)
  {
    $date = date("Y-m-d", strtotime("+2 days"));
    $this->db->select('booked_packages.payment_key,booked_packages.user_id,booked_packages.one_time_service_date,booked_packages.services,booked_packages.frequency,booked_packages.expiry_date,booked_packages.amount,booked_packages.days,booked_packages.package_type,booked_packages.package_name,booked_packages.purchase_date,cd.parking_number,cd.type,md.name as model,cb.name as brand,cd.id as car_id,cd.reg_no,booked_packages.no_of_months');
    $this->db->join('car_detail as cd','cd.id=booked_packages.car_id','left');
    $this->db->join('car_brand as cb','cb.id=cd.brand','left');
    $this->db->join('car_model as md','md.id=cd.model','left');
    $this->db->where('booked_packages.user_id',$user_id);
    $this->db->where('booked_packages.status',1);
    $this->db->where('cd.status',1);
    $this->db->where('booked_packages.expiry_date<=',$date,FALSE);
    $query = $this->db->get('booked_packages');
    //echo $this->db->last_query(); die;
    return $query->result_array();
  }
  public function get_additional_services($payment_key)
  {
    $this->db->select('A.additional_services_id, B.service_name, A.amount, A.purchase_date, A.status, A.status_reason');
    $this->db->join('additional_services as B','B.id=A.additional_services_id','inner');
    $this->db->where('A.payment_key',$payment_key);
    $query = $this->db->get('booked_additional_services AS A');
    //echo $this->db->last_query(); die;
    return $query->result_array();
  }
  public function update_order_id($insert_id,$order_id)
  {
    $this->db->set('orders_id',$order_id);
    $this->db->where('id',$insert_id);
    $query = $this->db->update('user_payment');
    //echo $this->db->last_query(); die;
    if($query)
    {
      return 1;
    }
    else{
      return 0;
    }

  }
  public function get_street_id_by_car_id($car_id)
  {
    $this->db->select('street_id');
    $this->db->where('id',$car_id);
    $query = $this->db->get('car_detail');
    return $query->row_array();
  }
  public function get_team_id_by_street_id($street_id)
  {
    // $this->db->select('team_id');
    // $this->db->where('street_id',$street_id);
    // $query = $this->db->get('teams_street');
    // return $query->row_array();
    $this->db->select('t.id,t.jobs');
    $this->db->where('ts.street_id',$street_id);
    $this->db->join('teams_street as ts','ts.team_id=t.id');
    $this->db->where('t.status',1);//only active teams
    $this->db->order_by('jobs','ASC');
    $this->db->limit(1);
    $query = $this->db->get('teams as t');
    //echo $this->db->last_query(); die;
    return $query->row_array();
    //echo $this->db->last_query(); die;
  }
  public function insert_data_to_assiagned_team($data)
  {
    $this->db->insert('assiagned_team',$data);
    $insert_id = $this->db->insert_id();

    return  $insert_id;

  }
  public function increment_job_by_one_in_teams_tabel($team_id)
  {
        $this->db->where('id',$team_id);
        $this->db->set('jobs', 'jobs+1', FALSE);
        $this->db->update('teams');
       // echo $this->db->last_query(); die;
  }

  public function update_package_status($car_id)
  {
    $this->db->set('status',2);
    $this->db->where('car_id',$car_id);
    $this->db->update('booked_packages');
  }
  public function get_email_by_user_id($user_id)
  {
    $this->db->select('email');
    $this->db->where('id',$user_id);
    $query = $this->db->get('users');
    return $query->row_array();
  }
  public function get_details_by_order_id($order_id)
  {
    $this->db->select('u.id,u.email,up.orders_id,up.net_paid,u.device_token,up.payment_type');
    $this->db->join('users as u','u.id=up.user_id');
    $this->db->where('up.id',$order_id);
    $query = $this->db->get('user_payment as up');
    return $query->row_array();
  }
  public function update_token($data,$id)
  {
    $this->db->where('id',$id);
    $query = $this->db->update('users',$data);
    if($query)
    {
      return 1;
    }
    else
    {
      return 0;;
    }
  }


    public function sendPush($json)
    {
     // print_r($json); die;
      $url = "https://fcm.googleapis.com/fcm/send";
      $serverKey = 'AAAAuNPqydM:APA91bHlf3OKR8YVWvTkXvhkuKJBO5uxVlfCgjP4v0x59eGJ-QjyInshYaKicrFY9irdr8BptL7p01nCvtn65Hb3eHu7TcufSOgy9mtnvXA5YGRf8uT4Y9xTA379TduU3wnhO5XVOuUn';
      $headers = array();
      $headers[] = 'Content-Type: application/json';
      $headers[] = 'Authorization: key='. $serverKey;

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
      curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      // die('testiing');
      //print_r($response);
      $response = curl_exec($ch);

      if ($response === FALSE)
      {
       die('FCM Send Error: ' . curl_error($ch));
      }
      return curl_close($ch);
    }

      public function get_order_data($order_id)
      {
        $this->db->where('up.id',$order_id);
        $this->db->select('bp.car_id,bp.no_of_months,up.actual_payment,bp.city_id,bp.locality_id,bp.street_id,bp.package_name,bp.package_type,bp.services,bp.days,bp.frequency,bp.coupan_applied,bp.expiry_date');
        $this->db->join('booked_packages as bp','bp.payment_key=up.id');
        $query = $this->db->get('user_payment as up');
        $row = $query->result_array();
        foreach ($row as $key => $value) {
          $this->db->select('A.id as additional_service_id, A.status, A.amount, B.service_name, B.image_string');
            $this->db->join('additional_services as B','B.id=A.additional_services_id');
            $this->db->where('A.payment_key',$order_id);
          $query = $this->db->get('booked_additional_services AS A');
          $row[$key]['additional_services'] = $query->result_array();
        }
        return $row;
      }

}
?>
