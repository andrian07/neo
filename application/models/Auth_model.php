<?php

class auth_model extends CI_Model {


    //login
    public function get_login_data($username, $password)
    {
        $query = $this->db->query("select * from user_login where user_name = '".$username."' and user_password = '".$password."' and is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function get_nav_auth_header($user_role)
    {
        $query = $this->db->query("select user_module_header_name, user_module_header_acc from user_module_header where user_module_header_role = '".$user_role."'");
        $result = $query->result();
        return $result;
    }

    public function get_nav_auth($user_role)
    {
        $query = $this->db->query("select module_name, nav_bar from user_module where user_role = '".$user_role."'");
        $result = $query->result();
        return $result;
    }

    public function check_data($old_pass, $id)
    {
        $query = $this->db->query("select * from user_login where user_id = '".$id."' and user_password = '".$old_pass."'");
        $result = $query->result();
        return $result;
    }

    public function update_pass($update_pass, $id)
    {
        $this->db->set($update_pass);
        $this->db->where('user_id ', $id);
        $this->db->update('user_login');
    }
    //end login

}

?>