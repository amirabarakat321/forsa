$(document).ready(function(){
				var ctx = $("#mycanvas").get(0).getContext("2d");

				//pie chart data
				//sum of values = 360
				var data = [
					{
						value: 40,
						color: "#194573",
						highlight: "#194573dd",
						label: "رواتب"
					},
					{
						value: 30,
						color: "#F1BE32",
						highlight: "#F1BE32dd",
						label: "فواتير"
					},
					{
						value: 10,
						color: "#BF4B4B",
						highlight: "#BF4B4Bdd",
						label: "ايجارات"
					},
					{
						value: 20,
						color: "#69B075",
						highlight: "#69B075dd",
						label: "اخرى"
					}
				];

				//draw
				var piechart = new Chart(ctx).Pie(data);
			});