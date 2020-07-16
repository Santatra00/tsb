(function($) {
  'use strict';
  $(function() {
    var sidebar = $('.sidebar');

    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required
    var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
    $('.nav li a', sidebar).each(function() {
      var $this = $(this);
      if (current === "") {
        //for root url
        if ($this.attr('href').indexOf("index.html") !== -1) {
          //$(this).parents('.nav-item').last().addClass('active');
          if ($(this).parents('.sub-menu').length) {
            $(this).closest('.collapse').addClass('show');
            //$(this).addClass('active');
          }
        }
      } else {
        //for other url
        if ($this.attr('href').indexOf(current) !== -1) {
          //$(this).parents('.nav-item').last().addClass('active');
          if ($(this).parents('.sub-menu').length) {
            $(this).closest('.collapse').addClass('show');
            //$(this).addClass('active');
          }
        }
      }
    })

    //Close other submenu in sidebar on opening any

    sidebar.on('show.bs.collapse', '.collapse', function() {
      sidebar.find('.collapse.show').collapse('hide');
    });


    //Change sidebar and content-wrapper height
    applyStyles();

    function applyStyles() {
      //Applying perfect scrollbar
      if ($('.scroll-container').length) {
        const ScrollContainer = new PerfectScrollbar('.scroll-container');
      }
    }

    //checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');


    $(".purchace-popup .popup-dismiss").on("click",function(){
      $(".purchace-popup").slideToggle();
    });

    $('#btn-toggle-menu').on("click", function(){
      var sidebar = $('#sidebar');
      var reste_sidebar = $(".reste-sidebar")
      var nav_haut = $("#nav-haut")
      let mainpanel = $('.main-panel');
      let max = 300;
      let min = 60;
      console.log('alert', sidebar.width())
      if(sidebar.width() == min){
        $('#sidebar').css('width', max+'px');
        $('#main').css('margin-left', '300px');

        $("#nav-haut").css('width', 'calc(100% - '+max+'px)');
        reste_sidebar.fadeOut();
        setTimeout(function(){
          map.resize()
        }, 2500)
        console.log('retraissir');
      }else{
        $('#sidebar').css('width', min + 'px');
        $('#main').css('margin-left', '60px');
        $("#nav-haut").css('width', 'calc(100% - '+min+'px)');
        reste_sidebar.fadeIn();
        setTimeout(function(){
          map.resize()
        }, 2500)
        console.log('retraissir');
      }
    })
  });
})(jQuery);