<?php

namespace hacklabr;

function run_soap (string $url, string $service, array $params = []) {
    try {
        $client = new \SoapClient($url, [ 'trace' => 1, 'exceptions' => true ]);
        $response = $client->__soapCall($service, $params);
        var_dump($response);
        var_dump($client->__getLastResponse());
        return $response;
    } catch (\Throwable $err) {
        var_dump($err->getMessage());
        error_log($err->getMessage());
    }
}

function run_soap_v0 (string $service, array $params = []) {
    $url = 'https://crmw.ethos.org.br/Futurum.Ethos.WebServices/Futurum.Ethos.WebServices.asmx?WSDL';
    return run_soap($url, $service, $params);
}

function run_soap_v1 (string $service, array $params = []) {
    $url = 'https://crmw.ethos.org.br/EthosWS/EthosWS.asmx?WSDL';
    return run_soap($url, $service, $params);
}
