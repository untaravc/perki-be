<script>
import { Pie } from 'vue-chartjs'
export default {
    extends: Pie,
    props:['chartData'],
    data () {
        return {
            options: {
                legend: {
                    display: true
                },
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    mounted () {
        Fire.$on('render-chart-pie', ()=>{
            this.renderChart(this.chartData, this.options)
        })
    }
}
</script>
