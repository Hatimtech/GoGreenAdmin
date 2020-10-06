<?php
  Class Additional_coupons_model extends CI_Model
  {
    public function check_img($imgname)
    {
      $this->db->select('*');
      $this->db->where('img_name',$imgname);
     $query =  $this->db->get('additional_coupans');
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
        $query = $this->db->update('additional_coupans',$data);
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

        $query = $this->db->insert('additional_coupans',$data);
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
      // $this->db->select('A.*, B.service_name');
      // $this->db->join('additional_services as B', 'B.id = A.additional_services_id','inner');
      // $query = $this->db->get('additional_coupans as A');
      // return $query->result_array();

      if($ftres['from'] == '' && $ftres['to'] == ''){
        $where = "1=1";
      }else{
        $w = array();
        $w1 = array();
        $w2 = array();
        $w3 = array();
        $w4 = array();
        if($ftres['from'] != ''){
          $w1[] = "'".$ftres['from']."' >= A.valid_from";
          $w2[] = "'".$ftres['from']."' < A.valid_from";
          $w3[] = "'".$ftres['from']."' >= A.valid_from";
          $w3[] = "'".$ftres['from']."' <= A.valid_upto";
          $w4[] = "'".$ftres['from']."' < A.valid_from";
        }
        if($ftres['to'] != ''){
          $w1[] = "'".$ftres['to']."' <= A.valid_upto";
          $w2[] = "'".$ftres['to']."' <= A.valid_upto";
          $w2[] = "'".$ftres['to']."' >= A.valid_from";
          $w3[] = "'".$ftres['to']."' >= A.valid_upto";
          $w4[] = "'".$ftres['to']."' > A.valid_upto";
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
      $query = $this->db->query("SELECT A.*, B.service_name FROM additional_coupans AS A INNER JOIN additional_services AS B ON A.additional_services_id = B.id WHERE $where");
      //echo "SELECT * FROM coupans WHERE $where"; die;
     return $query->result_array();
    }
    public function get_all_additional_services()
    {
      $this->db->select('*');
      $query = $this->db->get('additional_services');
      return $query->result_array();
    }
    public function check_coupan_code_exist($coupan_code)
    {
      $this->db->where('coupan_code',$coupan_code);
       $query = $this->db->get('additional_coupans');
       return $query->row_array();
    }
    public function delete_coupan_by_id($id)
    {
      $this->db->where('id',$id);
      $query =  $this->db->delete('additional_coupans');
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
      $query = $this->db->get('additional_coupans');
      return $query->row_array();
    }
  }
?>
