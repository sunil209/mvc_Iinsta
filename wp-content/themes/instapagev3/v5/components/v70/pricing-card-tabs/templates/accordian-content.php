
<div class="v7-accordion-content">
    <?php foreach ($row_contents as $rowContent): ?>
        <div class="v7-accordion-content-row v7-price-col-full">
                <div class="v7-price-col-left">
                    <div class="v7-price-description-text">
                        <?=esc_html($rowContent['row_label_group']['label']) ?? "";?>
                        <?php if (isset($rowContent['row_label_group']) && isset($rowContent['row_label_group']['label_tooltip']) && !empty($rowContent['row_label_group']['label_tooltip'])): ?>
                        <i class="v7-icon-help material-icons v7-tooltip">
                            help_outline
                            <div class="v7-tooltip-wrapper">
                                <span class="v7-tooltip-text"><?=esc_html($rowContent['row_label_group']['label_tooltip']) ?? "";?>   </span>
                            </div>
                        </i>
                        <?php endif;?>
                    </div>
                </div>
                <?php if (isset($rowContent['column_data']) && !empty($rowContent['column_data'])): ?>
                <div class="v7-price-col-right">
                    <?php foreach ($rowContent['column_data'] as $columnKey => $columnData): ?>
                        <?php if ( isset($columnData['acf_fc_layout']) &&  $columnKey <= $max_row): ?>
                                <?php if ($columnData['acf_fc_layout'] == 'content'): ?>
                                    <div class="v7-price-col v7-price-description-wrap v7-price-tab-<?= $columnKey ?>-col <?php echo $columnKey == 0 ? "v7-tab-active-content" : "" ; ?> ">
                                        <div class="v7-price-description-text"> <?=esc_html($columnData['text']) ?? "";?> </div>
                                    </div>
                                <?php elseif ($columnData['acf_fc_layout'] == 'tick__cross'): ?>
                                    <div class="v7-price-col v7-price-description-wrap v7-price-tab-<?= $columnKey ?>-col <?php echo $columnKey == 0 ? "v7-tab-active-content" : "" ; ?> ">
                                        <div class="v7-price-description-text">
                                            <i class="material-icons v7-list-<?=esc_html($columnData['select_option']) == true ? "check" : "clear";?>-sign"><?=esc_html($columnData['select_option']) == true ? "check" : "clear";?></i>
                                        </div>
                                    </div>
                                <?php endif;?>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
                <?php endif;?>
        </div>
    <?php endforeach;?>
</div>