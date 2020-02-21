$('select#days').change(function(ev){
	$.each($('div.module'), function(i, el){
		var url = $(el).css('background-image');
		url = url.substring(5, url.length - 2);
		$(el).css({'background-image': 'url("' + url + '&dy='+$(ev.target).val() + '")'});
		console.log(url + '&dy='+$(ev.target).val());
	});
});