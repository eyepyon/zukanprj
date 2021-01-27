<?php

/**
 *  Api_slack
 *
 * @author: aida
 * @version 2021/01/16 19:56
 *
 * @property Slack_model $slackModel
 * @property Mmapi $Mmapi
 */

class Api_slack extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library('Mmapi');
		$this->load->model('Slack_model', 'slackModel');

	}

	public function checkNewMessage()
	{

		$list = $this->slackModel->getWaitList();

		$n = 0;

		if (isset($list) && is_array($list) && count($list) > 0) {

			foreach ($list as $record) {
				$message_body = trim($record["message"]);
				if ($this->__sendMessage($message_body)) {
					$this->slackModel->setSendStatus($record["id"]);
					$n++;
				}
				sleep(1);// とりあえず規制防止
			}
			printf("%d件送信完了しました。\n", $n);
		} else {
			// 対象なし
		}
	}

	/**
	 * @param string $message_body
	 * @return bool
	 */
	private function __sendMessage($message_body = "")
	{

		// Webhook URL
		$url = DOTENV_SLACK_INCOME_HOOKS_URL;

		// メッセージ
		$message = array(
			"username" => "新規登録通知",
			"icon_emoji" => ":slack:",
			"attachments" => array(
				array(
					"text" => "新規登録がありました。\n内容を確認ください。\n" . $message_body
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

//		print "OK";
		return TRUE;
	}
}
