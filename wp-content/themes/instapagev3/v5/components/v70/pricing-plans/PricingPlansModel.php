<?php
namespace Instapage\Components\v70\PricingPlans;

use Instapage\Models\Component as ModelComponent;
use Instapage\Helpers\AcfHelper;

/**
 * Model for Left-Right component
 *
 */
class PricingPlansModel extends ModelComponent
{

    public function getPlansHeader(): string
    {
        return (string) get_field('plans_header_title');
    }

    public function getPlansHeaderButton() : array
    {
        $plansHeaderButton = [];
        while (have_rows('plans_header_button')) {
            the_row();
            $plansHeaderButton[] = AcfHelper::parseButtonAttributes([
              'class' => 'v7-btn-small v7-modal-header-btn ',
              'text' => get_sub_field('text'),
              'url' => get_sub_field('url'),
              'type' => get_sub_field('type')
            ]);
        }

        return $plansHeaderButton;
    }
    
    public function getPlansColumns(): array
    {
        return (array) get_field('plans_columns');
    }
    
    public function getPlansPackages(): array
    {
        return (array) get_field('plans_packages');
    }

    public function getPlansButtons() : array
    {
        $plansButtons = [];
        while (have_rows('plans_footer')) {
            the_row();
            $plansButtons[] = AcfHelper::parseButtonAttributes([
              'class' => 'v7-btn-small ',
              'text' => get_sub_field('text'),
              'url' => get_sub_field('url'),
              'type' => get_sub_field('type')
            ]);
        }

        return $plansButtons;
    }

    /**
     * Method from abstract class telling which info model can generate
     *
     * @return array
     */
    public function getParamsListToInject() : array
    {
        return [
            'plansHeader',
            'plansHeaderButton',
            'plansColumns',
            'plansPackages',
            'plansButtons'
        ];
    }
}
