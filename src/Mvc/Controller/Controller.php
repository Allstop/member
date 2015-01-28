<?php

namespace Mvc\Controller;

use Mvc\Model\Model;
use Mvc\View\View;

// 動作類別
class Controller
{
    // 共用的物件
    private $Model = NULL;
    // 使用者選擇的動作
    private $action = 'login';
    // 建構函式
    // 初始化要執行的動作以及物件
    public function __construct()
    {
        $this->Model = new Model();
    }
    // 執行選擇的動作
    public final function run()
    {
        $this->{$this->action}();
    }
    //*登入
    private function login(){
        session_start();
        if (isset($_SESSION["name"]) && $_SESSION["name"] != null) { //已經登入的話直接回首頁
            redirect(site_url("/")); //轉回首頁
            return true;
        }
        View::login('index.php');
    }
    //*檢查
    public function check(){
        switch ($_POST['submit']) {
            case 'Login':
                if ($this->Model->loginCheck()) {
                    $this->userData();
                    $_SESSION['name'] = $this->Model->loginCheck();
                    echo "<h2 style='color:blue'>登入成功!</h2>";
                } else {
                    $this->login();
                    echo "<h2 style='color:red'>帳號或密碼不正確!</h2>";
                }
                break;
            case '送出':
                if ($this->Model->loginCheck()) {
                    $this->newMember();
                    echo "<h2>註冊失敗,資料不齊全,請輸入帳號密碼!</h2>";
                } else {
                    $this->Model->create();
                    $this->login();
                    echo "<h2>註冊成功,請重新登入!</h2>";
                }
                break;
        }
    }
    //*會員資料
    public function userData(){
        $result = $this->Model->lists();
        View::show($result);
    }
    //*建立會員
    public function newMember(){
        View::newMember('index.php');
    }
    //*登出
    public function logout(){
        View::login('index.php');
        View::logout('index.php');
    }
    // 解構函式
    public function __destruct()
    {
        $this->Model = NULL;
    }
}

