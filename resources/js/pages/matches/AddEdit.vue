<template>
    <div class="d-flex flex-column flex-column-fluid" style="min-height: calc(100vh - 130px)">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ title }}</h1>
                    <Breadcrumb :list="breadcrumb_list"></Breadcrumb>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div class="app-container container-xxl">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-flush">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Detail</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <form>
                                    <div class="mb-5">
                                        <label class="form-label">Kopetisi</label>
                                        <vue-select label="name" v-model="form.competition_id" :reduce="name => name.id"
                                            :options="form_props.competitions"></vue-select>
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('competition_id')">
                                            {{ getMessage('competition_id') }}
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label">Kategori</label>
                                        <vue-select label="name" v-model="form.player_category_code"
                                            :reduce="name => name.code" :options="form_props.categories"></vue-select>
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('player_category_code')">
                                            {{ getMessage('player_category_code') }}
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label">Babak</label>
                                        <vue-select label="name" v-model="form.round_category_id" :reduce="name => name.id"
                                            :options="form_props.rounds"></vue-select>
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('round_category_id')">
                                            {{ getMessage('round_category_id') }}
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label">Tipe</label>
                                        <vue-select label="name" v-model="form.match_type_category_id"
                                            :reduce="name => name.id" :options="form_props.match_types"></vue-select>
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('match_type_category_id')">
                                            {{ getMessage('match_type_category_id') }}
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control form-control-sm mb-2" v-model="form.date">
                                        <div class="fv-plugins-message-container invalid-feedback" v-if="getStatus('date')">
                                            {{ getMessage('date') }}
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label">Pemenang</label>
                                        <select class="form-select mb-2" v-model="form.winner">
                                            <option value="home">Home</option>
                                            <option value="away">Away</option>
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('winner')">
                                            {{ getMessage('winner') }}
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label">Status</label>
                                        <select class="form-select mb-2" v-model="form.status">
                                            <option value="1">Aktif</option>
                                            <option value="0">Non Aktif</option>
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('status')">
                                            {{ getMessage('status') }}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3 card-flush">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>HOME</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="mb-5">
                                    <label class="form-label">Pemain 1</label>
                                    <vue-select label="full_name" v-model="form.home_first_player_id"
                                        :reduce="full_name => full_name.id" :options="form_props.players"></vue-select>
                                    <div class="fv-plugins-message-container invalid-feedback"
                                        v-if="getStatus('home_first_player_id')">
                                        {{ getMessage('home_first_player_id') }}
                                    </div>
                                </div>
                                <div class="mb-5" v-if="form_props.player_number === 2">
                                    <label class="form-label">Pemain 2</label>
                                    <vue-select label="full_name" v-model="form.home_second_player_id"
                                        :reduce="full_name => full_name.id" :options="form_props.players"></vue-select>
                                    <div class="fv-plugins-message-container invalid-feedback"
                                        v-if="getStatus('home_second_player_id')">
                                        {{ getMessage('home_second_player_id') }}
                                    </div>
                                </div>
                                <div class="mb-5 fv-row fv-plugins-icon-container">
                                    <label class="form-label">Skor</label>
                                    <div class="h3">{{ form.home_final_score }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-flush mb-3">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>AWAY</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="mb-5">
                                    <label class="form-label">Pemain 1</label>
                                    <vue-select label="full_name" v-model="form.away_first_player_id"
                                        :reduce="full_name => full_name.id" :options="form_props.players"></vue-select>
                                    <div class="fv-plugins-message-container invalid-feedback"
                                        v-if="getStatus('away_first_player_id')">
                                        {{ getMessage('away_first_player_id') }}
                                    </div>
                                </div>
                                <div class="mb-5" v-if="form_props.player_number === 2">
                                    <label class="form-label">Pemain 2</label>
                                    <vue-select label="full_name" v-model="form.away_second_player_id"
                                        :reduce="full_name => full_name.id" :options="form_props.players"></vue-select>
                                    <div class="fv-plugins-message-container invalid-feedback"
                                        v-if="getStatus('away_second_player_id')">
                                        {{ getMessage('away_second_player_id') }}
                                    </div>
                                </div>
                                <div class="mb-5 fv-row fv-plugins-icon-container">
                                    <label class="form-label">Skor</label>
                                    <div class="h3">{{ form.away_final_score }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mb-3">
                            <router-link to="/admin/matches" class="btn btn-light me-2">Batal</router-link>
                            <button v-if="!form_props.edit_mode"
                                :disabled="form_props.is_loading" @click="createData(1)" class="btn btn-primary me-2">
                                <span v-if="!form_props.is_loading">Tambah</span>
                                <span v-if="form_props.is_loading">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <button v-if="!form_props.edit_mode"
                                :disabled="form_props.is_loading" @click="createData(2)" class="btn btn-success me-2">
                                <span v-if="!form_props.is_loading">Simpan, input lagi</span>
                                <span v-if="form_props.is_loading">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <button v-if="form_props.edit_mode"
                                :disabled="form_props.is_loading" @click="editData" class="btn btn-primary me-2">
                                <span v-if="!form_props.is_loading">Simpan</span>
                                <span v-if="form_props.is_loading">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card mb-3 card-flush">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Detail Skor</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table table-striped score-table">
                                    <tr class="font-bold">
                                        <td></td>
                                        <td>Set 1</td>
                                        <td>Set 2</td>
                                        <td>Set 3</td>
                                        <td>Set 4</td>
                                        <td>Set 5</td>
                                        <td>Hasil</td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">
                                            Waktu <br>(menit)
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.first_time_minutes">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.second_time_minutes">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.third_time_minutes">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.fourth_time_minutes">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.fifth_time_minutes">
                                        </td>
                                        <td>
                                            {{ time_sum }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">HOME</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.first_home_points">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.second_home_points">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.third_home_points">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.fourth_home_points">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.fifth_home_points">
                                        </td>
                                        <td>
                                            {{ home_final }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">AWAY</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.first_away_points">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.second_away_points">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.third_away_points">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.fourth_away_points">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="form.match_detail.fifth_away_points">
                                        </td>
                                        <td>
                                            {{ away_final }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Breadcrumb from "../../components/Breadcrumb";
import { reactive, computed, watch } from "vue";
import useAxios from "../../src/service";
import useValidation from "../../src/validation";
import { useRouter, useRoute } from "vue-router";
import { useFilterStore } from "../../src/store_filter";
import VueSelect from "vue-select";
import Swal from "../../src/swal_toast";

export default {
    components: { VueSelect, Breadcrumb },
    setup() {
        const { postData, getData, patchData } = useAxios()
        const router = useRouter()
        const { setErrors, getStatus, getMessage, resetErrors } = useValidation()
        const route = useRoute()
        const { app_store } = useFilterStore()

        // Cek Mode
        const form_props = reactive({
            is_loading: false,
            errors: [],
            edit_mode: false,
            competitions: [],
            categories: [],
            players: [],
            rounds: [],
            match_types: [],
            player_number: 2,
        })

        const param_id = route.params.id
        form_props.edit_mode = param_id !== 'add'

        const title = form_props.edit_mode ? "Edit Pertandingan" : "Tambah Pertandingan"
        const breadcrumb_list = ["Pertandingan", form_props.edit_mode ? "Edit" : "Tambah"];

        const form = reactive({
            id: '',
            competition_id: '',
            competition_name: '',
            round_category_id: '',
            player_category_code: '',
            match_type_category_id: '',
            home_first_player_id: '',
            home_first_player_name: '',
            home_second_player_id: '',
            home_second_player_name: '',
            home_final_score: '',
            away_first_player_id: '',
            away_first_player_name: '',
            away_second_player_id: '',
            away_second_player_name: '',
            away_final_score: '',
            winner: '',
            date: '',
            user_id: '',
            status: 1,
            match_detail: {
                first_home_points: '',
                first_away_points: '',
                first_time_minutes: '',
                second_home_points: '',
                second_away_points: '',
                second_time_minutes: '',
                third_home_points: '',
                third_away_points: '',
                third_time_minutes: '',
                fourth_home_points: '',
                fourth_away_points: '',
                fourth_time_minutes: '',
                fifth_home_points: '',
                fifth_away_points: '',
                fifth_time_minutes: '',
                final_home_points: '',
                final_away_points: '',
                final_time_minutes: '',
            }
        })

        if (form_props.edit_mode) {
            getData('matches/' + param_id)
                .then((data) => {
                    form.id = data.result.id
                    form.competition_id = data.result.competition_id
                    form.competition_name = data.result.competition_name
                    form.round_category_id = data.result.round_category_id
                    form.player_category_code = data.result.player_category_code
                    form.match_type_category_id = data.result.match_type_category_id
                    form.home_first_player_id = data.result.home_first_player_id
                    form.home_first_player_name = data.result.home_first_player_name
                    form.home_second_player_id = data.result.home_second_player_id
                    form.home_second_player_name = data.result.home_second_player_name
                    form.home_final_score = data.result.home_final_score
                    form.away_first_player_id = data.result.away_first_player_id
                    form.away_first_player_name = data.result.away_first_player_name
                    form.away_second_player_id = data.result.away_second_player_id
                    form.away_second_player_name = data.result.away_second_player_name
                    form.away_final_score = data.result.away_final_score
                    form.winner = data.result.winner
                    form.date = data.result.date
                    form.user_id = data.result.user_id
                    form.status = data.result.status
                    if (data.result.match_detail !== null) {
                        form.match_detail = data.result.match_detail
                    }
                })
        }

        function createData(type) {
            form_props.is_loading = true
            postData('matches', form).then((data) => {
                form_props.is_loading = false;
                if (data.success) {
                    if(type === 1){
                        router.push('/admin/matches')
                    } else {
                        Swal("Berhasil menambahkan data pertandingan.")
                        resetPartial()
                    }
                    resetErrors()
                } else {
                    setErrors(data.errors)
                }
            }).catch(() => {
                form_props.is_loading = false
            })
        }

        function resetPartial(){
            form.home_first_player_id = ''
            form.home_second_player_id = ''
            form.away_first_player_id = ''
            form.away_second_player_id = ''
            form.match_detail = {
                first_home_points: '',
                first_away_points: '',
                first_time_minutes: '',
                second_home_points: '',
                second_away_points: '',
                second_time_minutes: '',
                third_home_points: '',
                third_away_points: '',
                third_time_minutes: '',
                fourth_home_points: '',
                fourth_away_points: '',
                fourth_time_minutes: '',
                fifth_home_points: '',
                fifth_away_points: '',
                fifth_time_minutes: '',
                final_home_points: '',
                final_away_points: '',
                final_time_minutes: '',
            }
        }

        function editData() {
            form_props.is_loading = true
            patchData('matches/' + param_id, form).then((data) => {
                form_props.is_loading = false;
                if (data.success) {
                    router.push('/admin/matches')
                    resetErrors()
                } else {
                    setErrors(data.errors)
                }
            })
        }

        function loadPlayerList(gender = null) {
            let params = {}
            if(gender !== null){
                params = {
                    gender: gender
                }
            }
            getData('players-list', params)
                .then((data) => {
                    form_props.players = data.result
                })
        }

        loadPlayerList()

        function loadCompetitionList() {
            getData('competitions-list')
                .then((data) => {
                    form_props.competitions = data.result
                })
        }

        loadCompetitionList()

        function loadCompetitionCategoryList() {
            getData('categories-list', { type: 'player' })
                .then((data) => {
                    form_props.categories = data.result
                })
        }

        loadCompetitionCategoryList()

        function loadRoundCategoryList() {
            getData('categories-list', { type: 'round' })
                .then((data) => {
                    form_props.rounds = data.result
                })
        }

        loadRoundCategoryList()

        function loadMatchTypeList() {
            getData('categories-list', { type: 'match_type' })
                .then((data) => {
                    form_props.match_types = data.result
                })
        }

        loadMatchTypeList()

        watch(() => _.cloneDeep(form.match_type_category_id), () => {
            const type = form_props.match_types.find(item=>{
                return item.id == form.match_type_category_id
            })

            if(type){
                const arr = type.name.split(' ');
                const number = arr[0] === 'Tunggal' ? 1 : 2;
                const gender = arr[1] === 'Putra' ? 'M' : 'F'

                form_props.player_number = number;
                form_props.player_gender = gender;

                loadPlayerList(gender)
            }
        });

        const time_sum = computed(() => {
            let time = 0;
            time += form.match_detail.first_time_minutes ? parseInt(form.match_detail.first_time_minutes) : 0;
            time += form.match_detail.second_time_minutes ? parseInt(form.match_detail.second_time_minutes) : 0;
            time += form.match_detail.third_time_minutes ? parseInt(form.match_detail.third_time_minutes) : 0;
            time += form.match_detail.fourth_time_minutes ? parseInt(form.match_detail.fourth_time_minutes) : 0;
            time += form.match_detail.fifth_time_minutes ? parseInt(form.match_detail.fifth_time_minutes) : 0;

            form.match_detail.final_time_minutes = time
            return time;
        });

        const home_final = computed(() => {
            let home_final = 0;
            home_final += form.match_detail.first_home_points > form.match_detail.first_away_points ? 1 : 0;
            home_final += form.match_detail.second_home_points > form.match_detail.second_away_points ? 1 : 0;
            home_final += form.match_detail.third_home_points > form.match_detail.third_away_points ? 1 : 0;
            home_final += form.match_detail.fourth_home_points > form.match_detail.fourth_away_points ? 1 : 0;
            home_final += form.match_detail.fifth_home_points > form.match_detail.fifth_away_points ? 1 : 0;

            form.match_detail.final_home_points = home_final
            form.home_final_score = home_final
            return home_final;
        });

        const away_final = computed(() => {
            let away_final = 0;
            away_final += form.match_detail.first_home_points < form.match_detail.first_away_points ? 1 : 0;
            away_final += form.match_detail.second_home_points < form.match_detail.second_away_points ? 1 : 0;
            away_final += form.match_detail.third_home_points < form.match_detail.third_away_points ? 1 : 0;
            away_final += form.match_detail.fourth_home_points < form.match_detail.fourth_away_points ? 1 : 0;
            away_final += form.match_detail.fifth_home_points < form.match_detail.fifth_away_points ? 1 : 0;

            form.match_detail.final_away_points = away_final
            form.away_final_score = away_final
            return away_final;
        });

        return {
            breadcrumb_list,
            title,
            form,
            form_props,
            app_store,
            time_sum,
            home_final,
            away_final,
            createData,
            getStatus,
            getMessage,
            editData
        }
    }
}
</script>
<style scoped>
.score-table tr td {
    padding: 2px;
    max-width: 20px;
    text-align: center;
}
</style>