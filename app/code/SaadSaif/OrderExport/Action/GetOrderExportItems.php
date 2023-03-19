<?php

namespace SaadSaif\OrderExport\Action;

use Magento\Catalog\Model\Product\Type;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;

class GetOrderExportItems
{
    private array $allowedTypes;

    public function __construct(
        array $allowedTypes = []
    )
    {
        $this->allowedTypes = $allowedTypes;
    }

    /**
     * @param OrderInterface $order
     * @return OrderItemInterface[]
     */
    public function execute(OrderInterface $order): array
    {
        $items = [];
        foreach ($order->getItems() as $orderItem) {
            if (in_array($orderItem->getProductType(), $this->allowedTypes)) {
                $items[] = $orderItem;
            }
        }
        return $items;
    }
}
