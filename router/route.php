<?php
/**
 * Created by PhpStorm.
 * User: cara
 * Date: 2015/1/19
 * Time: 下午 2:29
 */
use Pux\Executor;

$mux = new Pux\Mux;
$mux->any('index', ['Controller', 'run']);
