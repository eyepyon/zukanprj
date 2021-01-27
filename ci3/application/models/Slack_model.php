<?php

/**
 *  Slack_model
 *
 * @access public
 * @author: aida
 * @version 2021-01-16 8:55
 * @copyright FrogCompany Inc. All Rights Reserved
 */

class Slack_model extends CI_Model
{

	// テーブル名
	var $dataDb = 'slack_messages';

	function __construct()
	{
		parent::__construct();

	}

	function getWaitList()
	{
		$this->db->select('*');
		$this->db->from($this->dataDb);
		$this->db->where('send_status', STATUS_FLAG_OFF);
		$this->db->order_by("created_at", "asc");

		$resource = $this->db->get();
		return $resource->result_array();
	}

	/**
	 * @param string $message
	 * @param int $user_id
	 * @return mixed
	 */
	function setMessageData($message = "", $user_id = 0)
	{
		$data = array(
			'message' => $message,
			'send_status' => STATUS_FLAG_OFF,
			'user_id' => $user_id = 0,
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s"),
		);

		$this->db->insert($this->dataDb, $data);
		return $this->db->insert_id();
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
