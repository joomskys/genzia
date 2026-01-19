(function ($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSVideoBGHandler = function ($scope, $) {
        const videoEls = $scope.find('.cms-evideo-playback');
        if (videoEls.length === 0) {
            return;
        }
        loadYouTubeAPI().then((apiObject) => prepareYTVideo(apiObject, videoEls, {
            autoplay: 'yes',
            mute: 'yes',
            loop: 'yes',
            controls: 'no',
        }));
        let video_Width = $(window).outerWidth();
        let video_Height = video_Width * 0.5625; // video 16:9 //$(window).outerHeight();
        if (video_Width < 1366) {
            video_Height = videoEls.outerHeight();
            video_Width = video_Height * 1.777777;
        }
        $scope.find('.cms-yt-bg-video').each(function () {
            $(this).css({
                'width': video_Width,
                'height': video_Height
            });
            // Resize
            $(window).on('resize', function () {
                var video_Width_resize = $(window).outerWidth(),
                    video_Height_resize = video_Width_resize * 0.5625;
                if (video_Width_resize >= 1366) {
                    $scope.find('.cms-yt-bg-video').css({
                        'width': video_Width_resize,
                        'height': video_Height_resize
                    }).attr({
                        'width': video_Width_resize,
                        'height': video_Height_resize
                    });
                } else {
                    $(this).css({
                        'width': video_Width_resize,
                        'height': video_Height_resize
                    });
                }
            });
        });
    };

    const getYoutubeVideoIdFromUrl = (url) => {
        const regex = /^(?:https?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?vi?=|(?:embed|v|vi|user|shorts)\/))([^?&"'>]+)/;
        const match = url.match(regex);
        return match ? match[1] : null;
    };

    const loadYouTubeAPI = () => {
        return new Promise((resolve) => {
            if (window.YT && window.YT.loaded) {
                resolve(window.YT);
                return;
            }

            const YOUTUBE_IFRAME_API_URL = 'https://www.youtube.com/iframe_api';
            if (!document.querySelector(`script[src="${ YOUTUBE_IFRAME_API_URL }"]`)) {
                const tag = document.createElement('script');
                tag.src = YOUTUBE_IFRAME_API_URL;
                const firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            }

            const checkYT = () => {
                if (window.YT && window.YT.loaded) {
                    resolve(window.YT);
                } else {
                    setTimeout(checkYT, 350);
                }
            };
            checkYT();
        });
    };

    const prepareYTVideo = (YT, videoEls, settings) => {
        const autoplay = (settings.autoplay === 'yes') ? 1 : 0;
        const mute = (settings.mute === 'yes') ? 1 : 0;
        const loop = (settings.loop === 'yes') ? 1 : 0;
        const controls = (settings.controls === 'yes') ? 1 : 0;
        videoEls.each(function (index, bgvideoEl) {
            // Video auto play
            bgvideoEl = $(bgvideoEl);
            let ytElBg = $(this).find('.cms-yt-bg-video'),
                videoLink = ytElBg.data('video-link'),
                videoId = getYoutubeVideoIdFromUrl(videoLink);
            bgvideoEl.html(ytElBg);
            let ytBgPlayer = {};
            let BgplayerOptions = {
                videoId: videoId,
                events: {
                    onReady: () => {
                        if (mute) {
                            ytBgPlayer.mute();
                        }
                        if (autoplay) {
                            ytBgPlayer.playVideo();
                        }
                    },
                    onStateChange: event => {
                        if (mute) {
                            ytBgPlayer.mute();
                        }
                        if (event.data === YT.PlayerState.ENDED && loop) {
                            ytBgPlayer.seekTo(0); // loop
                        }
                    }
                },
                playerVars: {
                    controls: controls,
                    // rel: 1,
                    playsinline: 1,
                    modestbranding: 0,
                    autoplay: autoplay,
                    loop: loop,
                    mute: mute
                }
            };
            ytBgPlayer = new YT.Player(ytElBg[0], BgplayerOptions);
        });
    };

    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_slider.default', WidgetCMSVideoBGHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_text_scroll.default', WidgetCMSVideoBGHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_banner.default', WidgetCMSVideoBGHandler);
    });
})(jQuery);