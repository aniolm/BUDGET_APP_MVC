  

	$(document).on('click', '.btn_edit', function() { 
	var button = $(this);
	var id = button.data('id');
	var name = button.data('name');
	var color = button.data('color');
	var planned = button.data('planned');
	var type = button.attr('name');
	
	if (type == 'editincome')
	{
		var url = "/settings/"+id+"/editincome";
	}
	else
	{
		var url = "/settings/"+id+"/editexpense";
	}
	
	$("#name").val(name);
	$("#color").val(color);
	$("#planned").val(planned);
	$("#form").attr('action',url);
	}) 
	
	$('#submit_btn').click(function(){
		
		name = $("#name").val();
		color = $("#color").val();
		planned = $("#planned").val();
		url = $("#form").attr('action');
		
		$.ajax({
                url: url,
                method:'POST',
                data:{name:name , color:color, planned: planned},

                success:function(data)
                {
                    $('#editcategory').modal('hide');
					$('#content').html(data);
					
				}
            });
	
	});   
  

