<?php

namespace App\Controller;

class HelloAssoApi {


    public function getToken (){

        $client = new \GuzzleHttp\Client();
        $clientId = $_SERVER['HELLO_ASSO_CLIENT_ID'];
        $secret = $_SERVER['HELLO_ASSO_SECRET'];
        $response = $client->request('POST', 'https://api.helloasso.com/oauth2/token', [
          'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => $clientId,
            'client_secret' => $secret
          ],
          'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'accept' => 'application/json',
          ],
        ]);
        
       return $response->getBody();
    }
    public function getPaiementsInfo ($token){
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.helloasso.com/v5/organizations/les-enfants-de-trestel/forms/Event/piece-de-theatre-ma-femme-est-sortie-par-la-troupe-uni-ver-scene-comedie/payments', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer ' . $token,
            ],
        ]);

        return $response->getBody();
    }
}

