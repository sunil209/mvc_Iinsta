<?php
namespace Instapage\Components\v70\PricingCards;

use Instapage\Models\Component;
use Instapage\Helpers\AcfHelper;

/**
 * Model for pricing cards component
 *
 */
class PricingCardsModel extends Component
{
    public function getCards(): array
    {
        $pricingCards = get_field('pricing_cards', $this->contextID) ?? [];
        $pricingFeatures = get_field('features_list', $this->contextID) ?? [];

        $pricingCardMapped = array_map(function (array $card) {
            $card['button'] = AcfHelper::parseButtonAttributes($card['button']);

            return $card;
        }, $pricingCards);

        return (array) $pricingCardMapped;
    }

    public function getFeatures(): array
    {
        $pricingFeatures = get_field('features_list', $this->contextID) ?? [];

        return (array) $pricingFeatures;
    }

    public function getButton() : array
    {
        $btnArray = get_field('pricing_cards_button_bottom');

        if (($btnArray['show_button'] ?? false) === true) {
            return AcfHelper::parseButtonAttributes($btnArray['button']);
        }
        
        return [];
    }


    /**
     * Method from abstract class telling which info model can generate
     *
     * @return array
     */
    public function getParamsListToInject() : array
    {
        return [
            'cards',
            'features',
            'button'
        ];
    }
}
