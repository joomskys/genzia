<?php
/**
 * Search Form
 * 
 * @package CMS Theme
 * @subpackage Genzia
 * 
 */
$form_style = [
    '--cms-form-field-height:68px',
    '--cms-form-field-padding-end:68px',
    '--cms-btn-padding:0 26px',
    '--cms-form-field-border-width-hover:1px',
    '--cms-form-field-border-color-hover:var(--cms-primary)'
];
?>
<form role="search" method="get" class="relative" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="<?php echo implode(';', $form_style); ?>">
    <input type="text" name="s" class="cms-search-field" placeholder="<?php echo esc_attr('Search...','genzia');?>"/>
    <button type="submit" class="cms-search-icon absolute top right bottom" data-title="<?php echo esc_attr('Search','genzia') ?>"><?php genzia_svgs_icon(['icon'=>'core/search','icon_size' => 16]); ?></button>
</form>