<?php
namespace Maneza\Donation\Model\Total;

class Donationfee extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * donationFactory
     *
     * @var \Maneza\Donation\Model\Donation $donationFactory
     */
    protected $donationFactory;

    /**
     * @var \Magento\Framework\Json\Helper\Data $helper
     */
    protected $helper;

    /**
     * quoteValidator
     *
     * @var \Magento\Quote\Model\QuoteValidator $quoteValidator
     */
    protected $quoteValidator = null; 

    protected $request;

    /**
     * @var \Maneza\Donation\Api\Data\DonationInterface $donationInterface
     */
    protected $donationInterface;

    public function __construct(
        \Maneza\Donation\Api\Data\DonationInterface $donationInterface,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Quote\Model\QuoteValidator $quoteValidator,
        \Magento\Framework\Json\Helper\Data $helper,
        \Maneza\Donation\Model\DonationFactory $donationFactory
        )
    {
        $this->donationInterface = $donationInterface;
        $this->request = $request;
        $this->helper = $helper;
        $this->quoteValidator = $quoteValidator;
        $this->donationFactory = $donationFactory;
    }

    /**
     * Collect donation fee
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return void
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        //$donation_amount = $this->donationFactory->create();

        $exist_amount = 0; // always have to be 0
        $donation_amount = $this->getDonationCurentDonation(); 
        $balance = $donation_amount - $exist_amount;//final amount

        $label = $this->getLabel() ?? $this->getTitle();

        $total->setTotalAmount('donationAmount', $balance);
        $total->setBaseTotalAmount('donationAmount', $balance);

        $total->setDonationAmount($balance);
        $total->setBaseDonationAmount($balance);

        $total->setGrandTotal($total->getGrandTotal() + $balance);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() + $balance);


        return $this;
    } 
    
    /**
     * Clear donation values
     *
     * @param Address\Total $total
     * @return void
     */
    protected function clearValues(Address\Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }
    
    /**
     * Assign subtotal amount and label to address object
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        return [
            'code' => 'donation_amount',
            'title' => $this->getTitle(),
            'value' => null //$this->donationFactory->getDonationAmount()
        ];
    }

    

    /**
     * Get the Title
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTitle()
    {
        return __('Donation');
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Donation Amount');
    }

    
    protected function getDonationCurentDonation()
    {
        $model = $this->donationFactory->create();
        $collection = $model->getCollection();
		foreach($collection as $item){
			
			$model = $item->getData('donation_amount');
			
		}
        //$model->load($item);
        return $model;
    }
    
}