<template>
    <div class="d-flex flex-column flex-column-fluid" style="min-height: calc(100vh - 130px)">
        <div class="app-toolbar py-3 py-lg-6">
            <div class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ title }}
                    </h1>
                    <Breadcrumb :list="breadcrumb_list"></Breadcrumb>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <router-link to="/panel/posts/add" class="btn btn-sm fw-bold btn-primary">
                        Tambah Data
                    </router-link>
                </div>
            </div>
        </div>
        <div class="app-content flex-column-fluid">
            <div class="app-container container-xxl">
                <div class="card card-flush">
                    <div class="py-6 px-8">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Title.."
                                    @keyup.enter="loadDataContent()" v-model="post_store.title">
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" @change="loadDataContent()" v-model="post_store.year">
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" @change="loadDataContent()" v-model="post_store.category">
                                    <option value="">Semua</option>
                                    <option value="case_report">Case Report</option>
                                    <option value="research">Research</option>
                                    <option value="systematic_review">Systematic Review</option>
                                    <option value="meta_analysis">Meta Analysis</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" @change="loadDataContent()" v-model="post_store.status">
                                    <option value="">Semua</option>
                                    <option value="0">Pending</option>
                                    <option value="1">Accepted</option>
                                    <option value="2">Reject</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                                <Loading :active="is_loading" :loader="'dots'" :is-full-page="false" />
                                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th>No</th>
                                            <th></th>
                                            <th>Judul</th>
                                            <th>Reviewer</th>
                                            <th>Status</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr v-if="response.data_content.total === 0">
                                            <td colspan="5" class="text-center"><i>Tidak ada data.</i></td>
                                        </tr>
                                        <tr v-for="(data, d) in response.data_content.data">
                                            <td>
                                                {{ response.data_content.per_page *
                                                    (response.data_content.current_page - 1) + d + 1 }}
                                            </td>
                                            <td>
                                                {{ data.image }}
                                                <img :src="data.image" style="max-width: 50px;" alt="">
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="text-sm bg-yellow-50 text-black px-2 py-1 rounded">
                                                        {{ data.category }}
                                                    </span>
                                                </div>
                                                {{ data.title }}
                                                <div>
                                                    <small>{{ $filter.formatDate(data.created_at) }}</small>
                                                </div>
                                            </td>
                                            <td style="min-width: 150px;">
                                                <select class="form-control" v-model="data.reviewer_id"
                                                    @change="setReviewer(data.id, $event)">
                                                    <option value="">unset</option>
                                                    <option :value="rev.id" v-for="rev in response.reviewers">{{
                                                        rev.name }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="text-center h4">{{ data.score }}</div>
                                                <span v-if="data.status === 0"
                                                    class="rounded px-2 py-1 bg-slate-500 text-sm text-white">pending</span>
                                                <span v-if="data.status === 1"
                                                    class="rounded px-2 py-1 bg-green-500 text-sm text-white">accepted</span>
                                                <span v-if="data.status === 2"
                                                    class="rounded px-2 py-1 bg-red-500 text-sm text-white">reject</span>
                                            </td>
                                            <td class="text-end">
                                                <router-link :to="'/panel/posts/' + data.id + '/view'"
                                                    class="btn btn-light btn-sm">
                                                    Proses
                                                </router-link>
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
import { reactive, ref } from "vue";
import { container, promptModal } from "jenesius-vue-modal";
import SwalToast from '../../src/swal_toast'
import { useFilterStore } from "../../src/store_filter";

export default {
    components: { Breadcrumb, PerPage, WidgetContainerModal: container, StatusDefault },
    setup() {
        const title = "Data Post"
        const breadcrumb_list = ["Post", "Data"];
        const { getData, deleteData, postData } = useAxios()
        const is_loading = ref(true)
        const { app_store, post_store } = useFilterStore()

        const filter = reactive({
            page: 1,
            name: '',
            per_page: 25,
        })

        function loadDataContent(page = 1) {
            is_loading.value = true
            filter.page = page
            getData('posts', post_store)
                .then((data) => {
                    if (data.success) {
                        response.data_content = data
                    }
                    is_loading.value = false
                })
        }

        loadDataContent()

        const response = reactive({
            data_content: {
                data: [],
            },
            reviewers: []
        })

        function changePerPage(per_page) {
            filter.per_page = per_page
            loadDataContent()
        }

        async function deleteModal(id) {
            const delete_modal = await promptModal(DeleteModal, { title: "Hapus data?" })
            if (delete_modal) {
                deleteData('posts/' + id)
                    .then((data) => {
                        SwalToast('Berhasil menghapus data.')
                        loadDataContent(filter.page)
                    })
            }
        }

        function loadReviewer() {
            getData('reviewer-list')
                .then((data) => {
                    if (data.success) {
                        response.reviewers = data.result
                    }
                })
        }

        loadReviewer()

        function setReviewer(id, event) {
            let reviewer_id = event.target.value

            postData('post-set-reviewer/' + id, {
                reviewer_id: reviewer_id
            }).then((data) => {
                if (data.success) {
                    SwalToast('Berhasil set reviewer')
                }
            })
        }

        return {
            breadcrumb_list,
            title,
            response,
            filter,
            is_loading,
            app_store,
            post_store,
            loadDataContent,
            changePerPage,
            deleteModal,
            setReviewer
        }
    }
}
</script>
