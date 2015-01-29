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
    public function create($gtPost)
    {
        if ($this->status !== true) {
            return 'error in create!';
        }
        try{
            if ($gtPost['ctName'] != null && $gtPost['ctPwd'] != null ) {
                $this->memberdata = array();
                $_name = $gtPost['ctName'];
                $_password = $gtPost['ctPwd'];
                $_mobilePhone = $gtPost['ctMph'];
                $_memo = $gtPost['ctMemo'];
                $sql = self::$db->prepare("INSERT INTO information (username, password, mobilephone, memo)
                VALUES (:name ,:password, :mobilePhone, :memo)");
                $sql->bindvalue (':name', $_name);
                $sql->bindvalue (':password', $_password);
                $sql->bindvalue (':mobilePhone', $_mobilePhone);
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
    public function lists($lsName){
        if ($this->status !== true) {
            return 'error';
        }
        try {
            $this->memberList = array();
            $sql = self::$db->prepare("SELECT * FROM information where username='".$lsName."'");
            if ($sql->execute()) {
                $this->memberList=$sql;
                return $sql->fetchAll(\PDO::FETCH_ASSOC);
            }else{
                return 'error in lists!';
            }
        }catch(\PDOException $e){
            return 'error in lists!';
        }
    }
    //*檢查登入資料是否已存在
    public function loginCheck($gtPost){
        $sql = self::$db->query("SELECT username FROM information
        where username='".$gtPost['name']."' and password='".$gtPost['pwd']."' ");
        if ($sql->fetch()) {

            return $gtPost['name'];
        } else {
            return false;
        }
    }
    //*檢查建立資料是否已存在
    public function createCheck($gtPost){
        $sql = self::$db->query("SELECT username FROM information
        where username='".$gtPost['ctName']."'");
        if ($sql->fetch()) {
            return $gtPost['ctName'];
        } else {
            return false;
        }
    }
}
