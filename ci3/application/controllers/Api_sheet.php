<?php

require_once '/var/www/zukanprj/vendor/autoload.php';

define('SPREADSHEET_ID', '1tIAX3TAvsJWJRQ4XFl7GENGzIbBFJFm37WgD3-tILxU');
define('CLIENT_SECRET_PATH', APPPATH . 'config/development/weintech-2de74aca5c3b.json');
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

		$credentialsPath = CLIENT_SECRET_PATH;
		putenv('GOOGLE_APPLICATION_CREDENTIALS=' . dirname(__FILE__) . '/' . $credentialsPath);

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
		$response = $this->service->spreadsheets_values->append($this->spreadsheetId, 'シート1!A1', $value, ['valueInputOption' => 'USER_ENTERED']);

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

}



