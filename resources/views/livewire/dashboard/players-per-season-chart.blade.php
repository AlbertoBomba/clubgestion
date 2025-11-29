<div class="card-modern bg-white-pure rounded-2xl shadow-xl p-6 border border-primary/10">
    <div class="mb-4">
        <h3 class="text-lg font-bold text-black-deep mb-1">Jugadores por Temporada</h3>
        <p class="text-sm text-titanium">Distribución de jugadores inscritos en cada temporada</p>
    </div>
    <div class="relative" style="height: 300px;">
        <canvas id="playersPerSeasonChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    const renderChart = function() {
        const ctx = document.getElementById('playersPerSeasonChart');
        if (!ctx) {
            console.error('Canvas not found');
            return;
        }
        
        if (typeof Chart === 'undefined') {
            console.error('Chart.js not loaded');
            setTimeout(renderChart, 100);
            return;
        }
        
        const chartData = @json($chartData);
        console.log('Chart Data:', chartData);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Número de Jugadores',
                    data: chartData.data,
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' jugador' + (context.parsed.y !== 1 ? 'es' : '');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 50,
                            font: {
                                size: 12
                            },
                            color: '#6B7280'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            },
                            color: '#374151'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    };
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', renderChart);
    } else {
        renderChart();
    }
})();
</script>
