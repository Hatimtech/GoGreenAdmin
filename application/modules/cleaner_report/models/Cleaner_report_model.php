<?php
  Class Cleaner_report_model extends CI_Model
  {


    public function get_report($user_id)
    {
      $this->db->select('report');
      $this->db->where('id',$user_id);
      $query = $this->db->get('cleaners');
      return $query->row_array();
    }
  }
?>
