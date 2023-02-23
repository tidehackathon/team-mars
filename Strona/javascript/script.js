var OptionsLiniowy = {
    chart: {
      height: 380,
      width: "100%",
      type: "line"
    },
    series: [
      {
        name: "CWIX 2021",
        data: [45, 52, 38, 45, 19, 33]
      },
      {
        name:"CWIX 2022",
        data: [12, 34, 21, 23, 12, 12 ]
      },
      {
        name:"CWIX 2023 - Propagorane",
        data: [110, 122, 133, 444, 122, 0]
      }
    ],
    xaxis: {
      categories: [
        "01 Jan",
        "02 Jan",
        "03 Jan",
        "04 Jan",
        "05 Jan",
        "06 Jan"
      ]
    }
  };
  
var OptionsPieChart = {
    series: [44, 23, 12, 21],
    chart: {
        width: 280,
        height: 180,
        type: "pie",
    },
    labels :['Bolzga', 'USA', "Francja", "Niemcy" ],
    responsive :[
        {
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    ]
}

  var PieChart  = new ApexCharts(document.querySelector("#PieChart"), OptionsPieChart);
  var liniowy = new ApexCharts(document.querySelector("#liniowy"), OptionsLiniowy);
  PieChart.render();
  liniowy.render();
  