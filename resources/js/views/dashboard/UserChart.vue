<template>
    <PieChart :chart-data="chartData" :height="250"></PieChart>
</template>
<script>
import PieChart from '../../components/PieChart'

export default {
    components: {PieChart},
    data() {
        return {
            chartData: {
                labels: [],
                datasets: [
                    {
                        backgroundColor: [
                            '#813703',
                            '#1c0d0a',
                            '#d2750a',
                            '#ffe158',
                            '#23dd16',
                            '#16ddb9',
                            '#0945c7',
                            '#ab16dd',
                        ],
                        data: []
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

                    let ln = Object.keys(data.result.type_code).length;
                    for (let i = 0; i < ln; i++) {
                        console.log(data.result.type_code[i])
                        let job_label = data.result.type_code[i].job_label
                        let total = data.result.type_code[i].total
                        this.chartData.labels.push(job_label + " (" + total +")")

                        this.chartData.datasets[0].data.push(total)
                    }

                    Fire.$emit('render-chart-pie')
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
