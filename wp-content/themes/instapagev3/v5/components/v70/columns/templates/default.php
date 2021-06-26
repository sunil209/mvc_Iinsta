<?php
 /**
 * Template file. Template params are stored in $params array
 *
 * @param string $sectionTitle
 * @param string $sectionSubtitle
 * @param array  $columns           An array of columns, each containing:
 *        array  image_regular
 *        array  image_retina
 *        string title
 *        string text
 *        string button_url
 *        string button_text
 *
 * @example Usage
 * Component::render('columns');
 * @endexample
 */

use \Instapage\Classes\Component;

if (empty($columns) || !is_array($columns) || empty($columns[0])) {
    return;
}
$columnsCounter = 1;
?>

<section class="v7 v7-columns">
    <?php
    if (!empty($sectionTitle)) {
        Component::dumbRender('division-header', [
            'title' => $sectionTitle,
            'subtitle' => $sectionSubtitle,
            'class' => 'v7-mb-40 v7-mb-md-50'
        ]);
    }
    ?>
    <div class="container">
        <div class="row">

            <?php foreach ($columns as $column) : ?>
                <div class="v7-mb-30 col-sm-12 col-lg-4">

                    <div class="v7-columns-wrapper v7-mb-sm-only-30 row">
                        <div
                            class="
                                col-8 offset-2 col-sm-6 offset-sm-3 col-md-5 col-lg-12
                                <?= ($columnsCounter % 2 === 0) ? 'v7-columns-even offset-md-0' : 'offset-md-1 offset-lg-0' ?>
                            "
                        >
                            <?php Component::render(
                                'v51/image',
                                [
                                    'image' => $column['image_regular'] ?? '',
                                    'imageRetina' => $column['image_retina'] ?? '',
                                    'class' => 'img-responsive v7-columns-img',
                                    'onlyLazyImageClass' => true
                                ]
                            ); ?>
                        </div>
                        <div
                            class="
                                v7-columns-copy col-sm-12 col-md-5 col-lg-12
                                <?= ($columnsCounter % 2 === 0) ? 'offset-md-1 offset-lg-0' : '' ?>
                            "
                        >
                            <h3 class="h2 v7-mt-30">
                                <?= esc_html($column['title'] ?? '') ?>
                            </h3>
                            <p class="small v7-mb-30"><?= esc_html($column['text'] ?? '') ?></p>
                            <div class="v7-is-hidden-lg-up">
                                <?php if (!empty($column['button_url'])) :
                                    Component::render('button', [
                                        'url' => $column['button_url'] ?? '',
                                        'text' => $column['button_text'] ?? '',
                                        'class' => 'v7-btn-ghost-cta v7-btn-small'
                                    ]);
                                endif; ?>
                            </div>
                        </div>
                        <div class="v7-columns-btn-wrapper v7-is-hidden-lg col-sm-12">
                            <?php if (!empty($column['button_url'])) :
                                Component::render('button', [
                                    'url' => $column['button_url'] ?? '',
                                    'text' => $column['button_text'] ?? '',
                                    'class' => 'v7-btn-ghost-cta v7-btn-small'
                                ]);
                            endif; ?>
                        </div>
                    </div>

                </div>
                <?php $columnsCounter++;
            endforeach; ?>

        </div>
    </div>
</section>
