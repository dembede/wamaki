/**
* @file
* A JavaScript file for the theme.
*
* In order for this JavaScript to be loaded on pages, see the instructions in
* the README.txt next to this file.
*/

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth

// WINDOW LOAD FUNCTION
$(document).ready(function(){

  resize();
  var window_width = $(window).width();
  var window_height = $(window).height();

  $('a.anchor').click(function(){
    var anchor = "#"+$(this).attr('name');
    $('html, body').animate({
      scrollTop: $(anchor).offset().top
    }, 700);

    $('.anchor.active').removeClass('active');

    var active_class = ".anchor."+$(this).attr('name');
    $(active_class).addClass('active');
    if(window_width < 690) {
      $('#menu_toggle').click();
    }
    return false;
  });

  $('#menu_toggle').click(function(){
    $(this).next('#menu_block').slideToggle('fast');
  });


  $(window).resize(function(){
    resize();
  });

  function resize(){
    window_width = $(window).width();
    var min_height = window_width*0.41667;
    // $('.content').css('min-height',min_height);
    centre_overlay();
  }

  $('#main_slideshow').bjqs({
    // width and height need to be provided to enforce consistency
    // if responsive is set to true, these values act as maximum dimensions
    width : 1440,
    height : 600,

    // animation values
    animtype : 'slide', // accepts 'fade' or 'slide'
    animduration : 450, // how fast the animation are
    animspeed : 4000, // the delay between each slide
    automatic : true, // automatic

    // control and marker configuration
    showcontrols : true, // show next and prev controls
    centercontrols : true, // center controls verically
    nexttext : 'Next', // Text for 'next' button (can use HTML)
    prevtext : 'Prev', // Text for 'previous' button (can use HTML)
    showmarkers : true, // Show individual slide markers
    centermarkers : true, // Center markers horizontally

    // interaction values
    keyboardnav : true, // enable keyboard navigation
    hoverpause : true, // pause the slider on hover

    // presentational options
    usecaptions : true, // show captions for images using the image title tag
    randomstart : false, // start slider at random slide
    responsive : true // enable responsive capabilities (beta)
  });

  $('.button.readmore').click(function(){
    var overlay_content =  $(this).prev('.intro_blurb').html();
    overlay_content = overlay_content.replace('hidden','');
    overlay_content = '<span class="close"><i class="fa fa-times-circle fa-2x" aria-hidden="true"></i></span><span class="content_title">About Wamaki Safaris Ltd.</span><div class="content_blurb">'+overlay_content+'</div>';
    show_overlay(overlay_content);
  });

  $('.grid .item').click(function(){
    var overlay_content =  $(this).find('.feature_content').html();
    show_overlay(overlay_content);
  });

  function show_overlay(overlay_content) {
    $(document).find('.overlay').html("").html('<div class="overlay_content animated fadeIn round">'+overlay_content+'</div>').toggleClass('hidden');
    $('body').addClass('noscroll');
    centre_overlay();
  }

  function centre_overlay(){
    window_height = $(window).height();
    var overlay_height = $(document).find('.overlay .overlay_content').height();
    if(overlay_height > (window_height-150)){
      var overlay_max_height = window_height-250;
      if(window_width <= 480) {
        overlay_max_height = window_height-40;
      }
    }
    $(document).find('.overlay .overlay_content').css({'max-height':overlay_max_height, 'height':overlay_max_height});
    var overlayheader_height = $(document).find('.overlay .overlay_content .overlay_header').height();
    var bodycontent_max_height =  overlay_max_height - overlayheader_height;
    bodycontent_max_height = bodycontent_max_height-50;
    $(document).find('.overlay .overlay_content .content_blurb').css({'max-height': bodycontent_max_height , 'height': bodycontent_max_height});
    var margin_top = -(($(document).find('.overlay .overlay_content').height()/2)+15);
    $(document).find('.overlay .overlay_content').css('margin-top', margin_top);
  }

  $(document).delegate('.contact-form .form-submit', 'click', function(e){
    e.preventDefault();
    var form_id = $(this).parent().parent().parent();
    submit_contact_form(form_id);
  });

  function submit_contact_form(form_id){
    var title = "Contact Form Submission";
    $('input, textarea').removeClass('error');
    $(form_id).find('#edit-submit').text('Sending...');
    // Add spinner to button
    $(form_id).append('<div class="spinner"></div>');
    var name = $(form_id).find("input#edit-name").val();
    if (name == "") {
      $('.spinner').hide();
      $(form_id).find("input#edit-name").focus().toggleClass('error');
      $(form_id).find('#edit-submit').text('Send Message');
      return false;
    }
    var email = $("input#edit-mail").val();
    if (email == "") {
      $('.spinner').hide();
      $(form_id).find("input#edit-mail").focus().toggleClass('error');
      $(form_id).find('#edit-submit').text('Send Message');
      return false;
    } else if (email != "") {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if(regex.test(email) == 0){
        $(form_id).find("input#edit-mail").focus().toggleClass('error');
        $(form_id).find('#edit-submit').text('Send Message');
        return false;
      }
    }
    var subject = $(form_id).find("input#edit-subject").val();
    if (subject == "") {
      $('.spinner').hide();
      $(form_id).find("input#edit-subject").focus().toggleClass('error');
      $(form_id).find('#edit-submit').text('Send Message');
      return false;
    }
    var message = $(form_id).find("textarea#edit-message").val();
    if (message == "") {
      $('.spinner').hide();
      $(form_id).find("textarea#edit-message").focus().toggleClass('error');
      $(form_id).find('#edit-submit').text('Send Message');
      return false;
    }
    var dataString = 'submit='+ title + '&name='+ name + '&email=' + email + '&subject=' + subject+ '&message=' + message;
    var base_url = window.location.origin;
    $.ajax({
      type: "POST",
      url: "./js/scripts/contact_form_submission.php",
      data: dataString,
      success: function(data) {
        $('.spinner').hide();
        $(form_id).find('#edit-submit').text('Send Message');
        $(form_id).find("input[type=text], input[type=email], textarea").val("");
        $('#conf-message').html(data).toggleClass('hidden').delay(10000).fadeOut();
      }
    });
  }


  $(document).delegate('.close', 'click', function(e){
    e.preventDefault();
    $('body').removeClass('noscroll');
    $(document).find('.overlay').addClass('hidden').html('');
    $(document).find('.overlay *').remove();
  });
  $(document).keyup(function(e) {
    if (e.keyCode == 27) $('.close').click();   // esc
  });
});
