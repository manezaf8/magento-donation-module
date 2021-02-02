<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Sqli\Donation\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Sqli\Donation\Api\Data\DonationInterfaceFactory;
use Sqli\Donation\Api\Data\DonationSearchResultsInterfaceFactory;
use Sqli\Donation\Api\DonationRepositoryInterface;
use Sqli\Donation\Model\ResourceModel\Donation as ResourceDonation;
use Sqli\Donation\Model\ResourceModel\Donation\CollectionFactory as DonationCollectionFactory;

class DonationRepository implements DonationRepositoryInterface
{

    protected $resource;

    protected $donationFactory;

    protected $donationCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataDonationFactory;

    protected $extensionAttributesJoinProcessor;

    private $storeManager;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;

    /**
     * @param ResourceDonation $resource
     * @param DonationFactory $donationFactory
     * @param DonationInterfaceFactory $dataDonationFactory
     * @param DonationCollectionFactory $donationCollectionFactory
     * @param DonationSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceDonation $resource,
        DonationFactory $donationFactory,
        DonationInterfaceFactory $dataDonationFactory,
        DonationCollectionFactory $donationCollectionFactory,
        DonationSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->donationFactory = $donationFactory;
        $this->donationCollectionFactory = $donationCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataDonationFactory = $dataDonationFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Sqli\Donation\Api\Data\DonationInterface $donation
    ) {
        /* if (empty($donation->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $donation->setStoreId($storeId);
        } */
        
        $donationData = $this->extensibleDataObjectConverter->toNestedArray(
            $donation,
            [],
            \Sqli\Donation\Api\Data\DonationInterface::class
        );
        
        $donationModel = $this->donationFactory->create()->setData($donationData);
        
        try {
            $this->resource->save($donationModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the donation: %1',
                $exception->getMessage()
            ));
        }
        return $donationModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($donationId)
    {
        $donation = $this->donationFactory->create();
        $this->resource->load($donation, $donationId);
        if (!$donation->getId()) {
            throw new NoSuchEntityException(__('Donation with id "%1" does not exist.', $donationId));
        }
        return $donation->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->donationCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Sqli\Donation\Api\Data\DonationInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Sqli\Donation\Api\Data\DonationInterface $donation
    ) {
        try {
            $donationModel = $this->donationFactory->create();
            $this->resource->load($donationModel, $donation->getDonationId());
            $this->resource->delete($donationModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Donation: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($donationId)
    {
        return $this->delete($this->get($donationId));
    }
}

