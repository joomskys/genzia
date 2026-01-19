<?php
/**
 * The template for displaying the footer.
 *
 * @package CMS Theme
 * @subpackage Genzia
 * 
 */
$back_totop_on = genzia_get_opt( 'back_totop_on', true );
$footer_fixed = genzia_get_opts('footer_fixed', 'off', 'footer_custom');
?>
</main>
<?php 
    if(!genzia_is_built_with_elementor() && $footer_fixed == 'on'){
        // fix Footer_Fixed 
        echo '</div>'; // Closed .cms-body
    }
?>
<footer id="cms-footer" class="<?php genzia_footer_css_class(); ?>"><?php 
    genzia_footer(); 
?></footer>
<?php if ( isset( $back_totop_on ) && $back_totop_on ) : ?>
    <a href="#cms-header-wrap" class="scroll-top bg-accent-regular text-white bg-hover-primary-regular text-hover-white cms-shadow-1 cms-hover-move-icon-up">
        <?php 
            genzia_svgs_icon([
                'icon'      => 'core/arrow-up',
                'icon_size' => 13
            ]);
        ?>
    </a>
<?php endif; ?>
<div id="cms-theme-cursor" class="cms-theme-cursor relative">
    <div class="cms--drag d-flex flex-nowrap gap-10 align-items-center justify-content-center cms-shadow-1 text-sm font-500 absolute center"><?php
        //
        genzia_svgs_icon([
            'icon' => 'arrow-left',
            'icon_size' => 10
        ]);
        //
        esc_html_e('Drag', 'genzia');
        //
        genzia_svgs_icon([
            'icon' => 'arrow-right',
            'icon_size' => 10
        ]);
    ?></div>
    <div class="cms--drag-vert cms-shadow-1 text-sm font-500 absolute center cms-box-132 circle bg-white-70">
        <div class="cms---drag-vert text-center"><?php
            //
            genzia_svgs_icon([
                'icon'      => 'core/arrow-up',
                'icon_size' => 10,
                'tag'       => 'div'
            ]);
            //
            echo  '<div class="p-tb-10">'.esc_html__('Scroll', 'genzia').'</div>';
            //
            genzia_svgs_icon([
                'icon'      => 'core/arrow-down',
                'icon_size' => 10,
                'tag'       => 'div'
            ]);
        ?></div>
    </div>
    <div class="cms-cursor-text"></div>
</div>
<div class="cms-modal-overlay cursor-close-white cms-transition"></div>
<?php wp_footer(); ?>
</body>
</html>
