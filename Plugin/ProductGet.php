<?php

namespace Timoffmax\ExtensionAttribute\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Sales\Api\Data\OrderItemSearchResultInterfaceFactory;
use Magento\Sales\Api\OrderItemRepositoryInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Timoffmax\Useless\Api\SearchResultInterface\OrderSearchResultsInterfaceFactory;

class ProductGet
{
    /**
     * @var OrderItemRepositoryInterface
     */
    protected $orderItemRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var OrderItemSearchResultInterfaceFactory
     */
    protected $orderItemSearchResultsFactory;

    /**
     * @var CollectionFactory
     */
    protected $orderCollectionFactory;

    /**
     * ProductGet constructor.
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        OrderItemSearchResultInterfaceFactory $orderItemSearchResultsFactory,
        CollectionFactory $orderCollectionFactory,
        OrderItemRepositoryInterface $orderItemRepository
    )
    {
        $this->orderItemRepository = $orderItemRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->orderItemSearchResultsFactory = $orderItemSearchResultsFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    public function afterGet(
        ProductRepositoryInterface $product,
        ProductInterface $resultProduct
    ): ProductInterface
    {
        $resultProduct = $this->getSalesInformationAttribute($resultProduct);

        return $resultProduct;
    }

    private function getSalesInformationAttribute(ProductInterface $product): ProductInterface
    {
        $filter = $this->filterBuilder
            ->setField(OrderItemInterface::PRODUCT_ID)
            ->setConditionType('eq')
            ->create()
        ;

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter($filter)
            ->create()
        ;

        $searchResult = $this->orderItemSearchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);


        $orderCollection = $this->orderCollectionFactory->create();
        $orderCollection->getSelect()
            ->join(
                'sales_order_item',
                'main_table.entity_id = sales_order_item.order_id'
            )->where("product_id = {$product->getId()}");

        $extensionAttributes = $product->getExtensionAttributes();

        return $product;
    }
}
