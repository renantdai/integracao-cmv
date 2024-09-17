<?php

namespace App\Services;

use App\DTO\CreateCamDTO;
use App\Enums\CamStatus;
use App\Services\SoapClientCMVService;

const SOAP_URL_LEITURA = "https://cmv-ws.sefazrs.rs.gov.br/ws/cmvManutencaoEQP/cmvManutencaoEQP.asmx";
const SOAP_ACTION_LEITURA = 'http://www.portalfiscal.inf.br/cmv/wsdl/cmvManutencaoEQP/cmvManutencaoEQP';
const XMLNS = 'http://www.portalfiscal.inf.br/cmv/wsdl/cmvManutencaoEQP';

class ManutencaoEquipamentoService {
    public string $xmlPostString;

    public function __construct(
        protected CreateCamDTO $dto,
    ) {
    }

    public function getXmlPostString() {
        return $this->xmlPostString;
    }

    public function setXmlPostString(): void {
        $this->xmlPostString = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:cmv="http://www.portalfiscal.inf.br/cmv/wsdl/cmvManutencaoEQP">';
        $this->xmlPostString .= '<soap:Header/>';
        $this->xmlPostString .= '<soap:Body>';
        $this->xmlPostString .= '<oneDadosMsg xmlns="' . XMLNS . '"><oneManEQP versao="2.00" xmlns="http://www.portalfiscal.inf.br/one">';

        $this->xmlPostString .= '<tpAmb>' . trim($this->dto->tpAmb) . '</tpAmb>';
        $this->xmlPostString .= '<verAplic>' . trim($this->dto->verAplic) . '</verAplic>';
        $this->xmlPostString .= '<tpMan>' . CamStatus::sendFromValue($this->dto->tpMan->name) . '</tpMan>';
        $this->xmlPostString .= '<dhReg>' . trim($this->dto->dhReg) . '</dhReg>';
        $this->xmlPostString .= '<CNPJOper>' . trim($this->dto->CNPJOper) . '</CNPJOper>';
        $this->xmlPostString .= '<cEQP>' . trim($this->dto->cEQP) . '</cEQP>';
        $this->xmlPostString .= '<xEQP>' . trim($this->dto->xEQP) . '</xEQP>';
        $this->xmlPostString .= '<cUF>' . trim($this->dto->cUF) . '</cUF>';
        $this->xmlPostString .= '<tpSentido>' . trim($this->dto->tpSentido) . '</tpSentido>';
        $this->xmlPostString .= '<latitude>' . trim($this->dto->latitude) . '</latitude>';
        $this->xmlPostString .= '<longitude>' . trim($this->dto->longitude) . '</longitude>';
        $this->xmlPostString .= '<tpEQP>' . trim($this->dto->tpEQP) . '</tpEQP>';
        $this->xmlPostString .= '<xRefCompl>' . trim($this->dto->xRefCompl) . '</xRefCompl>';

        $this->xmlPostString .= '</oneManEQP></oneDadosMsg></soap:Body></soap:Envelope>';
    }

    public function sendRecord() {
        $soapClient = new SoapClientCMVService(SOAP_URL_LEITURA, SOAP_ACTION_LEITURA, $this->dto->CNPJOper);
        $soapClient->setXmlPostString($this->getXmlPostString());
        $retorno = $soapClient->sendCurl();

        return $retorno;
    }
}
