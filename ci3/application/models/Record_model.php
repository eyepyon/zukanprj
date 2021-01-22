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
     * @param string $name
     * @param string $detail
     * @param int $status
     * @return int|array
     */
    function getRecordList($offset = 0, $limit = 0, $name = "", $detail = "", $status = STATUS_FLAG_OFF)
    {

        $this->db->select('*');
        $this->db->from($this->dataDb);
        if ($status == STATUS_FLAG_ON) {
            $this->db->where('status', STATUS_FLAG_ON);
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

        $this->db->order_by("created_at ", "desc");
//        $this->db->order_by("end_date", "asc");

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

        if ($id > 0) {
            $this->db->where('id', $id);
            return $this->db->update($this->dataDb, $record);
        } else {
            $record['created_at '] = date("Y-m-d H:i:s");
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
     * @param array $record
     * @return mixed
     */
    function insertGoalHistory(array $record = array()){

        $record['updated_at'] = date("Y-m-d H:i:s");
        $record['created_at '] = date("Y-m-d H:i:s");
        $this->db->insert($this->goalDb, $record);
        return $this->db->insert_id();
    }

    /**
     * @param int $id
     * @return array
     */
    function getGoalHistory($id = 0)
    {
        $this->db->select('*');
        $this->db->from($this->goalDb);
        $this->db->where('id', $id);
        $this->db->order_by("created_at ", "desc");

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
        $this->db->order_by("created_at ", "desc");

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = $query->result_array();
            return $return;
        }

        return array();

    }

}
