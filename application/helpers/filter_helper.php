<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if(!function_exists('ftprocess'))
{
  function ftprocess($ft, $from, $to)
  {
    $fto = array();
    if($ft == 1){
      $from = date("Y-m-d");
      $to = date("Y-m-d");
    }
    else if($ft == 2){
      $monday = strtotime("last sunday");
      $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
      $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
      $from = date("Y-m-d",$monday);
      $to = date("Y-m-d",$sunday);
    }
    else if($ft == 3){
      $from = date("Y-m-d", strtotime("first day of this month"));
      $to = date("Y-m-d", strtotime("last day of this month"));
    }
    else if($ft == 4){
       $current_month = date('m');
       $current_year = date('Y');
       if($current_month>=1 && $current_month<=3)
       {
         $start_date = strtotime('1-January-'.$current_year);
         $end_date = strtotime('31-March-'.$current_year);
       }
       else  if($current_month>=4 && $current_month<=6)
       {
         $start_date = strtotime('1-April-'.$current_year);
         $end_date = strtotime('30-June-'.$current_year);
       }
       else  if($current_month>=7 && $current_month<=9)
       {
         $start_date = strtotime('1-July-'.$current_year);
         $end_date = strtotime('30-September-'.$current_year);
       }
       else  if($current_month>=10 && $current_month<=12)
       {
         $start_date = strtotime('1-October-'.$current_year);
         $end_date = strtotime('31-December-'.$current_year);
       }
       $from = date("Y-m-d", $start_date);
       $to = date("Y-m-d", $end_date);
    }
    else if($ft == 5){
      $current_year = date('Y');
      $start_date = strtotime('1-January-'.$current_year);
      $end_date = strtotime('31-December-'.$current_year);
      $from = date("Y-m-d", $start_date);
      $to = date("Y-m-d", $end_date);
    }
    else if($ft == 6){
      if($from != ''){
        list($m, $d, $y) = explode("/", $from);
        $from = $y."-".$m."-".$d;
      }
      if($to != ''){
        list($m, $d, $y) = explode("/", $to);
        $to = $y."-".$m."-".$d;
      }
    }
    else{
      $from = '';
      $to = '';
    }
    
    return array("from" => $from, "to" => $to);
  }
}
?>
