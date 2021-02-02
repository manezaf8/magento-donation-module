<?php
namespace Sqli\Donation\Controller\Ajax;

use \Sqli\Donation\Api\Data\DonationInterface;

class Save extends \Magento\Framework\App\Action\Action 
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @var \Magento\Framework\Json\Helper\Data $helper
     */
    protected $helper;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var Sqli\Donation\Model\DonationFactory
     */
    protected $donationFactory;


    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
       \Magento\Framework\View\Result\PageFactory $pageFactory,
       \Magento\Customer\Model\Session $customerSession,
       \Magento\Framework\Json\Helper\Data $helper,
       \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
       \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
       \Sqli\Donation\Model\DonationFactory $donationFactory
    )
    {
        $this->donationFactory = $donationFactory;
        $this->_customerSession = $customerSession;
        $this->_pageFactory = $pageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultRawFactory = $resultRawFactory;
        $this->helper = $helper;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $model = $this->donationFactory->create();
        //create a factory or use the interface
        $data = $this->helper->jsonDecode($this->getRequest()->getContent());
        $model->setData($data);
        $model->save();
        
        $collection = $model->getCollection();
        foreach ($collection as $data) {
           $response[] = ['donation_amount' => $data->getDonationAmount()];
        }
        
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($response);
    }
}
