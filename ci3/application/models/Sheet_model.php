<?php

/**
 *  Sheet_model
 *
 * @access public
 * @author: aida
 * @version 2021-04-16 8:55
 * @copyright FrogCompany Inc. All Rights Reserved
 */

class Sheet_model extends CI_Model
{

	// テーブル名
	var $dataDb = 'sheet_master';

	function __construct()
	{
		parent::__construct();

	}

	/**
	 * @return mixed
	 */
	function getList()
	{
		$this->db->select('*');
		$this->db->from($this->dataDb);
		$this->db->where('status', STATUS_FLAG_ON);
		$this->db->order_by("created_at", "asc");

		$resource = $this->db->get();
		return $resource->result_array();
	}

	/**
	 * @param int $type
	 * @return mixed
	 */
	function getByType($type = 0)
	{
		$this->db->select('*');
		$this->db->from($this->dataDb);
		$this->db->where('type', $type);
		$this->db->where('status', STATUS_FLAG_ON);
		$this->db->order_by("created_at", "asc");

		$resource = $this->db->get();
		$return = $resource->result_array();
		return $return[0];
	}

	/**
	 * @param int $type
	 * @return mixed|string
	 */
	function getSpreadSheetId($type = 0){

		$return = $this->getByType($type);
		if(isset($return["spreadsheet_id"])){
			return $return["spreadsheet_id"];
		}
		return "";
	}

	/**
	 * @param int $type
	 * @return mixed|string
	 */
	function getFormSpreadId($type = 0){

		$return = $this->getByType($type);
		if(isset($return["formspread_id"])){
			return $return["formspread_id"];
		}
		return "";
	}

	/**
	 * @param int $type
	 * @param string $versions
	 * @return bool
	 */
	function setVersionValue($type = 0, $versions = "")
	{
		if ($type > 0) {
			$data = array(
				'versions' => $versions,
				'updated_at' => date("Y-m-d H:i:s"),
			);

			$this->db->where('type', $type);
			$this->db->where('status', STATUS_FLAG_ON);
			$this->db->update($this->dataDb, $data);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param int $id
	 * @param string $versions
	 * @return bool
	 */
	function setVersionValueById($id = 0, $versions = "")
	{
		if ($id > 0) {
			$data = array(
				'versions' => $versions,
				'updated_at' => date("Y-m-d H:i:s"),
			);

			$this->db->where('id', $id);
			$this->db->update($this->dataDb, $data);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param int $id
	 * @param int $status
	 * @return bool
	 */
	function setSendStatus($id = 0, $status = STATUS_FLAG_ON)
	{
		if ($id > 0) {
			$data = array(
				'send_status' => $status,
				'send_datetime' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
			);
			$this->db->where('id', $id);
			$this->db->update($this->dataDb, $data);
			return TRUE;
		}
		return FALSE;
	}


}
