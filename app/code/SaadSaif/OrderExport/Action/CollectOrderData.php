<?php

namespace SaadSaif\OrderExport\Action;

use Magento\Sales\Api\OrderRepositoryInterface;
use SaadSaif\OrderExport\Model\HeaderData;

class CollectOrderData
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository
    )
    {
        $this->orderRepository = $orderRepository;
    }

    public function execute(int $orderId, HeaderData $headerData): array
    {
        $order = $this->orderRepository->get($orderId);

        $output = [];
        // TODO  Accumulate the output

        return $output;
    }
}
