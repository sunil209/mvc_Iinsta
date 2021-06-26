<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $cards          An array of pricing cards, each containing:
 *               array header           Title section of a card:
 *                  string title            Card's title
 *                  string subtitle         Card's subtitle
 *               array price_section    An array of sections with price details:
 *                  string price            Price, numeric or string
 *                  string plan             Type of a pricing plan
 *                  string plan_tooltip     Tooltip for that plan
 *               array button           An array passed to a button component:
 *                  string text             Button's text
 *                  string url              Button's url
 *                  string class            Button's CSS classes
 * @param array $features        An array of features included in each plan containing:
 *                  string feature                  Feature name
 *                  bool is_active_core             Is feature included in a core plan
 *                  bool is_active_enterprise       Is feature included in a enterprise plan
 *
 * @example Usage
 * Component::render('pricing-card-tabs);
 * @endexample
 */

use \Instapage\Classes\Component;
?>

<section class="v7 v7-box v7-price-cards-section v7-pricing-tabs-section v7-price-cards-section-col-<?=count($pricingList) ?? '' ?> v7-annually-active" id="v7-pricing-tabs-section">
    <div class="pricing_loader"></div>
    <div class="v7-price-cards-wrapper v7-invisible-box">
        <div class="v7-price-card-header" id="v7-price-card-header">
            <div class="v7-price-card-header-row v7-price-col-full">
                <div class="v7-price-col-left">
                    <div class="v7-price-col v7-price-main-head-text" id="v7-mob-switch-btn">
                        <div class="switch-button-wrap">
                            <div class="switch-button">
                                <button class="switch-button-case left">Monthly</button>
                                <button class="switch-button-case right active-case">Annually</button>
                            </div>
                            <?php if( isset( $discountLabel ) && !empty( $discountLabel ) ): ?>
                                <span class="v7-price-discount">
                                    <?php echo $discountLabel ?? ''; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <?php if( isset( $pricingList ) && !empty( $pricingList ) ): ?>
                            <?php foreach( $pricingList as $priceKey => $pricing ):?>
                                <?php if( isset( $pricing['annually_price']['discount_label'] ) && !empty($pricing['annually_price']['discount_label'])): ?>
                                    <div class="v7-price-discount-mob v7-price-tab-<?= $priceKey.'-col v7-md-hide '.( $priceKey == 0 ? "v7-tab-active-content" : "" ) ?>">
                                        <span class="v7-price-discount">
                                            <?=$pricing['annually_price']['discount_label'] ?? "";?></span>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>   
                        <?php endif; ?>

                    </div>
                </div>
                <div class="v7-price-col-right">
                <?php if( isset( $pricingList ) && !empty( $pricingList ) ): ?>
                <?php $footerButton = ''; $footerFloatingButton = '';?>
                    <?php foreach( $pricingList as $priceKey => $pricing ):
                            $customMonthly = $pricing['monthly_price']['custom_price_label'] ?? false;
                            $customAnnualy = $pricing['annually_price']['custom_price_label'] ?? false;

                            $pricing['button_section_button']['class'] = 'plan-tracking';
                            $pricing['button_section_button']['attributes'] = array( 
                                'data-plan' => $pricing['price_label'] ?? "" ,  
                                'data-monthly' => $pricing['monthly_price']['price'] ?? "" ,
                                'data-annually' => $pricing['annually_price']['price'] ?? "" ,
                                'data-utm-monthly' => $pricing['monthly_price']['utm_params'] ?? "" ,
                                'data-utm-annually' => $pricing['annually_price']['utm_params'] ?? "" ,
                                'data-url' => $pricing['button_section_button']['url'] ?? "" ,
                            );
                        $highlightClass = ( isset( $pricing['highlight_price'] ) && $pricing['highlight_price'] ) ? 'v7-pricing-highlight' : ''; ?>
                        <div class="v7-price-col v7-price-head-text v7-price-<?= $priceKey?>-col <?php echo $highlightClass; ?> <?php echo $priceKey == 0 ? 'v7-mob-active-tab' : '' ?>" data-tabname="tab-<?= $priceKey?>">
                            <div class="v7-price-tab">
                                <h3 class="v7-price-tab-heading"> <?=esc_html($pricing['price_label']) ?? "";?></h3>
                                <div class="v7-price-tab-description pricing-monthly">
                                    <p>
                                    <?php if( !$customMonthly ): ?> $ <?php endif; ?>
                                        <?=esc_html($pricing['monthly_price']['price']) ?? "";?>
                                    <?php if( !$customMonthly ): ?> <span> / mo</span> <?php endif; ?>                                    
                                    </p>
                                </div>
                                <div class="v7-price-tab-description pricing-annually">
                                    <p>
                                    <?php if( !$customAnnualy ): ?> $ <?php endif; ?>
                                        <?=esc_html($pricing['annually_price']['price']) ?? "";?>
                                    <?php if( !$customAnnualy ): ?> <span> / mo</span> <?php endif; ?> 
                                    </p>
                                </div>
                                 <?php 
                                        Component::render('button', $pricing['button_section_button']); 
                                 ?>
                                    <?php if( isset( $pricing['annually_price']['discount_label'] ) && !empty($pricing['annually_price']['discount_label'])): ?>
                                        <span class="v7-price-discount"><?=$pricing['annually_price']['discount_label'] ?? "";?></span>
                                    <?php endif; ?>
                            </div>
                        </div>
                        <?php 
                        $footerButton .= '<div class="v7-price-tab v7-footer-building v7-price-tab-'.$priceKey.'-col v7-md-hide '.( $priceKey == 0 ? "v7-tab-active-content" : "" ).'">
                            <h3 class="v7-price-tab-heading">'.( esc_html($pricing['price_label']) ?? "") .'</h3>';
                            if( !$customMonthly ):
                                $footerButton .= '<div class="v7-price-tab-description pricing-monthly">
                                <p>$'.( esc_html($pricing['monthly_price']['price']) ?? "" ).'<span> / mo</span></p>
                                </div>';
                            else:
                                $footerButton .= '<div class="v7-price-tab-description pricing-monthly">
                                    <p>'.( esc_html($pricing['monthly_price']['price']) ?? "" ).'</p>
                                </div>';
                            endif;

                            if( !$customAnnualy ):
                                $footerButton .= ' <div class="v7-price-tab-description pricing-annually">
                                    <p>$'.( esc_html($pricing['annually_price']['price']) ?? "" ).'<span> / mo</span></p>
                                </div>';
                            else:
                                $footerButton .= ' <div class="v7-price-tab-description pricing-annually">
                                    <p>'.( esc_html($pricing['annually_price']['price']) ?? "" ).'</p>
                                </div>';
                            endif;

                           
                        $footerButton .= '</div>';
                        $footerFloatingButton .=' <div class="v7-price-col v7-price-head-text v7-price-building-col v7-price-footer-tab-'.$priceKey.' '.( $priceKey == 0 ? "v7-tab-active-content" : "" ).' '.$highlightClass.' ">
                                <div class="v7-price-tab">
                                    '.Component::fetch('button', $pricing['button_section_button']).'
                                </div>
                            </div>'; 
                        ?>


                    <?php endforeach; ?>   
                <?php endif; ?>
                </div>
            </div>     
        </div>
        <?php if( isset( $pricingContent  ) && !empty( $pricingContent  ) ): ?>
        <div class="v7-accordion-container" id="v7-accordion-container">
        <?php foreach( $pricingContent as $tableContent ): ?>        
            <div class="v7-accordion-set active">
              <a href="#"> <?= esc_html($tableContent['label']);?> <i class="material-icons v7-arrow-acc v7-arrow-less">expand_more</i></a>
              <?php if( isset( $tableContent['row_content'] ) && !empty( $tableContent['row_content'] ) ): ?>
                <?php Component::render('v70/pricing-card-tabs', 'accordian-content', ['row_contents' => $tableContent['row_content'],  'max_row' => count($pricingList) - 1 ]); ?>
              <?php endif; ?>
            </div>
        <?php endforeach; ?>
        </div> 
        <?php endif; ?>


        <div class="v7-price-card-footer" id="v7-price-card-footer">
            <div class="v7-price-card-header-row v7-price-col-full">
                <div class="v7-price-col-left">
                    <div class="v7-price-footer-col">
                        <?php echo $footerButton; ?>                            
                    </div>
                </div>
                <div class="v7-price-col-right">
                   <?php echo $footerFloatingButton; ?>
                </div>
            </div>     
        </div>

    </div>
</section>

