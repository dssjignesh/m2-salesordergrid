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

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Dss\SalesOrderGrid\Model\Config\ModuleMetadata;
use Dss\SalesOrderGrid\Helper\Data as SalesOrderGridHelper;

class Version extends Field
{
    /**
     * Version constructor.
     * @param Context $context
     * @param SalesOrderGridHelper $goToCatalogHelper
     * @param ModuleMetadata $moduleMetadata
     */
    public function __construct(
        protected Context $context,
        protected SalesOrderGridHelper $goToCatalogHelper,
        protected ModuleMetadata $moduleMetadata
    ) {
        parent::__construct($context);
    }

    /**
     * Element Function
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        if ($this->moduleMetadata->soldViaMagentoMarketplace()) {
            $versionLabel = $this->moduleMetadata->getVersion();
        } else {
            $versionLabel = sprintf(
                '<a href="%s" title="%s" target="_blank">%s</a>',
                $this->moduleMetadata->getUrl(),
                $this->moduleMetadata->getName(),
                $this->moduleMetadata->getVersion()
            );
        }
        $element->setValue($versionLabel);

        return $element->getValue();
    }
}
