<?php
namespace Instapage\Helpers;

class AcfHelper
{
    /**
     *
     * @param array $attributes - attributes from ACF
     * @return array $buttonAttributes
     */
    public static function parseButtonAttributes(array $attributes = []) : array
    {
        $buttonAttributes = [
          'text' => $attributes['text'],
          'url' => $attributes['url'],
          'class' => $attributes['class'] ?? ''
        ];

        if ($attributes['size'] == 'small') {
            $buttonAttributes['class'] .= 'v7-btn-small ';
        } else {
            $buttonAttributes['class'] .= '';
        }

        switch ($attributes['type']) {
            case 'ghost-blue':
                $buttonAttributes['class'] .= 'v7-btn-ghost-cta';
                break;
            case 'ghost-white':
                $buttonAttributes['class'] .= 'v7-btn-ghost';
                break;
            case 'white':
                $buttonAttributes['class'] .= 'v7-btn-white';
                break;
            case 'no_background':
                $buttonAttributes['class'] .= 'v7-btn-flat';
                break;
            case 'rounded':
                $buttonAttributes['class'] .= 'v7-btn-round v7-btn-round-white';
                break;
            default:
                $buttonAttributes['class'] .= 'v7-btn-cta';
        }

        if ($attributes['video']) {
            $buttonAttributes['class'] .= ' js-video-trigger';
            $buttonAttributes['icon'] = 'play_arrow';
            $buttonAttributes['video'] =  true;
        }
        
        if ($attributes['play_arrow']) {
            $buttonAttributes['icon'] = 'play_arrow';
        }

        return $buttonAttributes;
    }
}
