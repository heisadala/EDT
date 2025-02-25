<?php

namespace App\Controller;

use GuzzleHttp\Client;

class HelloAssoApi {


    private function getToken (){

        $client = new Client();
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
    private function getPaiementsInfo ($token, $pageSize) {
      $client = new Client();
      $url = $_SERVER['HELLO_ASSO_FORM_EVENT_URL'] . 'payments?pageSize=' . $pageSize;
      $response = $client->request('GET', $url, [
          'headers' => [
              'accept' => 'application/json',
              'authorization' => 'Bearer ' . $token,
          ],
      ]);
      return $response->getBody();
    }

    private function getPaiementsInfoCont ($token, $pageSize, $contToken) {
        $client = new Client();
        $url = $_SERVER['HELLO_ASSO_FORM_EVENT_URL'] . 'payments?pageSize=' . $pageSize . '&continuationToken=' . $contToken;

        $response = $client->request('GET', $url , [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer ' . $token,
            ],
        ]);

      return $response->getBody();
    }

    private function getDataItemInfo($obj, $counter, $amount, $donation_counter, $donation_amount) {

      for ($i=0; $i < count($obj['data']); $i++){
        for ($j=0; $j < count($obj['data'][$i]['items']); $j++) {
          if ($obj['data'][$i]['items'][$j]['type'] == 'Registration') {
              $counter += 1;
              $amount += $obj['data'][$i]['items'][$j]['amount'];
          }
          if ($obj['data'][$i]['items'][$j]['type'] == 'Donation') {
              $donation_counter += 1;
              $donation_amount += $obj['data'][$i]['items'][$j]['amount'];
          }
        }
      }
      return $counter;
    }

    public function getParticipants() {

      $pageSize = 100;
      $counter = 0;
      $amount = 0;
      $donation_counter = 0;
      $donation_amount = 0;

      $resp = $this->getToken();
      $obj = json_decode($resp, true);
      // dd($obj);
      $access_token = $obj['access_token'];
      $resp = $this->getPaiementsInfo($access_token, $pageSize);
      $obj = json_decode($resp, true);

      // dd( $obj['data']);
      // dd( $obj['pagination']);
      $counter = $this->getDataItemInfo($obj, $counter, $amount, $donation_counter, $donation_amount);
      // echo '   ' . $counter;
      if ($obj['pagination']['totalPages'] > 1) {
        $resp = $this->getPaiementsInfoCont($access_token, $pageSize, $obj['pagination']['continuationToken']);
        $obj = json_decode($resp, true);
        // dd( $obj['pagination']);
        $counter = $this->getDataItemInfo($obj, $counter, $amount, $donation_counter, $donation_amount);
        // echo '  ' . $counter;
      }
      return $counter;
    }
  }

