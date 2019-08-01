$(document).ready(function(){
	//for Selectbox
	$('.selectForm').jqTransform();
	
	$(window).resize(function() {
		if ($(window).width() > 1100) {
			$('html').addClass('desktopL')
		}
		else {
			$('html').removeClass('desktopL')
		}
	});
	if ($(window).width() > 1100) {
		$('html').addClass('desktopL')
	}
	else {
		$('html').removeClass('desktopL')
	}

});

var SITE = SITE || {};
 
SITE.fileInputs = function() {
  var $this = $(this),
      $val = $this.val(),
      valArray = $val.split('\\'),
      newVal = valArray[valArray.length-1],
      $button = $this.siblings('.button'),
      $fakeFile = $this.siblings('.file-holder');
  if(newVal !== '') {
    $button.text('Photo Chosen');
    if($fakeFile.length === 0) {
      $button.after('<span class="file-holder">' + newVal + '</span>');
    } else {
      $fakeFile.text(newVal);
    }
  }
};
 
$(document).ready(function() {
  $('.file-wrapper input[type=file]').bind('change focus click', SITE.fileInputs);
});