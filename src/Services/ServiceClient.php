<?php

namespace VolkLms\Poc\Services;

class ServiceClient
{
  public static function request($data)
  {
    $ch = curl_init();

    if ($data['method'] === 'GET' && !empty($data['queryParams'])) {
      $data['url'] .= '?' . http_build_query($data['queryParams']);
    }

    curl_setopt($ch, CURLOPT_URL, $data['url']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $data['method']);

    if ($data['method'] === 'POST') {
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data['queryParams']));
    }

    if (!empty($data['headers'])) {
      $headerFields = [];
      foreach ($data['headers'] as $key => $value) {
        $headerFields[] = $key . ': ' . $value;
      }
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headerFields);
    }

    $response = curl_exec($ch);

    if ($response === false) {
      return [
        'error' => curl_error($ch),
        'error_code' => curl_errno($ch)
      ];
    }

    $responseData = json_decode($response, true);

    if ($responseData === null) {
      return [
        'error' => 'Erro na análise da resposta JSON',
        'response' => $response
      ];
    }

    return $responseData;
  }
}