try {


  /*
      ==============================
      |    @Options Charts Script   |
      ==============================
  */

  /*
      ======================================
          Visitor Statistics | Options
      ======================================
  */


  // Total Visits

  var spark1 = {
    chart: {
      id: 'unique-visits',
      group: 'sparks2',
      type: 'line',
      height: 58,
      sparkline: {
        enabled: true
      },
    },
    series: [{
      data: [21, 9, 36, 12, 44, 25, 59, 41, 66, 25]
    }],
    stroke: {
      curve: 'smooth',
      width: 2,
    },
    markers: {
      size: 0
    },
    grid: {
      padding: {
        top: 0,
        bottom: 0,
        left: 0
      }
    },
    colors: ['#2196f3'],
    tooltip: {
      x: {
        show: false
      },
      y: {
        title: {
          formatter: function formatter(val) {
            return '';
          }
        }
      }
    },
    responsive: [
      {
        breakpoint: 576,
        options: {
          chart: {
            height: 95,
          },
          grid: {
            padding: {
              top: 45,
              bottom: 0,
              left: 0
            }
          },
        },
      }

    ]
  }

  // Paid Visits

  var spark2 = {
    chart: {
      id: 'total-users',
      group: 'sparks1',
      type: 'line',
      height: 58,
      sparkline: {
        enabled: true
      },
    },
    series: [{
      data: [22, 19, 30, 47, 32, 44, 34, 55, 41, 69]
    }],
    stroke: {
      curve: 'smooth',
      width: 2,
    },
    markers: {
      size: 0
    },
    grid: {
      padding: {
        top: 0,
        bottom: 0,
        left: 0
      }
    },
    colors: ['#e2a03f'],
    tooltip: {
      x: {
        show: false
      },
      y: {
        title: {
          formatter: function formatter(val) {
            return '';
          }
        }
      }
    },
    responsive: [
      {
        breakpoint: 576,
        options: {
          chart: {
            height: 95,
          },
          grid: {
            padding: {
              top: 35,
              bottom: 0,
              left: 0
            }
          },
        },
      }
    ]
  }


  /*
      ===================================
          Unique Visitors | Options
      ===================================
  */

  var d_1options1 = {
    chart: {
      height: 350,
      type: 'bar',
      toolbar: {
        show: false,
      }
    },
    colors: ['#517281', '#f67062'],
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
        endingShape: 'rounded'
      },
    },
    dataLabels: {
      enabled: false
    },
    legend: {
      position: 'bottom',
      horizontalAlign: 'center',
      fontSize: '14px',
      markers: {
        width: 10,
        height: 10,
      },
      itemMargin: {
        horizontal: 0,
        vertical: 8
      }
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    series: [{
      name: 'Direct',
      data: [58, 44, 55, 57, 56, 61, 58, 63, 60, 66, 56, 63]
    }, {
      name: 'Organic',
      data: [91, 76, 85, 101, 98, 87, 105, 91, 114, 94, 66, 70]
    }],
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return val
        }
      }
    }
  }

  /*
      ==============================
          Statistics | Options
      ==============================
  */

  // Followers

  var d_1options3 = {
    chart: {
      id: 'sparkline1',
      type: 'area',
      height: 160,
      sparkline: {
        enabled: true
      },
    },
    stroke: {
      curve: 'smooth',
      width: 2,
    },
    series: [{
      name: 'Sales',
      data: [38, 60, 38, 52, 36, 40, 28]
    }],
    labels: ['1', '2', '3', '4', '5', '6', '7'],
    yaxis: {
      min: 0
    },
    colors: ['#4361ee'],
    tooltip: {
      x: {
        show: false,
      }
    },
  }

  // Referral

  var d_1options4 = {
    chart: {
      id: 'sparkline1',
      type: 'area',
      height: 160,
      sparkline: {
        enabled: true
      },
    },
    stroke: {
      curve: 'smooth',
      width: 2,
    },
    series: [{
      name: 'Sales',
      data: [60, 28, 52, 38, 40, 36, 38]
    }],
    labels: ['1', '2', '3', '4', '5', '6', '7'],
    yaxis: {
      min: 0
    },
    colors: ['#e7515a'],
    tooltip: {
      x: {
        show: false,
      }
    }
  }

  // Engagement Rate

  var d_1options5 = {
    chart: {
      id: 'sparkline1',
      type: 'area',
      height: 160,
      sparkline: {
        enabled: true
      },
    },
    stroke: {
      curve: 'smooth',
      width: 2,
    },
    fill: {
      opacity: 1,
    },
    series: [{
      name: 'Sales',
      data: [28, 50, 36, 60, 38, 52, 38]
    }],
    labels: ['1', '2', '3', '4', '5', '6', '7'],
    yaxis: {
      min: 0
    },
    colors: ['#1abc9c'],
    tooltip: {
      x: {
        show: false,
      }
    }
  }


  /*
      ==============================
      |    @Render Charts Script    |
      ==============================
  */


  /*
      ======================================
          Visitor Statistics | Script
      ======================================
  */

  // Total Visits
  d_1C_1 = new ApexCharts(document.querySelector("#total-users"), spark1);
  d_1C_1.render();

  // Paid Visits
  d_1C_2 = new ApexCharts(document.querySelector("#paid-visits"), spark2);
  d_1C_2.render();

  /*
      ===================================
          Unique Visitors | Script
      ===================================
  */

  var d_1C_3 = new ApexCharts(
    document.querySelector("#uniqueVisits"),
    d_1options1
  );
  d_1C_3.render();

  /*
      ====================================
          Orgainc and Direct | Script
      ====================================
  */

  // var d_1C_4 = new ApexCharts(document.querySelector("#orgaincDirect"), d_1options2);
  // d_1C_4.render();


  /*
      ==============================
          Statistics | Script
      ==============================
  */


  // Followers

  var d_1C_5 = new ApexCharts(document.querySelector("#hybrid_followers"), d_1options3);
  d_1C_5.render()

  // Referral

  var d_1C_6 = new ApexCharts(document.querySelector("#hybrid_followers1"), d_1options4);
  d_1C_6.render()

  // Engagement Rate

  var d_1C_7 = new ApexCharts(document.querySelector("#hybrid_followers3"), d_1options5);
  d_1C_7.render()



} catch (e) {
  // statements
  console.log(e);
}



try {

  /*
      ==============================
      |    @Options Charts Script   |
      ==============================
  */

  /*
      =============================
          Daily Sales | Options
      =============================
  */
  var d_2options1 = {
    chart: {
      height: 160,
      type: 'bar',
      stacked: true,
      toolbar: {
        show: false,
      }
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      show: true,
      width: 1,
    },
    colors: ['#70B2D9', '#e7f7ff'],
    responsive: [{
      breakpoint: 480,
      options: {
        legend: {
          position: 'bottom',
          offsetX: -10,
          offsetY: 0
        }
      }
    }],
    series: [{
      name: 'Sales',
      data: [44, 55, 41, 67, 22, 43, 21]
    }, {
      name: 'Last Week',
      data: [13, 23, 20, 8, 13, 27, 33]
    }],
    xaxis: {
      labels: {
        show: false,
      },
      categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
    },
    yaxis: {
      show: false
    },
    fill: {
      opacity: 1
    },
    plotOptions: {
      bar: {
        horizontal: false,
        startingShape: 'rounded',
        endingShape: 'rounded',
        columnWidth: '25%',

      }
    },
    legend: {
      show: false,
    },
    grid: {
      show: false,
      xaxis: {
        lines: {
          show: false
        }
      },
      padding: {
        top: 10,
        right: 0,
        bottom: -40,
        left: 0
      },
    },
  }

  /*
      =============================
          Total Orders | Options
      =============================
  */
  var d_2options2 = {
    chart: {
      id: 'sparkline1',
      group: 'sparklines',
      type: 'area',
      height: 280,
      sparkline: {
        enabled: true
      },
    },
    stroke: {
      curve: 'smooth',
      width: 2
    },
    fill: {
      opacity: 1,
    },
    series: [{
      name: 'Sales',
      data: [28, 40, 36, 52, 38, 60, 38, 52, 36, 40]
    }],
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
    yaxis: {
      min: 0
    },
    grid: {
      padding: {
        top: 125,
        right: 0,
        bottom: 0,
        left: 0
      },
    },
    tooltip: {
      x: {
        show: false,
      },
      theme: 'dark'
    },
    colors: ['#e7515a']
  }

  /*
      =================================
          Revenue Monthly | Options
      =================================
  */
  var options1 = {
    chart: {
      fontFamily: 'Quicksand, sans-serif',
      height: 365,
      type: 'area',
      zoom: {
        enabled: false
      },
      dropShadow: {
        enabled: true,
        opacity: 0.2,
        blur: 10,
        left: -7,
        top: 22
      },
      toolbar: {
        show: false
      },
      events: {
        mounted: function (ctx, config) {
          const highest1 = ctx.getHighestValueInSeries(0);
          const highest2 = ctx.getHighestValueInSeries(1);

          // ctx.addPointAnnotation({
          //   x: new Date(ctx.w.globals.seriesX[0][ctx.w.globals.series[0].indexOf(highest1)]).getTime(),
          //   y: highest1,
          //   label: {
          //     style: {
          //       cssClass: 'd-none'
          //     }
          //   },
          //   customSVG: {
          //     SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#2196f3" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
          //     cssClass: undefined,
          //     offsetX: -8,
          //     offsetY: 5
          //   }
          // })

          // ctx.addPointAnnotation({
          //   x: new Date(ctx.w.globals.seriesX[1][ctx.w.globals.series[1].indexOf(highest2)]).getTime(),
          //   y: highest2,
          //   label: {
          //     style: {
          //       cssClass: 'd-none'
          //     }
          //   },
          //   customSVG: {
          //     SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#6d17cb" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
          //     cssClass: undefined,
          //     offsetX: -8,
          //     offsetY: 5
          //   }
          // })
        },
      }
    },
    colors: ['#2196f3', '#6d17cb', '#e7515a', '#4361ee', '#009688', '#fc9842'],
    dataLabels: {
      enabled: false
    },
    markers: {
      discrete: [{
        seriesIndex: 0,
        dataPointIndex: 7,
        fillColor: '#000',
        strokeColor: '#000',
        size: 5
      }, {
        seriesIndex: 2,
        dataPointIndex: 11,
        fillColor: '#000',
        strokeColor: '#000',
        size: 4
      }]
    },
    subtitle: {
      text: '250',
      align: 'left',
      margin: 0,
      offsetX: 95,
      offsetY: 0,
      floating: false,
      style: {
        fontSize: '18px',
        color: '#4361ee'
      }
    },
    title: {
      text: 'Total Tests',
      align: 'left',
      margin: 0,
      offsetX: -10,
      offsetY: 0,
      floating: false,
      style: {
        fontSize: '18px',
        color: '#0e1726'
      },
    },
    stroke: {
      show: true,
      curve: 'smooth',
      width: 2,
      lineCap: 'square'
    },
    series: [{
      name: 'Answers',
      data: [16, 16, 15, 17, 15, 17, 19, 16, 10, 17, 14, 17]
    }, {
      name: 'Assist',
      data: [16, 17, 16, 17, 16, 19, 16, 17, 16, 19, 10, 19]
    }, {
      name: 'Butterfly',
      data: [15, 16, 17, 18, 23, 14, 13, 12, 10, 20, 24, 12]
    }, {
      name: 'Conversation',
      data: [10, 12, 19, 7, 6, 9, 16, 20, 13, 11, 10, 9]
    }, {
      name: 'Messaging',
      data: [6, 7, 6, 7, 6, 9, 6, 7, 16, 23, 18, 20]
    }, {
      name: 'Voice',
      data: [4, 8, 10, 12, 16, 9, 15, 11, 7, 21, 10, 9]
    }],
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    xaxis: {
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      },
      crosshairs: {
        show: true
      },
      labels: {
        offsetX: 0,
        offsetY: 5,
        style: {
          fontSize: '12px',
          fontFamily: 'Quicksand, sans-serif',
          cssClass: 'apexcharts-xaxis-title',
        },
      }
    },
    yaxis: {
      labels: {
        formatter: function (value, index) {
          //return (value / 1000) + 'K'
          return value
        },
        offsetX: -22,
        offsetY: 0,
        style: {
          fontSize: '12px',
          fontFamily: 'Quicksand, sans-serif',
          cssClass: 'apexcharts-yaxis-title',
        },
      }
    },
    grid: {
      borderColor: '#e0e6ed',
      strokeDashArray: 5,
      xaxis: {
        lines: {
          show: true
        }
      },
      yaxis: {
        lines: {
          show: false,
        }
      },
      padding: {
        top: 0,
        right: 0,
        bottom: 0,
        left: -10
      },
    },
    legend: {
      position: 'top',
      horizontalAlign: 'right',
      offsetY: -50,
      fontSize: '16px',
      fontFamily: 'Quicksand, sans-serif',
      markers: {
        width: 10,
        height: 10,
        strokeWidth: 0,
        strokeColor: '#fff',
        fillColors: undefined,
        radius: 12,
        onClick: undefined,
        offsetX: 0,
        offsetY: 0
      },
      itemMargin: {
        horizontal: 0,
        vertical: 20
      }
    },
    tooltip: {
      theme: 'dark',
      marker: {
        show: true,
      },
      x: {
        show: false,
      }
    },
    fill: {
      type: "gradient",
      gradient: {
        type: "vertical",
        shadeIntensity: 1,
        inverseColors: !1,
        opacityFrom: .28,
        opacityTo: .05,
        stops: [45, 100]
      }
    },
    responsive: [{
      breakpoint: 575,
      options: {
        legend: {
          offsetY: -30,
        },
      },
    }]
  }

  /*
      ==================================
          Sales By Category | Options
      ==================================
  */
  var options = {
    chart: {
      type: 'donut',
      width: 380
    },
    colors: ['#2196f3', '#e2a03f', '#8738a7'],
    dataLabels: {
      enabled: false
    },
    legend: {
      position: 'bottom',
      horizontalAlign: 'center',
      fontSize: '14px',
      markers: {
        width: 10,
        height: 10,
      },
      itemMargin: {
        horizontal: 0,
        vertical: 8
      }
    },
    plotOptions: {
      pie: {
        donut: {
          size: '65%',
          background: 'transparent',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '29px',
              fontFamily: 'Nunito, sans-serif',
              color: undefined,
              offsetY: -10
            },
            value: {
              show: true,
              fontSize: '26px',
              fontFamily: 'Nunito, sans-serif',
              color: '20',
              offsetY: 16,
              formatter: function (val) {
                return val
              }
            },
            total: {
              show: true,
              showAlways: true,
              label: 'Total',
              color: '#888ea8',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce(function (a, b) {
                  return a + b
                }, 0)
              }
            }
          }
        }
      }
    },
    stroke: {
      show: true,
      width: 25,
    },
    series: [985, 737, 270],
    labels: ['Adhoc', 'Release', 'Feature'],
    responsive: [{
      breakpoint: 1599,
      options: {
        chart: {
          width: '350px',
          height: '400px'
        },
        legend: {
          position: 'bottom'
        }
      },

      breakpoint: 1439,
      options: {
        chart: {
          width: '250px',
          height: '390px'
        },
        legend: {
          position: 'bottom'
        },
        plotOptions: {
          pie: {
            donut: {
              size: '65%',
            }
          }
        }
      },
    }]
  }


  /*
      ==============================
      |    @Render Charts Script    |
      ==============================
  */


  /*
      ============================
          Daily Sales | Render
      ============================
  */
  var d_2C_1 = new ApexCharts(document.querySelector("#daily-sales"), d_2options1);
  d_2C_1.render();

  /*
      ============================
          Total Orders | Render
      ============================
  */
  var d_2C_2 = new ApexCharts(document.querySelector("#total-orders"), d_2options2);
  d_2C_2.render();

  /*
      ================================
          Revenue Monthly | Render
      ================================
  */
  var chart1 = new ApexCharts(
    document.querySelector("#revenueMonthly"),
    options1
  );

  chart1.render();

  /*
      =================================
          Sales By Category | Render
      =================================
  */
  var chart = new ApexCharts(
    document.querySelector("#chart-2"),
    options
  );

  chart.render();


  /*
      =============================================
          Perfect Scrollbar | Recent Activities
      =============================================
  */
  // const ps = new PerfectScrollbar(document.querySelector('.mt-container'));
  $('.mt-container').each(function () { const ps = new PerfectScrollbar($(this)[0]); });


} catch (e) {
  console.log(e);
}