<?php
/**
 * @var $pricing_plans
 * @var $settings
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $column_style = lsow_get_column_class(intval($settings['per_line'])); ?>

<div class="lsow-pricing-table lsow-container">

    <?php

    foreach ($pricing_plans as $pricing_plan) :

        $pricing_title = esc_html($pricing_plan['pricing_title']);
        $tagline = esc_html($pricing_plan['tagline']);
        $price_tag = htmlspecialchars_decode(wp_kses_post($pricing_plan['price_tag']));
        $pricing_img = $pricing_plan['image'];
        $pricing_url = (empty($pricing_plan['url'])) ? '#' : sow_esc_url($pricing_plan['url']);
        $pricing_button_text = esc_html($pricing_plan['button_text']);
        $button_new_window = esc_html($pricing_plan['button_new_window']);
        $highlight = esc_html($pricing_plan['highlight']);
        
        $price_tag = (empty($price_tag)) ? '' : $price_tag;

        ?>

        <div
            class="lsow-pricing-plan <?php echo(!empty($highlight) ? ' lsow-highlight' : ''); ?> <?php echo $column_style; ?>">

            <div class="lsow-top-header">

                <?php if (!empty($tagline))
                    echo '<p class="lsow-tagline center">' . $tagline . '</p>'; ?>

                <h3 class="lsow-center"><?php echo $pricing_title; ?></h3>

                <?php

                if (!empty($pricing_img)) :
                    echo wp_get_attachment_image($pricing_img, 'full', false, array('class' => 'lsow-image full', 'alt' => $pricing_title));
                endif;

                ?>

            </div>

            <h4 class="lsow-plan-price lsow-plan-header lsow-center">

                <span class="lsow-text">

                    <?php echo wp_kses_post($price_tag); ?>

                </span>

            </h4>

            <div class="lsow-plan-details">

                <?php

                foreach ($pricing_plan['items'] as $pricing_item) : ?>

                    <div class="lsow-pricing-item">

                        <div class="lsow-title">

                            <?php echo htmlspecialchars_decode(wp_kses_post($pricing_item['title'])); ?>

                        </div>

                        <div class="lsow-value-wrap">

                            <?php

                            if (!empty($pricing_item['icon_new'])) {
                                echo siteorigin_widget_get_icon($pricing_item['icon_new']);
                            }

                            ?>

                            <div class="lsow-value">

                                <?php echo htmlspecialchars_decode(wp_kses_post($pricing_item['value'])); ?>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>
            <!-- .lsow-plan-details -->

            <div class="lsow-purchase">

                <a class="lsow-button default" href="<?php echo esc_url($pricing_url); ?>"
                    <?php if (!empty($button_new_window))
                        echo 'target="_blank"'; ?>><?php echo esc_html($pricing_button_text); ?></a>

            </div>

        </div>
        <!-- .lsow-pricing-plan -->

        <?php

    endforeach;

    ?>

</div><!-- .lsow-pricing-table -->

<div class="lsow-clear"></div>