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
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control mb-2" v-model="form.name">
                                        <div class="fv-plugins-message-container invalid-feedback" v-if="getStatus('name')">
                                            {{ getMessage('name') }}
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="form-label">Role</label>
                                        <select class="form-control mb-2" v-model="form.role_id">
                                            <option :value="role.id" :key="role.id" v-for="role in form_props.roles">{{
                                                role.name }}
                                            </option>
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('role_id')">{{ getMessage('role_id') }}
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control mb-2" v-model="form.email"
                                            autocomplete="new-password">
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('email')">
                                            {{ getMessage('email') }}
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="form-label">
                                            <span v-if="form_props.edit_mode">Ganti</span> Password
                                        </label>
                                        <input type="password" class="form-control mb-2" v-model="form.password"
                                            autocomplete="new-password">
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('password')">
                                            {{ getMessage('password') }}
                                        </div>
                                        <span class="text-small text-gray-600" v-if="form_props.edit_mode">
                                            Kosongkan bila tidak akan mengganti password
                                        </span>
                                    </div>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="form-label">
                                            Konfirmasi <span v-if="form_props.edit_mode">Ganti</span> Password
                                        </label>
                                        <input type="password" class="form-control mb-2" autocomplete="new-password"
                                            v-model="form.password_confirmation">
                                        <div class="fv-plugins-message-container invalid-feedback"
                                            v-if="getStatus('password_confirmation')">
                                            {{ getMessage('password_confirmation') }}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <router-link to="/admin/users" class="btn btn-light me-5">Batal</router-link>
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

export default {
    components: { Breadcrumb },
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
            clients: [],
            roles: [],
        })

        const param_id = route.params.id
        form_props.edit_mode = param_id !== 'add'

        const title = form_props.edit_mode ? "Edit Staff" : "Tambah Staff"
        const breadcrumb_list = ["Klien", form_props.edit_mode ? "Edit" : "Tambah"];

        const form = reactive({
            id: '',
            status: 1,
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            role_id: '',
        })

        if (form_props.edit_mode) {
            getData('users/' + param_id)
                .then((data) => {
                    form.id = data.result.id
                    form.status = data.result.status
                    form.code = data.result.code
                    form.name = data.result.name
                    form.email = data.result.email
                    form.client_id = data.result.client_id
                    form.role_id = data.result.role_id
                })
        }

        function createData() {
            form_props.is_loading = true
            postData('users', form).then((data) => {
                form_props.is_loading = false;
                if (data.success) {
                    router.push('/admin/users')
                    resetErrors()
                } else {
                    setErrors(data.errors)
                }
            })
        }

        function editData() {
            form_props.is_loading = true
            patchData('users/' + param_id, form).then((data) => {
                form_props.is_loading = false;
                if (data.success) {
                    router.push('/admin/users')
                    resetErrors()
                } else {
                    setErrors(data.errors)
                }
            })
        }

        function loadRoles() {
            getData('roles-list')
                .then((data) => {
                    form_props.roles = data.result
                })
        }

        loadRoles()

        return {
            breadcrumb_list,
            title,
            form,
            form_props,
            app_store,
            createData,
            getStatus,
            getMessage,
            editData
        }
    }
}
</script>
