<template>
    <div class="d-flex flex-column flex-column-fluid" style="min-height: calc(100vh - 130px)">
        <div class="app-toolbar py-3 py-lg-6">
            <div class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ title }}</h1>
                    <Breadcrumb :list="breadcrumb_list"></Breadcrumb>
                </div>
            </div>
        </div>
        <div class="app-content flex-column-fluid">
            <div class="app-container container-xxl">
                <div class="card card-flush py-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-5 col-md-6 fv-row fv-plugins-icon-container">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control mb-2" v-model="form.name">
                                <div class="fv-plugins-message-container invalid-feedback" v-if="getStatus('name')">
                                    {{ getMessage('name') }}
                                </div>
                            </div>
                            <div class="mb-5 col-md-6 fv-row fv-plugins-icon-container">
                                <label class="form-label">Kode</label>
                                <input type="text" class="form-control mb-2" v-model="form.code">
                                <div class="fv-plugins-message-container invalid-feedback" v-if="getStatus('code')">
                                    {{ getMessage('code') }}
                                </div>
                            </div>
                            <div class="mb-5 col-md-6 fv-row fv-plugins-icon-container">
                                <label class="form-label">Role</label>
                                <input type="text" class="form-control mb-2" v-model="form.role">
                                <div class="fv-plugins-message-container invalid-feedback" v-if="getStatus('role')">
                                    {{ getMessage('role') }}
                                </div>
                            </div>
                            <div class="mb-5 col-md-6 fv-row fv-plugins-icon-container">
                                <label class="form-label">Job Type</label>
                                <input type="text" class="form-control mb-2" v-model="form.job_type_scope">
                                <div class="fv-plugins-message-container invalid-feedback"
                                    v-if="getStatus('job_type_scope')">
                                    {{ getMessage('job_type_scope') }}
                                </div>
                            </div>
                            <div class="mb-5 col-md-6 fv-row fv-plugins-icon-container">
                                <label class="form-label">Type</label>
                                <input type="text" class="form-control mb-2" v-model="form.type">
                                <div class="fv-plugins-message-container invalid-feedback" v-if="getStatus('type')">
                                    {{ getMessage('type') }}
                                </div>
                            </div>
                            <div class="mb-5 col-md-6 fv-row fv-plugins-icon-container">
                                <label class="form-label">Value</label>
                                <input type="text" class="form-control mb-2" v-model="form.value">
                                <div class="fv-plugins-message-container invalid-feedback" v-if="getStatus('value')">
                                    {{ getMessage('value') }}
                                </div>
                            </div>
                            <div class="mb-5 col-md-6 fv-row fv-plugins-icon-container">
                                <label class="form-label">Qty</label>
                                <input type="text" class="form-control mb-2" v-model="form.qty">
                                <div class="fv-plugins-message-container invalid-feedback" v-if="getStatus('qty')">
                                    {{ getMessage('qty') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <router-link to="/panel/vouchers" class="btn btn-light me-5">Batal</router-link>
                    <button v-if="!form_props.edit_mode" :disabled="form_props.is_loading" @click="createData"
                        class="btn btn-primary">
                        <span v-if="!form_props.is_loading">Tambah</span>
                        <span v-if="form_props.is_loading">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <button v-if="form_props.edit_mode" :disabled="form_props.is_loading" @click="editData"
                        class="btn btn-primary">
                        <span v-if="!form_props.is_loading">Simpan</span>
                        <span v-if="form_props.is_loading">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
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

export default {
    components: { Breadcrumb },
    setup() {
        const { postData, getData, patchData } = useAxios()
        const router = useRouter()
        const { setErrors, getStatus, getMessage, resetErrors } = useValidation()
        const route = useRoute()
        // Cek Mode
        const form_props = reactive({
            is_loading: false,
            errors: [],
            edit_mode: false,
        })

        const param_id = route.params.id
        form_props.edit_mode = param_id !== 'add'

        const title = form_props.edit_mode ? "Edit Voucher" : "Tambah Voucher"
        const breadcrumb_list = ["Voucher", form_props.edit_mode ? "Edit" : "Tambah"];

        const form = reactive({
            id: '',
            name: '',
            code: '',
            role: '',
            job_type_scope: '',
            type: '',
            value: '',
            qty: '',
            qty_rest: '',
            status: '',
        })

        if (form_props.edit_mode) {
            getData('vouchers/' + param_id)
                .then((data) => {
                    form.id = data.result.id
                    form.name = data.result.name
                    form.code = data.result.code
                    form.role = data.result.role
                    form.job_type_scope = data.result.job_type_scope
                    form.type = data.result.type
                    form.value = data.result.value
                    form.qty = data.result.qty
                    form.qty_rest = data.result.qty_rest
                    form.status = data.result.status
                })
        }

        function createData() {
            form_props.is_loading = true
            postData('vouchers', form).then((data) => {
                form_props.is_loading = false;
                if (data.success) {
                    router.push('/panel/vouchers')
                    resetErrors()
                } else {
                    setErrors(data.errors)
                }
            })
        }

        function editData() {
            form_props.is_loading = true
            patchData('vouchers/' + param_id, form).then((data) => {
                form_props.is_loading = false;
                if (data.success) {
                    router.push('/panel/vouchers')
                    resetErrors()
                } else {
                    setErrors(data.errors)
                }
            })
        }

        return {
            breadcrumb_list,
            title,
            form,
            form_props,
            createData,
            getStatus,
            getMessage,
            editData
        }
    }
}
</script>
