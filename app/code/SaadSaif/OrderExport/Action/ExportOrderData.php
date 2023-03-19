<?php

namespace SaadSaif\OrderExport\Action;

use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use SaadSaif\OrderExport\Model\HeaderData;
use SaadSaif\OrderExport\Model\Config;

class ExportOrderData
{
    private CollectOrderData $collectOrderData;
    private OrderRepositoryInterface $orderRepository;
    private Config $config;

    public function __construct(
        CollectOrderData $collectOrderData,
        OrderRepositoryInterface $orderRepository,
        Config $config
    )
    {
        $this->collectOrderData = $collectOrderData;
        $this->orderRepository = $orderRepository;
        $this->config = $config;
    }

    public function execute(int $orderId, HeaderData $headerData): array
    {
        $order = $this->orderRepository->get($orderId);

        if(!$this->config->isEnabled(ScopeInterface::SCOPE_STORE, $order->getStoreId())) {
            throw new LocalizedException('Order export is disabled');
        }

        $results = ['success' => false, 'error' => null];

        $exportData = $this->collectOrderData->execute($order, $headerData);
        // TODO Export to web server, save the export details

        return $results;
    }
}
