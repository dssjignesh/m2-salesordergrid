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

use Magento\Framework\View\Element\AbstractBlock;

class ColorColumn extends AbstractBlock
{
    /**
     * Element Function
     *
     * @return string
     */
    protected function _toHtml(): string
    {
        $html = '<input type="text" name="' . $this->getInputName() . '" id="' . $this->getInputId() . '">';
        $html .= '<script type="text/javascript">
require(["jquery","domReady!", "jquery/colorpicker/js/colorpicker"], function ($) {
    var $colorElement = $("#'.$this->getInputId().'");
    $colorElement.css("background", $colorElement.val());
    $colorElement.ColorPicker({
        onChange: function (hsb, hex, rgb) {
            $colorElement.css("backgroundColor", "#" + hex).val("#" + hex);
        }
    });
});
</script>';
        return $html;
    }
}
