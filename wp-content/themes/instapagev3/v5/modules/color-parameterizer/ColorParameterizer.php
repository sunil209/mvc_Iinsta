<?php

namespace Instapage\Modules\ColorParameterizer;


class ColorParameterizer
{
    /**
     * Run whole module
     */
    public function run() : void
    {
        add_action('wp', function () {
            if ($this->shouldRun()) {
                $this->addClassForBodyBasedOnPageUrl();
                $this->parameterizeColors();
            }
        });
    }

    /**
     * Function encapsulating condition if module should start?
     *
     * @return bool
     */
    public function shouldRun() : bool
    {
        global $post;
        $postType = get_post_type($post);
        return $postType === 'product' || $postType === 'solution';
    }

    /**
     * Fetch leading colors definition from ACF
     *
     * @return array
     */
    protected function fetchColorsFromACF() : array
    {
        $settings = get_field('color_parameterizer');
        $leadingColor = $settings['leading_color'];
        $leadingColorHover = $settings['leading_color_hover'];

        return [
            'leadingColor' =>
                !empty($leadingColor) ? $leadingColor : null,
            'leadingColorHover' =>
                !empty($leadingColorHover) ? $leadingColorHover : null
        ];
    }

    /**
     * Perform action of parameterizing colors
     */
    protected function parameterizeColors() : void
    {
        $colors = $this->fetchColorsFromACF();
        $this->injectStyles($colors);
    }

    /**
     * Method generating css class for current page, if we are on:
     * `https://instapage.com/products/all-product-overview` it will
     * generate:
     * `products-all-product-overview`
     *
     * @return string
     */
    protected function getClassForBodyBasedOnPageUrl() : string
    {
        return sanitize_title(wp_make_link_relative(get_permalink()));
    }

    /**
     * Add class to each page based on slug, it is helpful for creating
     * parametric color variations, it was added in WWP-4012 => WWP-4013
     */
    protected function addClassForBodyBasedOnPageUrl() : void {
        add_filter(
            'body_class',
            function ($classes) {
                // we do not want classes on 404, 404 is generated on any address
                // we want to generate classes on body only on pages which really exists
                if (is_array($classes) && !is_404()) {
                    $classes[] = $this->getClassForBodyBasedOnPageUrl();
                }

                return $classes;
            }
        );
    }

    /**
     * Inject inline styles to head containg color parameterizing definitions
     *
     * @param array $colors Array containing colors definition,
     *                      format like from funciton $this->fetchColorsFromACF()
     */
    protected function injectStyles(array $colors) : void
    {
        if (empty($colors['leadingColorHover'])
            || empty($colors['leadingColor'])
        ) {
            return;
        }

        add_action('wp_head', function () use ($colors) {
            echo '<style>'
                 . $this->prepareStylesToInject($colors)
                 . '</style>';
        }, 100);
    }

    /**
     * Prepare CSS template with leading colors parameterizing,
     * its inject colors fetched from ACF
     *
     * @param array $colors Array containing colors definition,
     *                      format like from funciton $this->fetchColorsFromACF()
     *
     * @return string
     */
    protected function prepareStylesToInject(array $colors) : string {
        $rawStyles = file_get_contents(__DIR__ . '/css/color-parameterization.css');
        $replacements = [
            '{{className}}' => $this->getClassForBodyBasedOnPageUrl(),
            '{{leadingColorHover}}' => $colors['leadingColorHover'],
            '{{leadingColor}}' => $colors['leadingColor']
        ];

        $styleToInjectWithoutComments = substr(
            $rawStyles,
            strpos($rawStyles, '*/') + strlen('*/')
        );
        $styleToInject = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $styleToInjectWithoutComments
        );

        return $styleToInject;
    }
}
