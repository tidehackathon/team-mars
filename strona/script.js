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
        data: [20, 12, 40, 50, 30, 0]
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
        width: '75%',
        height: '75%',
        type: "pie",
    },
    labels :['Polska', 'USA', "Francja", "Niemcy" ],
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
    ],
    dataLabels: {
        enabled: true,
        formatter: function (val) {
          return val + "%";
        },
        offsetY: -20,
        style: {
          fontSize: '12px',
          colors: ["#304758"]
        }
      },
      
};

var OptionsSemiDonut = {
    series: [75, 25],
    chart:{
        width: '75%',
        height: '75%',
        type:"donut",
    },
    plotOptions: {
        pie: {
            startAngle: -90,
            endAngle: 90,
            offsetY: 10,
            expandOnClick: false,
        }
    },
    grid: {
    },
    labels:['Udane', 'Nie udane'],
    responsive: [
        {
            breakpoint: 480,
            options: {
                chart: {
                    width:200
                },
                legend: {
                    position: 'top'
                }
            }
        }
    ],
    dataLabels: {
        enabled: true,
        formatter: function (val) {
          return val + "%";
        },
        offsetY: -20  ,
        style: {
          fontSize: '12px',
          colors: ["#304758"]
        }
      }
      
};
var OptionsSlupkowy = {
    series: [{
        name: 'Dane Udanych Testów',
        data: [78.2,21.4,23.6,12.24,67.24,67.24,21.24,12.67,23.66,98.7 ]
      }],
        chart: {
        height: 350,
        type: 'bar',
      },
      plotOptions: {
        bar: {
          borderRadius: 10,
          dataLabels: {
            position: 'top', // top, center, bottom
          },
        }
      },
      dataLabels: {
        enabled: true,
        formatter: function (val) {
          return val + " pp ";
        },
        offsetY: -20,
        style: {
          fontSize: '12px',
          colors: ["#304758"]
        }
      },
      
      xaxis: {
        categories: ['Polska', "Niemcy", "Hiszpania", "Francja", "Grecja", "Chorwacja", "Szwecja", "Norwegia", "Włochy", "UK"],
        position: 'top',
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        crosshairs: {
          fill: {
            type: 'gradient',
            gradient: {
              colorFrom: '#D8E3F0',
              colorTo: '#BED1E6',
              stops: [0, 100],
              opacityFrom: 0.4,
              opacityTo: 0.5,
            }
          }
        },
        tooltip: {
          enabled: true,
        }
      },
      yaxis: {
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false,
        },
        labels: {
          show: false,
          formatter: function (val) {
            return val + "%";
          }
        }
      
      },
      title: {
        text: 'Udane compatibility na kraj',
        floating: true,
        offsetY: 330,
        align: 'center',
        style: {
          color: '#444'
        }
      }
};

var OptionsWierszSlup = {
    series: [{
        name: 'Marine Sprite',
        data: [44, 55, 41, 37, 22, 43, 21]
      }, {
        name: 'Striking Calf',
        data: [53, 32, 33, 52, 13, 43, 32]
      }, {
        name: 'Tank Picture',
        data: [12, 17, 11, 9, 15, 11, 20]
      }, {
        name: 'Bucket Slope',
        data: [9, 7, 5, 8, 6, 9, 4]
      }, {
        name: 'Reborn Kid',
        data: [25, 12, 19, 32, 25, 24, 10]
      }],
        chart: {
        type: 'bar',
        height: 350,
        stacked: true,
      },
      plotOptions: {
        bar: {
          horizontal: true,
          dataLabels: {
            total: {
              enabled: true,
              offsetX: 0,
              style: {
                fontSize: '13px',
                fontWeight: 900
              }
            }
          }
        },
      },
      stroke: {
        width: 1,
        colors: ['#fff']
      },
      title: {
        text: 'Fiction Books Sales'
      },
      xaxis: {
        categories: [2008, 2009, 2010, 2011, 2012, 2013, 2014],
        labels: {
          formatter: function (val) {
            return val + "K"
          }
        }
      },
      yaxis: {
        title: {
          text: undefined
        },
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + "K"
          }
        }
      },
      fill: {
        opacity: 1
      },
      legend: {
        position: 'top',
        horizontalAlign: 'left',
        offsetX: 40
      }
      };

  var WierszSlup = new ApexCharts(document.querySelector("#WierszSlupkowy"), OptionsWierszSlup);
  var slupkowy = new ApexCharts(document.querySelector("#slupkowy"), OptionsSlupkowy);
  var SemiDonut = new ApexCharts(document.querySelector("#SemiDonut"), OptionsSemiDonut);
  var SemiDonut2 = new ApexCharts(document.querySelector("#SemiDonut2"), OptionsSemiDonut);
  var PieChart  = new ApexCharts(document.querySelector("#PieChart"), OptionsPieChart);
  var PieChart2  = new ApexCharts(document.querySelector("#PieChart2"), OptionsPieChart);
  var liniowy = new ApexCharts(document.querySelector("#liniowy"), OptionsLiniowy);
  PieChart.render();
  PieChart2.render();
  liniowy.render();
  SemiDonut.render();
  SemiDonut2.render();
  slupkowy.render();
  WierszSlup.render();