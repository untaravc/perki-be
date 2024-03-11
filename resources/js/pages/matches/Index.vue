<template>
    <div class="d-flex flex-column flex-column-fluid" style="min-height: calc(100vh - 130px)">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ title }}
                    </h1>
                    <Breadcrumb :list="breadcrumb_list"></Breadcrumb>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <router-link to="/admin/matches/add" class="btn btn-sm fw-bold btn-primary">
                        Tambah Data
                    </router-link>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card card-flush">
                    <div class="px-8 pt-8 pb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Pemain</label>
                                <vue-select label="full_name" v-model="filter.player_id" :reduce="full_name => full_name.id"
                                    :options="filter_props.players"></vue-select>
                            </div>
                            <div class="col-md-3">
                                <label>Kompetisi</label>
                                <vue-select label="name" v-model="filter.competition_id" :reduce="name => name.id"
                                    :options="filter_props.competitions"></vue-select>
                            </div>
                            <div class="col-md-3">
                                <label>Tingkat Umur</label>
                                <vue-select label="name" v-model="filter.player_category_code" :reduce="name => name.code"
                                    :options="filter_props.player_categories"></vue-select>
                            </div>
                            <div class="col-md-3">
                                <label>Round</label>
                                <vue-select label="name" v-model="filter.round_category_id" :reduce="name => name.id"
                                    :options="filter_props.rounds"></vue-select>
                            </div>
                            <div class="col-md-3 mt-3">
                                <label>Kategori Pertandingan</label>
                                <vue-select label="name" v-model="filter.match_type_category_id" :reduce="name => name.id"
                                    :options="filter_props.match_types"></vue-select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                                <Loading :active="filter_props.is_loading" :loader="'dots'" :is-full-page="false" />
                                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                                    id="kt_ecommerce_products_table">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th>No</th>
                                            <th>Kompetisi</th>
                                            <th>Keterangan</th>
                                            <th class="text-center">Home</th>
                                            <th class="text-center">Away</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr v-if="response.data_content.total === 0">
                                            <td colspan="6" class="text-center"><i>Tidak ada data.</i></td>
                                        </tr>
                                        <tr v-for="(data, d) in response.data_content.data">
                                            <td>
                                                {{ response.data_content.per_page *
                                                    (response.data_content.current_page - 1) + d + 1 }}
                                            </td>
                                            <td>
                                                <b>{{ data.competition_name }} </b>
                                                <span v-if="data.competition_category_code">({{
                                                    data.competition_category_code }})</span>
                                                <div>
                                                    <i>{{ $filter.formatDate(data.date) }}</i>
                                                </div>
                                            </td>
                                            <td>
                                                <div v-if="data.match_type">{{ data.match_type.name }}</div>
                                                <div v-if="data.player_category">{{ data.player_category.name }}</div>
                                                <div v-if="data.round_category">{{ data.round_category.name }}</div>
                                            </td>
                                            <td class="text-center">
                                                <div>{{ data.home_first_player_name }}</div>
                                                <div>{{ data.home_second_player_name }}</div>
                                                <div v-if="data.match_detail">
                                                    <b class="h2">{{ data.home_final_score }}</b>
                                                    [
                                                    <span v-if="data.match_detail.first_home_points !== null">
                                                        {{ data.match_detail.first_home_points }}</span>
                                                    <span v-if="data.match_detail.second_home_points !== null">,
                                                        {{ data.match_detail.second_home_points }}</span>
                                                    <span v-if="data.match_detail.third_home_points !== null">,
                                                        {{ data.match_detail.third_home_points }}</span>
                                                    <span v-if="data.match_detail.fourth_home_points !== null">,
                                                        {{ data.match_detail.fourth_home_points }}</span>
                                                    <span v-if="data.match_detail.fifth_home_points !== null">,
                                                        {{ data.match_detail.fifth_home_points }}</span>
                                                    ]
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div>{{ data.away_first_player_name }}</div>
                                                <div>{{ data.away_second_player_name }}</div>
                                                <div v-if="data.match_detail">
                                                    <b class="h2">{{ data.away_final_score }}</b>
                                                    [
                                                    <span v-if="data.match_detail.first_away_points !== null">
                                                        {{ data.match_detail.first_away_points }}</span>
                                                    <span v-if="data.match_detail.second_away_points !== null">,
                                                        {{ data.match_detail.second_away_points }}</span>
                                                    <span v-if="data.match_detail.third_away_points !== null">,
                                                        {{ data.match_detail.third_away_points }}</span>
                                                    <span v-if="data.match_detail.fourth_away_points !== null">,
                                                        {{ data.match_detail.fourth_away_points }}</span>
                                                    <span v-if="data.match_detail.fifth_away_points !== null">,
                                                        {{ data.match_detail.fifth_away_points }}</span>
                                                    ]
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-light dropdown-toggle btn-sm"
                                                        data-toggle="dropdown">
                                                        Aksi
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <router-link :to="'/admin/matches/' + data.id"
                                                            class="dropdown-item">
                                                            Edit
                                                        </router-link>
                                                        <button class="dropdown-item text-danger"
                                                            @click="deleteModal(data.id)">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div
                                    class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                                    <PerPage :value="filter.per_page" @change-per-page="changePerPage" />
                                </div>
                                <div
                                    class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                                    <Bootstrap4Pagination :data="response.data_content" :limit="2"
                                        @pagination-change-page="loadDataContent"></Bootstrap4Pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <WidgetContainerModal />
        </div>
    </div>
</template>
<script>
import Breadcrumb from "../../components/Breadcrumb";
import PerPage from '../../components/PerPage'
import StatusDefault from '../../components/StatusDefault'
import useAxios from "../../src/service";
import DeleteModal from "./DeleteModal"
import { reactive, watch } from "vue";
import { container, promptModal } from "jenesius-vue-modal";
import SwalToast from '../../src/swal_toast'
import { useFilterStore } from "../../src/store_filter";
import VueSelect from "vue-select";
export default {
    components: { Breadcrumb, PerPage, WidgetContainerModal: container, StatusDefault, VueSelect },
    setup() {
        const title = "Data Pertandingan"
        const breadcrumb_list = ["Pertandingan", "Data"];
        const { getData, deleteData } = useAxios()
        const { match_store, app_store } = useFilterStore()

        const filter = reactive({
            page: match_store.page,
            per_page: 25,
            player_id: '',
            competition_id: '',
            round_category_id: '',
            player_category_code: '',
            match_type_category_id: '',
        })

        const filter_props = reactive({
            is_loading: false,
            players: [],
            competitions: [],
            rounds: [],
            match_types: [],
            player_categories: [],
            match_categoties: [],
        })

        filter.player_id = match_store.player_id

        function loadDataContent(page = 1) {
            filter_props.is_loading = true
            filter.page = page
            getData('matches', filter)
                .then((data) => {
                    if (data.success) {
                        response.data_content = data
                    }
                    filter_props.is_loading = false
                })
        }

        loadDataContent()

        const response = reactive({
            data_content: {
                data: []
            }
        })

        function changePerPage(per_page) {
            filter.per_page = per_page
            loadDataContent()
        }

        async function deleteModal(id) {
            const delete_modal = await promptModal(DeleteModal, { title: "Hapus data?" })
            if (delete_modal) {
                deleteData('matches/' + id)
                    .then((data) => {
                        SwalToast('Berhasil menghapus data.')
                        loadDataContent(filter.page)
                    })
            }
        }

        function loadPlayerList() {
            getData('players-list')
                .then((data) => {
                    filter_props.players = data.result
                })
        }

        loadPlayerList()

        function loadCompetitionList() {
            getData('competitions-list')
                .then((data) => {
                    filter_props.competitions = data.result
                })
        }

        loadCompetitionList()

        function loadRoundCategoryList() {
            getData('categories-list', { type: 'round' })
                .then((data) => {
                    filter_props.rounds = data.result
                })
        }

        loadRoundCategoryList()

        function loadPlayerCategoryList() {
            getData('categories-list', { type: 'player' })
                .then((data) => {
                    filter_props.player_categories = data.result
                })
        }

        loadPlayerCategoryList()
        
        function loadMatchCategoryList() {
            getData('categories-list', { type: 'match_type' })
                .then((data) => {
                    filter_props.match_types = data.result
                })
        }

        loadMatchCategoryList()

        watch(() => _.cloneDeep(filter.player_id), () => {
            match_store.filter.player_id
            loadDataContent()
        });

        watch(() => _.cloneDeep(filter.competition_id), () => {
            loadDataContent()
        });

        watch(() => _.cloneDeep(filter.round_category_id), () => {
            loadDataContent()
        });

        watch(() => _.cloneDeep(filter.player_category_code), () => {
            loadDataContent()
        });
        
        watch(() => _.cloneDeep(filter.match_type_category_id), () => {
            loadDataContent()
        });

        return {
            breadcrumb_list,
            title,
            response,
            filter,
            app_store,
            filter_props,
            loadDataContent,
            changePerPage,
            deleteModal
        }
    }
}
</script>
