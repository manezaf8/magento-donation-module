<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Sqli\Donation\Model\Data;

use Sqli\Donation\Api\Data\DonationInterface;

class Donation extends \Magento\Framework\Api\AbstractExtensibleObject implements DonationInterface
{

    /**
     * Get donation_id
     * @return string|null
     */
    public function getDonationId()
    {
        return $this->_get(self::DONATION_ID);
    }

    /**
     * Set donation_id
     * @param string $donationId
     * @return \Sqli\Donation\Api\Data\DonationInterface
     */
    public function setDonationId($donationId)
    {
        return $this->setData(self::DONATION_ID, $donationId);
    }

    /**
     * Get donation
     * @return string|null
     */
    public function getDonationAmount()
    {
        return $this->_get(self::DONATION);
    }

    /**
     * Set donation amount
     * @param string $donationAmount
     * @return \Sqli\Donation\Api\Data\DonationInterface
     */
    public function setDonationAmount($donation)
    {
        return $this->setData(self::DONATION, $donation);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Sqli\Donation\Api\Data\DonationExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Sqli\Donation\Api\Data\DonationExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Sqli\Donation\Api\Data\DonationExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

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
}

