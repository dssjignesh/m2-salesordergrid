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

namespace Dss\SalesOrderGrid\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Dss\SalesOrderGrid\Logger\Logger as ModuleLogger;
use Dss\SalesOrderGrid\Model\Config;

class Data extends AbstractHelper
{
    /**
     * Data Helper
     * @param Context $context
     * @param ModuleLogger $moduleLogger
     * @param Config $config
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        protected Context $context,
        protected ModuleLogger $moduleLogger,
        protected Config $config,
        protected StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
    }

    /**
     * Get config value
     *
     * @return void
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get Base Url
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->storeManager->getStore()->getBaseUrl(
            UrlInterface::URL_TYPE_WEB,
            true
        );
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->config->isActive();
    }

    /**
     * Logging Utility
     *
     * @param string $message
     * @param bool|false $useSeparator
     * @return bool
     */
    public function log($message, $useSeparator = false): bool
    {
        if ($this->isActive()
            && $this->config->isDebugEnabled()
        ) {
            if ($useSeparator) {
                $this->moduleLogger->customLog(str_repeat('=', 100));
            }

            $this->moduleLogger->customLog($message);
        }
    }
}
