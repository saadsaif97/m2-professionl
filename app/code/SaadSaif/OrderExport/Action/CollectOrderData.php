<?php

namespace SaadSaif\OrderExport\Action;

use Magento\Sales\Api\OrderRepositoryInterface;
use SaadSaif\OrderExport\Api\OrderDataCollectorInterface;
use SaadSaif\OrderExport\Model\HeaderData;

class CollectOrderData
{
    private OrderRepositoryInterface $orderRepository;


    /** @var OrderDataCollectorInterface[] $collectors */
    private array $collectors;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        array $collectors = []
    )
    {
        $this->orderRepository = $orderRepository;
        $this->collectors = $collectors;
    }

    public function execute(int $orderId, HeaderData $headerData): array
    {
        $order = $this->orderRepository->get($orderId);

        $output = [];
        foreach ($this->collectors as $collector){
            $output = $collector->collect($order, $headerData);
        }

        return $output;
    }
}
