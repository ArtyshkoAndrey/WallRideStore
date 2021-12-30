<?php
/*
 * Copyright (c) 2020. Данный файл является интелектуальной собственостью Fulliton.
 * Я буду рад если вы будите вносить улучшения, всегда жду ваших пул реквестов
 */

namespace App\Services;

use DOMDocument;
use DOMXPath;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class ParserEmsService
{


  /**
   * Почтовый индексполучателя
   * @var string
   */
  protected string $post_code;

  /**
   * Код страны получателя
   * @var string
   */
  protected string $country_code;

  /**
   * Вес посылки в кг
   * @var float|int
   */
  protected float $weight = 0;


  /**
   * Данные для тега product
   * @var array|string[]
   */
  private array $product = [
    'KZ' => 'P103'
  ];

  /**
   * Почтовый индекс отправителя
   * @var string
   */
  private string $send_post_code = '050059';

  /**
   * Ссылка для парсинга
   * @var string
   */
  private string $link = 'http://rates.kazpost.kz/postratesprod/postratesws.wsdl';

  /**
   * ParserEmsService constructor.
   * @param string $post_code
   * @param string $country_code
   * @param float $weight
   * @return void
   */
  public function __construct(string $post_code, string $country_code, float $weight)
  {
    $this->post_code = $post_code;
    $this->country_code = $country_code;
    $this->weight = $weight;
  }

  /**
   * Получение стоимости доставки
   * @return int
   * @throws GuzzleException
   * @throws Exception
   */
  public function getPrice(): int
  {
    $client = new Client();
    $create = $client->post($this->link, [
      'body' => $this->createXML()->saveXML()
    ]);

    $data = $create->getBody()->getContents();
    return $this->parseXML($data);
  }

  /**
   * Созданите тела запроса
   * @return DOMDocument
   */
  private function createXML(): DOMDocument
  {
    $productData = $this->product[$this->country_code] ?? 'P104';
   // $productData = 'P104';
    $xml = new DOMDocument();

    $Envelope = $xml->createElement('soapenv:Envelope');
    $Envelope->setAttribute('xmlns:soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
    $Envelope->setAttribute('xmlns:pos', 'http://webservices.kazpost.kz/postratesws');

    $Header = $xml->createElement('soapenv:Header');

    $Body = $xml->createElement('soapenv:Body');

    $GetPostRateRequest = $xml->createElement('pos:GetPostRateRequest');

    $GetPostRateInfo = $xml->createElement('pos:GetPostRateInfo');

    $SndrCtg = $xml->createElement('pos:SndrCtg', 1);
    $Contract = $xml->createElement('pos:Contract');
    $Product = $xml->createElement('pos:Product', $productData);
    $MailCat = $xml->createElement('pos:MailCat', 1);
    $SendMethod = $xml->createElement('pos:SendMethod', 1);
    $Weight = $xml->createElement('pos:Weight', $this->weight * 1000);
    $Dimension = $xml->createElement('pos:Dimension', 'L');
    $Value = $xml->createElement('pos:Value', 0);
    $From = $xml->createElement('pos:From', $this->send_post_code);
    $To = $xml->createElement('pos:To', $this->post_code);
    //$To = $xml->createElement('pos:To', '010001');
    $ToCountry = $xml->createElement('pos:ToCountry', $this->country_code);
    $PostMark = $xml->createElement('pos:PostMark',);

    $GetPostRateInfo->appendChild($SndrCtg);
    $GetPostRateInfo->appendChild($Contract);
    $GetPostRateInfo->appendChild($Product);
    $GetPostRateInfo->appendChild($MailCat);
    $GetPostRateInfo->appendChild($SendMethod);
    $GetPostRateInfo->appendChild($Weight);
    $GetPostRateInfo->appendChild($Dimension);
    $GetPostRateInfo->appendChild($Value);
    $GetPostRateInfo->appendChild($From);
    $GetPostRateInfo->appendChild($To);
    $GetPostRateInfo->appendChild($ToCountry);
    $GetPostRateInfo->appendChild($PostMark);

    $GetPostRateRequest->appendChild($GetPostRateInfo);
    $Body->appendChild($GetPostRateRequest);
    $Envelope->appendChild($Header);
    $Envelope->appendChild($Body);
    $xml->appendChild($Envelope);
    return $xml;
  }

  /**
   * Получение данных с API
   * @param $data
   * @return int
   * @throws Exception
   */
  private function parseXML($data): int
  {
    $doc = new DOMDocument();
    $doc->loadXML($data);
    $xpath = new DOMXpath($doc);
    $xpath->registerNamespace('SOAP-ENV', "http://schemas.xmlsoap.org/soap/envelope/");
    $body = $xpath->evaluate('//SOAP-ENV:Body')->item(0);
    $ns2 = $body->firstChild->firstChild;
    if ($ns2->localName === 'Sum') {
      return (int)$ns2->textContent;
    }

    throw new RuntimeException('Нет данных');
  }
}
