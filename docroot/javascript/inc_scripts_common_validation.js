/*
	Example:
			contact_validation = validate_form;
			window.addEvent('domready',function(){
					contact_validation.add_field({id:'name', type: 'blank'});
					contact_validation.add_field({id:'email',type: ['blank','email']});
					contact_validation.add_field({id:'confirm',type: ['blank','email','compare'],companion:'email'});
					contact_validation.add_field({id:'identity',type: 'selected', default: ''});
					contact_validation.add_field({id:'subject',type: 'selected', default: ''});
					contact_validation.add_field({id: 'message',type: 'blank'});
			});
			
			
			
			onclick="return contact_validation.form(this.id)"
*/
var validate_form = {
	error_color: '#cc0000',
	base_color: '#666666',
	fields: [],
	debug: false,

	add_field: function(data)
	{
		var nextId = this.fields.length;
		this.fields[nextId] = data;
	},
	remove_field: function(field_id)
	{	
		var remove_index = -1;
		this.fields.each(function(item,index){
				
				if(($type(field_id) == 'array')&&($type(item['id']) == 'array'))
				{
					if(item['id'].compare(field_id))
						remove_index = index;
				}
				else
					if(item['id'] == field_id)
						remove_index = index;
		});
		
		if(remove_index.toInt() != -1)
			this.fields.splice(remove_index,1);
	},
	form:  function(form_id)
	{
		var bValid = true;

		for(var i = 0; i < this.fields.length; i++)
		{
			if(!this.input(this.fields[i]))
				bValid = false;
		}
		
		if(form_id != null)
		{
			try
			{
					
				if(!bValid)
					$(form_id+'_error').setStyle('display','block');
				else
					$(form_id+'_error').setStyle('display','none');
			}
			catch(e){}
		}

		return bValid;
	},

	input: function(field)
	{
		var value = '';
		var bValid = true;
		var id = field['id'];
		var validation_type = field['type'];
		
		try
		{
			if(id.constructor != Array)
				id = new Array(id);
		}
		catch(e){
			id = new Array(id);
			
		}
		
		id.each(function(item){
			if(
				(($(item).nodeName.toUpperCase() == 'INPUT') && ($(item).attributes.getNamedItem('type').value.toUpperCase() == 'TEXT')) ||
				(($(item).nodeName.toUpperCase() == 'INPUT') && ($(item).attributes.getNamedItem('type').value.toUpperCase() == 'PASSWORD')) ||
				($(item).nodeName.toUpperCase() == 'TEXTAREA') ||
				(($(item).nodeName.toUpperCase() == 'SELECT') && ($(item).multiple == false))
			)
			{
				 value = value + $(item).value;
			}
			else if($(item).nodeName.toUpperCase() == 'FIELDSET') // Only used for Radio groups
			{
				value = -1;
				
				$(item).getElements('input[type=radio]').each(function(radio_item){
						if(radio_item.checked == true)
							value = radio_item.value;
				});
			}
		});
		
		try
		{	// Does not need to have an error field defined
			
			if($(id.copy(0,1)+'_error').getStyle('color').toLowerCase() != this.error_color.toLowerCase())
				this.base_color = $(id.copy(0,1)+'_error').getStyle('color');
		}
		catch(e){}

		try
		{
			if(validation_type.constructor != Array)
				validation_type = new Array(validation_type);
		}
		catch(e){
			validation_type = new Array(validation_type);
		}

		for(var i = 0; i < validation_type.length; i++)
		{
			switch(validation_type[i])
			{
				case 'selected':
					if(value == field['selected'])
						bValid = false;
					break;
				case 'is_selected':
					if(value != field['selected'])
						bValid = false;
					break;
				case 'blank':
					if(value.trim() == '')
						bValid = false;
					break;
				
				case 'email':
					var goodEmail = value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.biz)|(\.mil)|(\.gov)|(\.org)|(\..{2,2}))$)\b/gi);

					if(goodEmail != value)
						bValid = false;
					
					if(value.trim() == '')
						bValid = true;
					
					break;
					
				case 'numeric':
					if(value.replace(/[^0-9]/gi,"") == value)
						bValid = true;
					else 
						bValid = false;
					
					break;
					
				case 'phone':
					var phone_number = value.replace(/[^0-9]/gi,"");
					
					if((phone_number.length == 7)||(phone_number.length == 10)||(phone_number.length == 11))
						bValid = true;
					else
						bValid = false;
					
					if(value == '')	// If blank ignore validation
						bValid = true;
					
					break;
					
				case 'postal':
					var postalcode = value;
				
					//strip out the space
					postalcode = postalcode.replace(' ','');

					if(postalcode.length == 6)	// Validate as postal code
					{
						if (postalcode.length == 6 && postalcode.search(/^[a-zA-Z]\d[a-zA-Z]\d[a-zA-Z]\d$/)  != -1)
							bValid = true;
						else
							bValid =  false;
					}
					else	// Validate as ZipCode
					{
						if(postalcode.length == 5 && postalcode.search(/^[0-9]{5,6}$/) !=-1)
							bValid = true;
						else
							bValid =  false;
					}

					if(postalcode == "")	// Ignore if the field is blank
						bValid = true;
					
					break;
					
				case 'compare':
					if(value != $(field['companion']).value)
						bValid = false;
			}
			
			try
			{
				if(this.debug == true)
					console.log(field['id']+" ("+value+") :"+validation_type[i]+":"+bValid);
			}catch(e){}
			
			if(!bValid)	// If validation fails stop checking!
				break;
			
		}

		if(!bValid)
		{
			try
			{
				$(id[0]+'_error').setStyle('color',this.error_color);
				$(id[0]+'_error').setStyle('display','block');
			}
			catch(e){
			
			}
				
			try
			{
				if(field['companion'] != 'undefined')
				{
					$(field['companion']+'_error').setStyle('color',this.error_color);
					$(field['companion']+'_error').setStyle('display','block');
				}
			}
			catch(e){}
			
		}
		else
		{
			try{
				$(id[0]+'_error').setStyle('color',this.base_color);
			}
			catch(e){
			}

			try
			{
				if(field['companion'] != 'undefined')
					$(field['companion']+'_error').setStyle('color',this.base_color);
			}
			catch(e){}
		}

		return bValid;
	}
};
