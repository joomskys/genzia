<?php
    $classes = [
        $args['class'],
        'text-sm'
    ];
?>
<div id="cms-ptitle" class="<?php echo genzia_nice_class($classes); ?>">
    <?php  
    genzia_breadcrumb([
        'class'      => 'relative z-top container justify-content-center', 
        'link_class' => 'text-white text-hover-white',
        'before'     => '',
        'after'      => ''
    ]);
    ?>
</div>