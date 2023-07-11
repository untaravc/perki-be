<template>
    <LineChart :chart-data="chartData" :height="300"></LineChart>
</template>
<script>
import LineChart from '../../components/LineChart'

export default {
    components: {LineChart},
    data() {
        return {
            chartData: {
                labels: [],
                datasets: [
                    {
                        label: 'Pendaftar',
                        data: [],
                        fill: false,
                        borderColor: '#2554FF',
                        backgroundColor: '#2554FF',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengunjung',
                        data: [],
                        fill: false,
                        borderColor: '#a9a9a9',
                        backgroundColor: '#a9a9a9',
                        borderWidth: 1
                    }
                ]
            },
        }
    },
    methods: {
        loadChart() {
            this.authGet('adm/dashboard-chart')
                .then((data) => {
                    this.chartData.labels = [];

                    let ln = Object.keys(data.result).length;
                    for (let i = 1; i <= ln; i++) {
                        let date = data.result[i].date
                        let count = data.result[i].count
                        let visitor = data.result[i].visitor ?? 0
                        this.chartData.labels.push(date.slice(-2))

                        this.chartData.datasets[0].data.push(count)
                        this.chartData.datasets[1].data.push(visitor)
                    }

                    Fire.$emit('render-chart')
                })
        },
    },
    mounted() {
        this.loadChart()
    },
    created() {

    }
}
</script>
