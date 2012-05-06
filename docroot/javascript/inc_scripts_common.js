jQuery(document).ready(function(){
		
		var anchors = $('a[rel=action_link]');
		
		anchors.each(function(index,item){
				el = jQuery(item);
				el.removeAttr('href');
				el.css({
							'cursor': 'pointer',
							'text-decoration': 'underline'
				});
				
				el.mouseover(function(){
						el.css('text-decoration','none');
				});
				
				el.mouseout(function(){
						el.css('text-decoration','underline');
				});
		});
		
		cloudInit(jQuery(".cloudbox span"),"{exp} years");
		cloudInit(jQuery(".skillbox span"),"{exp}%");	
		
		jQuery("#top").click(function(){
				window.location.href='/';
		});
		
});

function cloudInit(el,title)
{
	if(el.length > 0)
	{
								
		var maximum = 0;
		el.each(function(index,item){
		var exp = Number(jQuery(item).attr('data-weight'));
											
		if(exp > maximum)
				maximum = exp;
		});
									
		el.each(function(index,item){
			item = jQuery(item);
			var exp = Number(item.attr('data-weight'));
			var size = exp/maximum;
			
			if(size < 0.6)
				size = 0.6;
											
			item.css('font-size',size+"em");
			item.css('cursor','pointer');
			
			if((title != null) && ($.trim(title) != ''))
			{
				var title_new = title.replace("{exp}",exp);
				title_new = title_new.replace("{max}",maximum);
				
				item.html('<abbr title="'+title_new+'">'+item.html()+'</abbr>');
			}
		});
	}
}
