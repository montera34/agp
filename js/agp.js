var container = ".single-project .entry-content";

function setContainerHeight(tarjet) {
	var newHeight = jQuery(window).height() - 90;
	jQuery(tarjet).css( "height", newHeight );
}

jQuery(document).ready(function($){

	// window resize event
	$(window).resize(function() {
		if(this.resizeTO) clearTimeout(this.resizeTO);
		this.resizeTO = setTimeout(function() {
			$(this).trigger('resizeEnd');
		}, 500);
	});
	$(window).bind("resizeEnd",function() {
		setContainerHeight(container)
	});

	// window load event
	$(window).load(setContainerHeight(container));
});
