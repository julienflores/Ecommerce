<?php
namespace App\Service;

use DateTimeImmutable;

class JWTService
{
    //On génère le token

    /**
     * @param array $header
     * @param array $payload
     * @param string $secret
     * @param int $validity
     * @return string
     */
     
    public function generate(array $header, array $apyload, string $secret, int $validity=10800 ):string
    {
        if($validity <=0){
            return "";
        }
        $now= new DateTimeImmutable();
        $exp=$now -> getTimestamp() + $validity;
        $payload['iat']=$now->getTimestamp();
        $payload['exp']=$exp;
        //on encode en base 64

        $base64Header=base64_encode(json_encode($header));
        $base64Payload=base64_encode(json_encode($payload));

        //on nettoie les valeurs encodées (retrait des +,/ et =)
        $base64Header=str_replace(['+','/','='],['-','_',''], $base64Header);
        $base64Payload=str_replace(['+','/','='],['-','_',''], $base64Payload);

        //on génère la signature

        $secret=base64_encode($secret);
        $signature = hash_hmac('sha256', $base64Header.'.'.$base64Payload, $secret, true);
        $base64Signature=base64_encode($signature);

        //on nettoie la signature (retrait des +,/ et =)
        $base64Signature=str_replace(['+','/','='],['-','_',''], $base64Signature);

        //on crée le token
        $jwt=$base64Header.'.'.$base64Payload.'.'.$base64Signature;





        return $jwt;
    }
}