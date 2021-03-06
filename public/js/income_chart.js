
   var ctx2 = document.getElementById("incomeChart");
   var incomeChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ["Sallary", "Bonus money" ,"Earned interest", "Rental property", "Sold items", "Others" ],
			
        datasets: [{
            label: '# Incomes',
            data: [ {% for category in incomes_summed %} {% if not loop.first %},{% endif %} {{ category.earned }}{% endfor %}],
            backgroundColor: [
                '#B6C7F2',               
                '#9DF2A3',
				'#F285AF',
				'#F2D691',
				'#F2EE85',
				'#F57A71'
            ],
            borderColor: [
                '#49704C',                
                '#49704C',
				'#49704C',                
                '#49704C',
				'#49704C',                
                '#49704C'
            ],
            borderWidth: 1
        }],
		
    },
    options: {

		responsive: true,
        maintainAspectRatio: false,
		layout: {
            padding: {
                left: 10,
                right: 10,
                top: 0,
                bottom: 0
            }
        },
		legend: {
            display: true    
        },
		elements: {
			center: {
					text: '28.3%',
					color: '#49704C', // Default is #000000
					fontStyle: 'Open Sans,sans-serif', // Default is Arial
					sidePadding: 20, // Default is 20 (as a percentage)
					minFontSize: 10, // Default is 20 (in px), set to false and text will not wrap.
					lineHeight: 10 // Default is 25 (in px), used for when text wraps
					}
		}
    }
    });