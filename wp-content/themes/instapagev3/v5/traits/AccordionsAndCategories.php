<?php
namespace Instapage\Traits;

trait AccordionsAndCategories
{
    public static function getAccordionsAndCategories(string $pageName): array
    {
        $accordions = [];
        $categories = [];

        if (have_rows('categories')) {
            while (have_rows('categories')) {
                the_row();
                $accordion = [
                    'headline' => get_sub_field('name'),
                    'groupID' => 'category-' . sanitize_title_with_dashes(get_sub_field('name'))
                ];

                $categories[] = [
                    'id' => '#category-' . sanitize_title_with_dashes(get_sub_field('name')),
                    'name' => get_sub_field('name')
                ];
                
                if (have_rows($pageName)) {
                    while (have_rows($pageName)) {
                        the_row();
                        $accordion['items'][] = [
                            'title' => get_sub_field('name'),
                            'excerpt' => get_sub_field('content'),
                            'icon' => get_sub_field('icon'),
                            'isOpen' => get_sub_field('is_open'),
                            'attributes' => [
                                'id' => $pageName . '-' . sanitize_title_with_dashes(get_sub_field('name'))
                            ]
                        ];
                    }
                    $accordions[] = $accordion;
                }
            }
        }

        return ['accordions' => $accordions, 'categories' => $categories];
    }
}
