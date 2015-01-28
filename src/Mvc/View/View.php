<?php

namespace Mvc\View;

class View{

    public $result = null;
    //*登入畫面
    public static function login()
    {
?>
        <html>
            <head><meta charset="utf-8"/><title>Login</title></head>
                <body>
                    <form action="/check" method="post">
                        username：<input type="text" name="name"><br>
                        passoword：<input type="text" name="pwd"><br>
                        <input type="submit" name="submit" value="Login" /><br><br>
                        <input type="submit" name="submit" value="申請會員" formaction="newMember"/>
                        <input type="submit" name="submit" value="忘記密碼" />
<?php
    }
    //*新建會員資料
    public static function newMember()
    {
?>
        <html>
        <head><meta charset="utf-8"/><title>NewMember</title></head>
        <body>
        <form action="/check" method="post">
        (*)必填欄位<br><br>
        username*：<input type="text" name="ctName"><br>
        passoword*：<input type="text" name="ctPwd"><br>
        mobilephone：<input type="text" name="ctMph"><br>
        memo：<input type="text" name="ctMemo"><br>
        <input type="submit" name="submit" value="送出"/>
        </form>
<?php
    }
    //*會員資料
    public function show($result)
    {
        header("Content-Type:text/html; charset=utf-8");
        $show ='<html>
        <head><meta charset="utf-8"/><title>NewMember</title></head>
        <body>
        <form action="/logout" method="post">
        <h2>會員資料：</h2>';
        foreach ($result as $row) {
            $show .= '<br>id:'.$row["id"];
            $show .= '<br>-Name:'.$row["username"];
            $show .= '<br>-Password:'.$row["password"];
            $show .= '<br>-mobilephone:'.$row["mobilephone"];
            $show .= '<br>-memo:'.$row["memo"].'<br>';
        }
        $show .= '<input type="submit" name="submit" value="登出"/>
        </form>';
        echo $show;
    }
    //*登出
    public static function logout()
    {
        header("Content-Type:text/html; charset=utf-8");
        $logout = '<body>
        <form action="/" method="post">
        <h2 style=color:blue>您已登出！謝謝光臨!</h2>
        </form>';
        echo $logout;
    }
}