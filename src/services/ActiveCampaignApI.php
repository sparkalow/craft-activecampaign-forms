<?php

namespace sparkalow\activecampaignforms\services;

use Craft;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use sparkalow\activecampaignforms\Plugin;
use yii\base\Component;

/**
 * Active Campaign API service
 * @see https://developers.activecampaign.com/reference/overview
 */
class ActiveCampaignApI extends Component
{
    private $_account;
    private $_apiKey;

    public function init()
    {
        $settings = Plugin::$plugin->getSettings();

        $this->_apiKey = $settings->apiKey;
        $this->_account = $settings->account;

        parent::init();
    }

    // Public Methods
    // =========================================================================

    public function get($uri, $params = [])
    {
        return $this->_request($uri, $params);
    }

    public function post($uri, $params = [])
    {
        return $this->_request($uri, $params, 'POST');
    }

    public function put($uri, $params = [])
    {
        return $this->_request($uri, $params, 'PUT');
    }

    public function delete($uri, $params = [])
    {
        return $this->_request($uri, $params, 'DELETE');
    }


    // Private Methods
    // =========================================================================

    /**
     * Perform the request with Guzzle
     * @param mixed $uri
     * @param array $params
     * @param string $method
     * @return mixed active campaign response object
     * @throws GuzzleException
     */
    private function _request($uri, $params = [], $method = "GET"): ?object
    {
        $url = $this->_account . '/api/3/';
        $client = new Client(['base_uri' => $url]);
        if (!$this->_account || !$this->_apiKey) {
            throw new \Exception('Missing ActiveCampaign API credentials.');
        }
        $params = array_merge_recursive([
            'headers' => [
                'Api-Token' => $this->_apiKey,
                'Accept' => 'application/json',
            ]
        ], $params);

        try {
            $response = $client->request($method, $uri, $params);
        } catch (ConnectException $e) {
            Craft::error('ActiveCampaign API Error: ' . $e->getMessage(), __METHOD__);
            throw new \Exception($e->getMessage());
        } catch (RequestException $e) {
            Craft::error('ActiveCampaign API Error: ' . $e->getMessage(), __METHOD__);
            throw new \Exception($e->getMessage());
        } catch (\Exception $e) {
            Craft::error('ActiveCampaign API Error: ' . $e->getMessage(), __METHOD__);
            throw new \Exception($e->getMessage());
        }

        return json_decode($response->getBody());
    }

}
