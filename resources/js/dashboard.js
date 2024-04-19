import Chart from 'chart.js/auto';

const labels = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
];

const data = {
    labels: labels,
    datasets: [
        {
            label: 'My First dataset',
            backgroundColor: '#000',
            borderColor: 'rgb(255, 99, 132)',
            data: [5, 10, 5, 2, 20, 30, 30],
        },
        {
            label: 'My First dataset',
            backgroundColor: '#5ca1e4',
            borderColor: 'rgb(255, 99, 132)',
            data: [2, 5, 5, 2, 20, 30, 30],
        },
    ]
};

const config = {
    type: 'bar',
    data: data,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
};

const chart = new Chart(
    document.getElementById('myChart'),
    config
);