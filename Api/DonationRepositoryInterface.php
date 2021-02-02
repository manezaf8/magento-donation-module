<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Maneza\Donation\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface DonationRepositoryInterface
{

    /**
     * Save Donation
     * @param \Maneza\Donation\Api\Data\DonationInterface $donation
     * @return \Maneza\Donation\Api\Data\DonationInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Maneza\Donation\Api\Data\DonationInterface $donation
    );

    /**
     * Retrieve Donation
     * @param string $donationId
     * @return \Maneza\Donation\Api\Data\DonationInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($donationId);

    /**
     * Retrieve Donation matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Maneza\Donation\Api\Data\DonationSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Donation
     * @param \Maneza\Donation\Api\Data\DonationInterface $donation
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Maneza\Donation\Api\Data\DonationInterface $donation
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

