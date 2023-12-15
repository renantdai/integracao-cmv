<?php

namespace App\Services;

use App\DTO\CreateCaptureDTO;
use App\Services\SoapClientCMVService;
use stdClass;

const SOAP_URL_LEITURA = "https://cmv-ws.sefazrs.rs.gov.br/ws/cmvRecepcaoLeitura/cmvRecepcaoLeitura.asmx";
const SOAP_ACTION_LEITURA = 'http://www.portalfiscal.inf.br/cmv/wsdl/cmvRecepcaoLeitura/CMVRecepcaoLeitura';

class EnvioLeituraService {
    public string $xmlPostString;

    public function __construct(
        protected CreateCaptureDTO $dto,
    ) {
    }

    public function getXmlPostString() {
        return $this->xmlPostString;
    }

    public function setXmlPostString(): void {
        $this->xmlPostString = '<?xml version="1.0" encoding="utf-8"?><soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope"><soap12:Body><oneDadosMsg xmlns="http://www.portalfiscal.inf.br/cmv/wsdl/cmvRecepcaoLeitura"><oneRecepLeitura versao="2.00" xmlns="http://www.portalfiscal.inf.br/one"><tpAmb>1</tpAmb><verAplic>SVRS</verAplic><tpTransm>N</tpTransm><dhTransm>2023-07-14T13:24:29-03:00</dhTransm><infLeitura><cUF>43</cUF><dhPass>2023-07-14T13:24:29-03:00</dhPass><CNPJOper>90256652000184</CNPJOper><cEQP>000000000001001</cEQP><placa>ANZ9192</placa><tpVeiculo>1</tpVeiculo><foto>' . $this->dto->image . '</foto><indiceConfianca>100</indiceConfianca></infLeitura></oneRecepLeitura></oneDadosMsg></soap12:Body></soap12:Envelope>';
    }

    public function sendRecord() {

        $soapClient = new SoapClientCMVService(SOAP_URL_LEITURA, SOAP_ACTION_LEITURA);
        $soapClient->setXmlPostString($this->getXmlPostString());
        $retorno = $soapClient->sendCurl();

        return $retorno;
    }
}
