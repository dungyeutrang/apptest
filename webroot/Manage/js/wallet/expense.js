  function donut(data) {
        if ($("#donutchart").length)
        {
            $.plot($("#donutchart"), data,
                    {
                        series: {
                            pie: {
                                innerRadius: 0.5,
                                show: true
                            }
                        },
                        legend: {
                            show: false
                        }
                    });
        }
    }