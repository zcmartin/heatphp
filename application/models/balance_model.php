<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Balance_model extends CI_Model{
    public function create_balance($user_id,$balance_money,$balance_state,$balance_style) {
        $this->db->insert("heat_balance",array(
            'user_id'=>$user_id,
            'balance_money'=>$balance_money,
            'balance_state'=>$balance_state,
            'balance_style'=>$balance_style
        ));
        return $this->db->affected_rows();
    }

    public function update_balance($user_id,$balance_money,$balance_state,$balance_style) {
        $this->db->set("balance_money",$balance_money);
        $this->db->set("balance_state",$balance_state);
        $this->db->set("balance_style",$balance_style);
        $this->db->where("user_id",$user_id);
        $this->db->update("heat_balance");
        return $this->db->affected_rows();
    }

    public function update_balance_style($user_id,$balance_style) {
        $this->db->set("balance_style",$balance_style);
        $this->db->where("user_id",$user_id);
        $this->db->update("heat_balance");
        return $this->db->affected_rows();
    }

    public function update_balance_state($user_id,$balance_state) {
        $this->db->set("balance_state",$balance_state);
        $this->db->where("user_id",$user_id);
        $this->db->update("heat_balance");
        return $this->db->affected_rows();
    }

    public function pay_information() {
        $sql = "select u.*,b.balance_money,b.balance_state,b.balance_style from heat_user u ,heat_balance b where u.user_id=b.user_id and b.balance_money>0";//查模糊匹配
        return $this->db->query($sql)->result();
    }

    public function arrears_information() {
        $sql = "select u.*,b.balance_money,b.balance_state,b.balance_style from heat_user u ,heat_balance b where u.user_id=b.user_id and b.balance_money<0";//查模糊匹配
        return $this->db->query($sql)->result();
    }
    public function find_stop()
    {
        $sql = "select u.*,b.balance_id,b.balance_money,b.balance_state,b.balance_style,b.balance_time from heat_user u,heat_balance b where u.user_id=b.user_id and b.balance_state='停保'";//查所有
        return $this->db->query($sql)->result();
    }

    public function update_stop_by_username($user_id,$month) {
        $sql= "update heat_balance set balance_time = date_add(balance_time,interval '$month' month) where user_id = '$user_id'";
        $this->db->query($sql);
        return $this->db->affected_rows();
    }
}