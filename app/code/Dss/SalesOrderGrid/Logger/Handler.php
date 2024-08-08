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

namespace Dss\SalesOrderGrid\Logger;

use Magento\Framework\Logger\Handler\Base;

class Handler extends Base
{
    /**
     * Path to template file for log.
     *
     * @var string
     */
    protected $fileName = '/var/log/Dss_salesordergrid.log';

    /**
     * Path to template file for logtype
     *
     * @var int
     */
    protected $loggerType = \Monolog\Logger::INFO;
}
