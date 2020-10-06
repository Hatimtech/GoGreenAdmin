<?php
  Class Push_notification_model extends CI_Model
  {

    public function sendPushNotification($for, $users, $title,$body = '', $additional = '')
    {
      $registrationIds = array(); $registrationIds2 = array();
      $url = "https://fcm.googleapis.com/fcm/send";
      if($for == 'users'){
        $serverKey = "AAAAuNPqydM:APA91bHlf3OKR8YVWvTkXvhkuKJBO5uxVlfCgjP4v0x59eGJ-QjyInshYaKicrFY9irdr8BptL7p01nCvtn65Hb3eHu7TcufSOgy9mtnvXA5YGRf8uT4Y9xTA379TduU3wnhO5XVOuUn";
      }else{
        $serverKey = "AAAAWQ_JiiI:APA91bFpSKRjkRr-3_abkFpDxu79XtIeL7tGuCFsuiimOnRIfxSbK2IpN3Sr8yilBB0TrNxOhI7z3blufa2shddyZVLZhg3dhPRPolpD5EgVP3moo8v9b4cetgtYosRIpvZw126Jodsx";
      }

       if (!defined('API_ACCESS_KEY')) define('API_ACCESS_KEY', $serverKey);
      if(is_array($users) && $users != ''){
        foreach ($users as $key => $value) {
          $t = explode("^", $value);
          if($t[0] == 'Android'){
            $registrationIds[] = $value;
          }else{
            $registrationIds2[] = $value;
          }
        }
      }else{
        $query=  $this->db->query("select device_token, device_type FROM users WHERE device_token != '' AND device_token IS NOT NULL");
        $rows = $query->result_array();
        foreach ($rows as $key => $value) {
          if($value['device_type'] == 'Android'){
              $registrationIds[] = $value['device_token'];
          }
          else{
              $registrationIds2[] = $value['device_token'];
          }

        }
      }
      $r = array();
      if(count($registrationIds) > 0){
        $msg = array
        (
          'message'  => $body,
          'title'    => $title
        );
        $data = array
        (
         'message'  => $body,
         'title'    => $title,
         'notification_for'=>'go green'
       );
       if($additional != ''){
           $additional = json_decode($additional, true);
         foreach ($additional as $key => $value) {
           $data[$key] = $value;
         }
       }
        $fields = array
        (
          'registration_ids'    => $registrationIds,
          'notification' => $msg,
          'data' => $data
        );
        $headers = array
        (
           'Authorization: key=' .$serverKey,
           'Content-Type: application/json'
         );

       $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt( $ch,CURLOPT_POST, true );

        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch );
        curl_close( $ch );
        $r[] = json_decode($result);
      }

      if(count($registrationIds2) > 0){
       //  $msg = array
       //  (
       //    'message'  => $body,
       //    'title'    => $title
       //  );
       //  $fields = array
       //  (
       //    'registration_ids'    => $registrationIds2,
       //    'notification' => $msg,
       //    'data' => array
       //    (
       //     'message'  => $body,
       //     'title'    => $title,
       //     'notification_for'=>'go green'
       //    )
       //  );
       //  $headers = array
       //  (
       //     'Authorization: key=' .$serverKey,
       //     'Content-Type: application/json'
       //   );
       //
       // $ch = curl_init();
       //  curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
       //  curl_setopt( $ch,CURLOPT_POST, true );
       //
       //  curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
       //  curl_setopt( $ch,CURLOPT_RETURNTRANSFER,1);
       //  curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
       //  curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
       //  $result = curl_exec($ch );
       //  curl_close( $ch );
       //  $r[] = json_decode($result);
      }




        return json_encode($r);
     }

    public function get_all_users()
    {

     //  $this->db->select('users.*,count(car_detail.user_id) as no_of_cars,count(CASE WHEN car_detail.is_package = 2 then 1 ELSE NULL END) as active_cars,ct.name as city,lt.name as locality,st.name as street');
     //  $this->db->join('booked_packages as bp','bp.user_id=users.id','left');
     //  $this->db->join('city as ct','ct.id=bp.city_id','left');
     //  $this->db->join('locality as lt','lt.id=bp.locality_id','left');
     //  $this->db->join('street as st','st.id=bp.street_id','left');
     //  $this->db->join('car_detail', 'users.id = car_detail.user_id','left');
     //  $this->db->group_by('users.email');
     // // $this->db->group_by('bp.id');
     //  $this->db->group_by(array("users.email", "bp.id"));
     //  $query = $this->db->get('users');
     $query=  $this->db->query("select id,name,email,phone_number,device_type,device_token FROM users WHERE status = 1 AND device_token != '' AND device_token IS NOT NULL");
       //echo $this->db->last_query(); die;
      return $query->result_array();
      // $this->db->select('*');
      // $query = $this->db->get('users');
      // return $query->result_array();
    }

    public function get_all_cleaners()
    {

     //  $this->db->select('users.*,count(car_detail.user_id) as no_of_cars,count(CASE WHEN car_detail.is_package = 2 then 1 ELSE NULL END) as active_cars,ct.name as city,lt.name as locality,st.name as street');
     //  $this->db->join('booked_packages as bp','bp.user_id=users.id','left');
     //  $this->db->join('city as ct','ct.id=bp.city_id','left');
     //  $this->db->join('locality as lt','lt.id=bp.locality_id','left');
     //  $this->db->join('street as st','st.id=bp.street_id','left');
     //  $this->db->join('car_detail', 'users.id = car_detail.user_id','left');
     //  $this->db->group_by('users.email');
     // // $this->db->group_by('bp.id');
     //  $this->db->group_by(array("users.email", "bp.id"));
     //  $query = $this->db->get('users');
     $query=  $this->db->query("select id,first_name, last_name,email,phone_number,device_type,device_token FROM cleaners WHERE status = 1 AND device_token != '' AND device_token IS NOT NULL");
       //echo $this->db->last_query(); die;
      return $query->result_array();
      // $this->db->select('*');
      // $query = $this->db->get('users');
      // return $query->result_array();
    }
    public function get_filtered_user($flag)
    {
      if($flag==2)// active user
      {
      $query=  $this->db->query("SELECT distinct id,name,email,phone_number,device_type,is_phone_verified,is_payment,no_of_cars,active_cars,city,locality,street,created_at,expiry_date,service_stop,package_id,user_status from (SELECT `users`.id as id,`users`.name as name,`users`.email as email,`users`.created_at,
      `users`.phone_number as phone_number,`users`.service_stop,`users`.status as user_status,
      `users`.device_type as device_type,
      `users`.is_phone_verified as is_phone_verified,
      `users`.is_payment as is_payment,
      count(car_detail.user_id) as no_of_cars,
      count(CASE WHEN car_detail.is_package = 2 then 1 ELSE NULL END) as active_cars,  `ct`.`name` as `city`, `lt`.`name` as `locality`, `st`.`name` as `street`,`bp`.`expiry_date`,`bp`.`id` as `package_id`
      FROM `users`
      LEFT JOIN `booked_packages` as `bp` ON `bp`.`user_id`=`users`.`id`
      LEFT JOIN `city` as `ct` ON `ct`.`id`=`bp`.`city_id`
      LEFT JOIN `locality` as `lt` ON `lt`.`id`=`bp`.`locality_id`
      LEFT JOIN `street` as `st` ON `st`.`id`=`bp`.`street_id`
      LEFT JOIN `car_detail` ON `users`.`id` = `car_detail`.`user_id`
      Where users.status=1
      AND users.is_payment=2
      AND bp.expiry_date > CURDATE()

      GROUP BY  `users`.`id`
      ,  `bp`.`id`

      ) user_dashboard
      GROUP BY email order by  created_at desc");
      //echo $this->db->last_query(); die;
      return $query->result_array();
    }
    elseif ($flag==3)// inactive user
    {
      $query=  $this->db->query("SELECT distinct id,name,email,phone_number,device_type,is_phone_verified,is_payment,no_of_cars,active_cars,city,locality,street,created_at,service_stop,expiry_date,package_id,user_status from (SELECT `users`.id as id,`users`.name as name,`users`.email as email,`users`.created_at,
      `users`.phone_number as phone_number,`users`.service_stop,`users`.status as user_status,
      `users`.device_type as device_type,
      `users`.is_phone_verified as is_phone_verified,
      `users`.is_payment as is_payment,
      count(car_detail.user_id) as no_of_cars,
      count(CASE WHEN car_detail.is_package = 2 then 1 ELSE NULL END) as active_cars,  `ct`.`name` as `city`, `lt`.`name` as `locality`, `st`.`name` as `street`,`bp`.`expiry_date`,`bp`.`id` as `package_id`
      FROM `users`

      JOIN `booked_packages` as `bp` ON `bp`.`user_id`=`users`.`id`
      LEFT JOIN `city` as `ct` ON `ct`.`id`=`bp`.`city_id`
      LEFT JOIN `locality` as `lt` ON `lt`.`id`=`bp`.`locality_id`
      LEFT JOIN `street` as `st` ON `st`.`id`=`bp`.`street_id`
      LEFT JOIN `car_detail` ON `users`.`id` = `car_detail`.`user_id`
      Where users.status=1
      AND
       bp.expiry_date < curdate()
       AND
       bp.status=1

      GROUP BY  `users`.`id`
      ,  `bp`.`id`

      ) user_dashboard
      GROUP BY email order by  created_at desc");
      //echo $this->db->last_query(); die;
      return $query->result_array();
    }
    else
    {
      $query=  $this->db->query("SELECT distinct id,name,email,phone_number,device_type,is_phone_verified,is_payment,no_of_cars,active_cars,city,locality,street,service_stop,created_at,user_status from (SELECT `users`.id as id,`users`.name as name,`users`.email as email,`users`.created_at,
      `users`.phone_number as phone_number,`users`.service_stop,`users`.status as user_status,
      `users`.device_type as device_type,
      `users`.is_phone_verified as is_phone_verified,
      `users`.is_payment as is_payment,
      count(car_detail.user_id) as no_of_cars,
      count(CASE WHEN car_detail.is_package = 2 then 1 ELSE NULL END) as active_cars,  `ct`.`name` as `city`, `lt`.`name` as `locality`, `st`.`name` as `street`
      FROM `users`

      LEFT JOIN `booked_packages` as `bp` ON `bp`.`user_id`=`users`.`id`
      LEFT JOIN `city` as `ct` ON `ct`.`id`=`bp`.`city_id`
      LEFT JOIN `locality` as `lt` ON `lt`.`id`=`bp`.`locality_id`
      LEFT JOIN `street` as `st` ON `st`.`id`=`bp`.`street_id`
      LEFT JOIN `car_detail` ON `users`.`id` = `car_detail`.`user_id`
      Where users.status=1
      AND car_detail.user_id IS NULL

      GROUP BY  `users`.`id`
      ,  `bp`.`id`

      ) user_dashboard
      GROUP BY email order by  created_at desc");
      //echo $this->db->last_query(); die;
      return $query->result_array();
    }

    }

     public function get_all_users_for_excel()
    {

     //  $this->db->select('u.id,cd.reg_no,cd.apartment_number,ct.name as city,lt.name as locality,st.name as street,bp.package_name,bp.id as test');

     //  $this->db->join('car_detail as cd', 'u.id = cd.user_id','left');
     //  $this->db->join('car_brand as cb', 'cb.id = cd.brand','left');
     //  $this->db->join('car_model as cm', 'cm.id = cd.model','left');
     //  $this->db->join('booked_packages as bp','bp.car_id=cd.id','left');
     //  $this->db->join('city as ct','ct.id=bp.city_id','left');
     //  $this->db->join('locality as lt','lt.id=bp.locality_id','left');
     //  $this->db->join('street as st','st.id=bp.street_id','left');
     //  // $this->db->count('cd.id');
     //  // $this->db->count('bp.car_id');
     //  // $this->db->group_by('bp.package_name');

     // // $this->db->group_by('users.email');
     // // $this->db->group_by('bp.id');
     //  // $this->db->group_by(array("users.email", "bp.id"));
     //  $query = $this->db->get('users as u');
     //  echo $this->db->last_query();die;
     //  return $query->result_array();
        $query=  $this->db->query("SELECT u.*, `cd`.`reg_no`,`cd`.`color`, `cd`.`apartment_number`,`cb`.`name` as brand,`cm`.`name` as model, `ct`.`name` as `city`, `lt`.`name` as `locality`, `st`.`name` as `street`, `bp`.`package_name`,`bp`.`amount`, `bp`.`id`, `up`.`status` FROM `users` as `u` LEFT JOIN `car_detail` as `cd` ON `u`.`id` = `cd`.`user_id` LEFT JOIN `car_brand` as `cb` ON `cb`.`id` = `cd`.`brand` LEFT JOIN `car_model` as `cm` ON `cm`.`id` = `cd`.`model` LEFT JOIN `booked_packages` as `bp` ON `bp`.`car_id`=`cd`.`id` LEFT JOIN `city` as `ct` ON `ct`.`id`=`bp`.`city_id` LEFT JOIN `locality` as `lt` ON `lt`.`id`=`bp`.`locality_id` LEFT JOIN `street` as `st` ON `st`.`id`=`bp`.`street_id` LEFT JOIN `user_payment` as `up` ON `up`.`id`=`bp`.`payment_key`");
        // //echo $this->db->last_query(); die;
         return $query->result_array();
        // $this->db->select('*');
        // $query = $this->db->get('users');
        // return $query->result_array();
    }

    public function total_rows()
    {
      $query = $this->db->query('SELECT * FROM users');
      return $query->num_rows();
    }



    public function get_car_details($id)
    {

      $this->db->select('cb.name as brand,cr.id,cr.is_package,cm.name as model,cr.reg_no,cr.status,ct.name as city,ct.id as city_id,lt.name as locality,lt.id as locality_id,st.name as street,st.id as street_id,bp.package_type,bp.id as package_id,bp.user_id as package_user_id,bp.expiry_date,t.name as team');
      $this->db->join('city as ct','ct.id=cr.city_id','left');
      $this->db->join('locality as lt','lt.id=cr.locality_id','left');
      $this->db->join('street as st','st.id=cr.street_id','left');
      $this->db->join('booked_packages as bp','bp.car_id=cr.id','left');

      $this->db->join('assiagned_team as at','at.payment_key=bp.payment_key','left');
      $this->db->join('teams as t','t.id=at.team_id','left');


      $this->db->join('car_brand as cb','cb.id = cr.brand');
      $this->db->join('car_model as cm','cm.id = cr.model');
     // $this->db->group_by('cr.id');
      $this->db->where('cr.user_id', $id);
      $this->db->where('cr.status',1);
	 // $subquery = "bp.expiry_date>Now()";
	//  $dj_genres = trim($subquery, "'");
     // $this->db->where($subquery);
      $this->db->order_by('bp.created_at','DESC');
      $query = $this->db->get('car_detail as cr');
    // echo $this->db->last_query(); die;
     // echo"<pre>";print_r($query->result_array()); die;
      return $query->result_array();
    }
    public function get_purchase_history($id,$user_id)
    {
      $this->db->select('booked_packages.*,user_payment.net_paid');
      $this->db->join('user_payment','user_payment.user_id=booked_packages.user_id');
      $this->db->where('booked_packages.id',$id);
      $query = $this->db->get('booked_packages');
      return $query->row_array();
    }
    public function get_user_detai($id)
    {
      $this->db->select('u.*,tm.name as t_name');
      $this->db->join('assiagned_team as at','at.user_id=u.id','left');
      $this->db->join('teams as tm','tm.id=at.team_id','left');
      $this->db->where('u.id',$id);
      $query = $this->db->get('users as u');
      return $query->row_array();

    }

    public function get_data($where = array(),$column=array(),$tableName = null)
	{
	  $this->db->select($column);
      $this->db->where($where);
	  // $this->db->join('car_detail as cp','cp.id=bp.car_id','left');
	   //$this->db->limit(1);
	   //$this->db->order_by('bp.expiry_date','DESC');
      $query = $this->db->get($tableName);
	  //echo $this->db->last_query(); die;
      return $query->row_array();
	}
  public function update_status_as_inactive($user_id)
    {
      $this->db->where('id',$user_id);
      $this->db->set('status',2);
      $query = $this->db->update('users');
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }

    }
	 public function update($where = array(),$column=array(),$tableName = null)
    {
      $this->db->where($where);
      $this->db->set($column);
      $query = $this->db->update($tableName);
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }

    }

    public function get_orders_ledger($user_id)
    {


      $this->db->select('up.*,bp.purchase_date');
      $this->db->where('up.user_id',$user_id);
      $this->db->join('booked_packages as bp','bp.payment_key=up.id','left');
      //$this->db->group_by('bp.purchase_date');
      $query =  $this->db->get('user_payment as up');
      return $query->result_array();
    }

    public function insert_write_off($data)
    {
      $this->db->insert('payment_collected',$data);
      return $this->db->insert_id();
    }

    public function get_user_detail($user_id)
    {
      $this->db->select('phone_number');
      $this->db->where('id',$user_id);
      $query = $this->db->get('users');
      return $query->row_array();

    }


    public function stop_user_service($id,$status)
    {
      $this->db->where('id',$id);
      $this->db->set('service_stop',$status);
      $query = $this->db->update('users');
     // echo $this->db->last_query(); die;
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }

    }

    public function activate_user_status($id)
    {
      $this->db->where('id',$id);
      $this->db->set('status',1);
      $query = $this->db->update('users');
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }

    }

    public function sendPush($json)
    {
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
      $response = curl_exec($ch);

      //print_r($response); die;
      if ($response === FALSE)
      {
       die('FCM Send Error: ' . curl_error($ch));
      }
      return curl_close($ch);
    }

    public function get_device_token($id)
    {
      $this->db->where('id',$id);
      $query  = $this->db->get('users');
      return $query->row_array();
    }

  }
?>
