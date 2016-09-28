<?php
namespace Conversion\VerificareTVA;

use GuzzleHttp\Client;

/**
 * Implementare API Verificare TVA
 * http://www.verificaretva.ro/serviciul_tva_api_web_service.htm
 */
class Connect
{
    protected $apiUri = 'http://www.verificaretva.ro/api/apiv2.aspx';
    protected $apikey = null;
    protected $error = null;

    /**
     *
     * @var \Guzzle\Http\Client
     */
    protected $client;

    /**
     *
     * @param string $apikey
     */
    public function __construct($apikey)
    {
        $this->apikey = $apikey;
    }

    /**
     *
     * @param string $cui
     * @return array
     * @throws \Exception
     *
     */
    public function check($cui)
    {
        $this->client = new Client();

        $date = new \DateTime();

        $options['form_params'] = array(
            'key' => $this->apikey,
            'cui' => trim($cui),
            'date' => $date->format('Y/m/d')
        );

        $response = $this->client->post($this->apiUri, $options);
        $ret = (string) $response->getBody();
        $data = json_decode($ret);

        if (false === $data || null === $data || "valid" !== $data->Raspuns) {
            $this->error = $ret;
            throw new \Exception("Response error, please check API.");
        }

        return $data;
    }

    protected function getError()
    {
        return $this->error;
    }

}
