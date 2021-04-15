<?php
/**
 * define.php
 *
 * @author: aida
 * @version: 2021-01-11 12:40
 */

define( "HTML_ENCODING", 'utf-8' );

define( 'LIST_SCREEN', '一覧画面' );
define( 'INPUT_SCREEN', '新規作成画面' );
define( 'EDIT_SCREEN', '編集画面' );
define( 'COFIRM_SCREEN', '確認画面' );

// 本番反映 1:未公開　2:公開
//define( 'PUBLIC_PERMISSION_UNRELEASED', 1 );
//define( 'PUBLIC_PERMISSION_RELEASED', 2 );
// 本番反映フラグ 1:全部関係なし 2:公開フラグのみ
//define( 'PUBLIC_PERMISSION_FLAG_ALL', 99 );
//define( 'PUBLIC_PERMISSION_FLAG_UNRELEASED_ONLY', 1 );
//define( 'PUBLIC_PERMISSION_FLAG_RELEASED_ONLY', 2 );

//define( 'START_UP_TYPE_NONE', 0 );// 指定なし
//define( 'START_UP_TYPE_EXPLICIT', 1 );// 明示的
//define( 'START_UP_TYPE_IMPLICIT', 2 );// 暗黙的

// ログインステータス
define( 'LOGIN_STATUS_CODE_NONE', 0 );
define( 'LOGIN_STATUS_CODE_SUCCESS', 1 );
define( 'LOGIN_STATUS_CODE_FAIL', 2 );

define( 'RANK_GENRE_ALL_CODE', 999999 );

define( 'LOGIN_PASSWORD_LIMIT_DAY', "+90 day" );

//define('DEFAULTS_NO_PICTURE_IMG', "/files/1x1.gif");
define( 'DEFAULTS_NO_PICTURE_IMG', "/files/nopic.png" );


define( 'STATUS_FLAG_OFF', 0 );
define( 'STATUS_FLAG_ON', 1 );
define( 'TEXT_STATUS_FLAG_OFF', "無効" );
define( 'TEXT_STATUS_FLAG_ON', "有効" );

define( 'USER_PERMISSION_READONLY', 0 );
define( 'USER_PERMISSION_ADMIN', 1 );
define( 'TEXT_USER_PERMISSION_READONLY', "参照権限" );
define( 'TEXT_USER_PERMISSION_ADMIN', "更新・参照権限" );


define( 'STATUS_CODE_PROCESSING', 1 );
define( 'STATUS_CODE_PROCESS_COMPLETE', 2 );
define( 'STATUS_CODE_PROCESS_ERROR_FORMAT', 9 );
define( 'TEXT_PROCESSING', "処理中" );
define( 'TEXT_PROCESS_COMPLETE', "正常完了" );
define( 'TEXT_PROCESS_ERROR_FORMAT', "処理エラー（フォーマットエラー）" );

define( 'ORDER_HISTORY_TYPE_DEFAULT', 1 );//
define( 'ORDER_HISTORY_TYPE_TICKET', 2 );

// この回数以上、連続ログイン失敗したらアカウントLOCK
define( 'MAX_FAIL_REPEAT_COUNT', 6 );
//define( 'FAIL_PASSWORD_LIMIT', 6 );// 何回間違えたらパスワードロック？
define( 'AGE_PASSWORD_LIMIT', 4 );// 何世代前までパスワード可能？
define( 'ALL_COUNT_FLAG_AT_LIMIT', -9999 );

define( 'DELETE_STATUS_ALIVE', 0 );//
define( 'DELETE_STATUS_DELETE', 1 );
define( 'DELETE_STATUS_WAIT_COMMIT', 2 );




//define( 'BATCH_LOCK_ACTIVE', STATUS_FLAG_ON );//	セマフォロック使うか？TODO 一時的にRESOURCEに移動
//define( 'BATCH_LOCK_ACTIVE', STATUS_FLAG_OFF );//	セマフォロック使うか？
define( 'BATCH_SEM_TARGET_ID_BATCH', 88 );//	送受信
//define( 'BATCH_SEM_TARGET_ID_SEND', 21 );//	SEND
define( 'BATCH_SEM_TARGET_ID_RECEIVE',22  );//	RECEIVE
define( 'BATCH_SEM_TARGET_ID_SEND', BATCH_SEM_TARGET_ID_BATCH );//	SEND
//define( 'BATCH_SEM_TARGET_ID_RECEIVE',BATCH_SEM_TARGET_ID_BATCH  );//	RECEIVE
define( 'BATCH_SEM_TARGET_ID_ORDER',44  );//
define( 'BATCH_SEM_TARGET_ID_REPORT',50  );//
define( 'BATCH_SEM_TARGET_ID_ID_REGISTER',24  );//

define( 'PRJ_SHEET_TYPE_NONE', 0 );//
define( 'PRJ_SHEET_TYPE_KANTO_ZUKAN', 1 );//
define( 'PRJ_SHEET_TYPE_TSUNAGU', 2 );//
define( 'PRJ_SHEET_TYPE_TSUNAGU_LONG', 3 );//
define( 'PRJ_SHEET_TYPE_KANTO_ZUKAN_NAME', '関東図鑑PRJ'  );//
define( 'PRJ_SHEET_TYPE_TSUNAGU_NAME', 'TSUNAGU'  );//　
define( 'PRJ_SHEET_TYPE_TSUNAGU_LONG_NAME', 'TSUNAGUv2'  );//　
$config['prj_sheet_type_array'] = array(
	''=>'---',
	PRJ_SHEET_TYPE_KANTO_ZUKAN => PRJ_SHEET_TYPE_KANTO_ZUKAN_NAME,
	PRJ_SHEET_TYPE_TSUNAGU => PRJ_SHEET_TYPE_TSUNAGU_NAME,
//	PRJ_SHEET_TYPE_TSUNAGU_LONG => PRJ_SHEET_TYPE_TSUNAGU_LONG_NAME,
);
define( 'PRJ_SHEET_TYPE_KANTO_ZUKAN_SPREADSHEET_ID', '1tIAX3TAvsJWJRQ4XFl7GENGzIbBFJFm37WgD3-tILxU'  );//
define( 'PRJ_SHEET_TYPE_TSUNAGU_SPREADSHEET_ID', '1X9lEQIp0m_JUuV6y0Ke7MxqoM8bGfvAXkNCcxHeiTJA'  );//　
define( 'PRJ_SHEET_TYPE_TSUNAGU_LONG_SPREADSHEET_ID', 'TSUNAGUv2'  );//　
$config['prj_sheet_type_spreadsheet_id_array'] = array(
	''=>'---',
	PRJ_SHEET_TYPE_KANTO_ZUKAN => PRJ_SHEET_TYPE_KANTO_ZUKAN_SPREADSHEET_ID,
	PRJ_SHEET_TYPE_TSUNAGU => PRJ_SHEET_TYPE_TSUNAGU_SPREADSHEET_ID,
	PRJ_SHEET_TYPE_TSUNAGU_LONG => PRJ_SHEET_TYPE_TSUNAGU_LONG_SPREADSHEET_ID,
);
define( 'PRJ_SHEET_TYPE_KANTO_ZUKAN_FORM_SPREAD_ID', '1HwVaAk61WJQxprH3V6jlVzLi_vjsbHxH8D5YQsNcuaw'  );//
define( 'PRJ_SHEET_TYPE_TSUNAGU_FORM_SPREAD_ID', '1oEls_L7LQIxDadGGW4o77RKJxUhVh0Kc1V11EhPioZ0'  );//　
define( 'PRJ_SHEET_TYPE_TSUNAGU_LONG_FORM_SPREAD_ID', 'TSUNAGUv2'  );//　
$config['prj_sheet_type_form_spread_id_array'] = array(
	''=>'---',
	PRJ_SHEET_TYPE_KANTO_ZUKAN => PRJ_SHEET_TYPE_KANTO_ZUKAN_FORM_SPREAD_ID,
	PRJ_SHEET_TYPE_TSUNAGU => PRJ_SHEET_TYPE_TSUNAGU_FORM_SPREAD_ID,
	PRJ_SHEET_TYPE_TSUNAGU_LONG => PRJ_SHEET_TYPE_TSUNAGU_LONG_FORM_SPREAD_ID,
);

define( 'PRJ_MEMBER_TYPE_NONE', 0 );//
define( 'PRJ_MEMBER_TYPE_CHALLENGE', 1 );//
define( 'PRJ_MEMBER_TYPE_SUPPORT', 2 );//
define( 'PRJ_MEMBER_TYPE_CHALLENGE_NAME', '挑戦者'  );// アクティブ
define( 'PRJ_MEMBER_TYPE_SUPPORT_NAME', '支援者'  );//　非アクティブ
$config['prj_member_type_array'] = array(
	''=>'---',
	PRJ_MEMBER_TYPE_CHALLENGE => PRJ_MEMBER_TYPE_CHALLENGE_NAME,
	PRJ_MEMBER_TYPE_SUPPORT => PRJ_MEMBER_TYPE_SUPPORT_NAME,
);


define( 'PRJ_ACTIVE_STATUS_USED', 1 );// active_status
define( 'PRJ_ACTIVE_STATUS_NONE', 2 );//
define( 'PRJ_ACTIVE_STATUS_USED_NAME', 'アクティブ'  );// アクティブ
define( 'PRJ_ACTIVE_STATUS_NONE_NAME', '非アクティブ'  );//　非アクティブ
$config['active_status_array'] = array(
	''=>'---',
	PRJ_ACTIVE_STATUS_USED => PRJ_ACTIVE_STATUS_USED_NAME,
	PRJ_ACTIVE_STATUS_NONE => PRJ_ACTIVE_STATUS_NONE_NAME,
);


// 10件、50件、100件
$config['site_page_limit_array'] = array(
    10=>'10件',
    50=>'50件',
    100=>'100件',
);

$config['site_account_status_array'] = array(
    ''=>'-',
    STATUS_FLAG_ON => TEXT_STATUS_FLAG_ON,
    STATUS_FLAG_OFF => TEXT_STATUS_FLAG_OFF,
);


// ■ISP様が投入したデータにエラーがある場合のアラートメール
$config['site_alert_subject_1'] = '投入したデータにエラーがありました';
$config['site_alert_message_1'] = 'yyyy/mm/dd hh:mmに処理を行った
「%s」ファイルに
エラーがありました。

詳細は以下となります。ご確認をお願い致します。
依頼内容：%s
全体レコード数：%dレコード
エラーレコード数：%dレコード
エラーステータス：%s
';




