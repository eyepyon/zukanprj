<?php

/**
 * login.php
 *
 * @author: aida
 * @version: 2021-01-16 20:02
 *
 * @property User_model $userModel
 * @property Management $management
 * @property CI_Form_validation form_validation
 * @property CI_Session $session
 * @property Facebook $facebook
 */
class Login extends MY_Controller
{

    var $forms = array(
        array(
            'field' => 'user_account',
            'label' => 'ログインID',
            'rules' => 'trim|required|min_length[3]|max_length[32]|alpha_numeric'
        ),
        array(
            'field' => 'password',
            'label' => 'パスワード',
            'rules' => 'trim|required|min_length[8]|max_length[32]|callback_check_alpha_and_num'
        ),
    );

    public function __construct()
    {
        parent::__construct();

        $this->load->library('user_agent');

        $this->load->model('User_model', 'userModel');

        $this->data['base_url'] = $this->config->item('base_url');

        $u = $this->input->get_post('u');
        //
        $this->data['u'] = $u;
		$this->data['base_url'] = "https://dev.zukan.cloud/";

	}

    public function index()
    {
        $this->data['error_word'] = "";
        $this->data['login_url'] = $this->facebook->login_url();

        $this->smarty->view('login.tpl', $this->data);
    }


//    public function confirm()
//    {
//
//        $user_account = $this->input->post('user_account');
//        $pass = $this->input->post('password');
//        //
//        $this->data['user_account'] = $user_account;
//
//        $login = $this->userModel->getAdminUser($user_account, $pass);
//
//        $this->load->library('form_validation');
//
//        $this->form_validation->set_rules($this->forms);
//        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
//
//        if ($this->form_validation->run() == FALSE) {
//            $login = FALSE;
//        }
//        $this->data['error_word'] = '<div class="text-danger">ログインIDまたはパスワードが間違っております。</div>';
//
//        if ($login == FALSE) {
//            $this->smarty->view('login.tpl', $this->data);
//        } else {
//            $this->data['error_word'] = "";
//            $redirectUrl = '/top/';
//
//            $userData = array(
//                'user_account' => $user_account,
//                'user_id' => $login['user_id'],
////				'user_name' => $login,
//                'login' => TRUE
//            );
//
//            $this->session->set_userdata($userData);
//
//            redirect($redirectUrl, 'refresh');
//            exit;
//        }
//
//    }


    public function fb_callback()
    {
        $user = $this->facebook->request('get', '/me?fields=id,name,gender');
        log_message("debug", "fb_user:" . print_r($user, true));
        if (!isset($user['error'])) {
            $userData = $this->userModel->getFbMember($user["id"]);
            if (!$userData) {
                $recordData = array(
                    "fb_name" => trim($user["name"]),
                    "fb_uid" => trim($user["id"]),
                    "sex" => sprintf("%s", trim($user["gender"])),
                    "fb_picture_url" => sprintf("https://graph.facebook.com/%s/picture?type=large", trim($user["id"])),
                    "remote_addr" => $_SERVER["REMOTE_ADDR"],
                    "user_agent" => $this->agent->agent_string(),
                );
                $user_id = $this->userModel->setUserData(0, $recordData);

                $this->session->set_userdata("user_id", $user_id);
                $this->session->set_userdata("fb_uid", $user["id"]);

                //                redirect("/reg/");
                redirect("/top/");
                exit;
            } else {
                $user_id = $userData["user_id"];
            }
            if ($user_id > 0) {
                $this->session->set_userdata("user_id", $user_id);
                if ($userData["fb_uid"] != '' && !is_null($userData["fb_uid"])) {
                    $this->session->set_userdata("userData", $userData);
                    $this->session->set_userdata("loggedIn", TRUE);
                    redirect("/top/", 'refresh');
                    exit;
                } else {
                    $this->session->set_userdata("fb_uid", $user["id"]);
//                    redirect("/reg/", 'refresh');
                    redirect("/top/", 'refresh');
                    exit;
                }
            }
        }
        redirect("/");
    }


//    public function login()
//    {
//
//        $this->data['login_url'] = "/";
//
//        if ($this->data['is_member'] != 1) {
//            $this->data['login_url'] = $this->facebook->login_url();
//            $this->smarty->view('login.tpl', $this->data);
//        } else {
//            redirect("/top/", "refresh");
////			$this->smarty->view( 'member/login.tpl', $this->data );
//        }
//    }

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
