<?php

/**
 * user.php
 *
 * @access public
 * @author: aida
 * @version: 2021-01-15 20:57
 * @copyright FrogCompany Inc. All Rights Reserved
 *
 * @property user_model $userModel
 * @property Management $management
 * @property CI_Form_validation form_validation
 * @property CI_Pagination $pagination
 */

class User extends MY_Controller
{

    var $forms = array(
        array(
            'field' => 'form_admin_login',
            'label' => 'ログインID',
            'rules' => 'trim|required|min_length[4]|max_length[32]|callback_alpha_num_key_check'
        ),
        array(
            'field' => 'form_admin_name',
            'label' => '名前',
            'rules' => 'trim|required|max_length[32]'
        ),
        array(
            'field' => 'pass1',
            'label' => 'パスワード',
            'rules' => 'trim|max_length[32]|callback_check_alpha_and_num_len'
        ),
        array(
            'field' => 'pass2',
            'label' => 'パスワード(確認用)',
            'rules' => 'trim|max_length[32]|matches[pass1]'
        ),

    );

    var $formsNew = array(
        array(
            'field' => 'form_admin_login',
            'label' => 'ログインID',
            'rules' => 'trim|required|min_length[4]|max_length[32]|callback_alpha_num_key_check|is_unique[admin_user.admin_login]'
        ),
        array(
            'field' => 'form_admin_name',
            'label' => '名前',
            'rules' => 'trim|required|max_length[32]'
        ),
        array(
            'field' => 'pass1',
            'label' => 'パスワード',
            'rules' => 'trim|required|min_length[8]|max_length[32]|callback_check_alpha_and_num'
        ),
        array(
            'field' => 'pass2',
            'label' => 'パスワード(確認用)',
            'rules' => 'trim|required|min_length[8]|max_length[32]|matches[pass1]'
        ),

    );


    public function __construct()
    {
        parent::__construct();

        $this->data['site_account_status_array'] = $this->config->item('wi2_account_status_array');

        $this->load->library('user_agent');
        // IEチェック 何故かIEとかmozillaとか曖昧なあれなので
        $on_browser = array('Firefox', 'Chrome', 'Opera', 'Safari');
        if (in_array($this->agent->browser(), $on_browser)) {
            $this->data["button_on"] = TRUE;
        } else {
            $this->data["button_on"] = FALSE;
        }

        // 管理権限チェック
        $this->load->model('User_model', 'userModel');
        $admin = $this->userModel->checkAdminLevel($this->data['admin_login']);
        $this->data["admin"] = $admin;
        if ($admin['account_type'] < 1) {
            $redirectUrl = '/top/';
            redirect($redirectUrl);
            exit;
        }

        // パスワード有効期限チェック
        $passLimit = "";
        if ($admin["pass_updated_at"]) {
            $zanTime = strtotime(LOGIN_PASSWORD_LIMIT_DAY, strtotime($admin["pass_updated_at"])) - time();
            $zanDate = ceil($zanTime / (24 * 60 * 60));
            if ($zanDate > 0) {
                $passLimit = sprintf("あと%d日", $zanDate);
            }
        }

        $this->data["passLimit"] = $passLimit;
        // パスワード有効期限チェックここまで

        $params = array();

        $this->load->library('Management', $params);
        // フォームパラメータの初期値を入れる
        $this->data = array_merge($this->data, $this->management->setDefault($params));

        $form_admin_name = $this->input->post_get('form_admin_name');
        $form_admin_login = $this->input->post_get('form_admin_login');
        $pass1 = $this->input->post_get('pass1');
        $pass2 = $this->input->post_get('pass2');
        //
//		$access_user    = $this->input->post_get( 'access_user' );
        $account_type = $this->input->post_get('account_type');
        $account_status = $this->input->post_get('account_status');

        // フォーム取得
        $this->data["form_admin_name"] = $form_admin_name;
        $this->data["form_admin_login"] = $form_admin_login;
        $this->data["pass1"] = $pass1;
        $this->data["pass2"] = $pass2;
        //
//		$this->data["access_user"]    = $access_user;
        $this->data["account_type"] = $account_type;
        $this->data["account_status"] = $account_status;


        $this->load->library('form_validation');
        $this->load->library('pagination');

        $this->data['site_page_limit_array'] = $this->config->item('site_page_limit_array');

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

        if ($page > 0) {
            $page--;
        } else {
            $page = 0;
        }

        $offset = $page * $this->data['page_limit'];

        $search_val = $this->getSearchValue();

        $list = $this->userModel->getAdminUserList($offset, $this->data['page_limit'],
            $this->data["form_admin_name"], $this->data["form_admin_login"], $this->data["account_status"]);
        $total_rows = $this->userModel->getAdminUserList(0, ALL_COUNT_FLAG_AT_LIMIT,
            $this->data["form_admin_name"], $this->data["form_admin_login"], $this->data["account_status"]);
        //
        $config = $this->management->getPageConfig();
        //
        $config['base_url'] = '/user/page/';
        $config["total_rows"] = $total_rows;//
        // 1ページにいくつ表示するか設定する
        $config["per_page"] = $this->data['page_limit'];

        $config["suffix"] = '?'.http_build_query($search_val);//
	    $config['first_url'] = $config['base_url'].$config['suffix'];

        $this->pagination->initialize($config);
        $page_link = $this->pagination->create_links();

        $this->data['page_link'] = $page_link;

        $this->data["list"] = $list;

        $this->smarty->view('admin_user/user.tpl', $this->data);

    }

    /**
     * @param int $page
     */
    public function page($page = 0)
    {

        if ($page > 0) {
            $page--;
        } else {
            $page = 0;
        }

        $offset = $page * $this->data['page_limit'];

        $search_val = $this->getSearchValue();

        $list = $this->userModel->getAdminUserList($offset, $this->data['page_limit'],
            $this->data["form_admin_name"], $this->data["form_admin_login"], $this->data["account_status"]);
        $total_rows = $this->userModel->getAdminUserList(0, ALL_COUNT_FLAG_AT_LIMIT,
            $this->data["form_admin_name"], $this->data["form_admin_login"], $this->data["account_status"]);
        //
        $config = $this->management->getPageConfig();
        //
        $config['base_url'] = '/user/page/';
        $config["total_rows"] = $total_rows;//
        // 1ページにいくつ表示するか設定する
        $config["per_page"] = $this->data['page_limit'];

        $config["suffix"] = '?'.http_build_query($search_val);//
	    $config['first_url'] = $config['base_url'].$config['suffix'];

        $this->pagination->initialize($config);
        $page_link = $this->pagination->create_links();

        $this->data['page_link'] = $page_link;

        $this->data["list"] = $list;

        $this->smarty->view('admin_user/user.tpl', $this->data);

    }

    /**
     * @param array $search
     * @return array
     */
    function getSearchValue($search = array()){

        if ( $this->data["form_admin_name"] != "" ) {
            $search["form_admin_name"] = $this->data["form_admin_name"];
        }
        if ( $this->data["form_admin_login"] != "" ) {
            $search["form_admin_login"] = $this->data["form_admin_login"];
        }
        if ( $this->data["account_status"] != "" ) {
            $search["account_status"] = $this->data["account_status"];
        }
        return $search;
    }

    /**
     * @param int $id
     */
    public function edit($id = 0)
    {

        $this->load->library('form_validation');

        $back_button = $this->input->post_get('back_button');

        if ($id > 0) {
            $this->form_validation->set_rules($this->forms);
        } else {
            $this->form_validation->set_rules($this->formsNew);
        }

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if ($id > 0 && $back_button != "1") {
            $userData = $this->userModel->getAdminUserByAdminId($id);
            $this->data["user"] = $userData;
        } else {
            $this->data["user"] = $this->data;
        }

        $this->data["back_button"] = $back_button;
        //
        $this->data["id"] = $id;

        if ($this->form_validation->run() == FALSE || $back_button == "1") {
            $this->smarty->view('admin_user/user_edit.tpl', $this->data);
        } else {
            $this->smarty->view('admin_user/user_confirm.tpl', $this->data);
        }

    }

    /**
     * @param int $id
     */
    public function confirm($id = 0)
    {
        $this->data["id"] = $id;

        $this->smarty->view('admin_user/user_confirm.tpl', $this->data);
    }

    /**
     * @param int $id
     */
    public function complete($id = 0)
    {

        $userData = array(
            'admin_login' => $this->data["form_admin_login"],
            "admin_name" => $this->data["form_admin_name"],
//			"access_user" => $this->data["access_user"],
            "account_type" => $this->data["account_type"],
            "account_status" => $this->data["account_status"],
        );

	    $passHash = "";
	    if ($id == 0 || strlen($this->data["pass1"]) > 1) {
		    $passHash = password_hash($this->data["pass1"], PASSWORD_DEFAULT);
		    //
		    $userData['pass_hash'] = $passHash;
//		    if ($id == 0) {
		    $userData['pass_updated_at'] = date("Y-m-d 00:00:00");
//		    }
	    }

	    $new_id = $this->userModel->setUserData($id, $userData);

        if ($passHash != "") {
	        $this->userModel->insertPassHistory($new_id, $passHash);
        }

        // 登録したらリダイレクト
        $redirectUrl = $this->date['base_url'] . '/user/user_complete/' . $id;
        redirect($redirectUrl);
    }

    /**
     * @param int $id
     */
    public function user_complete($id = 0)
    {
        $this->data['id'] = $id;
        $this->smarty->view('admin_user/user_complete.tpl', $this->data);
    }

//    /**
//     * @param int $id
//     */
//    public function delete($id = 0)
//    {
//        // 削除処理
//        $this->userModel->setDelete($id, $this->data["admin"]['user_id']);
//
//        // 削除したらリダイレクト
//        $redirectUrl = $this->date['base_url'] . '/user/';
//        redirect($redirectUrl);
//    }

    /**
     * @param string $pass1
     * @return bool
     */
    function pass_age_check($pass1 = "")
    {
        $admin_id = $this->data["admin_id"]['admin_id'];
        if ($admin_id > 0) {
            $passHash = password_hash($pass1, PASSWORD_DEFAULT);

            $list = $this->userModel->getPassHistory($admin_id);
            foreach ($list as $record) {
                if ($record['pass_hash'] == $passHash) {
                    $this->form_validation->set_message('pass_age_check', '%s 過去に登録したパスワードが利用されています');
                    return FALSE;
                } else {
                    return TRUE;
                }
            }
            return TRUE;
        }
        $this->form_validation->set_message('pass_age_check', '%s 管理者IDが取れない');
        return FALSE;
    }


    /**
     * @param string $str
     * @return bool
     */
    function check_alpha_and_num($str = "")
    {

        if ($str == "") {
            return TRUE;
        }

        if (preg_match("/[0-9].*[a-zA-Z]|[a-zA-Z].*[0-9]/", $str)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_alpha_and_num', '%sは英字と数字両方を利用下さい');
            return FALSE;
        }

    }

    /**
     * @param string $str
     * @return bool
     */
    function check_alpha_and_num_len($str = "")
    {

        if ($str == "") {
            return TRUE;
        }

        if (strlen($str) < 8) {
            $this->form_validation->set_message('check_alpha_and_num_len', '%s欄は最低8文字以上でなければなりません');
            return FALSE;
        }

        if (preg_match("/[0-9].*[a-zA-Z]|[a-zA-Z].*[0-9]/", $str)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_alpha_and_num_len', '%sは英字と数字両方を利用下さい');
            return FALSE;
        }

    }

    /**
     * @param string $str
     * @return bool
     */
    function alpha_num_key_check($str = "")
    {
//	    if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[!-~]{0,100}+\z/i', $str)) {
        if (preg_match("/^[!-~]+$/", $str)) {
            return TRUE;
        }
        $this->form_validation->set_message('alpha_num_key_check', '%sは英数字・記号を利用下さい');
        return FALSE;
    }

}
