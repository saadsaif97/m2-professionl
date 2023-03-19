<?php

namespace SaadSaif\OrderExport\Action\OrderDataCollector;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use SaadSaif\OrderExport\Action\GetOrderExportItems;
use SaadSaif\OrderExport\Api\OrderDataCollectorInterface;
use SaadSaif\OrderExport\Model\HeaderData;

class OrderItemsData implements OrderDataCollectorInterface
{
    private GetOrderExportItems $getOrderExportItems;

    public function __construct(
        GetOrderExportItems $getOrderExportItems
    )
    {
        $this->getOrderExportItems = $getOrderExportItems;
    }

    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $items = [];
        foreach ($this->getOrderExportItems->execute($order) as $orderItem) {
            $items[] = $this->transform($orderItem);
        }
        return [
            'items' => $items
        ];
    }

    public function transform(OrderItemInterface $orderItem): array
    {
        return [
            "sku" => $orderItem->getSku(),
            "qty" => $orderItem->getQtyOrdered(),
            "item_price" => $orderItem->getBasePrice(),
            "item_cost" => $orderItem->getBaseCost(),
            "total" => $orderItem->getRowTotal()
        ];
    }
}
