window.onload = function() {getTotal()};

var model = $('#model').val();
var insertion_ctx = document.getElementById('insertionChart').getContext('2d');
var insertion_chart = new Chart(insertion_ctx, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [
            {
                label: "MongoDB",
                backgroundColor: '#4BC0C0',
                data: [],
            },
            {
                label: "MySQL",
                backgroundColor: '#FF9F40',
                data: [],
            }
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

var update_ctx = document.getElementById('updateChart').getContext('2d');
var update_chart = new Chart(update_ctx, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [
            {
                label: "MongoDB",
                backgroundColor: '#4BC0C0',
                data: [],
            },
            {
                label: "MySQL",
                backgroundColor: '#FF9F40',
                data: [],
            }
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

var reading_ctx = document.getElementById('readingChart').getContext('2d');
var reading_chart = new Chart(reading_ctx, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [
            {
                label: "MongoDB",
                backgroundColor: '#4BC0C0',
                data: [],
            },
            {
                label: "MySQL",
                backgroundColor: '#FF9F40',
                data: [],
            }
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

var deleting_ctx = document.getElementById('deletingChart').getContext('2d');
var deleting_chart = new Chart(deleting_ctx, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [
            {
                label: "MongoDB",
                backgroundColor: '#4BC0C0',
                data: [],
            },
            {
                label: "MySQL",
                backgroundColor: '#FF9F40',
                data: [],
            }
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

var datasets = ['insertion', 'update', 'reading', 'deleting'];

function addAllDatasets(qty) {
    datasets.forEach(function (dataset) {
        addDataset(qty, false, dataset);
    });
}

function removeAllDatasets() {
    datasets.forEach(function (dataset) {
        removeData(dataset);
    });
}

function getTotal() {
    var param = '?model=' + model
    $.ajax({
        url: 'api/getTotal' + param,
        type: 'GET',
        success: function (response) {
            $(".total_records").html(response);
            $("#reading .qty").attr('max', response);
            $("#update .qty").attr('max', response);
            $("#deleting .qty").attr('max', response);
        }
    });
}

function addDataset(qty, random_data, id) {

    console.log('Adding ' + model + ' ' + id + ' dataset.');

    var type;
    var parameter = '';
    switch (id) {
        case 'insertion':
            type = 'post';
            break;
        case 'update':
            type = 'put';
            parameter = '/1';
            break;
        case 'reading':
            type = 'get';
            break;
        case 'deleting':
            type = 'delete';
            parameter = '/1';
            break;
        default:
            type = 'get';
    }

    var max = $("#reading .qty").attr('max');
    if ((parseInt(qty) > parseInt(max)) && id !== 'insertion'){
        $("#" + id + " .qty").val(max);
        alert('El máximo permitido es de ' + max)
        qty = parseInt(max)
    }

    var data = {
        "qty": qty,
        "random_data": random_data
    };

    $.ajax({
        data: data,
        url: 'api/' + model + parameter,
        type: type,
        beforeSend: function () {
            $("#" + id + " .result").html("Procesando, espere por favor...");
        },
        success: function (response) {
            $("#" + id + " .result").html("");
            var mongo_time = response.mongo.time;
            var mysql_time = response.mysql.time;
            var qty = response.data;
            var chart_name = window[id + '_chart'];
            $(".total_records").html(response.total);
            $("#" + id + " #accordion_mysql_query_" + id + " .query").html(response.mysql.query);
            $("#reading .qty").attr('max', response.total);
            $("#update .qty").attr('max', response.total);
            $("#deleting .qty").attr('max', response.total);
            addData(chart_name, qty, [mongo_time, mysql_time])
        }
    });
}

function addData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach(function (dataset, key, mapObj) {
        dataset.data.push(data[key]);
    });
    chart.update();
}

function removeData(id) {
    console.log('Removing last ' + model + ' ' + id + ' dataset.');
    var chart = window[id + '_chart'];
    chart.data.labels.pop();
    chart.data.datasets.forEach(function (dataset) {
        dataset.data.pop();
    });
    chart.update();
}
