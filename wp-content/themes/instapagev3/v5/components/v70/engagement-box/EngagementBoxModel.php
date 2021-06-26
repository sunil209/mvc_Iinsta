<?php
namespace Instapage\Components\v70\EngagementBox;

use Instapage\Models\Component;

/**
 * Model for v7 Engagement box component
 *
 */
class EngagementBoxModel extends Component
{
    public function getEngagementBox() : array
    {
        return (array) get_field('engagement_box');
    }

    /**
     * Method from abstract class telling which info model can generate
     *
     * @return array
     */
    public function getParamsListToInject() : array
    {
        return ['engagementBox'];
    }
}
