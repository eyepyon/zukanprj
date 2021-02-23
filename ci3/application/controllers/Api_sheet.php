<?php

require_once '/var/www/zukanprj/vendor/autoload.php';
//define('SPREADSHEET_ID', '1tIAX3TAvsJWJRQ4XFl7GENGzIbBFJFm37WgD3-tILxU');
define('SPREADSHEET_ID', '1X9lEQIp0m_JUuV6y0Ke7MxqoM8bGfvAXkNCcxHeiTJA');
define('FORM_SPREAD_ID', '1HwVaAk61WJQxprH3V6jlVzLi_vjsbHxH8D5YQsNcuaw');

define('CLIENT_SECRET_PATH', APPPATH . 'config/development/weintech-2de74aca5c3b.json');

/**
 *
 *
 * @access public
 * @author: aida
 * @version: 2020-01-16 14:22
 * @copyright FrogCompany Inc. All Rights Reserved
 *
 * @property Record_model $recordModel
 * @property User_model $userModel
 * @property Slack_model $slackModel
 */

// スコープの設定
//define('SCOPES', implode(' ', array(
//		Google_Service_Sheets::SPREADSHEETS)
//));

class Api_sheet extends CI_Controller
{
	/**
	 * @var Google_Service_Sheets
	 */
	protected $service;

	/**
	 * @var array|false|string
	 */
	protected $spreadsheetId;

	public function __construct()
	{
		parent::__construct();

		$this->load->library('Mmapi');
		$this->load->model('User_model', 'userModel');
		$this->load->model('Record_model', 'recordModel');
		$this->load->model('Slack_model', 'slackModel');

		$credentialsPath = CLIENT_SECRET_PATH;
		putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $credentialsPath);

		$this->spreadsheetId = SPREADSHEET_ID;
		$this->formspreadId = FORM_SPREAD_ID;

		$client = new Google_Client();
		$client->useApplicationDefaultCredentials();
		$client->addScope(Google_Service_Sheets::SPREADSHEETS);
		$client->setApplicationName('test');

		$this->service = new Google_Service_Sheets($client);


	}

//	/**
//	 * @param string $date
//	 * @param string $name
//	 * @param string $comment
//	 */
//	public function append(string $date, string $name, string $comment)
//	{
//		$value = new Google_Service_Sheets_ValueRange();
//		$value->setValues(['values' => [$date, $name, $comment]]);
//		$response = $this->service->spreadsheets_values->append(
//			$this->spreadsheetId, 'シート1!A1', $value, ['valueInputOption' => 'USER_ENTERED']
//		);
//
//		var_dump($response);
//	}

	public function up_sheet()
	{
		$offset = 0;
		$limit = 0;
		$name = "";
		$detail = "";
		$status = STATUS_FLAG_ON;
		$record_base = $this->recordModel->getRecordList($offset, $limit , $name , $detail, $status);

		$value = new Google_Service_Sheets_ValueRange();

		$num = 3;

		foreach ($record_base as $record) {

			$result = $this->__adjust_list($record);
			$value->setValues(['values' => $result]);

			$response = $this->service->spreadsheets_values->append(
				$this->spreadsheetId, sprintf('挑戦者リスト!B%d',$num), $value, ['valueInputOption' => 'USER_ENTERED']
			);
			$num++;

		}

		$message = "図鑑が更新されました。ご確認ください。";
		$user_id = 0;
		$this->slackModel->setMessageData($message, $user_id);

//		var_dump($response);
	}

	/**
	 * @param int $last
	 */
	public function clearListData($last = 0){

		$range = sprintf('挑戦者リスト!B3:%d',$last);
		$clearRange = new Google_Service_Sheets_ClearValuesRequest();
		$this->service->spreadsheets_values->clear($this->spreadsheetId, $range, $clearRange);

		print "OK";
	}

	public function getIdData(){

		$range = sprintf('登録フォーム!A2:N');
		$response = $this->service->spreadsheets_values->get($this->formspreadId, $range);

		if(isset($response->values) && is_array($response->values) && count($response->values)>0){

			foreach ($response->values as $records) {
				$return = $this->__adjust_form($records);

//				if (isset($return['facebook_account']) && $return['facebook_account'] != "") {
//					$record = $this->recordModel->getByFacebookAccount($return['facebook_account']);
//					if ($record) {
//						// 最新のヒストリーから更新日時を取得
//						$lasts = $this->recordModel->getLastUpdate($record["id"]);
//						if (isset($lasts['form_timestamp']) && isset($return['form_timestamp'])
//							&& (strtotime($return['form_timestamp']) > strtotime($lasts['form_timestamp']))) {
//							// 更新されているのでデータ更新
//							$res = $this->recordModel->setRecordData($record['id'],$return);
//							// ヒストリー
//							$this->recordModel->setImportHistory($record["id"],$return['form_timestamp']);
//						}
//					} else {
//						// データ無いのでインサート
//						$record_id = $this->recordModel->setRecordData(0,$return);
//						// ヒストリー
//						$this->recordModel->setImportHistory($record_id,$return['form_timestamp']);
//					}
//				}

				if (isset($return['email']) && $return['email'] != "") {
					$record = $this->recordModel->getByEmail($return['email']);
					if ($record) {
						// 最新のヒストリーから更新日時を取得
						$lasts = $this->recordModel->getLastUpdate($record["id"]);
						if (isset($lasts['form_timestamp']) && isset($return['form_timestamp'])
							&& (strtotime($return['form_timestamp']) > strtotime($lasts ['form_timestamp']))) {
							// 更新されているのでデータ更新
							$this->recordModel->setRecordData($record['id'],$return);
							// ヒストリー
							$this->recordModel->setImportHistory($record["id"],$return['form_timestamp']);
						}
					} else {
						// データ無いのでインサート
						$record_id = $this->recordModel->setRecordData(0,$return);
						// ヒストリー
						$this->recordModel->setImportHistory($record_id,$return['form_timestamp']);
					}
				}
			}

		}

		print "\nOK";
//		print_r($response);

	}

	/**
	 * @param array $record
	 * @param array $return
	 * @return array|mixed
	 */
	private function __adjust_list($record = array(), $return = array())
	{
		$array_attribute = array(
			"","社会人","学生"
		);

		$return[] = sprintf("%03d",trim($record['id'])); // No.
//		$return[] = $record['user_id']; // No.
		$return[] = trim($record['name']); // 名前（漢字）
		$return[] = trim($record['name_kana']); //	名前（カタカナ）
//		email
		if(strlen(trim($record['facebook_account'])>1)) {
			$return[] = "https://www.facebook.com/" . trim($record['facebook_account']); //	Facebookアカウント
		}else{
			$return[] = ""; //	Facebookアカウント
		}
		if(strlen(trim($record['twitter_account'])>1)){
			$return[] = "https://twitter.com/".trim($record['twitter_account']); //	Twitterアカウント
		}else{
			$return[] = ""; //	Twitterアカウント
		}
		$return[] = $array_attribute[trim($record['attribute'])]; //	属性(1,社会人 2,学生)
		$return[] = trim($record['study']); // 学びたいことやってみたいこと
		$return[] = trim($record['contribute']); // 教えられること 貢献できること
		$return[] = trim($record['most_area']); // 最も取り組みたい領域・分野
		$return[] = trim($record['enthusiasm']); //	頑張りたいこと＆意気込み
		$return[] = trim($record['qualification']); //	保有する資格
		$return[] = trim($record['community']); //	所属団体/コミュニティ（会社以外）
		//  	detail
		return $return;
	}

	/**
	 * @param array $record
	 * @param array $return
	 * @return array|mixed
	 */
	private function __adjust_form($record = array(), $return = array()){

		$array_re_attribute = array(
			"" => 0, "社会人" => 1, "学生" => 2
		);

		if (strpos($record[2], 'facebook.com/')) {
			$p = explode('facebook.com/', $record[2]);
			$p1 = explode('/', $p[1]);
			$facebook_account = trim($p1[0]);
		} else {
			$facebook_account = trim($record[2]);
		}

		if (strpos($record[2], 'twitter.com/')) {
			$p = explode('twitter.com/', $record[2]);
			$p1 = explode('/', $p[1]);
			$twitter_account = trim($p1[0]);
		} else {
			$twitter_account = trim($record[2]);
		}

		$return['form_timestamp'] = trim($record[0]);// タイムスタンプ
		$return['name'] = trim($record[1]);// 名前（フルネーム・漢字）
		$return['facebook_account'] = $facebook_account;// FacebookアカウントのURL
		$return['twitter_account'] = $twitter_account;// TwitterアカウントのURL
		$return['email'] = trim($record[4]);// メールアドレス
		$return['attribute'] = $array_re_attribute[trim($record[5])];// 属性
		$return['name_kana'] = trim($record[6]);// 名前（フルネーム・カタカナ）
		$return['study'] = trim($record[7]);// 学びたいこと・やってみたいこと
		$return['contribute'] = trim($record[8]);// 教えられること貢献できること
		$return['most_area'] = trim($record[9]);// 最も取り組みたい領域・分野
		$return['enthusiasm'] = trim($record[10]);// 頑張りたいこと＆意気込み
		$return['qualification'] = trim($record[11]);// 保有する資格
		$return['community'] = trim($record[12]);// 所属団体/コミュニティ（会社以外）

		return $return;
	}

}



