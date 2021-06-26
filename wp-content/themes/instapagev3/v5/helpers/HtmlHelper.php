<?php
namespace Instapage\Helpers;

use \Instapage\Classes\SimpleNonce;

class HtmlHelper
{
    private static $imageSizes = [
        'medium_large',
        'large',
        'listing-size',
        'listing-size-retina',
        'v5-single-size',
        'v5-single-size-retina',
        'v5-listing-size',
        'v5-listing-size-retina',
        'v5-resources-size',
        'v5-resources-size-retina'
    ];
    /**
     * Renders custom attributes.
     * @param array $attributes - List of attributes to render. Key is the attribute name.
     * @return string Rendered attribute list.
     */
    public static function renderAttributes($attributes = [])
    {
        $attributesString = '';

        if ((is_array($attributes)) && (!empty($attributes))) {
            foreach ($attributes as $attributeName => $attributeValue) {
                $attributesString .=  ' ' . $attributeName . '="' . $attributeValue . '"';
            }
        }

        return trim($attributesString);
    }

    /**
     * Renders logo svg icon
     * @param  string `small` | `big`
     * @return void
     */
    public static function renderLogo()
    {
        include get_template_directory() . '/v5/views/parts/logo.php';
    }

    public static function cleanUrl($url)
    {
        $replacements = ['#038;' => '&', '&&' => '&'];

        foreach ($replacements as $searched => $replacemnt) {
            if (stripos($url, $searched) !== false) {
                $url = str_replace($searched, $replacemnt, $url);
            }
        }

        return $url;
    }

    /**
     * Renders a srcset attribute.
     * @param array $set - List of image URLs. Key of the array is a width descriptor or pixel density descriptor.
     * @return string srcset attribute.
     */
    public static function renderSrcSet($set = [], $attributeName = 'srcset')
    {
        $html = self::renderSrcSetValue($set);

        if ($html !== '') {
            return $attributeName . '="' . $html . '"';
        }
    }

    /**
     * Renders a srcset attribute value.
     * @param array $set - List of image URLs. Key of the array is a width descriptor or pixel density descriptor.
     * @return string srcset attribute value.
     */
    public static function renderSrcSetValue($set = [])
    {
        if (empty($set) || !is_array($set)) {
            return '';
        }

        $html = '';

        foreach ($set as $descriptor => $url) {
            if (!empty($url) && !empty($descriptor)) {
                if ($html !== '') {
                    $html .= ', ';
                }

                $html .= $url . ' ' . $descriptor;
            }
        }

        return $html;
    }

    /**
     * Creates nonce
     * @param  string $name Nonce name
     * @uses   \Instapage\Classes\SimpleNonce::createNonceField()
     * @return  void
     */
    public static function createNonceField($name = 'nonce')
    {
        $nonce = \Instapage\Classes\SimpleNonce::createNonceField($name);
        \Instapage\Classes\SimpleNonce::nonceView($nonce);
    }

    /**
     * Render Image element for header
     *
     * @param string $attachment_id
     * @param string $class
     * @param string $title
     * @return string
     */
    public static function renderHeaderImg(string $attachment_id, string $class = '', string $title = '') : string
    {
        $srcset = [];
        $src = '';

        foreach (self::$imageSizes as $size) {
            $thumb = wp_get_attachment_image_src($attachment_id, $size);
            if ($size === 'v5-resources-size') {
                $src = $thumb[0];
            }
            $srcset[] = $thumb[0] . ' ' . $thumb[1] . 'w';
        }
    
        return '<img src="' . $src . '"' .
            'srcset="' . implode(', ', $srcset) . '"' .
            'class="' . $class . '"' .
            'alt="' . esc_attr($title) . '" />';
    }

    public static function setParagraph(string $text): string
    {
        if (strpos($text, '<p>') === false) {
            $text = '<p>' . $text . '</p>';
        }
        
        return $text;
    }

    /**
     * Get array with img url (if first size not exist return other size)
     *
     * @param string $size1 image size you looking for
     * @param string $size2 image size if $size1 not exist
     * @param int $id post_id
     * @return array|bool  with url of image or false
     */
    public static function getImgUlrIfSizeExists(string $size1, string $size2, int $id)
    {
        $imgSize =  (string) wp_get_additional_image_sizes()[$size1]['height'];
        $imgAttachment = wp_get_attachment_image_src(get_post_thumbnail_id($id), $size1);
        
        return strpos($imgAttachment[0], $imgSize) !== false ?
            $imgAttachment :
            wp_get_attachment_image_src(get_post_thumbnail_id($id), $size2);
    }
}
