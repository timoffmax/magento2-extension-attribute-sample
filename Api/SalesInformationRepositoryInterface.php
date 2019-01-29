<?php

namespace Timoffmax\ExtensionAttribute\Api;

interface SalesInformationRepositoryInterface
{
    /**
     * @throws
     */
    public function save();

    public function get($sku, $editMode = false, $storeId = null, $forceReload = false);

    public function getById($productId, $editMode = false, $storeId = null, $forceReload = false);

    public function delete(\Magento\Catalog\Api\Data\ProductInterface $product);

    public function deleteById($sku);

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
