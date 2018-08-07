<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Catalog\Block\Product\View\Options\View;

use Magento\Catalog\Api\Data\ProductCustomOptionValuesInterface;
use Magento\Catalog\Block\Product\View\Options\AbstractOptions;

/**
 * Class Checkable
 * @package Magento\Catalog\Block\Product\View\Options\View
 */
class Checkable extends AbstractOptions
{
    /** @noinspection ClassOverridesFieldOfSuperClassInspection */
    /**
     * @var string
     */
    protected $_template = 'Magento_Catalog::product/composite/fieldset/options/view/checkable.phtml';

    /**
     * @param ProductCustomOptionValuesInterface $value
     * @return string
     */
    public function formatPrice(ProductCustomOptionValuesInterface $value): string
    {
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        return parent::_formatPrice(
            [
                'is_percent' => $value->getPriceType() === 'percent',
                'pricing_value' => $value->getPrice($value->getPriceType() === 'percent')
            ]
        );
    }

    /**
     * @param ProductCustomOptionValuesInterface $value
     * @return float|string
     */
    public function getCurrencyByStore(ProductCustomOptionValuesInterface $value)
    {
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        return $this->pricingHelper->currencyByStore(
            $value->getPrice(true),
            $this->getProduct()->getStore(),
            false
        );
    }

    /**
     * @param mixed $option
     * @return string|array|null
     */
    public function getPreconfiguredValue($option)
    {
        return $this->getProduct()->getPreconfiguredValues()->getData('options/' . $option->getId());
    }
}
