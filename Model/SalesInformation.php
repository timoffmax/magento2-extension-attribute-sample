<?php

namespace Timoffmax\ExtensionAttribute\Model;

use Timoffmax\ExtensionAttribute\Api\Data\SalesInformationInterface;

class SalesInformation implements SalesInformationInterface
{
    /**
     * @return int|null
     */
    public function getQty(): ?int
    {
        return $this->getData(self::ATTRIBUTE_QTY);
    }

    /**
     * @param int|null $qty
     * @return SalesInformationInterface
     */
    public function setQty(?int $qty): SalesInformationInterface
    {
        return $this->setData(self::ATTRIBUTE_QTY, $qty);
    }
}
