<?php
class Pay_model extends CI_Model
{


  public function insert_write_off_entry($data)
  {
    $this->db->insert('payment_collected', $data);
    return $this->db->insert_id();
  }

  public function update_status($transaction_id)
  {
    $date = date('Y-m-d');
    $this->db->where('transaction_id', $transaction_id);
    $this->db->set('paytab_status', 2);
    $this->db->set('status', 2);

    $this->db->set('created_at', $date);
    $query = $this->db->update('payment_collected');
    if ($query) {
      return 1;
    } else {
      return 0;
    }
  }

  public function get_user_detail($id)
  {
    /*$this->db->where('id',$id);
      $query = $this->db->get('users');
      return $query->row_array(); */

    $this->db->select('u.name,u.email,u.phone_number,c.name as cityName,lc.name as localityName, st.name as streetName');
    $this->db->join('car_detail as cd', 'cd.user_id=u.id', 'left');
    $this->db->join('city as c', 'c.id=cd.city_id', 'left');
    $this->db->join('locality as lc', 'lc.id=cd.locality_id', 'left');
    $this->db->join('street as st', 'st.id=cd.street_id', 'left');
    $this->db->where('u.id', $id);
    $this->db->where('cd.status', 1);
    $query = $this->db->get('users as u');
    return $query->row_array();
  }
}
