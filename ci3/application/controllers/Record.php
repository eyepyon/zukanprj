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
            'rules' => 'trim|required|max_length[100]'
        ),
		array(
			'field' => 'name_kana',
			'label' => '名前（カタカナ）',
			'rules' => 'trim|required|max_length[100]'
		),
        array(
            'field' => 'facebook_account',
            'label' => 'Facebookアカウント',
            'rules' => 'trim|required|max_length[128]|callback_fb_name_check'
        ),
        array(
            'field' => 'twitter_account',
            'label' => 'Twitterアカウント',
            'rules' => 'trim|alpha_numeric|max_length[128]'
        ),
//		array(
//			'field' => 'email',
//			'label' => 'メールアドレス',
//			'rules' => 'trim|required|max_length[128]'
//		),

		array(
			'field' => 'attribute',
			'label' => '属性',
			'rules' => 'trim|exact_length[1]|greater_than_equal_to[1]'
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


//		array(
//			'field' => 'detail',
//			'label' => '詳細',
//			'rules' => 'trim|max_length[1500]'
//		),
    );


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

		$array_attribute = array(
			"","社会人","学生"
		);
        $this->data['array_attribute'] = $array_attribute;
		$this->data['validation_errors']= "";

        $name = $this->input->post_get('name');
		$name_kana = $this->input->post_get('name_kana');
		$facebook_account = $this->input->post_get('facebook_account');
		$twitter_account = $this->input->post_get('twitter_account');
//		$email = $this->input->post_get('email');
		$attribute = $this->input->post_get('attribute');
		$study = $this->input->post_get('study');
		$contribute = $this->input->post_get('contribute');
		$most_area = $this->input->post_get('most_area');
		$enthusiasm = $this->input->post_get('enthusiasm');
		$qualification = $this->input->post_get('qualification');
		$community = $this->input->post_get('community');
		$detail = $this->input->post_get('detail');

		$this->data['name'] = $name;
		$this->data['name_kana'] = $name_kana;
		$this->data['facebook_account'] = $facebook_account;
		$this->data['twitter_account'] = $twitter_account;
//		$this->data['email'] = $email;
		$this->data['attribute'] = $attribute;
		$this->data['study'] = $study;
		$this->data['contribute'] = $contribute;
		$this->data['most_area'] = $most_area;
		$this->data['enthusiasm'] = $enthusiasm;
		$this->data['qualification'] = $qualification;
		$this->data['community'] = $community;
		$this->data['detail'] = $detail;

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

		if ($id > 0) {
            $record = $this->recordModel->getByRecordId($id);
            $this->data['record'] = $record;
            //
            if ($mode != 'edit') {
                $this->data['name'] = $record['name'];//
				$this->data['name_kana'] = $record['name_kana'];// 名前（カタカナ）
				$this->data['facebook_account'] = $record['facebook_account'];//
				$this->data['twitter_account'] = $record['twitter_account'];//
//				$this->data['email'] = $record['email'];//
				$this->data['attribute'] = $record['attribute'];//;
				$this->data['study'] = $record['study'];// 学びたいことやってみたいこと
				$this->data['contribute'] = $record['contribute'];// 教えられること貢献できること
				$this->data['most_area'] = $record['most_area'];// 最も取り組みたい領域・分野
				$this->data['enthusiasm'] = $record['enthusiasm'];// 頑張りたいこと＆意気込み
				$this->data['qualification'] = $record['qualification'];// 保有する資格
				$this->data['community'] = $record['community'];// 所属団体/コミュニティ（会社以外）
//				$this->data['detail'] = $record['detail'];//
            }
        }

		$this->form_validation->set_data($this->data);
        $this->form_validation->set_rules($this->forms);
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');


        if ($this->form_validation->run() == FALSE || $back_button == "1") {
        	if($back_button != "1"){
				if ($mode == 'edit') {
					$this->data['validation_errors'] = validation_errors();
				}
			}

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
			'name_kana' => $this->data['name_kana'],
			'facebook_account' => $this->data['facebook_account'],
			'twitter_account' => $this->data['twitter_account'],
//			'email' => $this->data['email'],
			'attribute' => $this->data['attribute'],
			'study' => $this->data['study'],
			'contribute' => $this->data['contribute'],
			'most_area' => $this->data['most_area'],
			'enthusiasm' => $this->data['enthusiasm'],
			'qualification' => $this->data['qualification'],
			'community' => $this->data['community'],
            'status' => STATUS_FLAG_ON,
//			'detail' => $this->data['detail'],
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
        $goalList = array();
        $this->data["goal_list"] = $goalList;

//        $this->data["popup_url"] = $this->getPopup($id,PRJ_MEMBER_TYPE_CHALLENGE);
		$this->data["popup_url"] = "";

        $this->smarty->view('record/record_detail.tpl', $this->data);
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


	/**
	 * @param string $str
	 * @return bool
	 */
	public function fb_name_check($str = "")
	{
		if (preg_match("/^[a-zA-Z0-9_\.\-]+$/", $str)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('fb_name_check', '正しいFacebookアカウントを入れてください。');
			return FALSE;
		}
	}

}


