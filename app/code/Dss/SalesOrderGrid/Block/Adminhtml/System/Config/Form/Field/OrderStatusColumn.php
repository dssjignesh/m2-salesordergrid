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

namespace Dss\SalesOrderGrid\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\View\Element\Html\Select;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Model\ResourceModel\Order\Status\Collection as OrderStatusCollection;

class OrderStatusColumn extends Select
{
    /**
     * OrderStatusColumn constructor.
     * @param Context $context
     * @param OrderStatusCollection $orderStatusCollection
     * @param array $data
     */
    public function __construct(
        protected Context $context,
        protected OrderStatusCollection $orderStatusCollection,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName(string $value): self
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputId(string $value): self
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    /**
     * Get source array
     *
     * @return array
     */
    private function getSourceOptions(): array
    {
        return $this->orderStatusCollection->toOptionArray();
    }
}
