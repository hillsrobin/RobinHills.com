function actionLink(el)
{
	if($type(el) == 'string')
		el = document.getElement(el);
	
	el.removeProperty('href');
	el.setStyles({
							'cursor': 'pointer',
							'text-decoration': 'underline'
	});
	
	el.addEvent('mouseover',function(){
			el.setStyle('text-decoration','none');
	});
	
	el.addEvent('mouseout',function(){
			el.setStyle('text-decoration','underline');
	});
}
window.addEvent('domready',function(){
		var anchors = document.getElements('a[rel=action_link]');
		
		anchors.each(function(item){
				actionLink(item);
		});
});
