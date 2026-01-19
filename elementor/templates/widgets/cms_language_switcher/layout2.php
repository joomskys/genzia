<?php 
	cms_language_switcher([
		'class'          => '',
        'item_class'     => '',
        'link_class'     => 'text-'.$this->get_setting('color','primary').' text-hover-'.$this->get_setting('color_hover','accent'),   
        //'sub_link_class' => '',   
        'show_flag'      => $this->get_setting('show_flag','yes'),
        'show_name'      => $this->get_setting('show_name','yes'),
        'name_as'        => $this->get_setting('name_as', 'full'), // short,
        'dropdown_pos'   => $this->get_setting('dropdown_pos','bottom')
	]);
?>