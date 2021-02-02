<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Sqli\Donation\Api\Data;

interface DonationSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Donation list.
     * @return \Sqli\Donation\Api\Data\DonationInterface[]
     */
    public function getItems();

    /**
     * Set donation list.
     * @param \Sqli\Donation\Api\Data\DonationInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

