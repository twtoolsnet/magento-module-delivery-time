<?php

namespace Unexpected\DeliveryTime\Plugin\Model;

use Magento\Checkout\Model\DefaultConfigProvider as Subject;
use Unexpected\DeliveryTime\Helper\Config;
use Unexpected\DeliveryTime\Helper\View;

class DefaultConfigProvider
{
    /** @var Config */
    private $config;

    /** @var View */
    private $view;

    /**
     * DefaultConfigProvider constructor.
     * @param Config $config
     * @param View $view
     */
    public function __construct(Config $config, View $view)
    {
        $this->config = $config;
        $this->view = $view;
    }

    /**
     * @param Subject $subject
     * @param array $result
     * @return array
     */
    public function afterGetConfig(Subject $subject, array $result): array
    {
        $items = $result['totalsData']['items'];
        for ($i = 0; $i < count($items); $i++) {
            $product = $result['quoteItemData'][$i]['product'];
            $items[$i]['delivery_time'] = $this->view->renderFromProductArray($product);
        }
        $result['totalsData']['items'] = $items;
        return $result;
    }
}
