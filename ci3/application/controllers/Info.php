<?php

/**
 *
 *
 * @access public
 * @author aida
 * @copyright  FrogCompany Inc. All Rights Reserved
 *
 */
class Info extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
//        redirect("/info/about");
		$data = array();
		$this->smarty->view('info/info.tpl', $data);
	}

	public function about()
	{
		$data = array();
		$this->smarty->view('info/about.tpl', $data);
	}


	/**
	 * @param int $page
	 */
	public function faq($page = 0)
	{
		$data = array();
		$this->smarty->view('info/faq.tpl', $data);
	}

	public function privacy()
	{
		$data = array();
		$this->smarty->view('info/privacy.tpl', $data);
	}

	public function kiyaku()
	{
		$data = array();
		$this->smarty->view('info/kiyaku.tpl', $data);
	}

	public function tokusho()
	{
		$data = array();
		$this->smarty->view('info/tokusho.tpl', $data);
	}

	public function authentication()
	{
		$data = array();
		$this->smarty->view('info/authentication.tpl', $data);
	}

	public function authentication_confirm()
	{
		$data = array();
		$this->smarty->view('info/authentication_confirm.tpl', $data);
	}

	public function authentication_success()
	{
		$data = array();
		$this->smarty->view('info/authentication_success.tpl', $data);
	}

}
