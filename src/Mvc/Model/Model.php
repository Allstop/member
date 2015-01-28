<?php

namespace Mvc\Model;

class Model{

    private static $db = null;

    protected $status = false;

    public function __construct()
    {
        try {
            $conn = new \PDO('mysql:host=127.0.0.1;dbname=member', 'root', '1234');
            //*錯誤處理,方式為拋出異常
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            //* 轉型utf8
            $conn->query('set character set utf8');
            self::$db = $conn;
            $this->status = true;
        } catch (PDOException $e) {
            $this->status = false;
            return;
        }
    }
    //*寫入資料
    public function create()
    {
        if ($this->status !== true) {
            return 'error in create!';
        }
        try{
            foreach ($_POST as $key => $value)
            {
                $_POST[$key] = trim($value);
            }
            if ($_POST['name'] != null && $_POST['pwd'] != null ) {
                $this->memberdata = array();
                $_name = $_POST ["name"];
                $_password = $_POST ["pwd"];
                $_mobilephone = $_POST ["mph"];
                $_memo = $_POST ["memo"];
                $sql = self::$db->prepare("INSERT INTO information (username, password, mobilephone, memo)
                VALUES (:name ,:password, :mobilephone, :memo)");
                $sql->bindvalue (':name', $_name);
                $sql->bindvalue (':password', $_password);
                $sql->bindvalue (':mobilephone', $_mobilephone);
                $sql->bindvalue (':memo', $_memo);
                $this->memberdata = $sql;
                return ($sql->execute()) ? '成功' : '失敗';
            } else {
                return 'null';
            }
        }catch(PDOException $e){
            return 'error in create!';
        }
    }
    //*會員詳細資料
    public function lists(){
        if ($this->status !== true) {
            return 'error';
        }
        try {
            $this->memberList = array();
            $sql =  self::$db->prepare("SELECT * FROM information
                where username='".$_POST['name']."' and password='".$_POST['pwd']."' ");
            if ($sql->execute()) {
                $this->memberList=$sql;
                return $sql->fetchAll(\PDO::FETCH_ASSOC);
            }else{
                return 'error in lists!';
            }
        }catch(\PDOException $e){

        }
    }
    //*檢查登入資料是否已存在
    public function loginCheck(){
        foreach ($_POST as $key => $value)
        {
            $_POST[$key] = trim($value);
        }
        $lcPwd = ($_POST["pwd"]);
        $sql = self::$db->query("SELECT username FROM information
        where password='".$_POST["pwd"]."' ");
        if ($sql->fetch()) {
            return $lcPwd;
        } else {
            return false;
        }
    }
}
