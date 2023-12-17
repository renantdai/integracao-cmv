<?php

namespace App\Services;

use App\DTO\CreateCaptureDTO;
use App\Services\SoapClientCMVService;

const SOAP_URL_LEITURA = "https://cmv-ws.sefazrs.rs.gov.br/ws/cmvRecepcaoLeitura/cmvRecepcaoLeitura.asmx";
const SOAP_ACTION_LEITURA = 'http://www.portalfiscal.inf.br/cmv/wsdl/cmvRecepcaoLeitura/CMVRecepcaoLeitura';

const UF_CODIGO_IBGE = 43;
const CNPJ_EMPRESA = '90256652000184';

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
        $this->xmlPostString = '<?xml version="1.0" encoding="utf-8"?><soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope"><soap12:Body><oneDadosMsg xmlns="http://www.portalfiscal.inf.br/cmv/wsdl/cmvRecepcaoLeitura"><oneRecepLeitura versao="2.00" xmlns="http://www.portalfiscal.inf.br/one">';
        $this->xmlPostString .= '<tpAmb>1</tpAmb>';
        $this->xmlPostString .= '<verAplic>SVRS</verAplic>';
        $this->xmlPostString .= '<tpTransm>N</tpTransm>';
        $this->xmlPostString .= '<dhTransm>2023-07-14T13:24:29-03:00</dhTransm>';

        $this->xmlPostString .= '<infLeitura>';
        $this->xmlPostString .= '<cUF>' . UF_CODIGO_IBGE . '</cUF>';
        $this->xmlPostString .= '<dhPass>2023-07-14T13:24:29-03:00</dhPass>';
        $this->xmlPostString .= '<CNPJOper>' . CNPJ_EMPRESA . '</CNPJOper>';
        $this->xmlPostString .= '<cEQP>0000000000010' . $this->dto->idCam . '</cEQP>'; //criar regra para validar 15 digitos
        $this->xmlPostString .= '<placa>' . $this->dto->plate . '</placa>';
        $this->xmlPostString .= '<tpVeiculo>1</tpVeiculo>';
        $this->xmlPostString .= '<foto>' . $this->dto->image . '</foto>';
        $this->xmlPostString .= '<indiceConfianca>100</indiceConfianca>';
        $this->xmlPostString .= '</infLeitura>';

        $this->xmlPostString .= '</oneRecepLeitura></oneDadosMsg></soap12:Body></soap12:Envelope>';
    }

    public function sendRecord() {
        $soapClient = new SoapClientCMVService(SOAP_URL_LEITURA, SOAP_ACTION_LEITURA);
        $soapClient->setXmlPostString($this->getXmlPostString());
        $retorno = $soapClient->sendCurl();

        return $retorno;
    }
}
