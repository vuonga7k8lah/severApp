<?php


namespace severApp\Controllers\Statistic;


use mysql_xdevapi\Exception;
use severApp\Core\TrainJWT;
use severApp\Helpers\Message;

class PaysStatisticController
{
    use TraitStatistic;
    use TrainJWT;
    public function handleStatisticPay()
    {
        $filter=$_POST['filter']??'today';
        $token=$_POST['token']??'';
        if (!empty($token) && $this->verifyToken($token)){
            try{
                $aData=$this->coverTimeline($filter);
                echo Message::success('success',$aData);
            }catch (Exception $exception){
                echo Message::error($exception->getMessage(),$exception->getCode());
            }
        }else{
            echo Message::error('User not access', 401);
        }
    }
}