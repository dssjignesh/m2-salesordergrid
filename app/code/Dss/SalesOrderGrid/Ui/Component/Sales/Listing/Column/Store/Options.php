<?php

declare(strict_types = 1);

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

namespace Dss\SalesOrderGrid\Ui\Component\Sales\Listing\Column\Store;

use Magento\Framework\Escaper;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Store\Model\System\Store as SystemStore;

class Options implements OptionSourceInterface
{
    /**
     * Constructor
     *
     * @param SystemStore $systemStore
     * @param Escaper $escaper
     * @param array $options
     * @param array $currentOptions
     */
    public function __construct(
        protected SystemStore $systemStore,
        protected Escaper $escaper,
        protected $options = [],
        protected $currentOptions = []
    ) {
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $this->generateCurrentOptions();

        $this->options = array_values($this->currentOptions);

        return $this->options;
    }

    /**
     * Generate current options
     *
     * @return void
     */
    protected function generateCurrentOptions()
    {
        $websiteCollection  = $this->systemStore->getWebsiteCollection();
        $groupCollection    = $this->systemStore->getGroupCollection();
        $storeCollection    = $this->systemStore->getStoreCollection();
        /** @var \Magento\Store\Model\Website $website */
        foreach ($websiteCollection as $website) {
            /** @var \Magento\Store\Model\Group $group */
            foreach ($groupCollection as $group) {
                if ($group->getWebsiteId() == $website->getId()) {
                    /** @var  \Magento\Store\Model\Store $store */
                    foreach ($storeCollection as $store) {
                        if ($store->getGroupId() == $group->getId()) {
                            $name = sprintf(
                                '%s/%s',
                                $this->escaper->escapeHtml($website->getName()),
                                $this->escaper->escapeHtml($store->getName())
                            );
                            $this->currentOptions[$name]['label'] = $name;
                            $this->currentOptions[$name]['value'] = $store->getId();
                        }
                    }
                }
            }
        }
    }
}
