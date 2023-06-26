<script>
import { Bar } from 'vue-chartjs'
export default {
    extends: Bar,
    props:['chartData'],
    data () {
        return {
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    mounted () {
        Fire.$on('render-chart-bar', ()=>{
            this.renderChart(this.chartData, this.options)
        })
    }
}
</script>
