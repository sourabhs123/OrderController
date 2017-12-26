<?php

namespace Born\OrderController\Controller\OrderController;


class Index extends \Magento\Framework\App\Action\Action
{
    /**
     *
     * @var \Magento\Framework\App\Action\Context
     */
    protected $context;

    protected $salesOrderFactory;
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
       \Magento\Sales\Model\OrderFactory $salesOrderFactory
      )
    {
        parent::__construct($context);
        $this->salesOrderFactory = $salesOrderFactory;
    }
    public function execute()
    {
        
        $order = $this->salesOrderFactory->create()->load($this->_request->getParam('orderid'));
        
        if ($order->getCustomerIsGuest() == 1)
        {
            $orderArr = array();
            $orderArr['status'] = $order->getStatus();
            $orderArr['total_item_count'] = $order->getTotalItemCount();
            $orderArr['total_invoice'] = $order->getTotalDue();
            $orderItemsArr = array();
            $i = 0;
            foreach($order->getAllItems() as $eachItem)
            {
                $orderItemsArr[$i]['sku'] = $eachItem->getSku();
                $orderItemsArr[$i]['item_id'] = $eachItem->getItemId();
                $orderItemsArr[$i]['item_price'] = $eachItem->getPrice();
                $i++;
            }
            $orderArr['item_data'] = $orderItemsArr;
            echo json_encode($orderArr);
        }
        else
        {
            echo 'Not a guest order';
        }
       
    }

}
