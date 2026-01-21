(function($){
  var regions = window.saElectionsSlider && saElectionsSlider.cycle_regions ? saElectionsSlider.cycle_regions : ['National'];
  var interval = window.saElectionsSlider && saElectionsSlider.cycle_interval ? saElectionsSlider.cycle_interval : 5000;
  var idx = 0;

  function animateBars($wrapper){
    $wrapper.find('.party').each(function(){
      var $p = $(this);
      var w = $p.data('percent') || $p.attr('data-percent') || 0;
      $p.find('.bar span').css('width', w + '%');
    });
  }

  $(function(){
    var $s = $('.sa-elections-slider');
    if(!$s.length) return;
    animateBars($s);
    // Cycle regions
    if(regions.length > 1){
      setInterval(function(){
        idx = (idx + 1) % regions.length;
        $s.find('.slider-region').text(regions[idx]);
      }, interval);
    }
    // Re-animate when scrolled into view (simple)
    $(window).on('scroll resize', function(){
      animateBars($s);
    });
  });
})(jQuery);