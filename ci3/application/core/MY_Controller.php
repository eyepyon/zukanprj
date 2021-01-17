<?php

/**
 * prj.MY_controller.php
 *
 * @author: aida
 * @version: 2021-01-15 15:27
 */
class MY_Controller extends CI_Controller {
	protected $template;
	var $data = array();

	public function __construct() {
		parent::__construct();

		// ライブラリ群のロード
//		$libraries = array( 'parser','session' );
		$libraries = array( 'session' );
		$this->load->library( $libraries );
		//
//		$helpers = array( 'cookie', 'url', 'form' );
		$helpers = array( 'cookie', 'url', 'form');
		$this->load->helper( $helpers );

		$this->smarty->template_dir = APPPATH . 'templates';
		$this->smarty->compile_dir  = APPPATH . 'cache/templates_c';
		$this->template = 'layout.tpl';

		if ( ENVIRONMENT == 'development' ) {
//			$this->output->enable_profiler( true );
		}

		$base_url = base_url();
		//
        $base_url = str_replace("http://","//",$base_url);
        $base_url = str_replace("https://","//",$base_url);

		$this->data['base_url'] = $base_url;

		$admin_name = $this->session->userdata('admin_name');
		$admin_login = $this->session->userdata('admin_login');

//		$loginName = "";
		//
		$current_url = current_url();
		//
//		if ( !$admin_login && !strpos( $current_url, 'login' ) && !strpos( $current_url, 'videopass' ) ) {
//
//			$uri = uri_string();
//			//
//			$redirectUrl = '/login/';
//			if ( $uri != "" ) {
//				$redirectUrl .= sprintf( "?u=%s", $uri );
//			}
//			redirect( $redirectUrl );
//			exit;
//		}

		$this->data['admin_login'] = $admin_login;
		$this->data['admin_name'] = $admin_name;


	}

//	/**
//	 * ページ情報の組み込みおよびテンプレートの表示を行う。
//	 *
//	 * (モジュール別テンプレート配置先)
//	 *   APPPATH/modules/(モジュール名)/view/(テンプレート名)
//	 *
//	 * (共通テンプレート配置先)
//	 *   APPPATH/view/(テンプレート名)
//	 *
//	 * @param string $target 設定パス(アクション名/メソッド名で記述)。
//	 * @param string $pageInfo
//	 * @param bool $return_string
//	 */
//	public function parse( $target, $pageInfo = "", $return_string = FALSE ) {
//
//		// テンプレート情報の取得
//		$template_name = $target;
//		//　テンプレート表示
//		$CI =& get_instance();
//		$CI->output->set_header( 'Content-Type: text/html; charset=' . HTML_ENCODING );
//		$this->parser->html_parse( $template_name, $this->data, $return_string, TRUE, HTML_ENCODING );
//	}

	public function view($template)
	{
		$this->template = $template;
	}

	public function _output($output)
	{
		if (strlen($output) > 0) {
			echo $output;
		} else {
			$this->smarty->display($this->template);
		}
	}

}
