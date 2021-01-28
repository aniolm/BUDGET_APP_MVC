	$(document).ready(function() {
		$("#timew").change(function() {
			var timewindow= $(this).val();
			if (timewindow == "3") 
			{
            $("#dates").show();
            } 
			else 
			{
            $("#dates").hide();			
			};
		})
		});
     