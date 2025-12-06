<!-- Chart code -->
<script>
  am5.ready(function() {

    // Create root element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root = am5.Root.new("purchaseChartdiv");


    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
      am5themes_Animated.new(root)
    ]);


    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root.container.children.push(am5xy.XYChart.new(root, {
      panX: true,
      panY: true,
      wheelX: "panX",
      wheelY: "zoomX",
      pinchZoomX: true
    }));

    // Add cursor
    // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
    cursor.lineY.set("visible", false);


    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var xRenderer = am5xy.AxisRendererX.new(root, {
      minGridDistance: 30
    });
    xRenderer.labels.template.setAll({
      rotation: -90,
      centerY: am5.p50,
      centerX: am5.p100,
      paddingRight: 15
    });

    xRenderer.grid.template.setAll({
      location: 1
    })

    var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
      maxDeviation: 0.3,
      categoryField: "date",
      renderer: xRenderer,
      tooltip: am5.Tooltip.new(root, {})
    }));

    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
      maxDeviation: 0.3,
      renderer: am5xy.AxisRendererY.new(root, {
        strokeOpacity: 0.1
      })
    }));

    // Format y-axis labels with dollar signs
    yAxis.get("renderer").labels.template.setAll({
      labelText: "$" + "{value}"
    });

    // Format y-axis tooltips
    yAxis.set("tooltip", am5.Tooltip.new(root, {
      labelText: "${value}"
    }));


    // Create series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
      name: "Series 1",
      xAxis: xAxis,
      yAxis: yAxis,
      valueYField: "totalPrice",
      sequencedInterpolation: true,
      categoryXField: "date",
      tooltip: am5.Tooltip.new(root, {
        labelText: "${valueY}"
      })
    }));

    series.columns.template.setAll({
      cornerRadiusTL: 5,
      cornerRadiusTR: 5,
      strokeOpacity: 0
    });
    series.set("fill", am5.color('#ffcab6'));
    // series.columns.template.adapters.add("fill", function(fill, target) {
    //   return chart.get("colors").getIndex(series.columns.indexOf(target));
    // });

    series.columns.template.adapters.add("stroke", function(stroke, target) {
      return chart.get("colors").getIndex(series.columns.indexOf(target));
    });


    // Set data
    var data = <?php echo json_encode($analytics_data); ?>;

    xAxis.data.setAll(data);
    series.data.setAll(data);


    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series.appear(1000);
    chart.appear(1000, 100);

    var exporting = am5plugins_exporting.Exporting.new(root, {
      menu: am5plugins_exporting.ExportingMenu.new(root, {}),
      htmlOptions: {
        disabled: true
      },
      dataSource: data
    });

  }); // end am5.ready()
</script>