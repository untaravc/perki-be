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
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div id="kt_ecommerce_add_product_form"
                    class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Status</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <select class="form-select mb-2" v-model="form.status">
                                    <option value="1">Aktif</option>
                                    <option value="0">Non Aktif</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback" v-if="getStatus('status')">
                                    {{ getMessage('status') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Detail</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <form>
                                    <div class="mb-5">
                                        <label class="form-label">Pemain</label>
                                        <vue-select label="full_name" v-model="form.player_id"
                                            :reduce="full_name => full_name.id" :options="form_props.players"></vue-select>
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('player_id')">
                                            {{ getMessage('player_id') }}
                                        </div>
                                    </div>
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

                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control mb-2" v-model="form.date">
                                        <div class="fv-plugins-message-container invalid-feedback" v-if="getStatus('date')">
                                            {{ getMessage('date') }}
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="form-label">Point</label>
                                        <input type="number" min="0" class="form-control mb-2" v-model="form.point">
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('point')">
                                            {{ getMessage('point') }}
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <div class="d-flex">
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    v-model="form.is_cut_off">
                                                <span class="form-check-label">Data Cut Off</span>
                                            </label>
                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    v-model="form.is_historical">
                                                <span class="form-check-label">Historikal</span>
                                            </label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <router-link to="/admin/points" class="btn btn-light me-5">Batal</router-link>
                            <button id="kt_ecommerce_add_product_submit" v-if="!form_props.edit_mode"
                                :disabled="form_props.is_loading" @click="createData" class="btn btn-primary">
                                <span v-if="!form_props.is_loading">Tambah</span>
                                <span v-if="form_props.is_loading">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <button id="kt_ecommerce_add_product_submit" v-if="form_props.edit_mode"
                                :disabled="form_props.is_loading" @click="editData" class="btn btn-primary">
                                <span v-if="!form_props.is_loading">Simpan</span>
                                <span v-if="form_props.is_loading">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Breadcrumb from "../../components/Breadcrumb";
import { reactive } from "vue";
import useAxios from "../../src/service";
import useValidation from "../../src/validation";
import { useRouter, useRoute } from "vue-router";
import { useFilterStore } from "../../src/store_filter";
import VueSelect from "vue-select";

export default {
    components: { Breadcrumb, VueSelect },
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
            player_name: '',
            players: [],
            competition_name: '',
            competitions: [],
            categories: [],
        })

        const param_id = route.params.id
        form_props.edit_mode = param_id !== 'add'

        const title = form_props.edit_mode ? "Edit Player" : "Tambah Poin"
        const breadcrumb_list = ["Poin", form_props.edit_mode ? "Edit" : "Tambah"];

        const form = reactive({
            id: '',
            player_id: '',
            player_name: '',
            player_reg_id: '',
            competition_id: '',
            competition_name: '',
            player_category_code: '',
            point: '',
            is_cut_off: false,
            is_historical: false,
            date: '',
            user_id: '',
            status: 1,
        })

        if (form_props.edit_mode) {
            getData('points/' + param_id)
                .then((data) => {
                    form.id = data.result.id
                    form.player_id = data.result.player_id
                    form.player_name = data.result.player_name
                    form.player_reg_id = data.result.player_reg_id
                    form.competition_id = data.result.competition_id
                    form.competition_name = data.result.competition_name
                    form.player_category_code = data.result.player_category_code
                    form.point = data.result.point
                    form.is_cut_off = data.result.is_cut_off === 1
                    form.is_historical = data.result.is_historical === 1
                    form.user_id = data.result.user_id
                    form.status = data.result.status
                    form.date = data.result.date
                })
        }

        function createData() {
            form_props.is_loading = true
            postData('points', form).then((data) => {
                form_props.is_loading = false;
                if (data.success) {
                    router.push('/admin/points')
                    resetErrors()
                } else {
                    setErrors(data.errors)
                }
            }).catch(() => {
                form_props.is_loading = false;
            })
        }

        function editData() {
            form_props.is_loading = true
            patchData('points/' + param_id, form).then((data) => {
                form_props.is_loading = false;
                if (data.success) {
                    router.push('/admin/points')
                    resetErrors()
                } else {
                    setErrors(data.errors)
                }
            })
        }

        function loadPlayerList() {
            getData('players-list', { name: form_props.player_name })
                .then((data) => {
                    form_props.players = data.result
                })
        }

        loadPlayerList()

        function loadCompetitionList() {
            getData('competitions-list', { name: form_props.competition_name })
                .then((data) => {
                    form_props.competitions = data.result
                })
        }

        loadCompetitionList()

        function loadCategoryList() {
            getData('categories-list', { type: 'player' })
                .then((data) => {
                    form_props.categories = data.result
                })
        }

        loadCategoryList()

        return {
            breadcrumb_list,
            title,
            form,
            form_props,
            app_store,
            createData,
            getStatus,
            getMessage,
            editData,
        }
    }
}
</script>
