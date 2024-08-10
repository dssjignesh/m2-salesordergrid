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

namespace Dss\SalesOrderGrid\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    public const DEFAULT_AMOUNT_DISPLAY_TEXT = '| Total amount {{amount}}';

    public const XML_PATH_ENABLED = 'Dss_salesordergrid/general/enabled';
    public const XML_PATH_DEBUG = 'Dss_salesordergrid/general/debug';

    public const XML_PATH_GRID_AMOUNT_DISPLAY_TEXT       = 'Dss_salesordergrid/grid/amount_display_text';
    public const XML_PATH_GRID_AMOUNT_DISPLAY_ROUNDING   = 'Dss_salesordergrid/grid/amount_display_rounding';
    private const XML_PATH_GRID_STATUS_COLOR = 'Dss_salesordergrid/grid/status_color';

    /**
     * Config Model constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        protected ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Config flag
     *
     * @param string $xmlPath
     * @param int $storeId
     * @return bool
     */
    public function getConfigFlag($xmlPath, $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            $xmlPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Config flag
     *
     * @param string $xmlPath
     * @param int $storeId
     * @return void
     */
    public function getConfigValue($xmlPath, $storeId = null)
    {
        // var_dump($this->scopeConfig->getValue(
        //     $xmlPath,
        //     ScopeInterface::SCOPE_STORE,
        //     $storeId
        // ));
        return $this->scopeConfig->getValue(
            $xmlPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Config flag
     *
     * @param int $storeId
     * @return bool
     */
    public function isEnabled($storeId = null): bool
    {
        return $this->getConfigFlag(self::XML_PATH_ENABLED, $storeId);
    }

    /**
     * Is active
     *
     * @param int $storeId
     * @return bool
     */

    public function isActive($storeId = null): bool
    {
        return $this->isEnabled($storeId);
    }

    /**
     * Debug Enable
     *
     * @param int $storeId
     * @return string
     */
    public function isDebugEnabled($storeId = null): string
    {
        return $this->getConfigFlag(self::XML_PATH_DEBUG, $storeId);
    }

    /**
     * Amount DisplayText
     *
     * @param int $storeId
     * @return string
     */
    public function getAmountDisplayText($storeId = null): string
    {
        $text = $this->getConfigValue(self::XML_PATH_GRID_AMOUNT_DISPLAY_TEXT, $storeId);
        if (empty($text) || strpos($text, '{{amount}}') === false) {
            return self::DEFAULT_AMOUNT_DISPLAY_TEXT;
        }
        return $text;
    }

    /**
     * Amount DisplayRounding
     *
     * @param int $storeId
     * @return string
     */
    public function getAmountDisplayRounding($storeId = null): string
    {
        return $this->getConfigValue(self::XML_PATH_GRID_AMOUNT_DISPLAY_ROUNDING, $storeId);
    }

    /**
     * Grid StatusColor
     *
     * @param int $storeId
     * @return string
     */
    public function getGridStatusColor($storeId = null): string
    {
        return $this->getConfigValue(self::XML_PATH_GRID_STATUS_COLOR, $storeId);
    }
}
