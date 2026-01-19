(function($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSPointerHandler = function( $scope, $ ) {
            //
            $scope.find(".cms-pointer-item").on("click touch mouseenter", function(e){
                e.preventDefault();
                var parent = $(this).parent();
                // hide all
                parent.find(".cms-pointer-item").removeClass('active');
                // Show current
                $(this).addClass("active");
                // re-play counter
                $(this).find('.cms-counter-number').each(function() {
                    var $number = $(this),
                        data = $number.data();
                    $number.text(data.fromValue);
                    var decimalDigits = data.toValue.toString().match(/\.(.*)/);
                    if (decimalDigits) {
                        data.rounding = decimalDigits[1].length;
                    }
                    $number.numerator(data);
                });
            })
            .on('mouseenter', function(e){
                // re-play counter
                $(this).find('.cms-counter-number').each(function() {
                    var $number = $(this),
                        data = $number.data();
                    $number.text(data.fromValue);
                    var decimalDigits = data.toValue.toString().match(/\.(.*)/);
                    if (decimalDigits) {
                        data.rounding = decimalDigits[1].length;
                    }
                    $number.numerator(data);
                });
            })
            .on('mouseleave', function(e){
                
            });
        };
    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_counter.default', WidgetCMSPointerHandler);
    });
})(jQuery);