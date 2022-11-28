function renderChart(x, y) {
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: y,
            datasets: [{
                label: 'x',
                data: x,
            }]
        },
    });
}

$("#renderBtn").click(
    function () {
        renderChart(x, y);
    }
);