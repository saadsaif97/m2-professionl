<?php

namespace SaadSaif\OrderExport\Api\Data;

interface OrderExportDetailsSearchResultsInterface
    extends \Magento\Framework\Api\SearchResultsInterfaceSearchResultsInterface
{
    /**
     * @return \Magento\Framework\Api\SearchResultsInterfaceOrderExportDetailsInterface[]
     */
    public function getItems();

    /**
     * @param \Magento\Framework\Api\SearchResultsInterfaceOrderExportDetailsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
