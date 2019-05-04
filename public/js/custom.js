am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart3D);

// Add data
chart.data = [{
  "year": 2005,
  "income": 23.5,
  "color": chart.colors.next()
}, {
  "year": 2006,
  "income": 26.2,
  "color": chart.colors.next()
}, {
  "year": 2007,
  "income": 30.1,
  "color": chart.colors.next()
}, {
  "year": 2008,
  "income": 29.5,
  "color": chart.colors.next()
}, {
  "year": 2009,
  "income": 24.6,
  "color": chart.colors.next()
}];

// Create axes
var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "year";
categoryAxis.numberFormatter.numberFormat = "#";
categoryAxis.renderer.inversed = true;

var  valueAxis = chart.xAxes.push(new am4charts.ValueAxis()); 

// Create series
var series = chart.series.push(new am4charts.ColumnSeries3D());
series.dataFields.valueX = "income";
series.dataFields.categoryY = "year";
series.name = "Income";
series.columns.template.propertyFields.fill = "color";
series.columns.template.tooltipText = "{valueX}";
series.columns.template.column3D.stroke = am4core.color("#fff");
series.columns.template.column3D.strokeOpacity = 0.2;

}); // end am4core.ready()


$(document).ready(function(){
  $("input[type='radio']").on('click', function(event) {
    var validate = $("input[type='radio']:checked").val();
    console.info(validate);
    //event.preventDefault();

    $.ajax({
        url: "controller/usuario.php",
        type: "POST",
        data: {
            acc: 8,
            validate: validate
        },
        error: function (e) {
            alert("En desarrollo... " + e.responseText);
            console.info(e);
        },
        beforeSend: function () {
            //$("#btnGuardar").prop("disabled", true);
        },
        success: function (data) {
            eval(data);
            console.info(data);
            if (r.respuesta == "OK") {
                alertOk("Correcto", r.mensaje, function () {
                    $('#modalRecuperaClave').modal('hide');
                });
            } else {
                alertFail("Error", r.mensaje);
            }
            console.log("success");
            $("#section-2").text(r.response);
        }
    });
    
  });
});