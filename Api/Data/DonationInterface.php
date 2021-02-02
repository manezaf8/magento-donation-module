<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Sqli\Donation\Api\Data;

interface DonationInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const DONATION = 'donation_amount';
    const DONATION_ID = 'donation_id';

    /**
     * Get donation_id
     * @return string|null
     */
    public function getDonationId();

    /**
     * Set donation_id
     * @param string $donationId
     * @return \Sqli\Donation\Api\Data\DonationInterface
     */
    public function setDonationId($donationId);

    /**
     * Get donation
     * @return string|null
     */
    public function getDonationAmount();

    /**
     * Set donation
     * @param string $donation
     * @return \Sqli\Donation\Api\Data\DonationInterface
     */
    public function setDonationAmount($donation);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Sqli\Donation\Api\Data\DonationExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Sqli\Donation\Api\Data\DonationExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Sqli\Donation\Api\Data\DonationExtensionInterface $extensionAttributes
    );
}

