<?php

namespace Timoffmax\ExtensionAttribute\Api\Data;

interface SalesInformationInterface
{
    public const ATTRIBUTE_QTY = 'qty';

    /**
     * @return int|null
     */
    public function getQty(): ?int;

    /**
     * @param int|null $qty
     * @return SalesInformationInterface
     */
    public function setQty(?int $qty): SalesInformationInterface;
}
