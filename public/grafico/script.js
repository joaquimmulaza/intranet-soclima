
( function ( $ ) {

    var charts = {
        init: function () {
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.ddefaultFontColor = '#292b2c';

            this.ajaxGetPostMonthlyData();

        },

        ajaxGetPostMonthlyData: function () {
            var request = $.ajax( {
                method: 'GET',
                url: urlGrafic
            } );

            request.done( function ( response ) {
                charts.createCompletedJobsChart( response );
            });
        },

        createCompletedJobsChart: function ( response ) {

            var ctx = document.getElementById("myAreaChart");

            var ctx2 = document.getElementById("myCharts");
            var ctx3 = document.getElementById("myChartsCargos");
            var ctx4 = document.getElementById("myChartsUnidades");
            var ctx5 = document.getElementById("myChartsLikesDate");

            /*Notícias por mês x likes: response[0]*/
            var myLineChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: response[0].months,
                    datasets: [{
                        label: "Notícias",
                        lineTension: 0.3,
                        backgroundColor: "rgba(190,167,100,0.8)",
                        borderColor: "rgba(2,117,216,1)",
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(2,117,216,1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(112,117,216,1)",
                        pointHitRadius: 20,
                        pointBorderWidth: 2,
                        data: response[0].post_count_data
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: false
                            },
                            ticks: {
                                maxTicksLimit: 26,
                                fontSize: 10,
                                fontFamily: 'Arial',
                                fontColor: "#4a14Bc"
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                color: "rgba(0, 0, 0, .125)"
                            },
                            ticks: {
                                fontSize: 10,
                                fontColor: "#4a14Bc",
                                min: 0,
                                max: 5,
                                maxTicksLimit: 7,
                                callback: function(value, index, values){
                                    return value;
                                }
                            }
                        }]
                    },
                    tooltips:{
                        mode: 'index',
                        callback: {
                            label: function(tooltipItem, data){
                                return data.datasets[tooltipItem.datasetIndex].label + " : R$ " + data.datasets[tooltipItem.dataserIndex].data[tooltipItem.index]
                            }
                        }
                    },
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        text: 'Notícias criadas por mês',
                        fontSize: 10,
                        fontColor: "#4a14Bc"
                    },
                    hover: {
                        animationDuration: 100,
                        hoverBackgroundColor: "rgba(55,255,55,0.9)"
                    }
                }
            });

            /*Total de likes por data: response[4]*/
            var chart = new Chart(ctx5, {
                type: 'bar',
                data: {
                    labels: response[4].data,
                    datasets: [{
                        label: "Likes",
                        lineTension: 0.5,
                        backgroundColor: "rgba(200,100,216,0.5)",
                        borderColor: "rgba(2,117,216,1)",
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(2,117,216,1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(112,117,216,1)",
                        pointHitRadius: 20,
                        pointBorderWidth: 2,
                        data: response[4].total
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: true
                            },
                            ticks: {
                                maxTicksLimit: 26
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: response[4].max,
                                maxTicksLimit: 7
                            },
                            gridLines: {
                                color: "rgba(110, 110, 0, .125)"
                            }
                        }]
                    },
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        text: 'Likes por mês',
                        fontSize: 10,
                        fontColor: "#4a14Bc"
                    },
                    hover: {
                        animationDuration: 100,
                        hoverBackgroundColor: "rgba(55,255,55,0.9)"
                    }
                }
            });

            /*Notícias criada por usuário: response[1]*/
            var chart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: response[1].usuario,
                    datasets: [{
                        label: "Notícias por usuário",
                        lineTension: 0.5,
                        backgroundColor: "rgba(150,150,190,0.9)",
                        borderColor: "rgba(2,117,216,1)",
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(2,117,216,1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(112,117,216,1)",
                        pointHitRadius: 20,
                        pointBorderWidth: 2,
                        data: response[1].posts
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: false
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                maxTicksLimit: 7
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, .125)"
                            }
                        }]
                    },
                    legend: {
                        display: false
                    },
                    title: {
                        display: false,
                        text: 'Notícias criada por usuário',
                        fontSize: 20,
                        fontColor: "#4a14Bc"
                    },
                    hover: {
                        animationDuration: 100,
                        hoverBackgroundColor: "rgba(55,255,55,0.9)"
                    }
                }
            });

            /*Total de usuários por cargo: response[2]*/
            var chart = new Chart(ctx3, {
                type: 'pie',
                data: {
                    labels: response[2].cargos,
                    datasets: [{
                        label: "Total de usuários por cargo",
                        lineTension: 0.5,
                        backgroundColor: "rgba(150,190,45,0.9)",
                        borderColor: "rgba(2,117,216,1)",
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(2,117,216,1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(112,117,216,1)",
                        pointHitRadius: 20,
                        pointBorderWidth: 2,
                        data: response[2].users
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: true
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                maxTicksLimit: 7
                            },
                            gridLines: {
                                color: "rgba(110, 110, 0, .125)"
                            }
                        }]
                    },
                    legend: {
                        display: true
                    },
                    title: {
                        display: false,
                        text: 'Total de usuários por cargo',
                        fontSize: 20,
                        fontColor: "#4a14Bc"
                    },
                    hover: {
                        animationDuration: 100,
                        hoverBackgroundColor: "rgba(55,255,55,0.9)"
                    }
                }
            });

            /*Total de usuários por unidade: response[3]*/
            var chart = new Chart(ctx4, {
                type: 'bar',
                data: {
                    labels: response[3].unidades,
                    datasets: [{
                        label: "usuários e cargo",
                        lineTension: 0.5,
                        backgroundColor: "rgba(140,50,156,1)",
                        borderColor: "rgba(2,117,216,1)",
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(2,117,216,1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(112,117,216,1)",
                        pointHitRadius: 20,
                        pointBorderWidth: 2,
                        data: response[3].users
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: true
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                maxTicksLimit: 7
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, .125)"
                            }
                        }]
                    },
                    legend: {
                        display: true
                    },
                    title: {
                        display: false,
                        text: response[3].unidades,
                        fontSize: 20,
                        fontColor: "#4a14Bc"
                    },
                    hover: {
                        animationDuration: 300,
                        hoverBackgroundColor: "rgba(55,255,55,0.9)"
                    }
                }
            });
        }
    };

    charts.init();

} )( jQuery );
