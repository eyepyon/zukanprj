<?php

/**
 *  Api_slack
 *
 * @author: aida
 * @version 2021/01/16 19:56
 *
 * @property User_model $userModel
 * @property Mmapi $Mmapi
 */

class Api_slack extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library('Mmapi');
		$this->load->model('User_model', 'userModel');
	}


	public function Send_Message()
	{

		// Webhook URL
		$url = DOTENV_SLACK_INCOME_HOOKS_URL;

		// メッセージ
		$message = array(
			"username" => "ユーザー名",
			"icon_emoji" => ":slack:",
			"attachments" => array(
				array(
					"text" => "こんにちは。\n登録がありました！確認ください。"
				)
			)
		);

		// メッセージをjson化
		$message_json = json_encode($message);

		// payloadの値としてURLエンコード
		$message_post = "payload=" . urlencode($message_json);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $message_post);
		curl_exec($ch);
		curl_close($ch);

		print "OK";
	}
}
