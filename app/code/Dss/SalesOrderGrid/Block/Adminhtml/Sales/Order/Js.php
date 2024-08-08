<?php

declare(strict_types=1);

/**
 * Digit Software Solutions..
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category   Dss
 * @package    Dss_SalesOrderGrid
 * @author     Extension Team
 * @copyright Copyright (c) 2024 Digit Software Solutions. ( https://digitsoftsol.com )
 */

namespace Dss\SalesOrderGrid\Block\Adminhtml\Sales\Order;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Dss\SalesOrderGrid\Helper\Data as SalesOrderGridHelper;

class Js extends Template
{
    /**
     * Path to template file for grid.
     *
     * @var string
     */
    protected $_template = 'Dss_SalesOrderGrid::sales/order/js.phtml';

    /**
     * Js constructor.
     * @param Context $context
     * @param SalesOrderGridHelper $salesOrderGridHelper
     * @param array $data
     */
    public function __construct(
        protected Context $context,
        protected SalesOrderGridHelper $salesOrderGridHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Modify the _toHtml method
     *
     * @return string
     */
    protected function _toHtml(): string
    {
        if (!$this->isActive()) {
            return '';
        }

        return parent::_toHtml();
    }

    /**
     * Is active function
     *
     * @return bool
     */
    public function isActive():bool
    {
        return $this->salesOrderGridHelper->isActive();
    }

    /**
     * Base currency symbol
     *
     * @return string
     */
    public function getBaseCurrencySymbol(): string
    {
        return $this->_storeManager->getStore()->getBaseCurrency()->getCurrencySymbol();
    }

    /**
     * Modify the _toHtml method
     *
     * @return string
     */
    public function getAmountDisplayText(): string
    {
        return $this->salesOrderGridHelper->getConfig()->getAmountDisplayText();
    }

    /**
     * Amount display rounding function
     *
     * @return string
     */
    public function getAmountDisplayRounding(): string
    {
        return $this->salesOrderGridHelper->getConfig()->getAmountDisplayRounding();
    }

    /**
     * Grid config function
     *
     * @return array
     */
    public function getGridConfig():array
    {
        return [
            'is_active'                 => $this->isActive(),
            'base_currency_symbol'      => $this->getBaseCurrencySymbol(),
            'amount_display_text'       => $this->getAmountDisplayText(),
            'amount_display_rounding'   => $this->getAmountDisplayRounding()
        ];
    }
}
