<?php
  Class Cleaner_model extends CI_Model
  {


    public function get_all_cleaners($locality_id=null)
    {
      $this->db->where('is_del',1);
      if(!empty($locality_id))
      {
        $this->db->where_in('locality_id',$locality_id);
      }
      $this->db->select('cleaners.*,city.name as city,locality.name as locality');
      $this->db->join('city','city.id=cleaners.city_id');
      $this->db->join('locality','locality.id=cleaners.locality_id');

      $query = $this->db->get('cleaners');
      return $query->result_array();
    }
    public function get_all_collection($ftres)
    {
      if($ftres['from'] != ''){
        $this->db->where('date(A.created_at) >=',$ftres['from']);
      }
      if($ftres['to'] != ''){
        $this->db->where('date(A.created_at) <=',$ftres['to']);
      }
      $this->db->select('A.*,B.first_name, B.last_name');
      $this->db->join('cleaners as B','A.cleaner_id=B.id', 'inner');
      $this->db->order_by('A.created_at', 'DESC');
      $query = $this->db->get('collection_files AS A');
      return $query->result_array();
    }

    public function get_all_complaints($ftres)
    {
      $this->db->select('A.*,B.first_name, B.last_name');
      $this->db->join('cleaners as B','A.cleaner_id=B.id', 'inner');
      $this->db->order_by('A.created_at', 'DESC');
      $this->db->where('A.is_del',0);
      if($ftres['from'] != ''){
        $this->db->where('date(A.created_at) >=',$ftres['from']);
      }
      if($ftres['to'] != ''){
        $this->db->where('date(A.created_at) <=',$ftres['to']);
      }
      $query = $this->db->get('complaints AS A');
      return $query->result_array();
    }

    public function get_a_complaint($id)
    {
      $this->db->select('A.*,B.first_name, B.last_name');
      $this->db->join('cleaners as B','A.cleaner_id=B.id', 'inner');
      $this->db->order_by('A.created_at', 'DESC');
      $this->db->where('A.id',$id);
      $query = $this->db->get('complaints AS A');
      $row = $query->result_array();
      return $row[0];
    }

    public function get_all_replies($id)
    {
      $this->db->select('A.*,B.name');
      $this->db->join('users as B','A.created_by=B.id', 'left');
      $this->db->order_by('A.created_at');
      $this->db->where('A.complaint_id',$id);
      $query = $this->db->get('complaint_replies AS A');

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
   public function insert_cleaner_data($data)
   {
     $query = $this->db->insert('cleaners',$data);
     if($query)
     {
      return 1;
     }
     else{
      return 0;
     }
   }
   public function insert_reply($data)
   {
     $query = $this->db->insert('complaint_replies',$data);
     if($query)
     {
      return 1;
     }
     else{
      return 0;
     }
   }
   public function insert_complaint($data)
   {
     $query = $this->db->insert('complaints',$data);
     if($query)
     {
      return 1;
     }
     else{
      return 0;
     }
   }
   public function update_cleaner_data($data,$cleaner_id)
   {
    $this->db->where('id',$cleaner_id);
    $query = $this->db->update('cleaners',$data);
     // $query = $this->db->insert('cleaners',$data);
     if($query)
     {
      return 1;
     }
     else{
      return 0;
     }
   }
   public function update_complaint($data,$id)
   {
    $this->db->where('id',$id);
    $query = $this->db->update('complaints',$data);
     // $query = $this->db->insert('cleaners',$data);
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
    $query = $this->db->get('cleaners');
    // echo $this->db->last_query(); die;
    return $query->row_array();

   }
   public function check_email($email)
   {
      $this->db->select('*');
      $this->db->where('email',$email);
      // $this->db->where('id!=', $id);
      $query = $this->db->get('cleaners');
      // echo $this->db->last_query(); die;
      return $query->row_array();
   }
   public function inactivate_cleaner($id)
   {
      $this->db->where('id',$id);
      $this->db->set('is_del',2);
      $query = $this->db->update('cleaners');
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }

   }
   public function inactivate_complaint($id)
   {
      $this->db->where('id',$id);
      $this->db->set('is_del', 1);
      $query = $this->db->update('complaints');
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }

   }
   public function resolve_complaint($id)
   {
      $this->db->where('id',$id);
      $this->db->set('status', 1);
      $query = $this->db->update('complaints');
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }

   }
   public function unresolve_complaint($id)
   {
      $this->db->where('id',$id);
      $this->db->set('status', 0);
      $query = $this->db->update('complaints');
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }

   }
   public function get_cleaner_to_edit($cleaner_id)
   {

      $this->db->select('cl.id,cl.status as cleaner_status,cl.first_name,cl.email,cl.password,cl.last_name,cl.phone_number,cl.city_id as city_id,cl.locality_id as locality_id,ct.name as city,lt.name as locality');
      $this->db->join('locality as lt','lt.id=cl.locality_id','left');
      $this->db->join('city as ct','ct.id=cl.city_id','left');
      $this->db->where('cl.id',$cleaner_id);
      $query = $this->db->get('cleaners as cl');
      return $query->row_array();

   }
   public function get_cleaner_job_done_detail($ftres,$id)
   {
    $this->db->select('ch.*,st.name as street,lt.name as locality,bp.payment_key,up.orders_id');
    $this->db->join('booked_packages as bp','bp.payment_key=ch.payment_key','left');
    $this->db->join('street as st','st.id=bp.street_id','left');
    $this->db->join('locality as lt','lt.id=bp.locality_id','left');
    $this->db->join('user_payment as up','up.id=bp.payment_key');
    $this->db->where('ch.cleaner_id',$id);
    if($ftres['from'] != ''){
      $this->db->where('ch.job_done_date >=',$ftres['from']);
    }
    if($ftres['to'] != ''){
      $this->db->where('ch.job_done_date <=',$ftres['to']);
    }
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
      $query = $this->db->get('cleaners');
      return $query->row_array();
    }
  }
?>
