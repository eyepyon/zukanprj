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
    var $dataDb = 'record_data';
//    var $goalDb = 'goal_history';

    function __construct()
    {
        parent::__construct();

    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $record_name
     * @param string $record_detail
     * @param int $status
     * @return int|array
     */
    function getRecordList($offset = 0, $limit = 0, $record_name = "", $record_detail = "", $status = STATUS_FLAG_OFF)
    {

        $this->db->select('*');
        $this->db->from($this->dataDb);
        if ($status == STATUS_FLAG_ON) {
            $this->db->where('status', STATUS_FLAG_ON);
        }
        if ($record_name != "") {
            $this->db->like('record_name', $record_name, 'both');
        }
        if ($record_detail != "") {
            $this->db->like('record_detail', $record_detail, 'both');
        }

        if ($limit > 0 && $limit != ALL_COUNT_FLAG_AT_LIMIT) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by("regist_datetime", "desc");
//        $this->db->order_by("end_date", "asc");

        $resource = $this->db->get();

        if ($limit == ALL_COUNT_FLAG_AT_LIMIT) {
            return (int)$resource->num_rows();
        } else {
            return $resource->result_array();
        }
    }

    /**
     * @param int $record_id
     * @param array $record
     * @return mixed
     */
    function setRecordData($record_id = 0, array $record = array())
    {
        $record['update_datetime'] = date("Y-m-d H:i:s");

        if ($record_id > 0) {
            $this->db->where('record_id', $record_id);
            return $this->db->update($this->dataDb, $record);
        } else {
            $record['regist_datetime'] = date("Y-m-d H:i:s");
            $this->db->insert($this->dataDb, $record);
            return $this->db->insert_id();
        }
    }

    /**
     * @param int $record_id
     * @return array|null
     */
    function getByRecordId($record_id = 0)
    {

        $this->db->select('*');
        $this->db->from($this->dataDb);
        $this->db->where('record_id', $record_id);

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
    function insertGoalHistory(array $record = array()){

        $record['update_datetime'] = date("Y-m-d H:i:s");
        $record['regist_datetime'] = date("Y-m-d H:i:s");
        $this->db->insert($this->goalDb, $record);
        return $this->db->insert_id();
    }

    /**
     * @param int $record_id
     * @return array
     */
    function getGoalHistory($record_id = 0)
    {
        $this->db->select('*');
        $this->db->from($this->goalDb);
        $this->db->where('record_id', $record_id);
        $this->db->order_by("regist_datetime", "desc");

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = $query->result_array();
            return $return;
        }

        return array();

    }

    /**
     * @param int $landing_status
     * @param int $apos_status
     * @return array
     */
    function getHistoryList($landing_status = 9,$apos_status = 9){

        $this->db->select('*');
        $this->db->from($this->goalDb);
//        if($landing_status != 9){
//            $this->db->where('landing_status', $landing_status);
//        }
//        if($apos_status != 9){
//            $this->db->where('apos_status', $apos_status);
//        }
        $this->db->order_by("regist_datetime", "desc");

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = $query->result_array();
            return $return;
        }

        return array();

    }

}
