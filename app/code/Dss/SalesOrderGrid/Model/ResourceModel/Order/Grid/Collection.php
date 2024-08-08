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

namespace Dss\SalesOrderGrid\Model\ResourceModel\Order\Grid;

use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as SalesOrderGridCollection;
use Zend_Db_Expr;

class Collection extends SalesOrderGridCollection
{
    /**
     * Sales ordet item id
     *
     * @var $this
     */
    protected function _initSelect(): self
    {
        parent::_initSelect();

        $this->join(
            [$this->getTable('sales_order_item')],
            "main_table.entity_id = {$this->getTable('sales_order_item')}.order_id",
            []
        );
        $this->getSelect()->group('main_table.entity_id');

        return $this;
    }

    /**
     * Add to field filter
     *
     * @param string $field
     * @param bool $condition
     * @return $this
     */

    public function addFieldToFilter($field, $condition = null)
    {
        if (!$this->getFlag('order_items_filter_added') && $field === 'purchase_items') {
            $this->getSelect()->join(
                ['purchase_item_table' => $this->getTable('sales_order_item')],
                "main_table.entity_id = purchase_item_table.order_id",
                []
            );
            $this->getSelect()->group('main_table.entity_id');

            $this->addFieldToFilter(
                [
                    "purchase_item_table.sku",
                    "purchase_item_table.name",
                ],
                [
                    $condition,
                    $condition,
                ]
            );

            $this->setFlag('order_items_filter_added', true);
            return $this;
        }

        return parent::addFieldToFilter($field, $condition);
    }

    /**
     * After load.
     *
     * @var string
     */
    protected function _afterLoad()
    {
        $items = $this->getColumnValues('entity_id');

        if (count($items)) {
            $connection = $this->getConnection();

            $select = $connection->select()
                ->from([
                    'sales_order_item' => $this->getTable('sales_order_item'),
                ], [
                    'order_id',
                    'item_skus'  => new Zend_Db_Expr('GROUP_CONCAT(`sales_order_item`.sku SEPARATOR "|")'),
                    'item_names' => new Zend_Db_Expr('GROUP_CONCAT(`sales_order_item`.name SEPARATOR "|")'),
                    'item_qtys'  => new Zend_Db_Expr('GROUP_CONCAT(`sales_order_item`.qty_ordered SEPARATOR "|")'),
                ])
                ->where('order_id IN (?)', $items)
                ->where('parent_item_id IS NULL')
                ->group('order_id');

            $items = $connection->fetchAll($select);
            foreach ($items as $item) {
                $row = $this->getItemById($item['order_id']);
                $itemSkus = explode('|', $item['item_skus']);
                $itemQtys = explode('|', $item['item_qtys']);
                $itemNames = explode('|', $item['item_names']);

                $html = '';
                foreach ($itemSkus as $index => $sku) {
                    $html .= sprintf('<div>%d x %s (%s) </div>', $itemQtys[$index], $itemNames[$index], $sku);
                }

                $row->setData('purchase_items', $html);
            }
        }

        return parent::_afterLoad();
    }
}
