<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string featureTitle       Main title
 * @param string featureSubtitle    Text
 * @param string featureUrl         Url to link button
 * @param string featureImage       svg file
 * @param string featureButtonText  Button label text
 *
 * @example Basic usage
 * Component::render(
 *      'feature',
 *      [
 *          'sectionTitle'=> 'Lorem Ipsum',
 *          'sectionSubtitle', => 'Lorem Ipsum',
 *          'title' => 'lorem impsum',
 *          'subtitle' => 'Lorem Ipsum',
 *          'image' => '#',
 *          'buttonText' => 'Learn More',
 *          'url' => '#'
 *      ];
 * @endexample
 */

use Instapage\Classes\Component;

if (!empty($title)) :
    $class = $class ?? '';

    if ($variant !== true) {
        $buttonText = '';
        $url = '';
        $class .= ' v7-feature-no-button';
    }
    ?>
    <section class="v7 v7-mt-80 <?= esc_attr($class) ?>">
        <?php
        if (!empty($sectionTitle)) {
            Component::dumbRender('division-header', [
                'title' => $sectionTitle,
                'subtitle' => $sectionSubtitle,
                'class' => 'v7-mb-40 v7-mb-md-50'
            ]);
        }
        ?>
        <div class="container" data-self="sm-only-full">
            <div class="row">
                <div class="col-sm-12 col-xl-10 offset-xl-1">
                    <div class="v7-box v7-feature v7-feature-grid">
                        <div class="v7-feature-image">
                            <img src="<?= esc_url($image) ?>" />
                        </div>
                        <div class="v7-feature-copy">
                            <div class="v7-feature-copy-text">
                                <h4><?= esc_html($title) ?></h4>
                                <?php if (!empty($subtitle)) : ?>
                                    <p class="v7-feature-paragraph"><?= esc_html($subtitle) ?></p>
                                <?php endif; ?>
                            </div>
                            <?php
                            if (!empty($buttonText) && !empty($url)) {
                                Component::render('button', [
                                    'text' => $buttonText,
                                    'url' => $url,
                                    'class' => 'v7-btn-flat'
                                ]);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
