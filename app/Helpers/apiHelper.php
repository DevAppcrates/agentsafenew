<?php
/**
 * Created by PhpStorm.
 * User: PC3
 * Date: 12/5/2016
 * Time: 4:36 PM
 */

namespace App\Helpers;
use App\User;

class apiHelper{

    public static function success($message,$data){
        $data=array('response'=>array('status'=>1,'message'=>$message,'detail'=>$data),'error'=>array('status'=>0));
        return $data;
    }

    public static function success1($message){
        $data=array('response'=>array('status'=>1,'message'=>$message),'error'=>array('status'=>0));
        return $data;
    }

    public static function error($message){

        $data=array('response'=>array('status'=>0),'error'=>array('status'=>1,'message'=>$message));
        return $data;
    }

    public static function validation_error($message,$data){

        $data=array('response'=>array('status'=>0),'error'=>array('status'=>1,'message'=>$message,'detail'=>$data));
        return $data;
    }

    public static function authenticate($user_id,$auth_id){

        if ( empty( $user_id ) or empty($auth_id)){
            return false;
        }
        else{
            if(User::where('user_id',$user_id)->where('auth_id',$auth_id)->where('status','enabled')->exists())
                return true;
            else
                return false;
        }
    }


}