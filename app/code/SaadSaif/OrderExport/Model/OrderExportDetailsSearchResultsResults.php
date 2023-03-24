<?php

namespace SaadSaif\OrderExport\Model;

use Magento\Framework\Api\SearchResults;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterface;

/**
 * we need this concrete class only for the intellisence
 */
class OrderExportDetailsSearchResultsResults extends SearchResults implements OrderExportDetailsSearchResultsInterface
{
}
