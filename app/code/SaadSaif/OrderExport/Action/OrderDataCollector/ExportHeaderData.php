<?php

namespace SaadSaif\OrderExport\Action\OrderDataCollector;

use Magento\Sales\Api\Data\OrderInterface;
use SaadSaif\OrderExport\Api\OrderDataCollectorInterface;
use SaadSaif\OrderExport\Model\HeaderData;

class ExportHeaderData implements OrderDataCollectorInterface
{

    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $shippingDate = $headerData->getShipDate();
        return [
            "merchant_notes" => $headerData->getMerchantNotes(),
            "shipping" => [
                "ship_on" => ($shippingDate != null) ? $shippingDate->format('d/m/y') : ''
            ]
        ];
    }
}
