<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Client;

class GuzzleHttpClient {
    private $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function get($url, $options = []) {
        return $this->client->get($url, $options);
    }

}
