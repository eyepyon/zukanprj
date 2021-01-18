<?php

/**
 * Index.php
 *
 * @access public
 * @author: aida
 * @version: 2020-01-16 14:22
 * @copyright FrogCompany Inc. All Rights Reserved
 */

class Index extends MY_Controller {

	public function __construct() {
		parent::__construct();

        $this->data['base_url'] = $this->config->item('base_url');

        // アラート未読数
        $this->data['alert_count'] = 0;
        // メッセージ未読数
        $this->data['message_count'] = 0;

	}

	public function index() {
//		$this->view('top.tpl');

		$this->smarty->view('top.tpl',$this->data);
	}

}
