<?php

namespace SaadSaif\OrderExport\Action;

use Magento\Sales\Api\Data\OrderInterface;
use SaadSaif\OrderExport\Api\OrderDataCollectorInterface;
use SaadSaif\OrderExport\Model\HeaderData;

class CollectOrderData
{
    /** @var OrderDataCollectorInterface[] $collectors */
    private array $collectors;

    public function __construct(
        array $collectors = []
    )
    {
        $this->collectors = $collectors;
    }

    public function execute(OrderInterface $order, HeaderData $headerData): array
    {
        $output = [];
        foreach ($this->collectors as $collector){
            $output = array_merge_recursive($output ,$collector->collect($order, $headerData));
        }

        return $output;
    }
}
