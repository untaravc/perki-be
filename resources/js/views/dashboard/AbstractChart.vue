<template>
    <BarChart :chart-data="chartData" :height="250"></BarChart>
</template>
<script>
import BarChart from '../../components/BarChart'

export default {
    components: {BarChart},
    data() {
        return {
            chartData: {
                labels: ['asd','asd','q'],
                datasets: [
                    {
                        backgroundColor: [
                            '#16ddb9',
                            '#0945c7',
                            '#ab16dd',
                        ],
                        data: [1,2,3]
                    }
                ]
            },
        }
    },
    methods: {
        loadChart() {
            this.authGet('adm/dashboard-user-stat')
                .then((data) => {
                    this.chartData.labels = [];
                    this.chartData.datasets[0].data = [];

                    let ln = Object.keys(data.result.abstracts).length;
                    for (let i = 0; i < ln; i++) {
                        console.log(data.result.abstracts[i])
                        let label = data.result.abstracts[i].category
                        let total = data.result.abstracts[i].total
                        this.chartData.labels.push(label + " (" + total +")")

                        this.chartData.datasets[0].data.push(total)
                    }
                    console.log('bar')
                    Fire.$emit('render-chart-bar')
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
