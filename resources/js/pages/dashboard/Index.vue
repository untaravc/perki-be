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
                            <div class="text-lg h4">Angka</div>
                            <div>Submit abstrak</div>
                            <div>Jumlah uang</div>
                            <div>Total Member account</div>
                            <div>Total Member paid</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rounded-3 bg-white p-4">
                            <div class="text-lg h4">Sympo WS by transaction</div>
                            paid, pending, select event
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
            stats: {
                players_count: 0,
                competitions_count: 0,
                points_count: 0,
                matches_count: 0,
            }
        })

        function loadStats() {
            getData('dashboard-stats').then((data) => {
                content.stats = data.result
            })
        }

        // loadStats()

        return {
            title,
            breadcrumb_list,
            content,
        }
    }
}
</script>
