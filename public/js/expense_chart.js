var ctx3 = document.getElementById("expenseChart");
   var expenseChart = new Chart(ctx3, {
    type: 'doughnut',
    data: {
        labels: ["Transport", "Bills", "Healthcare", "Clothing", "Hygene", "Kids", "Amusement", "Training", "Books", "Savings", "Pension", "Debts", "Charity", "Others"],
        datasets: [{
            label: '# Expenses',
           
            data: [6.66, 6.66, 6.66, 6.66, 6.66, 6.66, 6.66, 6.66, 6.66, 6.66, 6.66, 6.66, 6.66 , 6.66    
			],
            backgroundColor: [
                '#B6C7F2',               
                '#9DF2A3',
				'#F285AF',
				'#F2D691',
				'#F2EE85',
				'#F57A71',
				'#F2EECB',               
                '#F2BEB4',
				'#9BF2D0',
				'#9F87F5',
				'#E79BF2',
				'#F2E0CB',
				'#74D2F5',               
                '#C7F29B',
				'#F5B584'
            ],
            borderColor: [
                '#49704C',                
                '#49704C',
				'#49704C',                
                '#49704C',
				'#49704C',                
                '#49704C',
				'#49704C',                
                '#49704C',
				'#49704C',                
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