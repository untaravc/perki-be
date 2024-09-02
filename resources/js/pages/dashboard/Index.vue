<template>
    <div class="d-flex flex-column flex-column-fluid" style="min-height: calc(100vh - 130px)">
        <div class="app-toolbar py-3 py-lg-6">
            <div class="app-container container-xxl">
                <div class="d-flex justify-content-between">
                    <h1 class="page-headingtext-dark fw-bold fs-3">
                        {{ title }}
                    </h1>
                    <div class="page-headingtext-dark fw-bold fs-3">{{ subtitle }}</div>
                </div>
            </div>
        </div>
        <div class="app-content flex-column-fluid">
            <div class="app-container container-xxl">
                <div class="row">
                    <div class="col-md-8 mb-5">
                        <div class="rounded-3 bg-white p-4">
                            <div class="text-lg h4">Web Activity (last 30 days)</div>
                            <LineChart v-if="content.chart_loaded" class="max-h-96" :chartData="chart_data"
                                :chartOptions="chart_options"></LineChart>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <div class="rounded-3 bg-white p-4">
                            <div class="text-lg h4 mb-0">Abstracts Submission</div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <div class="text-sm">Pending</div>
                                    <div class="h3 font-bold" v-if="content.abstract_status">
                                        {{ content.abstract_status.pending }}
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text-sm">Accepted</div>
                                    <div class="h3 text-green-500 font-bold" v-if="content.abstract_status">
                                        {{ content.abstract_status.accepted }}</div>
                                </div>
                                <div class="col-4">
                                    <div class="text-sm">Rejected</div>
                                    <div class="h3 text-red-500 font-bold" v-if="content.abstract_status">
                                        {{ content.abstract_status.rejected }}</div>
                                </div>
                            </div>

                            <div class="text-lg h4 mb-0">Members</div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <div class="text-sm">Registered</div>
                                    <div class="h3 font-bold">{{ content.stat.member }}</div>
                                </div>
                                <div class="col-4">
                                    <div class="text-sm">Purchased</div>
                                    <div class="h3 text-blue-500 font-bold">
                                        {{ content.stat.member_purchase }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-lg h4 mb-0">Transactions</div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <div class="text-sm">Est. Earning</div>
                                    <div class="h3 font-bold">{{
                                        $filter.currency(parseInt(content.stat.transaction_success_nominal)) }}</div>
                                </div>
                                <div class="col-4">
                                    <div class="text-sm">Paid</div>
                                    <div class="h3 text-blue-500 font-bold">
                                        {{ content.stat.transaction_success }}
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text-sm">Pending</div>
                                    <div class="h3 text-emerald-500 font-bold">
                                        {{ content.stat.transaction_pending }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rounded-3 bg-white p-4">
                            <div class="flex justify-between">
                                <div class="text-lg h4">Sympo & Ws by Transaction Status</div>
                                <div class="flex">
                                    <div class="h-6 w-6 me-1 bg-emerald-500"></div>
                                    Paid
                                    <div class="h-6 w-6 me-1 bg-slate-500 ms-3"></div>
                                    Pending
                                </div>
                            </div>
                            <div v-for="event in content.events">
                                <div><b>{{ event.name }}</b> <span class="text-slate-500">{{
                                    $filter.truncate(event.title, 50) }} </span></div>
                                <div class="overflow-hidden h-4 mb-2 text-xs flex rounded bg-emerald-50">
                                    <div :style="'width: ' + event.transaction_success_count * 100 / event.quota + '%'"
                                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-emerald-500">
                                        {{ event.transaction_success_count }}
                                    </div>
                                    <div :style="'width: ' + event.transaction_pending_count * 100 / event.quota + '%'"
                                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-slate-500">
                                        {{ event.transaction_pending_count }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rounded-3 bg-white p-4">
                            <div class="flex justify-between">
                                <div class="text-lg h4">Sympo & Ws by Type</div>
                                <div class="flex">
                                    <div class="h-6 w-6 me-1 bg-emerald-500"></div>
                                    STD
                                    <div class="h-6 w-6 me-1 bg-blue-500 ms-3"></div>
                                    GP
                                    <div class="h-6 w-6 me-1 bg-orange-500 ms-3"></div>
                                    SP
                                </div>
                            </div>
                            <div v-for="event in content.events">
                                <div><b>{{ event.name }}</b></div>
                                <div class="overflow-hidden h-4 mb-2 text-xs flex rounded bg-emerald-50">
                                    <div :style="'width: ' + event.transaction_success_std_count * 100 / event.quota + '%'"
                                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-emerald-500">
                                        {{ event.transaction_success_std_count }}
                                    </div>
                                    <div :style="'width: ' + event.transaction_success_gp_count * 100 / event.quota + '%'"
                                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500">
                                        {{ event.transaction_success_gp_count }}
                                    </div>
                                    <div :style="'width: ' + event.transaction_success_sp_count * 100 / event.quota + '%'"
                                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-orange-500">
                                        {{ event.transaction_success_sp_count }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import useAxios from "../../src/service";
import { reactive, watch } from "vue";
import LineChart from "../../components/LineChart.vue";
import moment from "moment";

export default {
    components: { LineChart },
    setup() {
        const title = "Jogja Cardiology Update 2024 - 7th Jincartos"
        const subtitle = moment().format('DD MMM, HH:mm')
        const breadcrumb_list = ["Dashboard"];
        const { getData } = useAxios()
        const content = reactive({
            chart_loaded: false,
            abstract_status: {},
            stat: {},
            events: []
        })

        function loadUserStats() {
            getData('dashboard-user-stat').then((data) => {
                content.abstract_status = data.result.abstract_status
            })
        }

        loadUserStats()

        function loadStats() {
            getData('dashboard-stat').then((data) => {
                content.stat = data.result.stat
            })
        }

        loadStats()

        function loadChart() {
            content.chart_loaded = false
            getData('dashboard-chart').then((data) => {
                parseChartData(data.result)
            })
        }

        loadChart()

        function loadEvent() {
            content.chart_loaded = false
            getData('dashboard-event-purchase').then((data) => {
                content.events = data.result
            })
        }

        loadEvent()

        function parseChartData(data) {
            for (const [key, item] of Object.entries(data)) {
                chart_data.labels.push(item.date.substring(8))
                chart_data.datasets[0].data.push(item.count)
                chart_data.datasets[1].data.push(item.visitor)
            }

            content.chart_loaded = true
        }

        const chart_data = {
            labels: [],
            datasets: [
                {
                    label: 'Paid Transaction',
                    borderColor: '#26ff71',
                    tension: 0.2,
                    pointStyle: false,
                    data: []
                },
                {
                    label: 'Visitor',
                    borderColor: '#425499',
                    tension: 0.2,
                    pointStyle: false,
                    data: []
                }
            ]
        }

        const chart_options = {

        }

        return {
            title,
            breadcrumb_list,
            content,
            chart_data,
            subtitle,
            chart_options
        }
    }
}
</script>
