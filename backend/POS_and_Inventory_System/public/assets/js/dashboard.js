// daily sales

const ctx = document.getElementById('Sales').getContext('2d');
const myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: typeof dailyLabels !== 'undefined' ? dailyLabels : [],
    datasets: [{
      label: 'Daily Sales',
      data: typeof dailySales !== 'undefined' ? dailySales : [],
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
        labels: typeof monthlyLabels !== 'undefined' ? monthlyLabels : [],
        datasets: [{
            label: 'Monthly Sales',
            data: typeof monthlySales !== 'undefined' ? monthlySales : [],
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