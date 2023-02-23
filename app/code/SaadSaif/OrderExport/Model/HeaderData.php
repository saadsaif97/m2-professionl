<?php

namespace SaadSaif\OrderExport\Model;

class HeaderData
{
    private ?string $merchantNotes;

    private ?\DateTime $shipDate;

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
