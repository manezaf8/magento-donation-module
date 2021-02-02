<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Sqli\Donation\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface DonationRepositoryInterface
{

    /**
     * Save Donation
     * @param \Sqli\Donation\Api\Data\DonationInterface $donation
     * @return \Sqli\Donation\Api\Data\DonationInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Sqli\Donation\Api\Data\DonationInterface $donation
    );

    /**
     * Retrieve Donation
     * @param string $donationId
     * @return \Sqli\Donation\Api\Data\DonationInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($donationId);

    /**
     * Retrieve Donation matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Sqli\Donation\Api\Data\DonationSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Donation
     * @param \Sqli\Donation\Api\Data\DonationInterface $donation
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Sqli\Donation\Api\Data\DonationInterface $donation
    );

    /**
     * Delete Donation by ID
     * @param string $donationId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($donationId);
}

