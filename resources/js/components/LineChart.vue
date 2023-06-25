<script>
import { Line } from 'vue-chartjs'
export default {
    extends: Line,
    props:['chartData'],
    data () {
        return {
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                    xAxes: [ {
                        gridLines: {
                            display: false
                        }
                    }]
                },
                legend: {
                    display: true
                },
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    mounted () {
        Fire.$on('render-chart', ()=>{
            this.renderChart(this.chartData, this.options)
        })
    },
    created() {

    }
}
</script>
