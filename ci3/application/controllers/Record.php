<?php

/**
 * record.php
 *
 * @access public
 * @author: aida
 * @version: 2021-01-16 11:11
 * @copyright FrogCompany Inc. All Rights Reserved
 *
 * @property CI_Form_validation form_validation
 * @property CI_Pagination $pagination
 * @property Management $management
 * @property User_model $userModel
 * @property Record_model $recordModel
 */

class Record extends MY_Controller
{


    var $forms = array(
        array(
            'field' => 'name',
            'label' => '名前',
            'rules' => 'trim|required|max_length[250]'
        ),
        array(
            'field' => 'detail',
            'label' => '詳細',
            'rules' => 'trim|max_length[1500]'
        ),
        array(
            'field' => 'email',
            'label' => 'メールアドレス',
            'rules' => 'trim|required|max_length[128]'
        ),
        array(
            'field' => 'facebook',
            'label' => 'Facebookアカウント',
            'rules' => 'trim|required|max_length[128]'
        ),
        array(
            'field' => 'twitter',
            'label' => 'Twitterアカウント',
            'rules' => 'trim|max_length[128]'
        ),
		array(
			'field' => 'name_kana',
			'label' => '名前（カタカナ）',
			'rules' => 'trim|required|max_length[100]'
		),
		array(
			'field' => 'qualification',
			'label' => '保有する資格',
			'rules' => 'trim|max_length[1000]'
		),
		array(
			'field' => 'community',
			'label' => '所属団体/コミュニティ（会社以外）',
			'rules' => 'trim|max_length[1000]'
		),
		array(
			'field' => 'study',
			'label' => '学びたいことやってみたいこと',
			'rules' => 'trim|max_length[1000]'
		),
		array(
			'field' => 'contribute',
			'label' => '教えられること貢献できること',
			'rules' => 'trim|max_length[1000]'
		),
		array(
			'field' => 'most_area',
			'label' => '最も取り組みたい領域・分野',
			'rules' => 'trim|max_length[1000]'
		),
		array(
			'field' => 'enthusiasm',
			'label' => '頑張りたいこと＆意気込み',
			'rules' => 'trim|max_length[1000]'
		),
    );

//    var $form_spot = array(
//        array(
//            'field' => 'lng',
//            'label' => 'SFTPフォルダ',
//            'rules' => 'trim|required|max_length[128]'
//        ),
//        array(
//            'field' => 'lat',
//            'label' => 'Spot名称',
//            'rules' => 'trim|required|max_length[128]'
//        ),
//
//    );


    public function __construct()
    {
        parent::__construct();

        $this->load->model('Record_model', 'recordModel');

        $params = array();
        $this->load->library('Management', $params);
        $this->load->library('form_validation');
        $this->load->library('pagination');

        $this->data['base_url'] = $this->config->item('base_url');
        $this->data['site_page_limit_array'] = $this->config->item('site_page_limit_array');

        if ($this->session->userdata('loggedIn') == true) {
            // ログイン済み
            $userData = $this->session->userdata('userData');
            $this->data['user_id'] = $userData['user_id'];
        } else {
            // ログインしてない
            $this->data['user_id'] = 0;
        }
        // アラート未読数
        $this->data['alert_count'] = 0;
        // メッセージ未読数
        $this->data['message_count'] = 0;

        $this->data["show_menu"]['record'] = ' show';
        $this->data["show_menu"]['project'] = '';
        $this->data["show_menu"]['user'] = '';

        $this->data["salt_wd"] = '?dmy='.date('U');

        $name = $this->input->post_get('name');
        $detail = $this->input->post_get('detail');
		$name_kana = $this->input->post_get('name_kana');
		$email = $this->input->post_get('email');
		$facebook_account = $this->input->post_get('facebook_account');
		$twitter_account = $this->input->post_get('twitter_account');
		$qualification = $this->input->post_get('qualification');
		$community = $this->input->post_get('community');
		$study = $this->input->post_get('study');
		$contribute = $this->input->post_get('contribute');
		$most_area = $this->input->post_get('most_area');
		$enthusiasm = $this->input->post_get('enthusiasm');

		$this->data['name'] = $name;
        $this->data['detail'] = $detail;
		$this->data['name_kana'] = $name_kana;
		$this->data['email'] = $email;
		$this->data['facebook_account'] = $facebook_account;
		$this->data['twitter_account'] = $twitter_account;
		$this->data['qualification'] = $qualification;
		$this->data['community'] = $community;
		$this->data['study'] = $study;
		$this->data['contribute'] = $contribute;
		$this->data['most_area'] = $most_area;
		$this->data['enthusiasm'] = $enthusiasm;

        // ページ表示数設定
        $ck_page_limit = $this->session->userdata('page_limit');
        if ((int)sprintf("%d", $ck_page_limit) < 1) {
            $ck_page_limit = 10;
        }
        $page_limit = $this->input->post_get('page_limit');
        if ($page_limit >= 10 && $page_limit != $ck_page_limit) {
            $this->session->set_userdata(array('page_limit' => $page_limit));
            $this->data['page_limit'] = $page_limit;
        } else {
            $this->data['page_limit'] = $ck_page_limit;
        }
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->data['error_word'] = "";

        $search = $this->input->post_get('search');
        $this->data['search'] = $search;
        $search_val = $this->getSearchValue();

        $offset = $page * $this->data['page_limit'];
        $list = $this->recordModel->getRecordList($offset, $this->data['page_limit'], $this->data["name"], $this->data["detail"], STATUS_FLAG_ON);
        $total_rows = $this->recordModel->getRecordList(0, ALL_COUNT_FLAG_AT_LIMIT, $this->data['name'], $this->data['detail'], STATUS_FLAG_ON);

        foreach ($list as $key => $record){
            $list[$key]["popup_url"] = $this->getPopup($record['id'],PRJ_MEMBER_TYPE_CHALLENGE);
        }

        $this->data["list"] = $list;
        // ページング用
        $config = $this->management->getPageConfig();
        $config['base_url'] = '/record/page/';
        $config["total_rows"] = $total_rows;//
        $config["per_page"] = $this->data['page_limit']; // 1ページにいくつ表示するか設定する
        $config["suffix"] = '?' . http_build_query($search_val);//
        $this->pagination->initialize($config);
        $page_link = $this->pagination->create_links();
        $this->data['page_link'] = $page_link;

        $this->smarty->view('record/record.tpl', $this->data);
    }

    /**
     * @param int $page
     */
    public function page($page = 0)
    {
        $this->data['error_word'] = "";

        $search = $this->input->post_get('search');
        $this->data['search'] = $search;
        $search_val = $this->getSearchValue();

        $offset = $page * $this->data['page_limit'];
        $list = $this->recordModel->getRecordList($offset, $this->data['page_limit'], $this->data["name"], $this->data["detail"], STATUS_FLAG_ON);
        $total_rows = $this->recordModel->getRecordList(0, ALL_COUNT_FLAG_AT_LIMIT, $this->data['name'], $this->data['detail'], STATUS_FLAG_ON);

        foreach ($list as $key => $record){
            $list[$key]["popup_url"] = $this->getPopup($record['id'],PRJ_MEMBER_TYPE_CHALLENGE);
        }

        $this->data["list"] = $list;
        // ページング用
        $config = $this->management->getPageConfig();
        $config['base_url'] = '/record/page/';
        $config["total_rows"] = $total_rows;//
        $config["per_page"] = $this->data['page_limit']; // 1ページにいくつ表示するか設定する
        $config["suffix"] = '?' . http_build_query($search_val);//
        $this->pagination->initialize($config);
        $page_link = $this->pagination->create_links();
        $this->data['page_link'] = $page_link;

        $this->smarty->view('record/record.tpl', $this->data);
    }


    /**
     * @param int $id
     */
    public function edit($id = 0)
    {

        $this->data['error_word'] = "";
        $this->data['id'] = $id;

        $back_button = $this->input->post_get('back_button');
        //
        $mode = $this->input->post('mode');

//		$this->data['email'] = "";//
//		$this->data['facebook_account'] = "";//
//		$this->data['twitter_account'] = "";//
//		$this->data['name_kana'] = "";// 名前（カタカナ）
//		$this->data['qualification'] = "";// 保有する資格
//		$this->data['community'] = "";// 所属団体/コミュニティ（会社以外）
//		$this->data['study'] = "";// 学びたいことやってみたいこと
//		$this->data['contribute'] = "";// 教えられること貢献できること
//		$this->data['most_area'] = "";// 最も取り組みたい領域・分野
//		$this->data['enthusiasm'] = "";// 頑張りたいこと＆意気込み

		if ($id > 0) {
            $record = $this->recordModel->getByRecordId($id);
            $this->data['record'] = $record;
            //
            if ($mode != 'edit') {
                $this->data['name'] = $record['name'];//
                $this->data['detail'] = $record['detail'];//
				$this->data['email'] = $record['email'];//
				$this->data['facebook_account'] = $record['facebook_account'];//
				$this->data['twitter_account'] = $record['twitter_account'];//
				$this->data['name_kana'] = $record['name_kana'];// 名前（カタカナ）
				$this->data['qualification'] = $record['qualification'];// 保有する資格
				$this->data['community'] = $record['community'];// 所属団体/コミュニティ（会社以外）
				$this->data['study'] = $record['study'];// 学びたいことやってみたいこと
				$this->data['contribute'] = $record['contribute'];// 教えられること貢献できること
				$this->data['most_area'] = $record['most_area'];// 最も取り組みたい領域・分野
				$this->data['enthusiasm'] = $record['enthusiasm'];// 頑張りたいこと＆意気込み
            }
        }

        $this->form_validation->set_rules($this->forms);
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if ($this->form_validation->run() == FALSE || $back_button == "1") {
            $this->smarty->view('record/record_edit.tpl', $this->data);
        } else {
            $this->smarty->view('record/record_confirm.tpl', $this->data);
        }
    }

    /**
     * @param int $id
     */
    public function action($id = 0)
    {
        $this->data['id'] = $id;

        $record = array(
            'user_id' => (int)sprintf('%d', $this->data['user_id']),
            'name' => $this->data['name'],
            'detail' => $this->data['detail'],
			'name_kana' => $this->data['name_kana'],
			'email' => $this->data['email'],
			'facebook_account' => $this->data['facebook_account'],
			'twitter_account' => $this->data['twitter_account'],
			'qualification' => $this->data['qualification'],
			'community' => $this->data['community'],
			'study' => $this->data['study'],
			'contribute' => $this->data['contribute'],
			'most_area' => $this->data['most_area'],
			'enthusiasm' => $this->data['enthusiasm'],
            'status' => STATUS_FLAG_ON,
        );

        $this->recordModel->setRecordData($id, $record);

        redirect('/record/complete/');
    }

    /**
     * @param int $id
     */
    public function complete($id = 0)
    {
        $this->data['id'] = $id;

        $this->smarty->view('record/record_complete.tpl', $this->data);
    }

    /**
     * @param int $id
     */
    public function picture($id = 0)
    {
        $this->data['id'] = $id;

        $this->smarty->view('record/picture.tpl', $this->data);
    }

    /**
     * @param int $id
     */
    public function vrm($id = 0)
    {
        $this->data['id'] = $id;

        $this->smarty->view('record/vrm.tpl', $this->data);
    }

    var $fileMaxSize = 5000000;

    /**
     * @param int $id
     */
    public function picture_upload($id = 0)
    {

        $path = '/var/www/shukin/html/files/';
        $file_name = sprintf('%d_%s.jpg', $id, time());

        $config = array(
            'file_name' => $file_name,
            'upload_path' => $path,
            'max_filename' => 200,
            'max_size' => 50000, // K
            'allowed_types' => 'jpg',
//          'allowed_types' => '*',
        );
        log_message('debug', 'FILE_DATA:' . print_r($_FILES, true));

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $file_info = $this->upload->data();
            log_message('debug', 'FILE_INFO:' . print_r($file_info, true));
            $file_name = $file_info['file_name'];
            $jumpUrl = '/record/picture_confirm/' . rawurlencode($file_name);
//          $mes = 'UPロードが完了しました';
        } else {
            $mes = 'アップロードエラー';
            $jumpUrl = '/record/picture_fail/' . rawurlencode($mes);
        }

        redirect($jumpUrl);
    }

    /**
     * @param int $id
     */
    public function vrm_upload($id = 0)
    {

        $path = '/var/www/shukin/html/files/';
        $file_name = sprintf('%d_%s.vrm', $id, time());

        $config = array(
            'file_name' => $file_name,
            'upload_path' => $path,
            'max_filename' => 200,
            'max_size' => 300000, // K
//            'allowed_types' => 'vrm',
          'allowed_types' => '*',
        );
        log_message('debug', 'FILE_DATA:' . print_r($_FILES, true));

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $file_info = $this->upload->data();
            log_message('debug', 'FILE_INFO:' . print_r($file_info, true));
            $file_name = $file_info['file_name'];
            $jumpUrl = '/record/vrm_confirm/' . rawurlencode($file_name);
//          $mes = 'UPロードが完了しました';
        } else {
            $mes = 'アップロードエラー';
            $jumpUrl = '/record/picture_fail/' . rawurlencode($mes);
        }

        redirect($jumpUrl);
    }

    /**
     * @param int $id
     */
    public function picture_action($id = 0)
    {
        $this->data['id'] = $id;

        $file_name = $this->input->post('file_name');

     // vrmファイルの場合
        if(strpos($file_name,'.vrm') !== false){
            $record = array(
                'vrm_file' => $file_name,
            );
        }else{
            $record = array(
                'picture_file' => $file_name,
            );
        }

        $this->recordModel->setRecordData($id, $record);

        redirect('/record/picture_complete/');
    }

    /**
     * @param int $id
     */
    public function picture_complete($id = 0)
    {
        $this->data['id'] = $id;

        $this->smarty->view('record/picture_complete.tpl', $this->data);
    }

    /**
     * @param string $mess
     */
    public function picture_fail($mess = '')
    {

        $this->smarty->view('record/picture_fail.tpl', $this->data);
    }

    /**
     * @param string $file_name
     */
    public function picture_confirm($file_name = '')
    {
        $p = explode('_', $file_name);
        //
        $id = (int)sprintf('%d', trim($p[0]));

        $this->data['file_name'] = rawurldecode($file_name);
        $this->data['id'] = $id;

        $this->smarty->view('record/picture_confirm.tpl', $this->data);
    }

    public function vrm_confirm($file_name = '')
    {
        $p = explode('_', $file_name);
        //
        $id = (int)sprintf('%d', trim($p[0]));

        $this->data['file_name'] = rawurldecode($file_name);
        $this->data['id'] = $id;

        $this->smarty->view('record/vrm_confirm.tpl', $this->data);
    }


    public function vr()
    {
        $google_api_key = getenv('GOOGLE_API_KEY');

        $lat = $this->input->get("lat");
        $lng = $this->input->get("lng");
        $this->data["g_location"] = "&location=" . $lat . ',' . $lng;

        $this->data["g_keys"] = sprintf("&key=%s", $google_api_key);
        $this->smarty->view('record/vr.tpl', $this->data);
    }

    /**
     * @param int $id
     */
    public function detail($id = 0)
    {
        $this->data['id'] = $id;
        $record = $this->recordModel->getByRecordId($id);
        if (!$record) {
            redirect('/record/');
        }

        $this->data["wallet_address"] = '';
        $this->data["wallet_url"] = "";

        $this->data['record'] = $record;

        $this->data["wallet_json"] = '';
        if (isset($record["wallet_address"]) && strlen($record["wallet_address"]) > 5) {
            $this->data["wallet_json"] = urlencode('{
  "type" : 1,
  "data" : {
    "addr" : "' . $record["wallet_address"] . '",
    "name" : "dnt"
  },
  "v" : 2
}');
        }

        $this->data["wallet_address"] = $record["wallet_address"];

        $goalList = array();
//        $goalList = $this->recordModel->getGoalHistory($id);
//        foreach ($list as $item) {
//
//        }
        $this->data["goal_list"] = $goalList;

//        $walletData = $this->nemModel->account_get($record["wallet_address"]);
//        //
//        $mosaic_all = $this->nemModel->account_mosaic($record["wallet_address"]);

        if (isset($mosaic_all["data"])) {
            foreach ($mosaic_all["data"] as $record) {
                log_message('debug', "mosaic" . print_r($record, true));

                if (isset($record['quantity']) && isset($record['mosaicId']["name"])) {
                    $walletData["mosaic"][$record['mosaicId']["name"]] = $record['quantity'];
                }
            }
        }

//        $this->data["walletData"] = $walletData;
        $this->data["popup_url"] = $this->getPopup($id,PRJ_MEMBER_TYPE_CHALLENGE);

        $this->smarty->view('record/detail.tpl', $this->data);
    }

    /**
     * @param int $user_id
     */
    public function qr($user_id = 0)
    {
        $link_enc_dec_method = getenv('LINK_ENC_DEC_METHOD');// 暗号化方式
        $link_enc_dec_pass = getenv('LINK_ENC_DEC_PASS');// パスワード
        $iv = getenv('LINK_ENC_DEC_IV');// iv

        $encrypted = bin2hex(openssl_encrypt($user_id, $link_enc_dec_method, $link_enc_dec_pass, OPENSSL_RAW_DATA, $iv));

        $this->data["wallet_url"] = 'https://shukin.pw/in/' . $encrypted . '/';
//      $this->data["wallet_url"] = urlencode('https://shukin.pw/in/' . $encrypted . '/');

        $this->smarty->view('record/record_qr.tpl', $this->data);
    }

    /**
     * @param int $id
     * @param int $code_type
     * @return string
     */
    private function getPopup($id = 0,$code_type=PRJ_MEMBER_TYPE_SUPPORT)
    {
        if($code_type == PRJ_MEMBER_TYPE_SUPPORT){
//            $id += IN_CODE_ADD_ID;
        }

        $attr = array(
            'width' => '240',
            'height' => '380',
            'scrollbars' => 'no',
            'status' => 'no',
            'resizable' => 'no',
            'screenx' => '200',
            'class' => 'btn btn-success',
        );
        $pop = anchor_popup(
            '/record/qr/'.$id,
            'RecordQR',
            $attr
        );
        return $pop;
    }


    /**
     * @param array $search
     * @return array
     */
    private function getSearchValue($search = array())
    {

        if ($this->data["name"] != "") {
            $search["name"] = $this->data["name"];
        }
        if ($this->data["detail"] != "") {
            $search["detail"] = $this->data["detail"];
        }
        return $search;
    }

}


