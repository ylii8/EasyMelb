<!DOCTYPE html>
<html lang="en">

<head>
    <script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="http://dimplejs.org/dist/dimple.v2.0.0.min.js"></script>
</head>

<body>

    <div style="width:1000px;margin:0 auto;">
        <div>

            <script type="text/javascript">
                var chartsyearid = new Array("chartContainerMon","chartContainerTue","chartContainerWed",
                    "chartContainerThu","chartContainerFri","chartContainerSat","chartContainerSun");
                // choose different year
                function selectchangeyear(e) {
                    // alert(e)
                    for(j = 0; j < chartsyearid.length; j++) {
                        try{
                            // document.getElementById(e).style.display="none";
                            if (chartsyearid[j]==e)
                            //document.getElementById(chartsyearid[j]).style.display="block";
                                document.getElementById(chartsyearid[j]).style.height="auto";
                            else
                            //document.getElementById(chartsyearid[j]).style.display="none";
                                document.getElementById(chartsyearid[j]).style.height="0";
                        }catch(err){
                            // alert(err);
                        }
                    }
                }
            </script>

            <select onchange="selectchangeyear(this.value)">
                <option value="chartContainerMon" selected="selected">Monday</option>
                <option value="chartContainerTue">Tuesday</option>
                <option value="chartContainerWed">Wednesday</option>
                <option value="chartContainerThu">Thursday</option>
                <option value="chartContainerFri">Friday</option>
                <option value="chartContainerSat">Saturday</option>
                <option value="chartContainerSun">Sunday</option>
            </select>

        </div>

        <div id="chartContainerMon" style="overflow: hidden;">
            <script type="text/javascript">
                var svgMon = dimple.newSvg("#chartContainerMon", 1000, 1000);
                d3.csv("group.csv", function (data) {

                    // Filter for Monday
                    data = dimple.filterData(data, "Day", [
                        "Monday"
                    ]);

                    // Filter for Sensor_ID
                    data = dimple.filterData(data, "Sensor_ID", [
                        "1"
                    ]);

                    var myChart = new dimple.chart(svgMon, data);
                    myChart.setBounds(60, 30, 510, 305)
                    var x = myChart.addCategoryAxis("x", "Time");
                    x.addOrderRule("Time");
                    myChart.addMeasureAxis("y", "Hourly_Counts");
                    myChart.addSeries(null, dimple.plot.bar);
                    myChart.draw();
                });
            </script>
        </div>

        <div id="chartContainerTue" style="overflow: hidden;">
            <script type="text/javascript">
                var svgTue = dimple.newSvg("#chartContainerTue", 1000, 1000);
                d3.csv("group.csv", function (data) {

                    // Filter for Monday
                    data = dimple.filterData(data, "Day", [
                        "Tuesday"
                    ]);

                    // Filter for Sensor_ID
                    data = dimple.filterData(data, "Sensor_ID", [
                        "1"
                    ]);

                    var myChart = new dimple.chart(svgTue, data);
                    myChart.setBounds(60, 30, 510, 305)
                    var x = myChart.addCategoryAxis("x", "Time");
                    x.addOrderRule("Time");
                    myChart.addMeasureAxis("y", "Hourly_Counts");
                    myChart.addSeries(null, dimple.plot.bar);
                    myChart.draw();
                });
            </script>
        </div>

        <div id="chartContainerWed" style="overflow: hidden;">
            <script type="text/javascript">
                var svgWed = dimple.newSvg("#chartContainerWed", 1000, 1000);
                d3.csv("group.csv", function (data) {

                    // Filter for Monday
                    data = dimple.filterData(data, "Day", [
                        "Wednesday"
                    ]);

                    // Filter for Sensor_ID
                    data = dimple.filterData(data, "Sensor_ID", [
                        "1"
                    ]);

                    var myChart = new dimple.chart(svgWed, data);
                    myChart.setBounds(60, 30, 510, 305)
                    var x = myChart.addCategoryAxis("x", "Time");
                    x.addOrderRule("Time");
                    myChart.addMeasureAxis("y", "Hourly_Counts");
                    myChart.addSeries(null, dimple.plot.bar);
                    myChart.draw();
                });
            </script>
        </div>

        <div id="chartContainerThu" style="overflow: hidden;">
            <script type="text/javascript">
                var svgThu = dimple.newSvg("#chartContainerThu", 1000, 1000);
                d3.csv("group.csv", function (data) {

                    // Filter for Monday
                    data = dimple.filterData(data, "Day", [
                        "Thursday"
                    ]);

                    // Filter for Sensor_ID
                    data = dimple.filterData(data, "Sensor_ID", [
                        "1"
                    ]);

                    var myChart = new dimple.chart(svgThu, data);
                    myChart.setBounds(60, 30, 510, 305)
                    var x = myChart.addCategoryAxis("x", "Time");
                    x.addOrderRule("Time");
                    myChart.addMeasureAxis("y", "Hourly_Counts");
                    myChart.addSeries(null, dimple.plot.bar);
                    myChart.draw();
                });
            </script>
        </div>

        <div id="chartContainerFri" style="overflow: hidden;">
            <script type="text/javascript">
                var svgFri = dimple.newSvg("#chartContainerFri", 1000, 1000);
                d3.csv("group.csv", function (data) {

                    // Filter for Monday
                    data = dimple.filterData(data, "Day", [
                        "Friday"
                    ]);

                    // Filter for Sensor_ID
                    data = dimple.filterData(data, "Sensor_ID", [
                        "1"
                    ]);

                    var myChart = new dimple.chart(svgFri, data);
                    myChart.setBounds(60, 30, 510, 305)
                    var x = myChart.addCategoryAxis("x", "Time");
                    x.addOrderRule("Time");
                    myChart.addMeasureAxis("y", "Hourly_Counts");
                    myChart.addSeries(null, dimple.plot.bar);
                    myChart.draw();
                });
            </script>
        </div>

        <div id="chartContainerSat" style="overflow: hidden;">
            <script type="text/javascript">
                var svgSat = dimple.newSvg("#chartContainerSat", 1000, 1000);
                d3.csv("group.csv", function (data) {

                    // Filter for Monday
                    data = dimple.filterData(data, "Day", [
                        "Saturday"
                    ]);

                    // Filter for Sensor_ID
                    data = dimple.filterData(data, "Sensor_ID", [
                        "1"
                    ]);

                    var myChart = new dimple.chart(svgSat, data);
                    myChart.setBounds(60, 30, 510, 305)
                    var x = myChart.addCategoryAxis("x", "Time");
                    x.addOrderRule("Time");
                    myChart.addMeasureAxis("y", "Hourly_Counts");
                    myChart.addSeries(null, dimple.plot.bar);
                    myChart.draw();
                });
            </script>
        </div>

        <div id="chartContainerSun" style="overflow: hidden;">
            <script type="text/javascript">
                var svgSun = dimple.newSvg("#chartContainerSun", 1000, 1000);
                d3.csv("group.csv", function (data) {

                    // Filter for Monday
                    data = dimple.filterData(data, "Day", [
                        "Sunday"
                    ]);

                    // Filter for Sensor_ID
                    data = dimple.filterData(data, "Sensor_ID", [
                        "1"
                    ]);

                    var myChart = new dimple.chart(svgSun, data);
                    myChart.setBounds(60, 30, 510, 305)
                    var x = myChart.addCategoryAxis("x", "Time");
                    x.addOrderRule("Time");
                    myChart.addMeasureAxis("y", "Hourly_Counts");
                    myChart.addSeries(null, dimple.plot.bar);
                    myChart.draw();
                });
            </script>
        </div>
    </div>

</body>




</html>