<?php
  Class Coupans_model extends CI_Model
  {
    public function check_img($imgname)
    {
      $this->db->select('*');
      $this->db->where('img_name',$imgname);
     $query =  $this->db->get('coupans');
      if($query->row_array())
      {
        return 1;
      }
      else{
        return 0;
      }
    }
    public function insert_coupan($data,$flag,$coupan_id=null)
    {
      if($flag==1)
      {
        $this->db->where('id',$coupan_id);
        $query = $this->db->update('coupans',$data);
        if($query)
        {
          return 1;
        }
        else
        {
          return 0;
        }
      }
      else
      {

        $query = $this->db->insert('coupans',$data);
        if($query)
        {
          return 1;
        }
        else{
          return 0;
        }
      }
    }
    public function get_all_coupans($ftres)
    {
      // $this->db->select('*');
      // $this->db->group_start();
      // if($ftres['from'] != ''){
      //   $this->db->where('valid_from <=',$ftres['from']);
      // }
      // if($ftres['to'] != ''){
      //   $this->db->where('valid_upto >=',$ftres['to']);
      // }
      // $this->db->group_end());
      //
      // $this->db->group_start();
      // if($ftres['from'] != ''){
      //   $this->db->where('valid_from <=',$ftres['from']);
      //   $this->db->where('valid_to >=',$ftres['to']);
      // }
      // if($ftres['to'] != ''){
      //   $this->db->where('valid_upto >=',$ftres['to']);
      //   $this->db->or_where('valid_to >=',$ftres['to']);
      // }
      // $this->db->group_end());
      // $query = $this->db->get('coupans');
      //  echo $this->db->last_query(); die;
       if($ftres['from'] == '' && $ftres['to'] == ''){
         $where = "1=1";
       }else{
         $w = array();
         $w1 = array();
         $w2 = array();
         $w3 = array();
         $w4 = array();
         if($ftres['from'] != ''){
           $w1[] = "'".$ftres['from']."' >= valid_from";
           $w2[] = "'".$ftres['from']."' < valid_from";
           $w3[] = "'".$ftres['from']."' >= valid_from";
           $w3[] = "'".$ftres['from']."' <= valid_upto";
           $w4[] = "'".$ftres['from']."' < valid_from";
         }
         if($ftres['to'] != ''){
           $w1[] = "'".$ftres['to']."' <= valid_upto";
           $w2[] = "'".$ftres['to']."' <= valid_upto";
           $w2[] = "'".$ftres['to']."' >= valid_from";
           $w3[] = "'".$ftres['to']."' >= valid_upto";
           $w4[] = "'".$ftres['to']."' > valid_upto";
         }
         if(count($w1) > 0){
           $w[] = "(".implode(" AND ", $w1).")";
         }
         if(count($w2) > 0){
           $w[] = "(".implode(" AND ", $w2).")";
         }
         if(count($w3) > 0){
           $w[] = "(".implode(" AND ", $w3).")";
         }
         if(count($w4) > 0){
           $w[] = "(".implode(" AND ", $w4).")";
         }


         $where = implode(" OR ", $w);
       }
       $query = $this->db->query("SELECT * FROM coupans WHERE $where");
       //echo "SELECT * FROM coupans WHERE $where"; die;
      return $query->result_array();
    }
    public function check_coupan_code_exist($coupan_code)
    {
      $this->db->where('coupan_code',$coupan_code);
       $query = $this->db->get('coupans');
       return $query->row_array();
    }
    public function delete_coupan_by_id($id)
    {
      $this->db->where('id',$id);
      $query =  $this->db->delete('coupans');
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }
    public function get_coupans_for_edit($coupan_id)
    {
      $this->db->select('*');
      $this->db->where('id',$coupan_id);
      $query = $this->db->get('coupans');
      return $query->row_array();
    }
  }
?>
