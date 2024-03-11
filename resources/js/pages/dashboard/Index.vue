<template>
    <div class="d-flex flex-column flex-column-fluid" style="min-height: calc(100vh - 130px)">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
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
                    <div class="col-md-3">
                        <div class="rounded-3 bg-white p-4">
                            <div class="text-lg h4">Pemain</div>
                            <div class="h2 font-bold text-green-600">
                                {{ content.stats.players_count }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="rounded-3 bg-white p-4">
                            <div class="text-lg h4">Kompetisi</div>
                            <div class="h2 font-bold text-green-600">
                                {{ content.stats.competitions_count }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="rounded-3 bg-white p-4">
                            <div class="text-lg h4">Catatan Poin</div>
                            <div class="h2 font-bold text-green-600">
                                {{ content.stats.points_count }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="rounded-3 bg-white p-4">
                            <div class="text-lg h4">Catatan Pertandingan</div>
                            <div class="h2 font-bold text-green-600">
                                {{ content.stats.matches_count }}
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

        loadStats()

        return {
            title,
            breadcrumb_list,
            content,
        }
    }
}
</script>
