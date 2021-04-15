<?php

/**
 *  Record_model
 *
 * @access public
 * @author: aida
 * @version 2021-01-16 8:55
 * @copyright FrogCompany Inc. All Rights Reserved
 */

class Record_model extends CI_Model
{
    // テーブル名
    var $dataDb = 'records';
//    var $goalDb = 'goal_history';
    var $importHistoryDb = 'import_history';

    function __construct()
    {
        parent::__construct();

    }

	/**
	 * @param int $sheet_type
	 * @param int $offset
	 * @param int $limit
	 * @param string $name
	 * @param string $detail
	 * @param int $status
	 * @return int
	 */
    function getRecordList($sheet_type=PRJ_SHEET_TYPE_NONE,$offset = 0, $limit = 0, $name = "", $detail = "", $status = STATUS_FLAG_OFF)
    {

        $this->db->select('*');
        $this->db->from($this->dataDb);
		if ($status == STATUS_FLAG_ON) {
			$this->db->where('status', STATUS_FLAG_ON);
		}
        if ($sheet_type != PRJ_SHEET_TYPE_NONE) {
            $this->db->where('sheet_type', $sheet_type);
        }
        if ($name != "") {
            $this->db->like('name', $name, 'both');
        }
        if ($detail != "") {
            $this->db->like('detail', $detail, 'both');
        }

        if ($limit > 0 && $limit != ALL_COUNT_FLAG_AT_LIMIT) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by("created_at", "desc");

        $resource = $this->db->get();

        if ($limit == ALL_COUNT_FLAG_AT_LIMIT) {
            return (int)$resource->num_rows();
        } else {
            return $resource->result_array();
        }
    }

    /**
     * @param int $id
     * @param array $record
     * @return mixed
     */
    function setRecordData($id = 0, array $record = array())
    {
        $record['updated_at'] = date("Y-m-d H:i:s");
		if(isset($record['form_timestamp'])){
			unset($record['form_timestamp']);
		}
        if ($id > 0) {
            $this->db->where('id', $id);
            return $this->db->update($this->dataDb, $record);
        } else {
            $record['created_at'] = date("Y-m-d H:i:s");
            $this->db->insert($this->dataDb, $record);
            return $this->db->insert_id();
        }
    }

    /**
     * @param int $id
     * @return array|null
     */
    function getByRecordId($id = 0)
    {

        $this->db->select('*');
        $this->db->from($this->dataDb);
        $this->db->where('id', $id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = $query->result_array();
            return $return[0];
        }

        return null;
    }

	/**
	 * @param string $email
	 * @param int $sheet_type
	 * @return mixed|null
	 */
	function getByEmail($email = "",$sheet_type=PRJ_SHEET_TYPE_NONE)
	{

		$this->db->select('*');
		$this->db->from($this->dataDb);
		$this->db->where('email', $email);
		if ($sheet_type != PRJ_SHEET_TYPE_NONE) {
			$this->db->where('sheet_type', $sheet_type);
		}

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$return = $query->result_array();
			return $return[0];
		}

		return null;
	}

	/**
	 * @param string $facebook_account
	 * @return mixed|null
	 */
	function getByFacebookAccount($facebook_account = "")
	{

		$this->db->select('*');
		$this->db->from($this->dataDb);
		$this->db->where('facebook_account', $facebook_account);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$return = $query->result_array();
			return $return[0];
		}

		return null;
	}

	/**
	 * @param int $record_id
	 * @return mixed|null
	 */
	function getLastUpdate($record_id = 0)
	{

		$this->db->select('*');
		$this->db->from($this->importHistoryDb);
		$this->db->where('record_id', $record_id);
		$this->db->order_by("form_timestamp", "desc");

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$return = $query->result_array();
			return $return[0];
		}

		return null;
	}


	/**
     * @param array $record
     * @return mixed
     */
    function insertImportHistory(array $record = array()){

        $record['updated_at'] = date("Y-m-d H:i:s");
        $record['created_at'] = date("Y-m-d H:i:s");
        $this->db->insert($this->importHistoryDb, $record);
        return $this->db->insert_id();
    }

	/**
	 * @param int $record_id
	 * @param string $form_timestamp
	 * @return mixed
	 */
    function setImportHistory($record_id=0,$form_timestamp = ""){
    	$record = array(
    		'record_id'=>$record_id,
			'status'=>STATUS_FLAG_ON,
			'form_timestamp '=>$form_timestamp,
		);

    	return $this->insertImportHistory($record);
	}

    /**
     * @param int $id
     * @return array
     */
    function getImportHistory($id = 0)
    {
        $this->db->select('*');
        $this->db->from($this->importHistoryDb);
        $this->db->where('id', $id);
        $this->db->order_by("created_at", "desc");

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = $query->result_array();
            return $return;
        }

        return array();

    }

    /**
     * @param int $status
     * @return array
     */
    function getHistoryList($status = 0){

        $this->db->select('*');
        $this->db->from($this->importHistoryDb);
//        if($status != 0){
//            $this->db->where('status', $status);
//        }
        $this->db->order_by("created_at", "desc");

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = $query->result_array();
            return $return;
        }

        return array();

    }

}
