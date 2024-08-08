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

use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use Dss\SalesOrderGrid\Model\Config;

class StatusColor
{

    /**
     * @var array
     */
    private $configValues;

    /**
     * StatusColor constructor.
     * @param Config $config
     * @param JsonSerializer $jsonSerializer
     */
    public function __construct(
        private Config $config,
        private JsonSerializer $jsonSerializer
    ) {
    }

    /**
     * Color by Status
     *
     * @param string $status
     * @return string
     */
    public function getColorByStatus($status): string
    {
        $configValues = $this->getConfigValues();
        $defaultValue = 'transparent';
        if (empty($configValues)) {
            return $defaultValue;
        }
        $value = $defaultValue;
        foreach ($configValues as $data) {
            if ($data['order_status'] == $status) {
                $value = $data['color'];
                break;
            }
        }
        return $value;
    }

    /**
     * Config values
     *
     * @return array|mixed
     */
    public function getConfigValues(): array
    {
        if (!$this->configValues) {
            $configValues = $this->config->getGridStatusColor();
            if (empty($configValues)) {
                return $this->configValues = [];
            }
            if (is_array($configValues)) {
                return $this->configValues = $configValues;
            }
            $this->configValues = $this->jsonSerializer->unserialize($configValues);
        }

        return $this->configValues;
    }
}
