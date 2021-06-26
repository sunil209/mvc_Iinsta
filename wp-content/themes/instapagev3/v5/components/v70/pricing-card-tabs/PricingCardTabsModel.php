<?php
namespace Instapage\Components\v70\PricingCardTabs;

use Instapage\Models\Component;
use Instapage\Helpers\AcfHelper;

/**
 * Model for pricing cards component
 *
 */
class PricingCardTabsModel extends Component
{

    public function getPricingContent():array 
    {
        $pricingContentTable = get_field('pricing_content', $this->contextID) ?? [];
        return (array) $pricingContentTable;
    }

    public function getPricingList():array 
    {
        $pricingContentTable = get_field('pricing_button', $this->contextID) ?? [];
        return (array) $pricingContentTable;
    }

    public function getDiscountLabel() 
    {
        return  get_field('discount_label', $this->contextID) ?? '';
    }

    /**
     * Method from abstract class telling which info model can generate
     *
     * @return array
     */
    public function getParamsListToInject() : array
    {
        return [
            'pricingContent',
            'pricingList',
            'discountLabel'
        ];
    }
}
