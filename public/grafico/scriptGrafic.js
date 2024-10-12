
( function ( $ ) {

    var charts = {
        init: function () {
            this.ajaxGetPostMonthlyData();
        },

        ajaxGetPostMonthlyData: function () {
            var request = $.ajax( {
                method: 'GET',
                url: urlGrafic2
            } );

            request.done( function ( response ) {
                console.log( response );
                charts.createCompletedJobsChart( response );
            });
        },

        createCompletedJobsChart: function ( response ) {

            var ctx = document.getElementById("myCharts2");



            var test = ['janeiro','fevereiro','março'];
            var test2 = [10,9,5];
            var titlo = [];
            var num = [];

            for(var i=0; i < 3; i++){
                titlo.push(test[i]);
                num.push(test2[i]);
            }

            console.log(titlo,num);


            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: titlo,
                    datasets: [{
                        label: "Notícias por usuário",
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
                        data: num
                    },
                        {
                        label: "Notícias por usuário",
                        lineTension: 0.5,
                        backgroundColor: "rgba(100,50,216,0.9)",
                        borderColor: "rgba(2,117,216,1)",
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(2,117,216,1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(112,117,216,1)",
                        pointHitRadius: 20,
                        pointBorderWidth: 2,
                        data: num
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
                                fontSize: 20,
                                fontColor: "#4a14Bc",
                                maxTicksLimit: 7,
                                callback: function(value, index, values){
                                    return 'Mês ' + value;
                                }
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                fontSize: 15,
                                fontColor: "#4a14Bc",
                                min: 0,
                                max: 10,
                                maxTicksLimit: 7,
                                callback: function(value, index, values){
                                    return 'R$ ' + value;
                                }
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, .125)"
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
                        display: false
                    },
                    title: {
                        display: true,
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
        }
    };

    charts.init();

} )( jQuery );
