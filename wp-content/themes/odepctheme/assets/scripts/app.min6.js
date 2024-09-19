var viewportHeight = $(window).height();
var viewportWidth = $(window).width();

var initFunctions = {
  matchHeight: function(){

  },
  videoPlay: function(wrapper) {
    var iframe = wrapper.find('.js-videoIframe');
    var src = iframe.data('src');
    wrapper.addClass('videoWrapperActive');
    iframe.attr('src',src);
  },
  menuToggle: function() {
    $(".navbar-toggler").click(function () {
      $(".collapse.navbar-collapse").slideToggle("show");
    });
  },
    dropDownToggle: function () {
        $(".dropdown").hover(function () {
            $(".dropdown-menu, .nav-item.dropdown").toggleClass("ahow");
        });
    },
  sectionBg: function () {
    var sectionBg = $('[data-bg]');
    $(sectionBg).each(function () {
        var bg = $(this).attr('data-bg');
        $(this).css("background-image", "url(" + bg + ")").addClass('add-overlay');
    });
  }
}

var initSliders = {
  heroSlider: function() {
    $("#hero-slider").slick({
      autoplay: false,
      speed: 800,
      lazyLoad: 'progressive',
      fade: true,
      arrows: false,
      dots: true,
      prevArrow: '<button class="slide-arrow prev-arrow"><i class="iconmoon icon-arrow-left" aria-hidden="true"></i></button>',
      nextArrow: '<button class="slide-arrow next-arrow"><i class="iconmoon icon-arrow-right" aria-hidden="true"></i></button>',
      responsive: [
          {
              breakpoint: 991,
              settings: {
                  arrows: false
              }
          }
      ]
    });
  },
    generalVideoSlider: function () {
        var slideWrapper = $(".video-slider"),
            iframes = slideWrapper.find('.embed-player'),
            lazyImages = slideWrapper.find('.slide-image'),
            lazyCounter = 0;

        // POST commands to YouTube or Vimeo API
        function postMessageToPlayer(player, command) {
            if (player == null || command == null) return;
            player.contentWindow.postMessage(JSON.stringify(command), "*");
        }

        // When the slide is changing
        function playPauseVideo(slick, control) {
            var currentSlide, slideType, startTime, player, video;

            currentSlide = slick.find(".slick-current");
            slideType = currentSlide.attr("class").split(" ")[1];
            player = currentSlide.find("iframe").get(0);
            startTime = currentSlide.data("video-start");

            if (slideType === "vimeo") {
                switch (control) {
                    case "play":
                        if ((startTime != null && startTime > 0) && !currentSlide.hasClass('started')) {
                            currentSlide.addClass('started');
                            postMessageToPlayer(player, {
                                "method": "setCurrentTime",
                                "value": startTime
                            });
                        }
                        postMessageToPlayer(player, {
                            "method": "play",
                            "value": 1
                        });
                        break;
                    case "pause":
                        postMessageToPlayer(player, {
                            "method": "pause",
                            "value": 1
                        });
                        break;
                }
            } else if (slideType === "youtube") {
                switch (control) {
                    case "play":
                        postMessageToPlayer(player, {
                            "event": "command",
                            "func": "mute"
                        });
                        postMessageToPlayer(player, {
                            "event": "command",
                            "func": "playVideo"
                        });
                        break;
                    case "pause":
                        postMessageToPlayer(player, {
                            "event": "command",
                            "func": "pauseVideo"
                        });
                        break;
                }
            } else if (slideType === "video") {
                video = currentSlide.children("video").get(0);
                if (video != null) {
                    if (control === "play") {
                        video.play();
                    } else {
                        video.pause();
                    }
                }
            }
        }

        // Resize player
        function resizePlayer(iframes, ratio) {
            if (!iframes[0]) return;
            var win = $(".video-slider"),
                width = win.width(),
                playerWidth,
                height = win.height(),
                playerHeight,
                ratio = ratio || 16 / 9;

            iframes.each(function () {
                var current = $(this);
                if (width / ratio < height) {
                    playerWidth = Math.ceil(height * ratio);
                    current.width(playerWidth).height(height).css({
                        left: (width - playerWidth) / 2,
                        top: 0
                    });
                } else {
                    playerHeight = Math.ceil(width / ratio);
                    current.width(width).height(playerHeight).css({
                        left: 0,
                        top: (height - playerHeight) / 2
                    });
                }
            });
        }

        // DOM Ready
        $(function () {
            // Initialize
            slideWrapper.on("init", function (slick) {
                slick = $(slick.currentTarget);
                setTimeout(function () {
                    playPauseVideo(slick, "play");
                }, 1000);
                resizePlayer(iframes, 16 / 9);
            });
            slideWrapper.on("beforeChange", function (event, slick) {
                slick = $(slick.$slider);
                playPauseVideo(slick, "pause");
            });
            slideWrapper.on("afterChange", function (event, slick) {
                slick = $(slick.$slider);
                playPauseVideo(slick, "play");
            });
            slideWrapper.on("lazyLoaded", function (event, slick, image, imageSource) {
                lazyCounter++;
                if (lazyCounter === lazyImages.length) {
                    lazyImages.addClass('show');
                    // slideWrapper.slick("slickPlay");
                }
            });

            //start the slider
            slideWrapper.slick({
                // fade:true,
                autoplaySpeed: 4000,
                lazyLoad: "progressive",
                speed: 600,
                arrows: false,
                dots: true,
                cssEase: "cubic-bezier(0.87, 0.03, 0.41, 0.9)"
            });
        });

        // Resize event
        $(window).on("resize.slickVideoPlayer", function () {
            resizePlayer(iframes, 16 / 9);
        });
    },
  thumbnailSLider: function() {
    $(".thumbnail-slider").slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      arrows: false,
      responsive: [
          {
              breakpoint: 1200,
              settings: {
                  slidesToShow: 4,
                  slidesToScroll: 4
              }
          },
          {
              breakpoint: 736,
              settings: {
                  slidesToShow: 2,
                  slidesToScroll: 2
                  // prevArrow: false,
                  // nextArrow: false
              }
          }
      ]
    });
  },
  generalSlider: function() {
    $('.row.slider').slick({
      dots: true,
      arrows: false,
      infinite: false,
      adaptiveHeight: true,
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 736,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });

  }
}

var initLibraries = {
  counterUp: function() {
    $('.counter').counterUp({
      delay: 10,
      time: 1000
    });
  },
  initSelect2: function () {
    $('.selectpicker').select2({
      placeholder: false,
    });
  },
    initSelect2NoSearch: function () {
        $('.selectpicker.hide-search').select2({
            placeholder: false,
            minimumResultsForSearch: -1
        });
    },
    initTelInput: function () {
        $(".telephone").intlTelInput();
    },
  slickSliders: function() {
    initSliders.heroSlider();
    initSliders.thumbnailSLider();
    initSliders.generalSlider();
    initSliders.generalVideoSlider();
  },

}


$(document).on('click','.js-videoPoster',function(e) {
  e.preventDefault();
  var poster = $(this);
  var wrapper = poster.closest('.js-videoWrapper');
  initFunctions.videoPlay(wrapper);
});


$(document).ready(function() {
    initFunctions.menuToggle();
    initFunctions.dropDownToggle();
    initFunctions.sectionBg();
    initLibraries.slickSliders();
    initLibraries.initSelect2();
    initLibraries.initSelect2NoSearch();
    initLibraries.initTelInput();

});

