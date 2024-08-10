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

/**
 * Module metadata
 *
 * @api
 */
interface ModuleMetadataInterface
{
    /**
     * Get Module version
     *
     * @return string
     */
    public function getVersion();

    /**
     * Get Module edition
     *
     * @return string
     */
    public function getEdition();

    /**
     * Get Module name
     *
     * @return string
     */
    public function getName();
}
