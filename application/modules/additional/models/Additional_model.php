<?php
  Class Additional_model extends CI_Model
  {


    public function get_all_additional($locality_id=null)
    {
      $this->db->where('is_del',1);
      if(!empty($locality_id))
      {
        $this->db->where_in('locality_id',$locality_id);
      }
      $this->db->select('additional_services.*,city.name as city,locality.name as locality');
      $this->db->join('city','city.id=additional_services.city_id');
      $this->db->join('locality','locality.id=additional_services.locality_id');

      $query = $this->db->get('additional_services');
      return $query->result_array();
    }

    public function get_booked_additional($ftres)
    {
      $this->db->select('A.*, B.name, C.service_name');
      $this->db->join('users AS B','A.user_id=B.id', 'inner');
      $this->db->join('additional_services AS C','A.additional_services_id=C.id', 'inner');
      $this->db->order_by('A.created_at', 'DESC');
      if($ftres['from'] != ''){
        $this->db->where('date(A.created_at) >=',$ftres['from']);
      }
      if($ftres['to'] != ''){
        $this->db->where('date(A.created_at) <=',$ftres['to']);
      }
      $query = $this->db->get('booked_additional_services AS A');
      return $query->result_array();
    }

    public function total_rows()
    {
      $query = $this->db->query('SELECT * FROM users');
      return $query->num_rows();
    }

   public function get_city()
   {
      $this->db->where('status',1);
      $query = $this->db->get('city');
      return $query->result_array();
   }
   public function get_locality_by_ajax($city_id)
   {
     $this->db->select('*');
     $this->db->where('status',1);
     $this->db->where('city_id',$city_id);
     $query = $this->db->get('locality');
     return $query->result_array();
   }
   public function insert_additional_data($data)
   {
     $query = $this->db->insert('additional_services',$data);
     if($query)
     {
      return 1;
     }
     else{
      return 0;
     }
   }
   public function update_additional_data($data,$cleaner_id)
   {
    $this->db->where('id',$cleaner_id);
    $query = $this->db->update('additional_services',$data);
     // $query = $this->db->insert('additional_services',$data);
     if($query)
     {
      return 1;
     }
     else{
      return 0;
     }
   }
   public function check_phone_number($email,$id)
   {
    $this->db->select('*');
    $this->db->where('email',$email);
    $this->db->where('id!=', $id);
    $query = $this->db->get('additional_services');
    // echo $this->db->last_query(); die;
    return $query->row_array();

   }
   public function check_email($email)
   {
      $this->db->select('*');
      $this->db->where('email',$email);
      // $this->db->where('id!=', $id);
      $query = $this->db->get('additional_services');
      // echo $this->db->last_query(); die;
      return $query->row_array();
   }
   public function inactivate_additional($id)
   {
      $this->db->where('id',$id);
      $this->db->set('is_del',2);
      $query = $this->db->update('additional_services');
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }

   }
   public function get_additional_to_edit($cleaner_id)
   {

      $this->db->select('cl.id,cl.status as cleaner_status,cl.service_name, cl.price, cl.city_id as city_id,cl.locality_id as locality_id,ct.name as city,lt.name as locality');
      $this->db->join('locality as lt','lt.id=cl.locality_id','left');
      $this->db->join('city as ct','ct.id=cl.city_id','left');
      $this->db->where('cl.id',$cleaner_id);
      $query = $this->db->get('additional_services as cl');
      return $query->row_array();

   }
   public function get_cleaner_job_done_detail($id)
   {
    $this->db->select('ch.*,st.name as street,lt.name as locality,bp.payment_key,up.orders_id');
    $this->db->join('booked_packages as bp','bp.payment_key=ch.payment_key','left');
    $this->db->join('street as st','st.id=bp.street_id','left');
    $this->db->join('locality as lt','lt.id=bp.locality_id','left');
    $this->db->join('user_payment as up','up.id=bp.payment_key');
    $this->db->where('ch.cleaner_id',$id);
    $this->db->group_by('bp.payment_key');
    $query = $this->db->get('cleaner_job_done_history as ch');
    return $query->result_array();
   }
    public function get_locality_ajax($city_id)
    {
      $this->db->select('*');
      $this->db->where('status', 1);
      $this->db->where_in('city_id', $city_id);
      $query = $this->db->get('locality');
      $result = $query->result_array();
      return $result;
    }

    public function delete_this_cleaner_row_from_team_cleaner_tabel($cleaner_id)
    {
      $this->db->where('cleaner_id',$cleaner_id);
      $this->db->delete('team_cleaner');
    }
    public function get_report($user_id)
    {
      $this->db->select('report');
      $this->db->where('id',$user_id);
      $query = $this->db->get('additional_services');
      return $query->row_array();
    }
  }
?>
