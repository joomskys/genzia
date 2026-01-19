<?php
/**
 * Change flags folder path for certain languages.
 *
 * Add the language codes you wish to replace in the list below.
 * Make sure you place your desired flags in a folder called "flags" next to this file.
 * Make sure the file names for the flags  are identical with the ones in the original folder located at 'plugins/translatepress/assets/images/flags/'.
 * If you wish to change the file names, use filter trp_flag_file_name .
 *
 * @package CMS Theme
 * @subpackage 
 * @since 1.0
 * 
 */
//add_filter( 'trp_flags_path', 'genzia_trpc_flags_path', 10, 2 );
function genzia_trpc_flags_path( $original_flags_path,  $language_code ){
	// only change the folder path for the following languages:
	$languages_with_custom_flags = array( 'en_US', 'es_ES', 'ar_AR', 'ar' );

	if ( in_array( $language_code, $languages_with_custom_flags ) ) {
		return  get_template_directory_uri() . '/assets/images/language-flags/' ;
	} else {
		return $original_flags_path;
	}
}

/**
 * Language list
 * 
 * IMPORTANT! You need to have data-no-translation on the wrapper with the links or 
 * TranslatePress will automatically translate them in a secondary language.
 * */
function cms_language_switcher($args = []){
    $args = wp_parse_args($args, [
        'class'          => '',
        'item_class'     => '',
        'link_class'     => '',   
        'sub_link_class' => 'd-flex flex-nowrap align-items-center gap-10',
        'show_flag'      => 'yes',
        'show_name'      => 'yes',
        'name_as'        => 'full', // short 
        'dropdown_pos'   => 'bottom',
        'img_size'       => 35,
        'data'           => [
            'default_class'     => [],
            'sticky_class'      => [],
            'transparent_class' => []
        ]   
    ]);
    $args['data'] = wp_parse_args($args['data'], [
        'default_class'     => [],
        'sticky_class'      => [],
        'transparent_class' => []
    ]);
    $languages = trp_custom_language_switcher();
    global $TRP_LANGUAGE;

    $classes = ['cms-ls', 'cms-dropdown', 'dropdown-'.$args['dropdown_pos'], 'cms-touchedside', $args['class']];
    $item_classes = ['cms-ls-item', $args['item_class']];
    $link_classes = ['cms-header-change','cms-ls-link','current-language', $args['link_class'], 'd-flex align-items-center gap-5'];
    $sub_link_classes = ['cms-ls-link', $args['sub_link_class']];
    $flag_class = ['cms-lflag'];
    $text_class =['cms-lname'];
?>  
    <ul class="<?php echo implode(' ', array_filter($classes)); ?>" style="--cms-ls-img-size:<?php echo esc_attr($args['img_size']).'px;' ?>" data-no-translation>
        <li class="<?php echo implode(' ', array_filter($item_classes)) ?>">
            <?php 
                foreach ($languages as $name => $item){
                    if($item['language_code'] === $TRP_LANGUAGE) {
            ?>
                    <a href="<?php echo esc_url($item['current_page_url']);?>" onclick="event.preventDefault()" class="<?php echo implode(' ', array_filter($link_classes)); ?>" data-classes='<?php echo wp_json_encode($args['data']); ?>'>
                        <?php 
                        // Flag
                        if($args['show_flag'] === 'yes'){  ?>
                            <img src="<?php echo esc_url($item['flag_link']); ?>" title="<?php echo esc_attr($item['language_name']); ?>" alt="<?php echo esc_attr($item['language_name']); ?>" class="<?php echo implode(' ', array_filter($flag_class)); ?>" />
                        <?php } 
                        // Name Text
                        if($args['show_name'] === 'yes'){ ?>
                            <span class="<?php echo implode(' ', array_filter($text_class)); ?>">
                                <?php 
                                    switch ($args['name_as']) {
                                        case 'short':
                                            echo esc_html($item['short_language_name']);
                                            break;
                                        
                                        default:
                                            echo esc_html($item['language_name']);
                                            break;
                                    }
                                ?>
                            </span>
                        <?php }
                            if($args['show_name'] === 'yes'){
                                // dropdown icon
                                genzia_svgs_icon([
                                    'icon'      => 'core/chevron-down',
                                    'icon_size' => 8
                                ]);
                            }
                        ?>
                    </a>
                <?php
                }
            }
            if(count($languages)>1){
            ?>
            <ul class="dropdown cms--touchedside">
                <?php foreach ($languages as $name => $item){
                    if($item['language_code'] != $TRP_LANGUAGE) { 
                    ?>
                        <li class="<?php echo implode(' ', array_filter($item_classes)); ?>"> 
                            <a href="<?php echo esc_url($item['current_page_url']);?>" class="<?php echo implode(' ', array_filter($sub_link_classes)); ?>">
                                <?php //if($args['show_flag'] === 'yes'){ ?>
                                    <img src="<?php echo esc_url($item['flag_link']); ?>" title="<?php echo esc_attr($item['language_name']); ?>" alt="<?php echo esc_attr($item['language_name']); ?>" class="<?php echo implode(' ', array_filter($flag_class)); ?>" />
                                <?php //} 
                                    //if($args['show_name'] === 'yes'){
                                ?>
                                    <span class="cms-lname">
                                        <?php 
                                            switch ($args['name_as']) {
                                                case 'short':
                                                    echo esc_html($item['short_language_name']);
                                                    break;
                                                
                                                default:
                                                    echo esc_html($item['language_name']);
                                                    break;
                                            }
                                        ?>
                                    </span>
                                <?php //} ?>
                            </a>
                        </li>
                <?php } 
                } ?>
            </ul>
            <?php } ?>
        </li>
    </ul>
<?php
}
/**
 * Update Option TranslatePress
 * 
 * */
if(!function_exists('genzia_translatepress_configs')){
    add_action('plugins_loaded', 'genzia_translatepress_configs');
    add_action('activate_translatepress-multilingual/index.php', 'genzia_translatepress_configs');
    add_action('theme_core_ie_after_import', 'genzia_translatepress_configs');
    function genzia_translatepress_configs(){
        $trp_settings = (array)get_option('trp_settings');
        $trp_settings['trp-ls-floater'] = 'no'; // Hide Floating language selection
        $trp_settings['trp-ls-show-poweredby'] = 'no'; // Hide "Powered by TranslatePress"
        update_option( 'trp_settings', $trp_settings );
        // from Version 3.0.5 
        $trp_language_switcher_settings = (array)get_option('trp_language_switcher_settings');
        $trp_language_switcher_settings['floater']['enabled'] = false;
        update_option( 'trp_language_switcher_settings', $trp_language_switcher_settings );
    }
}
add_filter('etc_remove_styles', 'genzia_translatepress_remove_styles');
function genzia_translatepress_remove_styles($styles){
    $trp_settings = (array)get_option('trp_settings');
    if($trp_settings['trp-ls-floater'] = 'no'){
        $styles[] = 'trp-floater-language-switcher-style';
        $styles[] = 'trp-language-switcher-style';
    }
    return $styles;
}
// Change currency based on Language 
if(class_exists('WOOCS_STARTER')){
    //add_filter('wp_head', 'genzia_woosc_base_on_language');
    function genzia_woosc_base_on_language() {
        $lang = get_locale();
        global $WOOCS;
        switch ($lang) {
            case 'bg_BG':
                $WOOCS->set_currency('BGN');
                break;
            case 'en_GB':
                $WOOCS->set_currency('EUR');
                break;
            case 'ar':
                $WOOCS->set_currency('AED');
                break;
            default:
                $WOOCS->set_currency('USD');
                break;
        }
    }
}