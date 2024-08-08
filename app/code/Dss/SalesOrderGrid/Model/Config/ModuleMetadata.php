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

namespace Dss\SalesOrderGrid\Model\Config;

use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Config;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Component\ComponentRegistrarInterface;
use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\Framework\Module\ModuleListInterface;

class ModuleMetadata implements ModuleMetadataInterface
{
    private const PLATFORM_NAME = 'Magento 2';

    private const PLATFORM_NAME_SHORT = 'M2';

    private const PRODUCT_NAME = 'Enhanced Order Grid';

    private const PRODUCT_URL = 'https://www.Dss.com/magento2-enhanced-admin-order-grid.html';

    private const MODULE_NAME = 'Dss_SalesOrderGrid';

    private const VERSION_CACHE_KEY = 'Dss-salesordergrid-module-version';

    private const SELLER_PLATFORM = 'Dss.com'; #Dss.com|marketplace.magento.com

    /**
     * Module version
     *
     * @var string
     */
    protected $version;

    /**
     * Magento Version
     *
     * @var string
     */
    protected $mageVersion;

    /**
     * Magento Edition
     *
     * @var string
     */
    protected $mageEdition;

    /**
     * Module metadata constructor.
     * @param ProductMetadataInterface $productMetadata
     * @param ModuleListInterface $moduleList
     * @param ComponentRegistrarInterface $componentRegistrar
     * @param ReadFactory $readFactory
     * @param CacheInterface $cache
     */
    public function __construct(
        private ProductMetadataInterface $productMetadata,
        private ModuleListInterface $moduleList,
        private ComponentRegistrarInterface $componentRegistrar,
        private ReadFactory $readFactory,
        private CacheInterface $cache
    ) {
        $this->cache = $cache ?: ObjectManager::getInstance()->get(CacheInterface::class);
    }

    /**
     * Get Product version
     *
     * @return string
     */
    public function getVersion(): string
    {
        $this->version = $this->version ?: $this->cache->load(self::VERSION_CACHE_KEY);
        if (!$this->version) {
            if (!($this->version = $this->getSetupVersion())) {
                $this->version = $this->getComposerVersion();
            }
            $this->cache->save($this->version, self::VERSION_CACHE_KEY, [Config::CACHE_TAG]);
        }
        return $this->version;
    }

    /**
     * Get Product edition
     *
     * @return string
     */
    public function getEdition(): string
    {
        return $this->getMageEdition();
    }

    /**
     * Get Magento version
     *
     * @return string
     */
    public function getMageVersion(): string
    {
        if (!$this->mageVersion) {
            $this->mageVersion = $this->productMetadata->getVersion();
        }
        return $this->mageVersion;
    }

    /**
     * Get Magento edition
     *
     * @return string
     */
    public function getMageEdition(): string
    {
        if (!$this->mageEdition) {
            $this->mageEdition = $this->productMetadata->getEdition();
        }
        return $this->mageEdition;
    }

    /**
     * Get Platform name
     *
     * @return string
     */
    public function getPlatform(): string
    {
        return self::PLATFORM_NAME;
    }

    /**
     * Get Platform short name
     *
     * @return string
     */
    public function getPlatformShort(): string
    {
        return self::PLATFORM_NAME_SHORT;
    }

    /**
     * Get Seller platform name
     *
     * @return string
     */
    public function getSellerPlatform(): string
    {
        return self::SELLER_PLATFORM;
    }

    /**
     * Magento market place
     *
     * @return bool
     */
    public function soldViaMagentoMarketplace(): bool
    {
        return self::SELLER_PLATFORM == 'marketplace.magento.com';
    }

    /**
     * Get Product name
     *
     * @return string
     */
    public function getName(): string
    {
        return self::PRODUCT_NAME;
    }

    /**
     * Get Product URL
     *
     * @return string
     */
    public function getUrl(): string
    {
        return self::PRODUCT_URL;
    }

    /**
     * Get Setup version
     *
     * @return string
     */
    private function getSetupVersion(): string
    {
        $moduleInfo = $this->moduleList->getOne(self::MODULE_NAME);
        return $moduleInfo['setup_version'] ?? '';
    }

    /**
     * Get composer version
     *
     * @return string
     */
    private function getComposerVersion(): string
    {
        $path = $this->componentRegistrar->getPath(
            \Magento\Framework\Component\ComponentRegistrar::MODULE,
            self::MODULE_NAME
        );
        $directoryRead = $this->readFactory->create($path);
        $composerJsonData = $directoryRead->readFile('composer.json');
        $data = \json_decode($composerJsonData);

        return !empty($data->version) ? $data->version : __('NA');
    }
}
