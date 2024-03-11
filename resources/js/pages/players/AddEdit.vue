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
                    class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework"
                    data-kt-redirect="../../demo1/dist/apps/ecommerce/catalog/products.html">
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-body pt-0">
                                <div class="mb-3">
                                    <label>Status</label>
                                    <select class="form-select mb-2" v-model="form.status">
                                        <option value="1">Aktif</option>
                                        <option value="0">Non Aktif</option>
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback" v-if="getStatus('status')">
                                        {{ getMessage('status') }}
                                    </div>
                                </div>
                                <div>
                                    <Loading Loading :active="form_props.image_loader" :loader="'dots'"
                                        :is-full-page="false"></Loading>
                                    <div class="form-group">
                                        <label>Foto</label>
                                        <div>
                                            <input type="file" id="photo-file"
                                                accept="image/png,image/gif,image/jpeg,application/pdf"
                                                @change="uploadProof($event)" />
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <img :src="form.image" style="width: 100%; height: auto" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="card card-flush p-10">
                            <div class="h4">Cek nama</div>
                            <div class="mb-5">
                                <vue-select label="full_name" v-model="form_props.player_name"
                                    :options="form_props.players"></vue-select>
                            </div>
                        </div>
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <div class="h4">Detail</div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <form>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="form-label">Nomor</label>
                                        <input type="text" class="form-control mb-2" v-model="form.reg_id">
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('reg_id')">
                                            {{ getMessage('reg_id') }}
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control mb-2" v-model="form.full_name">
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('full_name')">
                                            {{ getMessage('full_name') }}
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" placeholder="First Name" class="form-control mb-2"
                                                    v-model="form.first_name">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" placeholder="Surname" class="form-control mb-2"
                                                    v-model="form.surname_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-control mb-2" v-model="form.gender">
                                            <option value="M">Laki Laki</option>
                                            <option value="F">Perempuan</option>
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('gender')">
                                            {{ getMessage('gender') }}
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control mb-2" v-model="form.birth_date">
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('birth_date')">
                                            {{ getMessage('birth_date') }}
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="form-label">Kota</label>
                                        <input type="text" class="form-control mb-2" v-model="form.city">
                                        <div class="fv-plugins-message-container invalid-feedback" v-if="getStatus('city')">
                                            {{ getMessage('city') }}
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="form-label">Inisal Kota</label>
                                        <input type="text" class="form-control mb-2" v-model="form.city_init">
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('city_init')">
                                            {{ getMessage('city_init') }}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <router-link to="/admin/players" class="btn btn-light me-5">Batal</router-link>
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
                    <div></div>
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
            players: [],
            image_url: '',
            image_loader: false,
            player_name: '',
        })

        const param_id = route.params.id
        form_props.edit_mode = param_id !== 'add'

        const title = form_props.edit_mode ? "Edit Player" : "Tambah Staff"
        const breadcrumb_list = ["Player", form_props.edit_mode ? "Edit" : "Tambah"];

        const form = reactive({
            id: '',
            reg_id: '',
            full_name: '',
            first_name: '',
            surname_name: '',
            gender: '',
            image: '',
            city: '',
            city_init: '',
            birth_date: '',
            status: 1,
        })

        if (form_props.edit_mode) {
            getData('players/' + param_id)
                .then((data) => {
                    form.id = data.result.id
                    form.reg_id = data.result.reg_id
                    form.full_name = data.result.full_name
                    form.first_name = data.result.first_name
                    form.surname_name = data.result.surname_name
                    form.gender = data.result.gender
                    form.birth_date = data.result.birth_date
                    form.city = data.result.city
                    form.image = data.result.image
                    form.city_init = data.result.city_init
                    form.status = data.result.status
                })
        }

        function createData() {
            form_props.is_loading = true
            postData('players', form).then((data) => {
                form_props.is_loading = false;
                if (data.success) {
                    router.push('/admin/players')
                    resetErrors()
                } else {
                    setErrors(data.errors)
                }
            })
        }

        function editData() {
            form_props.is_loading = true
            patchData('players/' + param_id, form).then((data) => {
                form_props.is_loading = false;
                if (data.success) {
                    router.push('/admin/players')
                    resetErrors()
                } else {
                    setErrors(data.errors)
                }
            })
        }

        function uploadProof(e) {
            let file = e.target.files[0];
            let reader = new FileReader();
            reader.onloadend = (file) => {
                form.image = reader.result;
            };
            form_props.image_url = URL.createObjectURL(file);
            reader.readAsDataURL(file)

            const form_file = document.getElementById('photo-file');
            const formData = new FormData();
            if (form_file != '') {
                formData.append('file', form_file.files[0]);
            }

            form_props.image_loader = true;
            postData('upload', formData)
                .then((data) => {
                    form_props.image_loader = false;
                    document.getElementById('photo-file').value = '';
                    form.image = data.result;
                }).catch(() => {
                    form_props.image_loader = false;
                    alert('file upload failed');
                })
        }

        function loadPlayerList() {
            getData('players-list')
                .then((data) => {
                    form_props.players = data.result
                })
        }

        loadPlayerList()

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
            uploadProof
        }
    }
}
</script>
