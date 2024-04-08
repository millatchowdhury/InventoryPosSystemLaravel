<?php
namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Psr7\Request;

class JWTToken{

    public static function CreateToken($userEmail, $userID){

        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'Laravel Pos',
            'iat' => time(),
            'exp' => time()+60*60*60*60,
            'userEmail' => $userEmail,
            'userID' => $userID
        ];
        return  JWT::encode($payload, $key, 'HS256');


        
        

    }

    public static function VerifyToken($token){
        try {
            if($token==null){
                return 'unauthorized1';
            }
            else{
                $key =env('JWT_KEY');
                $decode=JWT::decode($token,new Key($key,'HS256'));
                return $decode;
            }
        }
        catch (Exception $e){
            return 'unauthorized';
        }
    }


    public static function CreateTokenForSetPassword($userEmail){
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'Laravel Pos',
            'iat' => time(),
            'exp' => time()+60*20*60*60,
            'userEmail' => $userEmail,
            'userID' => '0'
        ];
        return JWT::encode($payload, $key, 'HS256');
    }












}