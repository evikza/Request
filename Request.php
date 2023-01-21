<?php

namespace Request;

class Request
{
  private $userAgent;

  private $httpCode;
  private $responseBody;

  private $requestType;
  private $header = [];
  private $uriQuery;
  private $postFields;

  public function __construct()
  {
    $this->userAgent =
      'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36';
  }

  public function withMethod($requestType)
  {
    $this->requestType = $requestType;
  }

  public function withHeaders($headersArray)
  {
    $headerList = [];

    foreach ($headersArray as $key => $value) {
      $headerList[] = $key . ':' . $value;
    }

    $this->header = $headerList;
  }

  public function setUriQuery($queryArray)
  {
    $preperedQuery = '?' . http_build_query($queryArray);

    $this->uriQuery = $preperedQuery;
  }

  public function getHttpCode()
  {
    return $this->httpCode;
  }

  public function setPostFields($fields = [])
  {
    $this->postFields = $fields;
  }

  public function getBody()
  {
    return $this->responseBody;
  }

  public function execute()
  {
    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => 'https://httpbin.org/get' . $this->uriQuery,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $this->requestType,
      CURLOPT_POSTFIELDS => '',
      CURLOPT_USERAGENT => $this->userAgent,
      CURLOPT_HTTPHEADER => $this->header,
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    $this->httpCode = $httpCode;
    $this->responseBody = $response;
  }
}
