<?php

namespace SaadSaif\OrderExport\Action;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Store\Model\ScopeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use SaadSaif\OrderExport\Model\Config;

class PushDetailsToWebservice
{
    private Config $config;
    private LoggerInterface $logger;

    public function __construct(
        Config $config,
        LoggerInterface $logger
    ) {
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * @throws GuzzleException | LocalizedException
     */
    public function execute(array $exportedData, OrderInterface $order): bool
    {
        $apiUrl = $this->config->getApiUrl(ScopeInterface::SCOPE_STORE, $order->getStoreId());
        $apiToken = $this->config->getApiToken(ScopeInterface::SCOPE_STORE, $order->getStoreId());

        $client = new Client();
        $options = [
            RequestOptions::HEADERS => [
                'Content-Type'=> 'application/json',
                'Authorization'=> 'Bearer ' . $apiToken
            ],
            RequestOptions::BODY => json_encode($exportedData)
        ];

        try {
            $response = $client->post($apiUrl, $options);
            $this->processResponse($response);
        } catch (GuzzleException $exception) {
            $this->logger->error($exception->getMessage(), [
                'details' => $exportedData
            ]);
            throw($exception);
        }

        return true;
    }

    /**
     * @throws LocalizedException
     */
    private function processResponse(ResponseInterface $response): void
    {
        $responseBody = $response->getBody();
        try {
            $responseData = json_decode($responseBody, true);
        } catch (\Exception $e) {
            $responseData = [];
        }

        $successMsg = $responseData['success'] ?? false;
        $errorMsg = $responseData['error'] ?? __('There was a problem: %1', $responseBody);

        if (!$successMsg) {
            throw new LocalizedException($errorMsg);
        }
    }
}
