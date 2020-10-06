<?php
	$user = 'root';
	$pass = 'gogreen@987@#$';
  $db = new mysqli("localhost",$user,$pass,"gogreenstaging");

  if ($db -> connect_errno) {
    echo "Failed to connect to MySQL: " . $db -> connect_error;
    exit();
  }

  date_default_timezone_set("Asia/Kolkata");
  $device_type = array(); $device_token = array(); $ids = array(); $notification = array();

  $d = date("Y-m-d", strtotime("+2 days"));
  echo $d."<br>";
  $r = $db->query("SELECT A.device_token, A.device_type, A.email, B.id as pid FROM users AS A INNER JOIN booked_packages AS B ON A.id = B.user_id WHERE B.expiry_date = '$d' AND B.auto_renewal = 1");
  while ($ro = $r->fetch_assoc()){
    $device_token[] = $ro['device_token'];
    $device_type[] = $ro['device_type'];
    $ids[] = $ro['pid'];
    $notification[] = array (
      'message'  => 'Your package is expiring in two days, please renew it.',
      'title'    => 'Package Renewal Alert'
    );
  }

  $d = date("Y-m-d", strtotime("+1 month"));
  echo $d."<br>";
  $r = $db->query("SELECT A.device_token, A.device_type, A.email, B.id as pid FROM users AS A INNER JOIN booked_packages AS B ON A.id = B.user_id WHERE B.expiry_date = '$d' AND B.auto_renewal = 1");
  while ($ro = $r->fetch_assoc()){
    $device_token[] = $ro['device_token'];
    $device_type[] = $ro['device_type'];
    $ids[] = $ro['pid'];
    $notification[] = array (
      'message'  => 'Your package is expiring next month please renew it.',
      'title'    => 'Package Renewal Alert'
    );
  }

  $d = date("Y-m-d");
  echo $d."<br>";
  $r = $db->query("SELECT A.device_token, A.device_type, A.email, B.id as pid FROM users AS A INNER JOIN booked_packages AS B ON A.id = B.user_id WHERE B.expiry_date = '$d' AND B.auto_renewal = 1");
  while ($ro = $r->fetch_assoc()){
    $device_token[] = $ro['device_token'];
    $device_type[] = $ro['device_type'];
    $ids[] = $ro['pid'];
    $notification[] = array (
      'message'  => 'Your package is expiring today, please renew it.',
      'title'    => 'Package Renewal Alert'
    );
  }

  $d = date("Y-m-d", strtotime("-1 month"));
  echo $d."<br>";
  $r = $db->query("SELECT A.device_token, A.device_type, A.email, B.id as pid FROM users AS A INNER JOIN booked_packages AS B ON A.id = B.user_id WHERE B.expiry_date < '$d' AND B.discontinue_alert = 0 AND B.auto_renewal = 1");
  while ($ro = $r->fetch_assoc()){
    $device_token[] = $ro['device_token'];
    $device_type[] = $ro['device_type'];
    $ids[] = $ro['pid'];
    $notification[] = array (
      'message'  => 'Your package has been discontinued.',
      'title'    => 'Package Discontinuation Alert'
    );
    $pid = $ro['pid'];
    $db->query("UPDATE booked_packages SET discontinue_alert = 1 WHERE id = '$pid'");
  }


  if(count($ids) > 0){
    $headers = array (
       'Authorization: key=AAAAuNPqydM:APA91bHlf3OKR8YVWvTkXvhkuKJBO5uxVlfCgjP4v0x59eGJ-QjyInshYaKicrFY9irdr8BptL7p01nCvtn65Hb3eHu7TcufSOgy9mtnvXA5YGRf8uT4Y9xTA379TduU3wnhO5XVOuUn',
       'Content-Type: application/json'
     );

    $multiCurl = array();
    $result = array();
    $mh = curl_multi_init();
    foreach ($ids as $i => $id) {
      if($device_type[$i] == 'Android'){
      $multiCurl[$i] = curl_init();
      $msg = $notification[$i];
      $fields = array
      (
        'registration_ids'    => array($device_token[$i]),
        'notification' => $msg,
        'data' => array
        (
         'message'  => $msg['message'],
         'title'    => $msg['title'],
         'notification_for'=>'go green',
         'item_id' => $id,
         'item_type' => 'package',
         'type_id' => 10
        )
      );
      curl_setopt( $multiCurl[$i],CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
      curl_setopt( $multiCurl[$i],CURLOPT_POST, true );
      curl_setopt( $multiCurl[$i],CURLOPT_HTTPHEADER, $headers );
      curl_setopt( $multiCurl[$i],CURLOPT_RETURNTRANSFER,1);
      curl_setopt( $multiCurl[$i],CURLOPT_SSL_VERIFYPEER, false );
      curl_setopt( $multiCurl[$i],CURLOPT_POSTFIELDS, json_encode($fields));
      curl_multi_add_handle($mh, $multiCurl[$i]);
      }
    }

    $index=null;
    do {
      curl_multi_exec($mh,$index);
    } while($index > 0);

    foreach($multiCurl as $k => $ch) {
      $o = curl_multi_getcontent($ch);
      echo $o."<br>";
      curl_multi_remove_handle($mh, $ch);
    }

    curl_multi_close($mh);
  }


	/* Daily Cleaner Summary */
	$ids = array();
	$device_type = array();
	$device_token = array();
	$notification = array();

	$current_day =  date('D');
	$current_date = date('Y-m-d');

	$rq = $db->query("SELECT id, first_name, last_name, device_type, device_token FROM cleaners WHERE status = 1");
	while ($row = $rq->fetch_assoc()) {
		$id = $row['id'];
		$r = $db->query("
			SELECT at.payment_key, bp.package_type, bp.one_time_service_date, bp.car_id, bp.days FROM team_cleaner as tc
			INNER JOIN assiagned_team as at ON at.team_id=tc.team_id
			INNER JOIN booked_packages as bp ON bp.payment_key=at.payment_key
			INNER JOIN users as u ON u.id=bp.user_id
			WHERE bp.purchase_date <= CURDATE() AND bp.expiry_date > CURDATE() AND bp.is_off = 1 AND u.service_stop = 1 AND tc.cleaner_id = $id
		");
		//
		// echo "
		// 	SELECT at.payment_key, bp.package_type, bp.one_time_service_date, bp.car_id, bp.days FROM team_cleaner as tc
		// 	INNER JOIN assiagned_team as at ON at.team_id=tc.team_id
		// 	INNER JOIN booked_packages as bp ON bp.payment_key=at.payment_key
		// 	INNER JOIN users as u ON u.id=bp.user_id
		// 	WHERE bp.purchase_date <= CURDATE() AND bp.expiry_date > CURDATE() AND bp.is_off = 1 AND u.service_stop = 1 AND tc.cleaner_id = $id
		// ";

		$count = 0;
		$additional = 0;

		while ($value = $r->fetch_assoc())
		{

			$key = $value['payment_key'];
			//echo "SELECT count(id) as count FROM booked_additional_services WHERE payment_key = '$key' AND status = 0";
			$r2 = $db->query("SELECT count(id) as count FROM booked_additional_services WHERE payment_key = '$key' AND status = 0");
		 	$ro2 = $r2->fetch_assoc();
			// echo $ro2['count'];
			// echo "<br>";
			$additional += $ro2['count'];
			$car_id =$value['car_id'];
			if($value['package_type'] == 'monthly')
			{
				$days_array = explode(',',$value['days']);
				if(in_array($current_day, $days_array))
				{
					$count++;
				}
			}
			else
			{
				if($current_date ==$value['one_time_service_date'])
				{
					$count++;
				}
			}
		}

		$r = $db->query("SELECT count(id) as count FROM cleaner_job_done_history WHERE cleaner_id = $id AND job_done_date = CURDATE()");
		$ro = $r->fetch_assoc();
		$done =  $ro['count'];
		$remain = $count-$done;
		$remain = ($remain < 0) ? 0 : $remain;
		$additional = ($additional < 0) ? 0 : $additional;
		if($remain > 0 || $additional > 0){
			$device_token[] = $row['device_token'];
			$device_type[] = $row['device_type'];
			$ids[] = $id;
			$notification[] = array (
				'message'  => 'Hi '.$row[first_name].' '.$row[last_name].', today you have '.$remain.' packages and '.$additional.' additional services to do.',
				'title'    => 'Daily Summary'
			);
		}
	}

// echo "<pre>";
	 //print_r($notification);

	if(count($ids) > 0){
    $headers = array (
       'Authorization: key=AAAAWQ_JiiI:APA91bFpSKRjkRr-3_abkFpDxu79XtIeL7tGuCFsuiimOnRIfxSbK2IpN3Sr8yilBB0TrNxOhI7z3blufa2shddyZVLZhg3dhPRPolpD5EgVP3moo8v9b4cetgtYosRIpvZw126Jodsx',
       'Content-Type: application/json'
     );

    $multiCurl = array();
    $result = array();
    $mh = curl_multi_init();
    foreach ($ids as $i => $id) {
      if($device_type[$i] == 'Android'){
      $multiCurl[$i] = curl_init();
      $msg = $notification[$i];
      $fields = array
      (
        'registration_ids'    => array($device_token[$i]),
        'notification' => $msg,
        'data' => array
        (
         'message'  => $msg['message'],
         'title'    => $msg['title'],
         'notification_for'=>'go green'
        )
      );
      curl_setopt( $multiCurl[$i],CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
      curl_setopt( $multiCurl[$i],CURLOPT_POST, true );
      curl_setopt( $multiCurl[$i],CURLOPT_HTTPHEADER, $headers );
      curl_setopt( $multiCurl[$i],CURLOPT_RETURNTRANSFER,1);
      curl_setopt( $multiCurl[$i],CURLOPT_SSL_VERIFYPEER, false );
      curl_setopt( $multiCurl[$i],CURLOPT_POSTFIELDS, json_encode($fields));
      curl_multi_add_handle($mh, $multiCurl[$i]);
      }
    }

    $index=null;
    do {
      curl_multi_exec($mh,$index);
    } while($index > 0);

    foreach($multiCurl as $k => $ch) {
      $o = curl_multi_getcontent($ch);
      echo $o."<br>";
      curl_multi_remove_handle($mh, $ch);
    }

    curl_multi_close($mh);
  }



?>
