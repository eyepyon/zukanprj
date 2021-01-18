<?php

/**
 * logout.php
 *
 * @access public
 * @author: aida
 * @version: 2021-01-16 19:47
 * @copyright FrogCompany Inc. All Rights Reserved
 *
 * @property User_model $userModel
 * @property Management $management
 *
 */

class Logout extends MY_Controller {

	public function __construct() {
		parent::__construct();

        $this->data['base_url'] = $this->config->item('base_url');
        // アラート未読数
        $this->data['alert_count'] = 0;
        // メッセージ未読数
        $this->data['message_count'] = 0;

        $this->data["show_menu"]['project'] = '';
        $this->data["show_menu"]['record'] = '';
        $this->data["show_menu"]['user'] = '';
	}

	public function index() {

		$this->smarty->view( 'logout.tpl', $this->data );
	}

	public function bye() {


        // Remove token and user data from the session
        $this->session->unset_userdata('loggedIn');
        $this->session->unset_userdata('userData');

        // Destroy entire session data
        $this->session->sess_destroy();
		//
		$redirectUrl = '/login/';
		redirect( $redirectUrl );
	}
}

