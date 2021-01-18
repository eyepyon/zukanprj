<?php

/**
 * top.php
 *
 * @author: aida
 * @version: 2020-01-16 15:11
 *
 * @property User_model $userModel
 * @property Management $management
 */
class Top extends MY_Controller {

	public function __construct() {
		parent::__construct();

        $this->data['base_url'] = $this->config->item('base_url');

        // アラート未読数
        $this->data['alert_count'] = 0;
        // メッセージ未読数
        $this->data['message_count'] = 0;

        $this->data["show_menu"]['record'] = ' show';
        $this->data["show_menu"]['project'] = ' show';
		$this->data["show_menu"]['user'] = ' show';

		$params = array();
		//
		$this->load->library( 'Management', $params );
	}

	public function index() {

        $this->smarty->view( 'top.tpl', $this->data );
	}

}


