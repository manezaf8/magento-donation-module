<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Maneza\Donation\Model;

use Magento\Framework\Api\DataObjectHelper;
use Maneza\Donation\Api\Data\DonationInterface;
use Maneza\Donation\Api\Data\DonationInterfaceFactory;

class Donation extends \Magento\Framework\Model\AbstractModel
{

    protected $donationDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'maneza_donation_donation';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param DonationInterfaceFactory $donationDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Maneza\Donation\Model\ResourceModel\Donation $resource
     * @param \Maneza\Donation\Model\ResourceModel\Donation\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        DonationInterfaceFactory $donationDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Maneza\Donation\Model\ResourceModel\Donation $resource,
        \Maneza\Donation\Model\ResourceModel\Donation\Collection $resourceCollection,
        array $data = []
    ) {
        $this->donationDataFactory = $donationDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init('Maneza\Donation\Model\ResourceModel\Donation'); 
    }

}

