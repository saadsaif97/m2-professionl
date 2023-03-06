<?php

namespace SaadSaif\OrderExport\Action;

use Laminas\Json\Json;
use Magento\Customer\Model\CustomerFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\TestFramework\Event\Magento;
use SaadSaif\OrderExport\Api\OrderDataCollectorInterface;
use SaadSaif\OrderExport\Model\HeaderData;

class OrderHeaderData implements OrderDataCollectorInterface
{
    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $output = [
            "id" => $order->getIncrementId(),
            "currency" => $order->getBaseCurrencyCode(),
            "discount" => $order->getDiscountAmount(),
            "total" => $order->getGrandTotal(),
        ];

        if (true) {
            $output["shipping"] = [
                "name" => "Chris Nanning",
                "address" => "123 Main Street",
                "city" => "Kansas City",
                "state" => "KS",
                "postcode" => "12345",
                "country" => "US",
                "amount" => 15,
                "method" => "UPS"
            ];
        }

        return $output;
    }

}
