<?php

namespace SaadSaif\OrderExport\Action;

use GuzzleHttp\Exception\GuzzleException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use SaadSaif\OrderExport\Model\Config;
use SaadSaif\OrderExport\Model\HeaderData;

class ExportOrderData
{
    private PushDetailsToWebservice $pushDetailsToWebservice;
    private OrderRepositoryInterface $orderRepository;
    private CollectOrderData $collectOrderData;
    private Config $config;

    public function __construct(
        PushDetailsToWebservice  $pushDetailsToWebservice,
        CollectOrderData         $collectOrderData,
        OrderRepositoryInterface $orderRepository,
        Config                   $config
    )
    {
        $this->collectOrderData = $collectOrderData;
        $this->orderRepository = $orderRepository;
        $this->pushDetailsToWebservice = $pushDetailsToWebservice;
        $this->config = $config;
    }

    /**
     * @throws LocalizedException
     */
    public function execute(int $orderId, HeaderData $headerData): array
    {
        $order = $this->orderRepository->get($orderId);

        if (!$this->config->isEnabled(ScopeInterface::SCOPE_STORE, $order->getStoreId())) {
            throw new LocalizedException('Order export is disabled');
        }

        $results = ['success' => false, 'error' => null];

        $exportData = $this->collectOrderData->execute($order, $headerData);

        try {
            $results['success'] = $this->pushDetailsToWebservice->execute($exportData, $order);
        } catch (\Throwable $e) {
            $results['error'] = $e->getMessage();
        }

        return $results;
    }
}
