<?php

namespace SaadSaif\OrderExport\Model;

use Magento\Framework\Model\AbstractModel;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface;
use SaadSaif\OrderExport\Model\ResourceModel\OrderExportDetails as ResourceModel;

class  OrderExportDetails extends AbstractModel implements OrderExportDetailsInterface
{
    protected function _construct(): void
    {
        $this->_init(ResourceModel::class);
    }

    public function getOrderId(): ?int
    {
        return $this->hasData(self::ORDER_ID) ? (int)$this->getData(self::ORDER_ID) : null;
    }

    public function setOrderId(?int $orderId): OrderExportDetailsInterface
    {
        $this->setData(self::ORDER_ID, $orderId);
        return $this;
    }

    public function getShipOn(): ?\DateTime
    {
        $dateString = $this->getData(self::SHIP_ON);
        return $dateString ? new \DateTime($dateString) : null;
    }

    public function setShipOn(?\DateTime $shipOn): OrderExportDetailsInterface
    {
        $this->setData(self::SHIP_ON, $shipOn->format('Y-m-d'));
        return $this;
    }

    public function getMerchantNotes(): ?string
    {
        return (string) $this->getData(self::MERCHANT_NOTES);
    }

    public function setMerchantNotes(?string $merchantNotes): OrderExportDetailsInterface
    {
        $this->setData(self::MERCHANT_NOTES, $merchantNotes);
        return $this;
    }

    public function getExportedAt(): ?\DateTime
    {
        $dateString = $this->getData(self::EXPORTED_AT);
        return $dateString ? new \DateTime($dateString) : null;
    }

    public function setExportedAt(?\DateTime $exportedAt): OrderExportDetailsInterface
    {
        $this->setData(self::EXPORTED_AT, $exportedAt->format('Y-m-d H:i:s'));
        return $this;
    }

    public function getIsArchived(): bool
    {
        return (bool) $this->getData(self::IS_ARCHIVED);
    }

    public function setIsArchived(bool $status): OrderExportDetailsInterface
    {
        $this->setData(self::IS_ARCHIVED, $status ? 1 : 0);
        return $this;
    }

    public function hasBeenExported(): bool
    {
        return (bool) $this->getExportedAt();
    }
}
