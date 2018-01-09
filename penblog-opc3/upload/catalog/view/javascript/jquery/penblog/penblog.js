$(document).ready(function() {
	$('#list-view').click(function() {
		$('#content .gen-cms-grid > .clearfix').remove();

		$('#content .row > .gen-cms-grid').attr('class', 'product-layout gen-cms-list col-xs-12');

		localStorage.setItem('display', 'list');
	});

	$('#grid-view').click(function() {
		// What a shame bootstrap does not take into account dynamically loaded columns
		cols = $('#column-right, #column-left').length;

		if (cols == 2) {
			$('#content .gen-cms-list').attr('class', 'product-layout gen-cms-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');
		} else if (cols == 1) {
			$('#content .gen-cms-list').attr('class', 'product-layout gen-cms-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');
		} else {
			$('#content .gen-cms-list').attr('class', 'product-layout gen-cms-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');
		}

		 localStorage.setItem('display', 'grid');
	});

	if (localStorage.getItem('display') == 'list') {
		$('#list-view').trigger('click');
	} else {
		$('#grid-view').trigger('click');
	}
});