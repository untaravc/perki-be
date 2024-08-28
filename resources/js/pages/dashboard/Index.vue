<template>
    <div class="d-flex flex-column flex-column-fluid" style="min-height: calc(100vh - 130px)">
        <div class="app-toolbar py-3 py-lg-6">
            <div class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ title }}
                    </h1>
                </div>
            </div>
        </div>
        <div class="app-content flex-column-fluid">
            <div class="app-container container-xxl">
                <div class="row">
                    <div class="col-md-8 mb-5">
                        <div class="rounded-3 bg-white p-4">
                            <div class="text-lg h4">Grafik</div>
                            <div>Pembeli pending</div>
                            <div>Pembeli paid</div>
                            <div>Pembeli pengunjung web</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <div class="rounded-3 bg-white p-4">
                            <div class="text-lg h4 mb-0">Abstract Submission</div>
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

                            <div class="text-lg h4 mb-0">Member</div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <div class="text-sm">Register</div>
                                    <div class="h3 font-bold">122</div>
                                </div>
                                <div class="col-4">
                                    <div class="text-sm">On Payment</div>
                                    <div class="h3 text-green-500 font-bold">22</div>
                                </div>
                                <div class="col-4">
                                    <div class="text-sm">Paid</div>
                                    <div class="h3 text-red-500 font-bold">22</div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rounded-3 bg-white p-4">
                            <div class="text-lg h4">Sympo WS by transaction</div>
                            <div>
                                <div>Workshop 1</div>
                                <div class="overflow-hidden h-4 mb-4 text-xs flex rounded bg-emerald-200">
                                    <div style="width: 10%"
                                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500">
                                    </div>
                                    <div style="width: 15%"
                                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-orange-500">
                                    </div>
                                    <div style="width: 25%"
                                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-emerald-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rounded-3 bg-white p-4">
                            <div class="text-lg h4">Sympo WS by job</div>
                            mhs, dr, sp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useAxios from "../../src/service";
import { reactive } from "vue";

export default {
    components: {},
    setup() {
        const title = "Dashboard"
        const breadcrumb_list = ["Dashboard"];
        const { getData } = useAxios()
        const content = reactive({
            abstract_status: {}
        })

        function loadStats() {
            getData('dashboard-user-stat').then((data) => {
                content.abstract_status = data.result.abstract_status
            })
        }

        loadStats()

        return {
            title,
            breadcrumb_list,
            content,
        }
    }
}
</script>
