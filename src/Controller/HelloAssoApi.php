<?php

namespace App\Controller;

class HelloAssoApi {


    public function getToken (){

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.helloasso.com/oauth2/token', [
          'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => 'c8f02126696b4b769d0afde6dd185bea',
            'client_secret' => 'Ua4hwjwxYRhGQHmRXu3MbpJwJS/2HzUz'
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

