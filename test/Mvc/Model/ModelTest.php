<?php
namespace Mvc\Model;

use PHPUnit_Framework_TestCase;

require('./vendor/autoload.php');
//require_once ( 'Model.php' );

class ModelTest extends PHPUnit_Framework_TestCase
{

     public function testCreate()
     {
         $arr = array('ctName' => 'est', 'ctPwd' => '999', 'ctMph' => null , 'ctMemo' => null);
         $Model = new Model($arr);
         $this->assertEquals('成功',$Model->create($arr, null));
     }
    /*public function testLoginCheck()
    {
        $arr = array('name' => 'AAA', 'pwd' => '999');
        $this->assertEquals('name', Model::LoginCheck($arr), false);
    }
    /* public function testLists()
    {
        $List = array();
        $Model = new Model($List);
        $this->assertEquals(
            true,
            //$Model->lists($List)
            array_filter($Model->lists($List), 'is_string')
            );
    }
    /*
        public function testLoginCheck()
        {
            $Name = '';
            $Model = new Model($Name);
            $this->assertEquals(
                true,
                $Model->loginCheck($Name)
                );
        }

        public function testCreateCheck()
        {
            $Name = '';
            $Model = new Model($Name);
            $this->assertEquals(
                true,
                $Model->createCheck($Name)
            );
        }
        */
 }

