
	$(function(){
		$('#artist').autocomplete({
			source: 'index.php?controller=admin&action=checkartist',
			minLength: 3,
			appendTo : '.instantresult'

		})

		$('#album').autocomplete({
			source: 'index.php?controller=admin&action=checkalbum',
			minLength: 3,
			appendTo : '.instantresult'

		})
	});
