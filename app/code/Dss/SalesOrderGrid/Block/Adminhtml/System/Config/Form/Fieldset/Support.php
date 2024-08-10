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

namespace Dss\SalesOrderGrid\Block\Adminhtml\System\Config\Form\Fieldset;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Dss\SalesOrderGrid\Model\Config\ModuleMetadata;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;

class Support extends Template implements RendererInterface
{
    /**
     * Path to template file for system config
     *
     * @var string
     */
    protected $_template = 'Dss_SalesOrderGrid::system/config/form/fieldset/support.phtml';

    /**
     * Support constructor.
     * @param Context $context
     * @param ModuleMetadata $moduleMetadata
     * @param array $data
     */
    public function __construct(
        protected Context $context,
        protected ModuleMetadata $moduleMetadata,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Render Function
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element): string
    {
        if ($this->moduleMetadata->soldViaMagentoMarketplace()) {
            return '';
        }
        return $this->toHtml();
    }

    /**
     * Mageversion Function
     *
     * @return string
     */
    public function getMageVersion(): string
    {
        $mageVersion = $this->moduleMetadata->getMageVersion();
        $mageEdition = $this->moduleMetadata->getMageEdition();
        switch ($mageEdition) {
            case 'Community':
                $mageEdition = 'CE';
                break;
            case 'Enterprise':
                $mageEdition = 'EE';
                break;
        }

        return $mageEdition . ' ' . $mageVersion;
    }

    /**
     * Module vesrion
     *
     * @return string
     */
    public function getModuleVersion(): string
    {
        return $this->moduleMetadata->getVersion();
    }

    /**
     * Extension Name
     *
     * @return string
     */
    public function getExtensionName(): string
    {
        return $this->moduleMetadata->getName();
    }

    /**
     * Platform function
     *
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->moduleMetadata->getPlatformShort();
    }
}
