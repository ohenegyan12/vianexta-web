 {{-- FARMER SECTION --}}
    <section class="py-5 ">
        <div class="container px-2 px-lg-3 ">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <h1 class="display-6 fw-bolder text-primary text-center  py-5">Sensory Stats </h1>
                
                @php 
                    for($i=1;$i<6;$i++){
                @endphp
                <div class="col mb-md-5 pt-3 pt-md-1" id="chart{{$i}}"></div>
                @php }@endphp
                <div class="row">
                    @php 
                        for($i=6;$i<11;$i++){
                    @endphp
                    <div class="col mb-md-5 pt-3 pt-md-1" id="chart{{$i}}"></div>
                    @php }@endphp
                </div>
            </div>
        </div>
    </section>

@section('scripts')
    <script>
        var c1 = {
            series: [65],
            chart: {
                height: 200,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '65%',
                    },

                    fill: {
                        colors: ['#000000'],
                        type: 'solid',

                    },
                    dataLabels: {

                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '20px',
                            fontWeight: 'bold',
                        },
                        total: {
                            show: true,
                            label: 'Aroma',

                        }
                    }
                }
            },
            colors: ['#FCEFE3']


        };

        var c2 = {
            series: [65],
            chart: {
                height: 200,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '65%',
                    },

                    fill: {
                        colors: ['#000000'],
                        type: 'solid',

                    },
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '20px',
                            fontWeight: 'bold',
                        },
                        total: {
                            show: true,
                            label: 'Flavor',

                        }
                    }
                }
            },
            colors: ['#FCEFE3']
        };

        var c3 = {
            series: [100],
            chart: {
                height: 200,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '65%',
                    },

                    fill: {
                        colors: ['#000000'],
                        type: 'solid',

                    },
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '20px',
                            fontWeight: 'bold',
                        },
                        total: {
                            show: true,
                            label: 'Clean cup',

                        }
                    }
                }
            },

            colors: ['#000000']
        };

        var c4 = {
            series: [100],
            chart: {
                height: 200,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '65%',
                    },

                    fill: {
                        colors: ['#000000'],
                        type: 'solid',

                    },
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '20px',
                            fontWeight: 'bold',
                        },
                        total: {
                            show: true,
                            label: 'After taste',

                        }
                    }
                }
            },
            colors: ['#000000']
        };

        var c5 = {
            series: [65],
            chart: {
                height: 200,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '65%',
                    },

                    fill: {
                        colors: ['#000000'],
                        type: 'solid',

                    },
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '20px',
                            fontWeight: 'bold',
                        },
                        total: {
                            show: true,
                            label: 'Acid',

                        }
                    }
                }
            },

            colors: ['#D8501C']
        };

        var c6 = {
            series: [65],
            chart: {
                height: 200,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '65%',
                    },

                    fill: {
                        colors: ['#000000'],
                        type: 'solid',

                    },
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '20px',
                            fontWeight: 'bold',
                        },
                        total: {
                            show: true,
                            label: 'Uniformity',

                        }
                    }
                }
            },

            colors: ['#D8501C']
        };

        var c7 = {
            series: [65],
            chart: {
                height: 200,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '65%',
                    },

                    fill: {
                        colors: ['#000000'],
                        type: 'solid',

                    },
                    dataLabels: {
                        name: {

                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '20px',
                            fontWeight: 'bold',
                        },
                        total: {
                            show: true,
                            label: 'Body',

                        }
                    }
                }
            },

            colors: ['#D8501C']
        };

        var c8 = {
            series: [100],
            chart: {
                height: 200,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '65%',
                    },

                    fill: {
                        colors: ['#000000'],
                        type: 'solid',

                    },
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '20px',
                            fontWeight: 'bold',
                        },
                        total: {
                            show: true,
                            label: 'Taster point',

                        }
                    }
                }
            },

            colors: ['#000000']
        };

        var c9 = {
            series: [65],
            chart: {
                height: 200,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '65%',
                    },

                    fill: {
                        colors: ['#000000'],
                        type: 'solid',

                    },
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '20px',
                            fontWeight: 'bold',
                        },
                        total: {
                            show: true,
                            label: 'Sweetness',

                        }
                    }
                }
            },
            colors: ['#D8501C']
        };

        var c10 = {
            series: [100],
            chart: {
                height: 200,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '65%',
                    },

                    fill: {
                        colors: ['#000000'],
                        type: 'solid',

                    },
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '20px',
                            fontWeight: 'bold',
                        },
                        total: {
                            show: true,
                            label: 'Fermentation',

                        }
                    }
                }
            },
            colors: ['#000000']
        };


        var chart1 = new ApexCharts(document.querySelector("#chart1"), c1);
        chart1.render();

        var chart2 = new ApexCharts(document.querySelector("#chart2"), c2);
        chart2.render();

        var chart3 = new ApexCharts(document.querySelector("#chart3"), c3);
        chart3.render();
        var chart4 = new ApexCharts(document.querySelector("#chart4"), c4);
        chart4.render();
        var chart5 = new ApexCharts(document.querySelector("#chart5"), c5);
        chart5.render();
        var chart6 = new ApexCharts(document.querySelector("#chart6"), c6);
        chart6.render();
        var chart7 = new ApexCharts(document.querySelector("#chart7"), c7);
        chart7.render();
        var chart8 = new ApexCharts(document.querySelector("#chart8"), c8);
        chart8.render();
        var chart9 = new ApexCharts(document.querySelector("#chart9"), c9);
        chart9.render();
        var chart10 = new ApexCharts(document.querySelector("#chart10"), c10);
        chart10.render();
    </script>
@endsection
