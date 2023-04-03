<?php

namespace SaadSaif\OrderExport\Api\Data;

interface OrderExportDetailsInterface
{
    public const ID = "id";
    public const ORDER_ID = "order_id";
    public const SHIP_ON = "ship_on";
    public const MERCHANT_NOTES = "merchant_notes";
    public const EXPORTED_AT = "exported_at";
    public const IS_ARCHIVED = "is_archived";

    public function getOrderId(): ?int;

    public function setOrderId(?int $orderId): OrderExportDetailsInterface;

    public function getShipOn(): ?\DateTime;

    public function setShipOn(\DateTime $shipOn): OrderExportDetailsInterface;

    public function getMerchantNotes(): ?string;

    public function setMerchantNotes(?string $merchantNotes): OrderExportDetailsInterface;

    public function getExportedAt(): ?\DateTime;

    public function setExportedAt(?\DateTime $exportedAt): OrderExportDetailsInterface;

    public function getIsArchived(): bool;

    public function setIsArchived(bool $status): OrderExportDetailsInterface;

    public function hasBeenExported(): bool;
}
