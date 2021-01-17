<?php if ( !defined( 'BASEPATH' ) ) {
	exit('No direct script access allowed');
}

/**
 *  Mmapi.php
 *
 * @author: aida
 * @version: 2019-03-16 17:11
 *
 */
class Mmapi {

	function readRequestJson() {
		$CI =& get_instance();

		$CI->load->library( 'user_agent' );

		$json_string = file_get_contents( 'php://input' );
		$json_array  = json_decode( $json_string, TRUE );

		return $json_array;
	}

	/**
	 * @param array $array
	 * @param int $status_code
	 * @param bool $masterFlg
	 */
	function response_json( $array = array(), $status_code = STATUS_CODE_SUCCESS, $masterFlg = FALSE ) {

		$CI =& get_instance();

		if ( $masterFlg == TRUE ) {
			$jsonArray = $array;
		} else {
			$jsonArray = array(
				"status" => $status_code,
			);
			if ( count( $array ) > 0 ) {
				$jsonArray["data"] = $array;
			}
		}

		$jsonData = json_encode( $jsonArray, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );

		$CI->output->set_header( "Content-Type: application/json; charset=utf-8" );
		// フレームセットの一部として表示される事を禁止
//		$CI->output->set_header( 'X-FRAME-OPTIONS: DENY' );
        $CI->output->set_header( 'X-FRAME-OPTIONS: SAMEORIGIN' );
		// XSS対策
//		$CI->output->set_header( "X-Content-Type-Options: nosniff" );
		// キャッシュOFF
		$CI->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate" );
		$CI->output->set_header( "Cache-Control: post-check=0, pre-check=0" );
		$CI->output->set_header( "Pragma: no-cache" );
		//
		$CI->output->set_output( $jsonData );
	}

	/**
	 * エラーを返す
	 * @param int $status
	 */
	function response_error_status( $status = STATUS_CODE_FAIL ) {
		$array = array();
		$this->response_json( $array, $status );
	}

}

