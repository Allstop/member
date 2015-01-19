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
    private $action = 'index';
    // 建構函式
    // 初始化要執行的動作以及物件
    public function __construct($host, $dbname, $user, $pwd)
    {
        $this->action = isset($_GET['refer'])
            ? strtolower($_GET['refer'])
            : 'index';
        $this->Model = new Model($host, $dbname, $user, $pwd);
    }
    // 執行選擇的動作
    public final function run()
    {
        $this->{$this->action}();
    }
    // 預設的列表功能
    // 等同於原來的 index.php
    private function index()
    {
        if (!isset($_POST['submit'])) {
            View::login('index.php');
        } else {
            switch ($_POST['submit']) {
                case 'Login':
                    if ($this->Model->loginCheck() == 'success') {
                        $result = $this->Model->lists();
                        View::show('index.php',$result);
                        echo "<h2 style='color:blue'>登入成功!</h2>";
                    } elseif ($this->Model->loginCheck() == 'fail') {
                        View::login('index.php');
                        echo "<h2 style='color:red'>尚未建立,查無符合資料!</h2>";
                    } else {
                        View::login('index.php');
                        echo "<h2 style='color:red'>帳號或密碼輸入錯誤!</h2>";

                    }
                    break;
                case '申請會員':
                    View::newMember('index.php');
                    break;
                case '送出':
                    if ($this->Model->loginCheck() !== 'success' && $this->Model->loginCheck() !== 'repeatNum') {
                        $this->Model->create();
                        View::login('index.php');
                        echo "<h2>註冊成功,請重新登入!</h2>";
                    } else {
                        View::newMember('index.php');
                        echo "<h2>註冊失敗,資料重複,請重新輸入!</h2>";
                    }
                    break;
                case '登出':
                    View::login('index.php');
                    View::showoutput('index.php');
                    break;
            }
        }
    }
    // 解構函式
    public function __destruct()
    {
        $this->Model = NULL;
    }
}

