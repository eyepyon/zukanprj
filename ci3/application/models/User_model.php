<?php

/**
 * user_model.php
 *
 * @author: aida
 * @version: 2019-03-16 21:37
 */
class User_model extends CI_Model
{
    // テーブル名
    var $dataDb = 'user_data';

    function __construct()
    {
        parent::__construct();
    }

    public function checkUser($data = array()){

        $this->db->select('user_id');
        $this->db->from($this->dataDb);

        $con = array(
            'oauth_provider' => $data['oauth_provider'],
            'oauth_uid' => $data['oauth_uid']
        );
        $this->db->where($con);

        $query = $this->db->get();

        $check = $query->num_rows();

        if($check > 0){
            // Get prev user data
            $result = $query->row_array();

            // Update user data
            $data['update_datetime'] = date("Y-m-d H:i:s");
            $update = $this->db->update($this->dataDb, $data, array('user_id'=>$result['user_id']));

            // user id
            $userID = $result['user_id'];
        }else{
            // Insert user data
            $data['regist_datetime'] = date("Y-m-d H:i:s");
            $data['update_datetime'] = date("Y-m-d H:i:s");
            $insert = $this->db->insert($this->dataDb,$data);

            // user id
            $userID = $this->db->insert_id();
        }

        // Return user id
        return $userID?$userID:false;
    }


    /**
     * @param string $uid
     * @return array|null
     */
    function getByUid($uid = "")
    {

        $this->db->select('*');
        $this->db->from($this->dataDb);
        $this->db->where('user_id', $uid);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = $query->result_array();
            return $return[0];
        }

        return null;
    }

    /**
     * @return array
     */
    function getMemberList()
    {

        $this->db->select('*');
        $this->db->from($this->dataDb);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = $query->result_array();
            return $return;
        }

        return array();
    }


    /**
     * @param int $uid
     * @return mixed
     */
    function onWriteMode($uid = 0)
    {
        $data = array(
            'write_mode' => WRITE_MODE_TEXT
        );

        $data['update_datetime'] = date("Y-m-d H:i:s");
        $this->db->where('user_id', $uid);
        return $this->db->update($this->dataDb, $data);
    }

    /**
     * @param int $uid
     * @return mixed
     */
    function offWriteMode($uid = 0)
    {
        $data = array(
            'write_mode' => WRITE_MODE_OFF
        );

        $data['update_datetime'] = date("Y-m-d H:i:s");
        $this->db->where('user_id', $uid);
        return $this->db->update($this->dataDb, $data);
    }

    /**
     * @param int $uid
     * @return mixed
     */
    function numberWriteMode($uid = 0)
    {
        $data = array(
            'write_mode' => WRITE_MODE_NUMBER
        );

        $data['update_datetime'] = date("Y-m-d H:i:s");
        $this->db->where('user_id', $uid);
        return $this->db->update($this->dataDb, $data);
    }

    /**
     * @param int $user_id
     * @return null
     */
    function getByUserId($user_id = 0)
    {

        $this->db->select('*');
        $this->db->from($this->dataDb);
        $this->db->where('user_id', $user_id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = $query->result_array();
            return $return[0];
        }

        return null;
    }

    /**
     * @param string $address
     * @return null
     */
    function getByWalletAddress($address = "")
    {

        $this->db->select('*');
        $this->db->from($this->dataDb);
        $this->db->where('wallet_address', $address);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = $query->result_array();
            return $return[0];
        }

        return null;
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    function setUserData($id = 0, array $data)
    {
        $data['update_datetime'] = date("Y-m-d H:i:s");

        if ($id > 0) {
            $this->db->where('user_id', $id);
            return $this->db->update($this->dataDb, $data);
        } else {
            $data['regist_datetime'] = date("Y-m-d H:i:s");
            $this->db->insert($this->dataDb, $data);
            return $this->db->insert_id();
        }
    }

    /**
     * @param $user_account
     * @return bool
     */
    function checkAdminLogin( $user_account = '') {

        $this->db->select( '*' );
        $this->db->from( $this->dataDb );
        $this->db->where( 'user_account', $user_account );

        $query = $this->db->get();
        if ( $query->num_rows() > 0 ) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * @param string $user_account
     * @return bool|array
     */
    function checkAdminLevel( $user_account = '') {

        $this->db->select( "*" );
        $this->db->from( $this->dataDb );
        $this->db->where( 'user_account', $user_account );

        $query = $this->db->get();
        if ( $query->num_rows() > 0 ) {
            $row = $query->row_array();
            return $row;
        }
        return FALSE;
    }

    /**
     * @param string $user_account
     * @param string $pass
     * @return mixed
     */
    function getAdminUser( $user_account, $pass ) {

        $this->db->select( '*' );
        $this->db->from( $this->dataDb );
        $this->db->where( 'user_account', $user_account );
        $this->db->where( 'account_status',STATUS_FLAG_ON );

        $query = $this->db->get();
        if ( $query->num_rows() > 0 ) {
            $row = $query->row_array();
            if ( password_verify( $pass, $row['pass_hash'] ) ) {
                return $row;
            } else {
                return FALSE;
            }
        }
        return FALSE;
    }

    /**
     * @param int $id
     * @return bool
     */
    function setDelete( $id = 0 ) {

        if ( $id > 0 ) {
            $data = array(
                'account_status' => STATUS_FLAG_OFF,
                'delete_datetime' => date( "Y-m-d H:i:s" ),
            );
            $this->db->where( 'user_id', $id );
            $this->db->update( $this->dataDb, $data );
            return TRUE;
        }

        return FALSE;
    }

    /**
     * @param string $fb_uid
     * @return null
     */
    function getFbMember($fb_uid = "")
    {

        $this->db->select('*');
        $this->db->from($this->dataDb);
        $this->db->where('fb_uid', $fb_uid);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = $query->result_array();
            return $return[0];
        }

        return null;
    }

    /**
     * @param string $line_mid
     * @return array|null
     */
    function getLineMember($line_mid = "")
    {

        $this->db->select('*');
        $this->db->from($this->dataDb);
        $this->db->where('line_mid', $line_mid);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = $query->result_array();
            return $return[0];
        }

        return null;
    }

}


