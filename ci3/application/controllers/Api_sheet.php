<?php

require_once '/var/www/zukanprj/vendor/autoload.php';
//define('SPREADSHEET_ID', '1tIAX3TAvsJWJRQ4XFl7GENGzIbBFJFm37WgD3-tILxU');
define('SPREADSHEET_ID', '1X9lEQIp0m_JUuV6y0Ke7MxqoM8bGfvAXkNCcxHeiTJA');

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
 * @property user_model $userModel
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

		$credentialsPath = CLIENT_SECRET_PATH;
		putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $credentialsPath);

		$this->spreadsheetId = SPREADSHEET_ID;

		$client = new Google_Client();
		$client->useApplicationDefaultCredentials();
		$client->addScope(Google_Service_Sheets::SPREADSHEETS);
		$client->setApplicationName('test');

		$this->service = new Google_Service_Sheets($client);

	}

	/**
	 * @param string $date
	 * @param string $name
	 * @param string $comment
	 */
	public function append(string $date, string $name, string $comment)
	{
		$value = new Google_Service_Sheets_ValueRange();
		$value->setValues(['values' => [$date, $name, $comment]]);
		$response = $this->service->spreadsheets_values->append(
			$this->spreadsheetId, 'シート1!A1', $value, ['valueInputOption' => 'USER_ENTERED']
		);

		var_dump($response);
	}

	/**
	 * @param array $record
	 */
	public function up_sheet($record = array())
	{
		$result = array();
		$offset = 0;
		$limit = 0;
		$name = "";
		$detail = "";
		$status = STATUS_FLAG_OFF;
		$record_base = $this->recordModel->getRecordList($offset, $limit , $name , $detail, $status);

		foreach ($record_base as $record){
			$result = $this->__adjust_list($record);
		}
		print_r($result);

		exit;

		$value = new Google_Service_Sheets_ValueRange();
		$value->setValues(['values' => $record]);
		$response = $this->service->spreadsheets_values->append(
			$this->spreadsheetId, 'シート1!B3', $value, ['valueInputOption' => 'USER_ENTERED']
		);

		var_dump($response);
	}


	public function test()
	{
		$sample = $this->service;

		$date = date('Y/m/d');
		$name = '山川のりを';
		$comment = 'ギターうまい';
		$this->append($date, $name, $comment);

	}

	/**
	 * @param array $addRecord
	 * @param string $sheetRangeStart
	 * @param string $sheetRangeEnd
	 * @param int $sheetNo
	 * @param array $record
	 * @return array|mixed
	 */
	private function __Sheet_Update($addRecord =array(),$sheetRangeStart="",$sheetRangeEnd="",$sheetNo=1,$record =array()){

		$record[] = new \Google_Service_Sheets_ValueRange([
			'range' => sprintf('Sheet%d!%s:%s',$sheetNo,$sheetRangeStart,$sheetRangeStart),
			'values' => $addRecord(),
		]);
		return $record;
	}

	public function batch_update(){
		try {

			$spreadsheet_service = new \Google_Service_Sheets($client);
			$spreadsheet_id = '（スプレッドシートのID）';

		$result = $spreadsheet_service->spreadsheets_values->batchUpdate($spreadsheet_id, $body);
		echo $updated_cell_count = $result->getTotalUpdatedCells();

		} catch (\Exception $e) {

			// エラー処理

		}
	}



	public function Update_Sheet()
	{
		// アカウント認証情報インスタンスを作成
		$client = new Google_Client();
		$client->setScopes(SCOPES);
		$client->setAuthConfig(CLIENT_SECRET_PATH);
		// シートのインスタンスを生成
		$service = new Google_Service_Sheets($client);
		try {
			// スプレッドシートの ID
			$spreadsheetId = 'スプレッドシートのID';
			// 更新するシートの名前とセルの範囲
			$range = 'シート1!A2:B7';
			// 更新するデータ
			$values = [
				["A1", "B1"],
				["2019/1/1", "2020/12/31"],
				["アイウエオ", "かきくけこ"],
				[10, 20],
				[100, 200],
				['=(A5+A6)', '=(B5+B6)']
			];
			$updateBody = new Google_Service_Sheets_ValueRange([
				'values' => $values
			]);
			// valueInputOption を指定（ USER_ENTERED か RAW から選択）
			$params = [
				'valueInputOption' => 'USER_ENTERED'
			];
			$result = $service->spreadsheets_values->update($spreadsheetId, $range, $updateBody, $params);
			// 更新したセルの数が返ってくる
			echo $result->getUpdatedCells();
		} catch (Google_Exception $e) {
			// $e は json で返ってくる
			$errors = json_decode($e->getMessage(), true);
			$err = "code : " . $errors["error"]["code"] . "";
			$err .= "message : " . $errors["error"]["message"];
			echo "Google_Exception" . $err;
		}

	}

	private function __adjust_list($record = array(), $return = array())
	{
		$return[] = $record['user_id']; // No.
		$return[] = $record['name']; // 名前（漢字）
		$return[] = $record['name_kana']; //	名前（カタカナ）
//		email
		$return[] = $record['facebook_account']; //	Facebookアカウント
		$return[] = $record['twitter_account']; //	Twitterアカウント
		$return[] = $record['attribute']; //	属性(1,社会人 2,学生)
		$return[] = $record['study']; // 学びたいことやってみたいこと
		$return[] = $record['contribute']; // 教えられること 貢献できること
		$return[] = $record['most_area']; // 最も取り組みたい領域・分野
		$return[] = $record['enthusiasm']; //	頑張りたいこと＆意気込み
		$return[] = $record['qualification']; //	保有する資格
		$return[] = $record['community']; //	所属団体/コミュニティ（会社以外）
		//  	detail
		return $record;
	}

}



