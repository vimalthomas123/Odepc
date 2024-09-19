(function($) {
  "use strict";

  $( document ).ready(function() {

  	//tooltip settings
    $('.tooltip').tooltipster({
      theme: 'tooltipster-light',
      contentCloning: true,
      // trigger: 'click', // used to style the tooltip content
    });

    //Pro version notice
    $('.csf .hashbar_pro_notice, .csf .hashbar_pro_opacity, .wc-metaboxes .hashbar_pro_notice, .hashbar_pro_notice_radiio ul li:last-child').on('click', function(){
        $('.thickbox.hashbar_trigger_pro_notice').click();
    });

    var countdown_init_style = $('.hthb-countdown-style-demo select').val();
    countdownStyleDisplay(countdown_init_style);
    $('.hthb-countdown-style-demo select').on('change',function(){
      countdownStyleDisplay($(this).val());
    });

    function countdownStyleDisplay(countdown_style){
      var ptagtest     = $('.hthb-countdown-style-demo .csf-fieldset').find('.countdown-style-img'),
        selected_style = countdown_style;

      if(!selected_style){
        $('.countdown-style-img').html('');
        return;
      }

      if(ptagtest.length == 0){
        $('.hthb-countdown-style-demo .csf-fieldset').append('<div class="countdown-style-img"><img src="'+hashbar_admin.hashbar_plugin_uri+'/admin/img/'+selected_style+'.png" alt="style-image"></div>');
      }else{
        $('.countdown-style-img').html('<img src="'+hashbar_admin.hashbar_plugin_uri+'/admin/img/'+selected_style+'.png" alt="style-image">');
      }
    }

    $('.hashbar_pro_notice_radiio ul li:last-child label input').attr('disabled', true);

      // CHange notification display option to open when the user change position to top/bottom promo.
      $('[name="_wphash_[_wphash_notification_position]"]').on('change', function() {
        if($(this).val() === 'ht-n_toppromo' || $(this).val() === 'ht-n_bottompromo') {
            $('[name="_wphash_[_wphash_notification_display]"]').val("ht-n-open");
        }
    })
    
  });
})(jQuery);