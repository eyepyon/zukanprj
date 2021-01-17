<?php

/**
 * password.php
 *
 * @author: aida
 * @version: 2020-01-16 15:09
 *
 * @property User_model $userModel
 * @property Management $management
 * @property CI_Form_validation form_validation
 *
 */

class Password extends MY_Controller
{

    var $forms = array(
        array(
            'field' => 'pass_old',
            'label' => '現在のパスワード',
            'rules' => 'trim|required|max_length[100]|callback_pass_check'
        ),
        array(
            'field' => 'pass1',
            'label' => '新しいパスワード',
            'rules' => 'trim|required|min_length[8]|max_length[100]|callback_check_alpha_and_num'
        ),
        array(
            'field' => 'pass2',
            'label' => '新しいパスワード(確認用)',
            'rules' => 'trim|required|min_length[8]|max_length[100]|matches[pass1]'
        ),

    );


    public function __construct()
    {
        parent::__construct();

        // 管理権限チェック用
        $this->load->model('User_model', 'userModel');
        $admin = $this->userModel->checkAdminLevel($this->data['user_account']);
        //
        $this->data["admin"] = $admin;

        // パスワード有効期限チェック
        $passLimit = "";
        $this->data["passLimit"] = $passLimit;

        $params = array();

        $this->data['time_id'] = 0;
        $this->data['set_status'] = 0;
        //
        $params['year'] = date('Y');
        $params['month'] = date('m');
        $params['day'] = date('d');
        $params['hour'] = date('H');
        $params['minute'] = date('i');
        //

        $this->load->library('Management', $params);
        // フォームパラメータの初期値を入れる
        $this->data = array_merge($this->data, $this->management->setDefault($params));

        $pass_old = $this->input->post('pass_old');
        $pass1 = $this->input->post('pass1');
        $pass2 = $this->input->post('pass2');

        // フォーム取得
        $this->data["formYear"] = $this->management->getYearArray();
        $this->data["formMonth"] = $this->management->getMonthArray();
        $this->data["formDay"] = $this->management->getDayArray();
        $this->data["formHour"] = $this->management->getHourArray();
        $this->data["formMinute"] = $this->management->getMinuteArray();

        $this->data["pass_old"] = $pass_old;
        $this->data["pass1"] = $pass1;
        $this->data["pass2"] = $pass2;

    }

    public function index()
    {

        $this->data['passLimitError'] = "";

        $this->load->library('form_validation');

        $this->form_validation->set_rules($this->forms);
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if ($this->form_validation->run() == FALSE) {
            $this->smarty->view('password/password.tpl', $this->data);
        } else {
            $this->smarty->view('password/password_confirm.tpl', $this->data);
        }

    }

    public function complete()
    {

        $passHash = password_hash($this->data["pass1"], PASSWORD_DEFAULT);
        //
        $userData = array(
            'pass_hash' => $passHash,
//            'pass_update_datetime' => date("Y-m-d 00:00:00"),
        );

        $this->userModel->setUserData($this->data["admin"]['admin_id'], $userData);

        // 登録したらリダイレクト
        $redirectUrl = $this->date['base_url'] . '/top/';
        redirect($redirectUrl);
    }


    /**
     * @param string $pass
     * @return bool
     */
    function pass_check($pass = "")
    {

        $user_account = $this->data['admin']['user_account'];

        if ($this->userModel->getAdminUser($user_account, $pass)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('pass_check', '「%s」パスワードが違います');
            return FALSE;
        }
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

}
