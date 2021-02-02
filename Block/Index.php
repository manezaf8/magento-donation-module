<?php
namespace Maneza\Donation\Block;

class Index extends \Magento\Framework\View\Element\Template
{

    protected $DonationFactory;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Maneza\Donation\Model\DonationFactory $DonationFactory,
        array $data = []
    ) {
        $this->donationFactory = $DonationFactory;
        parent::__construct($context, $data);
    }

     public function getResult()
     {
          $data = $this->donationFactory->create();
          $collection = $data->getCollection();
          return $collection;
     }
}
