<?php

require_once '/var/www/zukanprj/vendor/autoload.php';
//define('SPREADSHEET_ID', '1tIAX3TAvsJWJRQ4XFl7GENGzIbBFJFm37WgD3-tILxU');
define('SPREADSHEET_ID', '1X9lEQIp0m_JUuV6y0Ke7MxqoM8bGfvAXkNCcxHeiTJA');
//define('FORM_SPREAD_ID', '1HwVaAk61WJQxprH3V6jlVzLi_vjsbHxH8D5YQsNcuaw');
define('FORM_SPREAD_ID', '1oEls_L7LQIxDadGGW4o77RKJxUhVh0Kc1V11EhPioZ0'); // NEW

// https://docs.google.com/spreadsheets/d/1oEls_L7LQIxDadGGW4o77RKJxUhVh0Kc1V11EhPioZ0/edit#gid=1372403603

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
	protected $formspreadId;

	protected $prj_sheet_type_array;
	protected $prj_sheet_type_spreadsheet_id_array;
	protected $prj_sheet_type_form_spread_id_array;

	public function __construct()
	{
		parent::__construct();

		$this->load->library('Mmapi');
		$this->load->model('User_model', 'userModel');
		$this->load->model('Record_model', 'recordModel');
		$this->load->model('Slack_model', 'slackModel');

		$this->prj_sheet_type_array = $this->config->item('prj_sheet_type_array');
		$this->prj_sheet_type_spreadsheet_id_array = $this->config->item('prj_sheet_type_spreadsheet_id_array');
		$this->prj_sheet_type_form_spread_id_array = $this->config->item('prj_sheet_type_form_spread_id_array');

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

	public function up_sheet()
	{
		$offset = 0;
		$limit = 0;
		$name = "";
		$detail = "";
		$status = STATUS_FLAG_ON;
		$sheet_type = 2;
		$this->spreadsheetId = $this->prj_sheet_type_spreadsheet_id_array[$sheet_type];

		$this->clearListData($this->spreadsheetId,100);
		sleep(1);

		$record_base = $this->recordModel->getRecordList($sheet_type,$offset, $limit , $name , $detail, $status);

		$value = new Google_Service_Sheets_ValueRange();

		$num = 3;

		foreach ($record_base as $record) {

			$result = $this->__adjust_list($record);

			print_r($result);
			$value->setValues(['values' => $result]);

//			$response = $this->service->spreadsheets_values->append(
//				$this->spreadsheetId, sprintf('挑戦者リスト!B%d',$num), $value, ['valueInputOption' => 'USER_ENTERED']
//			);
			$response = $this->service->spreadsheets_values->update(
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
	 * @param string $spreadsheetId
	 * @param int $last
	 */
	public function clearListData($spreadsheetId = "",$last = 0){

		$range = sprintf('挑戦者リスト!B3:%d',$last);
		$clearRange = new Google_Service_Sheets_ClearValuesRequest();
		$this->service->spreadsheets_values->clear($spreadsheetId, $range, $clearRange);

		print "OK";
	}

	public function checkUpdater($last = 0)
	{
		$sheet_type = 2;
		$this->spreadsheetId = $this->prj_sheet_type_spreadsheet_id_array[$sheet_type];

		$range = sprintf('挑戦者リスト!B1:B1');
		$options = [
			'range'=>$range,
			'DateTimeRenderOptionbookmark_border' => 'SERIAL_NUMBER'
		];
		$response = $this->service->spreadsheets_values->batchGet($this->spreadsheetId, $options);

		if (isset($response->values) && is_array($response->values) && count($response->values) > 0) {
			print_r($response->values);
		}
	}
	/**
	 * フォーム→DBにいれるやつ
	 */
	public function getIdData(){

		$sheet_type = 2;
		$this->formspreadId = $this->prj_sheet_type_form_spread_id_array[$sheet_type];

		$range = sprintf('登録フォーム!A2:N');
		$response = $this->service->spreadsheets_values->get($this->formspreadId, $range);

		if(isset($response->values) && is_array($response->values) && count($response->values)>0){

			foreach ($response->values as $records) {
				switch($sheet_type){
					case PRJ_SHEET_TYPE_KANTO_ZUKAN:
					case PRJ_SHEET_TYPE_TSUNAGU:
						$return = $this->__adjust_form($records);
						break;
					case PRJ_SHEET_TYPE_TSUNAGU_LONG:
						$return = $this->__adjust_tsunagu_form($records);
						break;
					default:
						$return = $this->__adjust_form($records);
				}

				$return["sheet_type"]= $sheet_type;

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
					$record = $this->recordModel->getByEmail($return['email'],$sheet_type);

//					print_r($record);
//					print_r($return);

					if ($record) {
						// 最新のヒストリーから更新日時を取得
						$lasts = $this->recordModel->getLastUpdate($record["id"]);
//						print_r($lasts);
						if(is_null($lasts)){
							// 更新されているのでデータ更新
							$this->recordModel->setRecordData($record['id'],$return);
							// ヒストリー
							$this->recordModel->setImportHistory($record["id"],$return['form_timestamp']);

							log_message('debug', __LINE__." DBを更新しました".print_r($record,true).print_r($return,true));

							//							print("更新1");
						}elseif (isset($lasts['form_timestamp']) && isset($return['form_timestamp'])
							&& (strtotime($return['form_timestamp']) > strtotime($lasts ['form_timestamp']))) {
							// 更新されているのでデータ更新
							$this->recordModel->setRecordData($record['id'],$return);
							// ヒストリー
							$this->recordModel->setImportHistory($record["id"],$return['form_timestamp']);

							log_message('debug', __LINE__." DBを更新しました".print_r($record,true).print_r($return,true));
						}

					} else {
						// データ無いのでインサート
						$record_id = $this->recordModel->setRecordData(0,$return);
						// ヒストリー
						$this->recordModel->setImportHistory($record_id,$return['form_timestamp']);

						log_message('debug', __LINE__." DBに投入しました".print_r($return,true));
					}
				}
			}

		}
		log_message('debug', __LINE__." OK");
//		print "\nOK";

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
		if(strlen(trim($record['facebook_account']))>1) {
			$return[] = "https://www.facebook.com/" . trim($record['facebook_account']); //	Facebookアカウント
		}else{
			$return[] = ""; //	Facebookアカウント
		}
		if(strlen(trim($record['twitter_account']))>1){
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
	private function __adjust_formOLD($record = array(), $return = array()){

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
			$p = explode('twitter.com/', $record[3]);
			$p1 = explode('/', $p[1]);
			$twitter_account = trim($p1[0]);
		} else {
			$twitter_account = trim($record[3]);
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
		$return['status'] = STATUS_FLAG_ON;// 所属団体/コミュニティ（会社以外）

		return $return;
	}

	private function __adjust_form($record = array(), $return = array()){

		$array_re_attribute = array(
			"" => 0, "社会人" => 1, "学生" => 2
		);

		if (strpos($record[4], 'facebook.com/')) {
			$p = explode('facebook.com/', $record[4]);
			$p1 = explode('/', $p[1]);
			$facebook_account = trim($p1[0]);
		} else {
			$facebook_account = trim($record[4]);
		}

		if (strpos($record[5], 'twitter.com/')) {
			$p = explode('twitter.com/', $record[5]);
			$p1 = explode('/', $p[1]);
			$twitter_account = trim($p1[0]);
		} else {
			$twitter_account = trim($record[5]);
		}

		$return['form_timestamp'] = trim($record[0]);// タイムスタンプ
		$return['email'] = trim($record[1]);// メールアドレス
		$return['name'] = trim($record[2]);// 名前（フルネーム・漢字）
		$return['name_kana'] = trim($record[3]);// 名前（フルネーム・カタカナ）
		$return['facebook_account'] = $facebook_account;// FacebookアカウントのURL
		$return['twitter_account'] = $twitter_account;// TwitterアカウントのURL
		$return['attribute'] = $array_re_attribute[trim($record[6])];// 属性
		$return['study'] = trim($record[7]);// 学びたいこと・やってみたいこと
		$return['contribute'] = trim($record[8]);// 教えられること貢献できること
		$return['most_area'] = trim($record[9]);// 最も取り組みたい領域・分野
		$return['enthusiasm'] = trim($record[10]);// 頑張りたいこと＆意気込み
		$return['qualification'] = trim($record[11]);// 保有する資格
		$return['community'] = trim($record[12]);// 所属団体/コミュニティ（会社以外）
		$return['challenge_now'] = trim($record[13]);// あなたの現在の挑戦・支援の取り組みは行えていますか？ [挑戦]
		$return['support_now'] = trim($record[14]);// あなたの現在の挑戦・支援の取り組みは行えていますか？ [支援]
		$return['happiness_rank'] = trim($record[15]);// あなたの幸福度に近い数値をご記入ください。（全体・上限を10としたとき）
		$return['join_prj'] = trim($record[16]);// 少人数　みんなで挑戦プロジェクト参加意向
//		$return['community'] = trim($record[17]);// 上記確認事項に同意する
		$return['status'] = STATUS_FLAG_ON;//

		return $return;
	}

	private function __adjust_tsunagu_form($record = array(), $return = array()){

		$array_re_attribute = array(
			"" => 0, "社会人" => 1, "学生" => 2
		);

		if (strpos($record[4], 'facebook.com/')) {
			$p = explode('facebook.com/', $record[4]);
			$p1 = explode('/', $p[1]);
			$facebook_account = trim($p1[0]);
		} else {
			$facebook_account = trim($record[4]);
		}

		if (strpos($record[5], 'twitter.com/')) {
			$p = explode('twitter.com/', $record[5]);
			$p1 = explode('/', $p[1]);
			$twitter_account = trim($p1[0]);
		} else {
			$twitter_account = trim($record[5]);
		}

		$return['form_timestamp'] = trim($record[0]);// タイムスタンプ
		$return['email'] = trim($record[1]);// メールアドレス
		$return['name'] = trim($record[2]);// 名前（フルネーム・漢字）
		$return['name_kana'] = trim($record[3]);// 名前（フルネーム・カタカナ）
		$return['facebook_account'] = $facebook_account;// FacebookアカウントのURL
		$return['twitter_account'] = $twitter_account;// TwitterアカウントのURL
		$return['attribute'] = $array_re_attribute[trim($record[6])];// 属性
		$return['study'] = trim($record[7]);// 学びたいこと・やってみたいこと

		$return['study'] = sprintf("%s",trim($record[7]));// "[SNS運用の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[WEBデザインの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[グラフィックデザインの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[プロダクトデザインの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[写真撮影/動画撮影の経験年数]"

		$return['contribute'] = trim($record[8]);// 教えられること貢献できること

		$return['study'] = sprintf("%s",trim($record[7]));// "[オフラインイベント企画・運営の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[オンラインイベント企画・運営の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[Youtube・SNS等LIVE動画配信の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[オンラインコミュニティ設計・運営の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[PR/ブランディングの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[マーケティングの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[ライティング/執筆の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[Webサイト制作の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[フロントエンドエンジニアの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[ゲームエンジニアの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[制御・組み込み系エンジニアの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[サーバーエンジニアの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[ネットワークエンジニアの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[データベースエンジニアの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[機械学習の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[ディープラーニングの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[会社・組織経営の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[経営企画の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[人事/採用の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[ファイナンスの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[経理の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[営業の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[知財の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[法務/法律の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[語学（英語）の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[語学（その他）の経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[コーチングの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[講師・研修ファシリテーションの経験年数]"
		$return['study'] = sprintf("%s",trim($record[7]));// "[カウンセリングの経験年数]"

		$return['most_area'] = trim($record[9]);// 最も取り組みたい領域・分野
		$return['enthusiasm'] = trim($record[10]);// 頑張りたいこと＆意気込み
		$return['qualification'] = trim($record[11]);// 保有する資格
		$return['community'] = trim($record[12]);// 所属団体/コミュニティ（会社以外）

		$return['chanow'] = trim($record[13]);// "[マーケティング経験者]得意なスキル・受賞歴"
//		$return['community'] = trim($record[17]);// 上記確認事項に同意する
		$return['status'] = STATUS_FLAG_ON;//

		return $return;
	}

}



