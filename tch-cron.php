<?php

include_once( dirname( __FILE__ ) . '/tch-cron-db.php');

ob_implicit_flush(true);
ob_end_flush();

try{
    $response = array('message' => 'Установка задания в Cron<br>' , 'progress' => '0');
    echo json_encode($response);    
    
    include_once( dirname( __FILE__ ) . '/src/phpQuery-onefile.php');
    require_once '../../../wp-load.php';
    
    $is_new_keys = isset($_GET['is_new_keys']) ? $_GET['is_new_keys'] : 0;//по умолчанию исключаем те по которым сегодня проверяли
    $key_id = isset($_GET['key_id']) ? $_GET['key_id'] : '';//по умолчанию исключаем те по которым сегодня проверяли
    
    //Устанавливаем задание для крон
    function add_cron($is_new_keys, $key_id){
        $today = new DateTime("now", new DateTimeZone('Europe/Moscow'));
        $today_str = $today->format('Y-m-d H:i:s');
        insert_sheduler_cron($today_str, $today_str, 'в ожидании', $is_new_keys, '0', 'Проверка начнется в указанное время');
    }
    add_cron($is_new_keys, $key_id);
}
catch (Exception $e) {
    $response = array(  'message' => 'Возникла ошибка при установке задания в Cron: '.$e->getMessage().'<br>' , 
                        'progress' => '0');
    echo json_encode($response);
}
