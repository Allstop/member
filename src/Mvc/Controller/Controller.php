<?php
namespace Mvc\Controller;

session_start();

use Mvc\Model\Model;
use Mvc\View\View;

// 動作類別
class Controller
{
    // 共用的物件
    private $Model = NULL;

    private $gtPost = NULL;
    // 使用者選擇的動作
    private $action = 'login';
    // 建構函式
    // 初始化要執行的動作以及物件
    public function __construct()
    {
        $this->Model = new Model();
        $this->gtPost=$this->getPost();
    }
    //取得POST值
    public function getPost()
    {
        foreach ($_POST as $key => $value)
        {
            $_POST[$key] = trim($value);
        }
        $memData = array();
        if (isset($_POST['name'])) {
            $memData['name'] = $_POST['name'];
        }
        if (isset($_POST['pwd'])) {
            $memData['pwd'] = $_POST['pwd'];
        }
        if (isset($_POST['ctName'])) {
            $memData['ctName'] = $_POST['ctName'];
        }
        if (isset($_POST['ctPwd'])) {
            $memData['ctPwd'] = $_POST['ctPwd'];
        }
        if (isset($_POST['ctMph'])) {
            $memData['ctMph'] = $_POST['ctMph'];
        }
        if (isset($_POST['ctMemo'])) {
            $memData['ctMemo'] = $_POST['ctMemo'];
        }
        return $memData;
    }
    // 執行選擇的動作
    public final function run()
    {
        $this->{$this->action}();
    }
    //*登入
    private function login(){
        View::login('index.php');
    }
    //*檢查
    public function check(){
        switch ($_POST['submit']) {
            case 'Login':
                if ($this->Model->loginCheck($this->gtPost)) {
                    $_SESSION["name"]=$this->gtPost['name'];
                    $this->userData();
                    echo "<h2 style='color:blue'>登入成功!</h2>";
                } else {
                    $this->login();
                    echo "<h2 style='color:red'>帳號或密碼不正確!</h2>";
                }
                break;
            case '送出':
                if ($this->Model->createCheck($this->gtPost)) {
                    $this->newMember();
                    echo "<h2>註冊失敗,資料重複,請重新輸入!</h2>";
                } elseif (empty($this->gtPost['ctName']) || empty($this->gtPost['ctPwd']) ) {
                    $this->newMember();
                    echo "<h2>註冊失敗,帳號密碼請勿空白,請重新輸入!</h2>";
                } else {
                    $this->Model->create($this->gtPost);
                    $this->login();
                    echo "<h2>註冊成功,請重新登入!</h2>";
                }
                break;
        }
    }
    //*會員資料
    public function userData(){
        $lsName = $_SESSION["name"];
        $result = $this->Model->lists($lsName);
        View::show($result);
    }
    //*建立會員
    public function newMember(){
        View::newMember('index.php');
    }
    //*登出
    public function logout(){
        unset($_SESSION['name']);
        View::login('index.php');
        View::logout('index.php');
    }
    // 解構函式
    public function __destruct()
    {
        $this->Model = NULL;
    }
}

