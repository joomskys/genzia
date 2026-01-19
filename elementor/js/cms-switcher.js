( function( $ ) {
    /**
     * Switcher Load more
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSSwitcherHandler = function( $scope, $ ) {
        $('.cms-toggle-switcher').each(function(){
            var switcher    = $(this),
                default_color = switcher.parent().find('.default').data('color'),
                switched_color = switcher.parent().find('.switched').data('color');
            switcher.on('click touch', function() {
                $(this).toggleClass('cms-swiched');
                $(this).parent().find('.default').toggleClass('text-'+default_color);
                $(this).parent().find('.switched').toggleClass('text-'+switched_color);
            });
        });
        //
        var cmsSwitcher      = $scope.find(".cms-switch-value"),
            cmsSwitchers     = cmsSwitcher.parents('.cms-switch-values'),
            cmsSwitcherItem  = cmsSwitchers.find('[data-switch-value]');
            
            cmsSwitcher.on('click touch',  function(e) { // click event for load more
                e.preventDefault();
                cmsSwitchers.find('.cms-switch').toggleClass('d-none');
            });
    };

    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_pricing.default', WidgetCMSSwitcherHandler );
    } );
} )( jQuery );