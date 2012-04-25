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
		
		cloudInit(document.getElements(".cloudbox span"),"{exp} years");
		cloudInit(document.getElements(".skillbox span"),"{exp}%");	
		
		document.getElement("#top").addEvent('click',function(){
				window.location.href='/';
		});
		
});

function cloudInit(el,title)
{
	if(el.length > 0)
	{
								
		var maximum = 0;
		el.each(function(item){
		var exp = Number.from(item.get('data-weight'));
											
		if(exp > maximum)
				maximum = exp;
		});
									
		el.each(function(item){
			var exp = Number.from(item.get('data-weight'));
			var size = exp/maximum;
											
			if(size < 0.6)
				size = 0.6;
											
			item.setStyle('font-size',size+"em");
			item.setStyle('cursor','pointer');
			
			if((title != null) && (title.trim() != ''))
			{
				var title_new = title.replace("{exp}",exp);
				title_new = title_new.replace("{max}",maximum);
				
				item.set('html','<abbr title="'+title_new+'">'+item.get('html')+'</abbr>');
			}
		});
	}
}
