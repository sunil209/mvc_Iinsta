<?php
use \Instapage\Helpers\HtmlHelper;
use \Instapage\Classes\Component;
use \Instapage\Helpers\AcfHelper;

?>
<?php if (!empty($leftRightRows)) : ?>
    <section class="v7 v7-content-overflow-hidden">
        <?php
        if (!empty($sectionTitle)) {
            echo '<div class="v7-mt-80">';
            Component::dumbRender('division-header', [
                'title' => $sectionTitle,
                'subtitle' => $sectionSubtitle
                ]);
            echo '</div>';
        }
        ?>
        <div class="v7-content">
            <?php
            if ($showNavigation) {
                Component::render('navigation-tabs', 'left-right', ['leftRightRows' => $leftRightRows]);
            }
            foreach ($leftRightRows as $leftRightRow) : ?>
                <div
                <?php if (!empty($leftRightRow['row_id'])) {
                    echo 'id="'.esc_attr($leftRightRow['row_id']).'"';
                }
                $button = [];
                if (!empty($leftRightRow['button']['url'])) {
                    $button = AcfHelper::parseButtonAttributes($leftRightRow['button']);
                }
                ?>
                    class="
                        v7-mt-80 v7-left-right-section
                        <?= $leftRightLayout ? 'v7-left-right-odd' : '' ?>
                        <?= $renderTileUnderImage ? 'v7-left-right-section-image-tiles' : '' ?>
                        <?= $class ?? '' ?>
                    "
                >
                <?php
                $leftRightLayout = !$leftRightLayout;
                if (!empty($leftRightRow['image']['url'])) :
                    ?>
                    <div
                        class="
                            v7-position-relative v7-left-right-img-section
                            <?=
                                'v7-left-right-img-section'
                                . ($renderTileUnderImage ? '-tiles' : '-regular')
                            ?>
                        "
                    >
                        <div
                            class="
                                <?= 'v7-left-right-img' . ($renderTileUnderImage ? '-with-tile-container' : '') ?>
                                <?= ($leftRightRow['is_img_fully_visible'] ?? false) ? 'is-responsive' : '' ?>
                            "
                        >
                            <?php
                                Component::render('v51/lazy-image', [
                                    'imageRegularURL' => $leftRightRow['image']['url'],
                                    'imageRetinaURL' => $leftRightRow['image_retina']['url'],
                                    'width' => $leftRightRow['image']['width'],
                                    'height' => $leftRightRow['image']['height'],
                                    'alt' => $leftRightRow['image']['title'],
                                    'imageClass' => $renderTileUnderImage ? '' : 'insta-lazy-image-object-fit-contain-large-tablet'
                                ]);
                            ?>
                            <?php
                            if (($leftRightRow['button']['type'] ?? '') === 'rounded') {
                                Component::render('button', $button);
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="v7-left-right-text-section">
                    <div class="v7-left-right-text v7-left-right-text-right">
                    <?php if ($leftRightSlot) : ?>
                        <?= $leftRightSlot; ?>
                    <?php else :
                        if (!empty($leftRightRow['label'])) : ?>
                            <small class="v7-left-right-label v7-label-<?= esc_attr($leftRightRow['label_color']); ?>">
                                <?= esc_html($leftRightRow['label']); ?>
                            </small>
                        <?php endif; ?>
                        <?php if (!empty($leftRightRow['title'])) : ?>
                            <h2 class="h1 <?= $renderTileUnderImage ? 'v7-mt-md-20' : '' ?>">
                                <?= $leftRightRow['title']; ?>
                            </h2>
                        <?php endif; ?>
                        <?php if (!empty($leftRightRow['testimonial']['logo'])) : ?>
                            <div class="v7-left-right-logo-container v7-mx-md-auto v7-mt-10 v7-mb-md-20">
                                <img
                                    data-src="<?= esc_url($leftRightRow['testimonial']['logo']['url'] ?? '') ?>"
                                    class="lazyload"
                                >
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($leftRightRow['text'])) : ?>
                            <p><?= $leftRightRow['text']; ?></p>
                        <?php endif; ?>
                        <?php if (!empty($leftRightRow['list'])) : ?>
                            <ul class="v7-checklist <?= esc_attr($listClass) ?> v7-mt-10 v7-mt-md-20">
                                <?= $leftRightRow['list']; ?>
                            </ul>
                        <?php endif; ?>
                        <?php if (!empty($leftRightRow['testimonial']['name'])) : ?>
                            <p class="small v7-pt-20 v7-pt-md-30 v7-pt-lg-20">
                                <strong class="small"><?= $leftRightRow['testimonial']['name']; ?></strong>
                                <?= $leftRightRow['testimonial']['company']; ?>
                            </p>
                        <?php endif; ?>
                        <?php if ((($leftRightRow['button']['type'] ?? '') !== 'rounded') &&
                        !empty($leftRightRow['button']['url'])) : ?>
                            <div class="v7-pt-30 v7-pt-md-40">
                            <?php Component::render('button', $button) ?>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                </div>
            <?php endforeach ?>
        </div>
    </section>
<?php endif; ?>
