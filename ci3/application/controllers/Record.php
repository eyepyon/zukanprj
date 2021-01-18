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
            'field' => 'record_name',
            'label' => 'record名',
            'rules' => 'trim|required|max_length[250]'
        ),
        array(
            'field' => 'record_detail',
            'label' => 'record詳細',
            'rules' => 'trim|max_length[1500]'
        ),
//        array(
//            'field' => 'start_date',
//            'label' => '受付開始日',
//            'rules' => 'trim|required|max_length[128]'
//        ),
//        array(
//            'field' => 'end_date',
//            'label' => '受付終了日',
//            'rules' => 'trim|required|max_length[128]'
//        ),
//        array(
//            'field' => 'amount',
//            'label' => '実行可能額',
//            'rules' => 'trim|required|max_length[10]|numeric'
//        ),

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

        $record_name = $this->input->post_get('record_name');
        $record_detail = $this->input->post_get('record_detail');
//        $start_date = $this->input->post_get('start_date');
//        $end_date = $this->input->post_get('end_date');
//        $amount = $this->input->post_get('amount');

        $this->data['record_name'] = $record_name;
        $this->data['record_detail'] = $record_detail;
//        $this->data['start_date'] = $start_date;
//        $this->data['end_date'] = $end_date;
//        $this->data['amount'] = $amount;

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
        $list = $this->recordModel->getRecordList($offset, $this->data['page_limit'], $this->data["record_name"], $this->data["record_detail"], STATUS_FLAG_ON);
        $total_rows = $this->recordModel->getRecordList(0, ALL_COUNT_FLAG_AT_LIMIT, $this->data['record_name'], $this->data['record_detail'], STATUS_FLAG_ON);

        foreach ($list as $key => $record){
            $list[$key]["popup_url"] = $this->getPopup($record['record_id'],PRJ_MEMBER_TYPE_CHALLENGE);
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
        $list = $this->recordModel->getRecordList($offset, $this->data['page_limit'], $this->data["record_name"], $this->data["record_detail"], STATUS_FLAG_ON);
        $total_rows = $this->recordModel->getRecordList(0, ALL_COUNT_FLAG_AT_LIMIT, $this->data['record_name'], $this->data['record_detail'], STATUS_FLAG_ON);

        foreach ($list as $key => $record){
            $list[$key]["popup_url"] = $this->getPopup($record['record_id'],PRJ_MEMBER_TYPE_CHALLENGE);
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
     * @param int $record_id
     */
    public function edit($record_id = 0)
    {

        $this->data['error_word'] = "";
        $this->data['record_id'] = $record_id;

        $back_button = $this->input->post_get('back_button');
        //
        $mode = $this->input->post('mode');

        if ($record_id > 0) {
            $record = $this->recordModel->getByRecordId($record_id);
            $this->data['record'] = $record;
            //
            if ($mode != 'edit') {
                $this->data['record_name'] = $record['record_name'];
                $this->data['record_detail'] = $record['record_detail'];
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
     * @param int $record_id
     */
    public function action($record_id = 0)
    {
        $this->data['record_id'] = $record_id;

        $record = array(
            'user_id' => (int)sprintf('%d', $this->data['user_id']),
            'record_name' => $this->data['record_name'],
            'record_detail' => $this->data['record_detail'],
            'status' => STATUS_FLAG_ON,
        );

        $this->recordModel->setRecordData($record_id, $record);

        redirect('/record/complete/');
    }

    /**
     * @param int $record_id
     */
    public function complete($record_id = 0)
    {
        $this->data['record_id'] = $record_id;

        $this->smarty->view('record/record_complete.tpl', $this->data);
    }

    /**
     * @param int $record_id
     */
    public function picture($record_id = 0)
    {
        $this->data['record_id'] = $record_id;

        $this->smarty->view('record/picture.tpl', $this->data);
    }

    /**
     * @param int $record_id
     */
    public function vrm($record_id = 0)
    {
        $this->data['record_id'] = $record_id;

        $this->smarty->view('record/vrm.tpl', $this->data);
    }

    var $fileMaxSize = 5000000;

    /**
     * @param int $record_id
     */
    public function picture_upload($record_id = 0)
    {

        $path = '/var/www/shukin/html/files/';
        $file_name = sprintf('%d_%s.jpg', $record_id, time());

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
     * @param int $record_id
     */
    public function vrm_upload($record_id = 0)
    {

        $path = '/var/www/shukin/html/files/';
        $file_name = sprintf('%d_%s.vrm', $record_id, time());

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
     * @param int $record_id
     */
    public function picture_action($record_id = 0)
    {
        $this->data['record_id'] = $record_id;

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

        $this->recordModel->setRecordData($record_id, $record);

        redirect('/record/picture_complete/');
    }

    /**
     * @param int $record_id
     */
    public function picture_complete($record_id = 0)
    {
        $this->data['record_id'] = $record_id;

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
        $record_id = (int)sprintf('%d', trim($p[0]));

        $this->data['file_name'] = rawurldecode($file_name);
        $this->data['record_id'] = $record_id;

        $this->smarty->view('record/picture_confirm.tpl', $this->data);
    }

    public function vrm_confirm($file_name = '')
    {
        $p = explode('_', $file_name);
        //
        $record_id = (int)sprintf('%d', trim($p[0]));

        $this->data['file_name'] = rawurldecode($file_name);
        $this->data['record_id'] = $record_id;

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
     * @param int $record_id
     */
    public function detail($record_id = 0)
    {
        $this->data['record_id'] = $record_id;
        $record = $this->recordModel->getByRecordId($record_id);
        if (!$record) {
            redirect('/record/');
        }

        $this->data["wallet_address"] = '';
        $this->data["wallet_url"] = "";

        if (!isset($record["wallet_address"]) || $record["wallet_address"] == "") {

            $wallet = $this->nemModel->account_generate();
            if ($wallet) {
                $wallet_address = $wallet["address"];
                $public_key = $wallet["publicKey"];
                $private_key = $wallet["privateKey"];

                $setData = array();
                $setData["wallet_address"] = $wallet_address;
                $setData["wallet_pubkey"] = $public_key;
                $setData["wallet_prikey"] = $private_key;
                //
                $this->recordModel->setRecordData($record["record_id"], $setData);

                $record["wallet_address"] = $wallet_address;
                $record["wallet_pubkey"] = $public_key;
                $record["wallet_prikey"] = $private_key;
            }
        }

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
//        $goalList = $this->recordModel->getGoalHistory($record_id);
//        foreach ($list as $item) {
//
//        }
        $this->data["goal_list"] = $goalList;

        $walletData = $this->nemModel->account_get($record["wallet_address"]);
        //
        $mosaic_all = $this->nemModel->account_mosaic($record["wallet_address"]);

        if (isset($mosaic_all["data"])) {
            foreach ($mosaic_all["data"] as $record) {
                log_message('debug', "mosaic" . print_r($record, true));

                if (isset($record['quantity']) && isset($record['mosaicId']["name"])) {
                    $walletData["mosaic"][$record['mosaicId']["name"]] = $record['quantity'];
                }
            }
        }

        $this->data["walletData"] = $walletData;
        $this->data["popup_url"] = $this->getPopup($record_id,PRJ_MEMBER_TYPE_CHALLENGE);

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
    private function getPopup($id = 0,$code_type=IN_CODE_TYPE_USER)
    {
        if($code_type == IN_CODE_TYPE_USER){
            $id += IN_CODE_ADD_ID;
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

        if ($this->data["record_name"] != "") {
            $search["record_name"] = $this->data["record_name"];
        }
        if ($this->data["record_detail"] != "") {
            $search["record_detail"] = $this->data["record_detail"];
        }
        return $search;
    }

}


