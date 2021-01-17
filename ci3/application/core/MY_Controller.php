<?php

/**
 * prj.MY_controller.php
 *
 * @author: aida
 * @version: 2021-01-15 15:27
 */
class MY_Controller extends CI_Controller {

	var $data = array();

	public function __construct() {
		parent::__construct();

		// ライブラリ群のロード
//		$libraries = array( 'parser', 'session', 'facebook' );
		$libraries = array( 'parser','session' );
		$this->load->library( $libraries );
		//
		$helpers = array( 'cookie', 'url', 'form');
		$this->load->helper( $helpers );

		if ( ENVIRONMENT == 'development' ) {
//			$this->output->enable_profiler( true );
		}

//		// メンテチェック
//    	if($this->config->item( 'app_sv_maintenance_mode' ) == 1){
//            if(!$this->remoteIpChecker()){
//                redirect($this->config->item( 'app_sv_maintenance_redirect_url' ));
//            }
//        }

//        $base_url = base_url();
		$base_url = $this->config->item( 'base_url' );
		//
//        $base_url = str_replace("http://","//",$base_url);
//        $base_url = str_replace("https://","//",$base_url);

		$this->data['base_url'] = $base_url;

		$loggedIn = $this->session->userdata('loggedIn');
		$userData = $this->session->userdata('userData');
		//
		$current_url = current_url();
		//
		if ( !$loggedIn && !strpos( $current_url, 'member' ) && !stripos( $current_url, 'reg' )&& !stripos( $current_url, 'info' )&& !stripos( $current_url, 'user_authentication' ) ) {
			//
			$redirectUrl = '/member/';
			redirect($redirectUrl);
			exit;
		}

		$this->data['loggedIn'] = $loggedIn;
		$this->data['userData'] = $userData;


	}

	/**
	 * @return bool
	 */
	function remoteIpChecker(){

		$allowIpList = $this->config->item( 'maintenance_staff_ip_array' );;

// リモートIP取得
		$thisIp = $_SERVER['REMOTE_ADDR'];

// リモートIPをドットで区切る
		$thisIpNums = explode('.', $thisIp);

// リモートIPを10進数値に変更
		$thisIpNum = isset($thisIpNums[3]) ? (
			$thisIpNums[0] * pow(2,24)
			+ $thisIpNums[1] * pow(2,16)
			+ $thisIpNums[2] * pow(2,8)
			+ $thisIpNums[3] * pow(2,0)
		) : 0;

// 許可IPリストとのマッチ検索開始
		$matchFlag = false;
		foreach ($allowIpList as $allowIp) {
			// 許可IPをスラッシュで区切る
			$allowIpArray = explode('/', $allowIp);

			// 許可IPをドットで区切る
			$allowIpNums = explode('.', $allowIpArray[0]);

			// 許可IPを10進数値に変更
			$allowIpNum = isset($allowIpNums[3]) ? (
				$allowIpNums[0] * pow(2,24)
				+ $allowIpNums[1] * pow(2,16)
				+ $allowIpNums[2] * pow(2,8)
				+ $allowIpNums[3] * pow(2,0)
			) : 0;

			// 許可IPのマスクを数値に変更
			$maskNum = isset($allowIpArray[1])
				? (pow(2,(int)$allowIpArray[1]) - 1) * pow(2, 32 - (int)$allowIpArray[1])
				: pow(2, 32) - 1;

			// リモートIPと許可IPの一致を確認
			if (($thisIpNum & $maskNum) === ($allowIpNum & $maskNum)) {
				$matchFlag = true;
				break;
			}
		}
		return $matchFlag;
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

}
