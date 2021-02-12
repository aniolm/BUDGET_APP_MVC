
  $('#editcategory').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var name = button.data('name');
	var color = button.data('color');
	var planned = button.data('planned');
	var type = button.attr('name');
	if (type == 'editincome')
	{
		var url = "/settings/" + id + "/editincome";
	}
	else
	{
		var url = "/settings/" + id + "/editexpense";
	}
	$("#form").attr("action", url);
	$("#name").val(name);
	$("#color").val(color);
	$("#planned").val(planned);
	
  })
  
  