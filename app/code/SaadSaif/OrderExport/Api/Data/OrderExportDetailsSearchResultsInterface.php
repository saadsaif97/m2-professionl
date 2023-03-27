<?php

namespace SaadSaif\OrderExport\Api\Data;

interface OrderExportDetailsSearchResultsInterface
    extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \SaadSaif\OrderExport\Api\DataOrderExportDetailsInterface[]
     */
    public function getItems();

    /**
     * @param \SaadSaif\OrderExport\Api\DataOrderExportDetailsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
