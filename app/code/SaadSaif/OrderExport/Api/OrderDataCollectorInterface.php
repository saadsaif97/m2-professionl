<?php

namespace SaadSaif\OrderExport\Api;

use Magento\Sales\Api\Data\OrderInterface;
use SaadSaif\OrderExport\Model\HeaderData;

interface OrderDataCollectorInterface
{
    public function collect(OrderInterface $order, HeaderData $headerData);
}
