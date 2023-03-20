<?php

namespace SaadSaif\OrderExport\Model;

class HeaderData
{
    private ?string $merchantNotes = null;

    private ?\DateTime $shipDate = null;

    public function getMerchantNotes(): ?string
    {
        return (string) $this->merchantNotes;
    }

    public function setMerchantNotes(?string $merchantNotes): HeaderData
    {
        $this->merchantNotes = $merchantNotes;
        return $this;
    }

    public function getShipDate(): ?\DateTime
    {
        return $this->shipDate;
    }

    public function setShipDate(?\DateTime $shipDate): HeaderData
    {
        $this->shipDate = $shipDate;
        return $this;
    }
}
