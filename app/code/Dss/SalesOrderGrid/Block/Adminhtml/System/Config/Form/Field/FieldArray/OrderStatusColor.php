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

namespace Dss\SalesOrderGrid\Block\Adminhtml\System\Config\Form\Field\FieldArray;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Dss\SalesOrderGrid\Block\Adminhtml\System\Config\Form\Field\OrderStatusColumn;
use Dss\SalesOrderGrid\Block\Adminhtml\System\Config\Form\Field\ColorColumn;

class OrderStatusColor extends AbstractFieldArray
{

    /**
     * @var OrderStatusColumn
     */
    private $orderStatusRenderer;

    /**
     * @var ColorColumn
     */
    private $colorRenderer;

    /**
     * Prepare layout
     *
     * @return $this
     */
    protected function _prepareToRender(): self
    {
        $this->addColumn(
            'order_status',
            [
                'label' => __('Order Status'),
                'renderer' => $this->getOrderStatusRenderer()
            ]
        );
        $this->addColumn(
            'color',
            [
                'label' => __('Color'),
                'renderer' => $this->getColorRenderer()
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add New');
        return $this;
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];
        $orderStatus = $row->getOrderStatus();
        if ($orderStatus !== null) {
            $options['option_' . $this->getOrderStatusRenderer()->calcOptionHash($orderStatus)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * Order status render
     *
     * @return OrderStatusColumn
     * @throws LocalizedException
     */
    private function getOrderStatusRenderer()
    {
        if (!$this->orderStatusRenderer) {
            $this->orderStatusRenderer = $this->getLayout()->createBlock(
                OrderStatusColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->orderStatusRenderer;
    }

    /**
     * Color render
     *
     * @return ColorColumn
     * @throws LocalizedException
     */
    private function getColorRenderer()
    {
        if (!$this->colorRenderer) {
            $this->colorRenderer = $this->getLayout()->createBlock(
                ColorColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->colorRenderer;
    }
}
