// daily sales

const ctx = document.getElementById('Sales').getContext('2d');
const myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['03-21', '03-22', '03-23', '03-24', '03-25', '03-26', '03-27'],
    datasets: [{
      label: 'Daily Sales',
      data: [300, 500, 400, 600, 700, 800, 900],
      borderWidth: 3,
      borderColor: '#009192',
      backgroundColor: 'rgba(0, 145, 146, 0.1)',
      fill: true,
      tension: 0.4
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: function(value) {
            return '₱' + value.toLocaleString();
          }
        }
      }
    },
    plugins: {
      tooltip: {
        callbacks: {
          label: function(context) {
            const label = context.dataset.label || '';
            const value = context.raw;
            return `${label}: ₱${value.toLocaleString()}`;
          }
        }
      }
    }
  }
});

// monthly sales

const ctx2 = document.getElementById('monthlySales').getContext('2d');
const monthlySalesChart = new Chart(ctx2, {
    type: 'bar',
    data: {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    datasets: [{
        label: 'Monthly Sales',
        data: [12000, 15000, 13000, 17000, 16000, 19000, 21000, 18000, 20000, 22000, 23000, 25000],
        backgroundColor: 'rgba(0, 145, 146, 0.6)',
        borderColor: '#009192',
        borderWidth: 2
    }]
    },
    options: {
    responsive: true,
    scales: {
        y: {
        beginAtZero: true,
        ticks: {
            callback: function(value) {
            return '₱' + value.toLocaleString();
            }
        }
        }
    },
    plugins: {
        tooltip: {
        callbacks: {
            label: function(context) {
            const label = context.dataset.label || '';
            const value = context.raw;
            return `${label}: ₱${value.toLocaleString()}`;
            }
        }
        }
    }
    }
});