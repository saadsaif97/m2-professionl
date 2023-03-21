<?php

namespace SaadSaif\OrderExport\Model\ResourceModel\OrderExportDetails;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SaadSaif\OrderExport\Model\OrderExportDetails as Model;
use SaadSaif\OrderExport\Model\ResourceModel\OrderExportDetails as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
