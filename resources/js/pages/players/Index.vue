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
                    <div class="btn btn-sm btn-secondary" @click="clearFilter">
                        Hapus Filter
                    </div>
                    <router-link to="/admin/players/add" class="btn btn-sm fw-bold btn-primary">
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
                                <label>Nama</label>
                                <input type="text" class="form-control" v-model="filter.name" @keyup.enter="loadDataContent">
                            </div>
                            <div class="col-md-3">
                                <label>Kota</label>
                                <input type="text" class="form-control" v-model="filter.city" @keyup.enter="loadDataContent">
                            </div>
                            <div class="col-md-3">
                                <label>Jenis Kel</label>
                                <select class="form-control" v-model="filter.gender" @change="loadDataContent">
                                    <option value="F">Perempuan</option>
                                    <option value="M">Laki-laki</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Status</label>
                                <select class="form-control" v-model="filter.status" @change="loadDataContent">
                                    <option value="1">Aktif</option>
                                    <option value="0">Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                                <Loading :active="is_loading" :loader="'dots'" :is-full-page="false" />
                                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                                    id="kt_ecommerce_products_table">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th>No</th>
                                            <th></th>
                                            <th>Nama</th>
                                            <th>Gender</th>
                                            <th>TTL</th>
                                            <th>Status</th>
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
                                            <td style="width: 80px;">
                                                <div v-if="data.image" class="bg-thumbnail"
                                                    :style="'width: 50px; height: 50px;background: url(' + data.image + ');'">
                                                </div>
                                            </td>
                                            <td>
                                                <b>{{ data.full_name }}</b>
                                                <br>
                                                <i>{{ data.city }}</i>
                                            </td>
                                            <td>
                                                {{ data.gender }}
                                            </td>
                                            <td>
                                                {{ data.birth_date }}
                                            </td>
                                            <td>
                                                <StatusDefault :status="data.status" />
                                            </td>
                                            <td class="text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-light dropdown-toggle btn-sm"
                                                        data-toggle="dropdown">
                                                        Aksi
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <router-link :to="'/admin/players/' + data.id"
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
import { reactive, ref } from "vue";
import { container, promptModal } from "jenesius-vue-modal";
import SwalToast from '../../src/swal_toast'
import { useFilterStore } from "../../src/store_filter";

export default {
    components: { Breadcrumb, PerPage, WidgetContainerModal: container, StatusDefault },
    setup() {
        const title = "Data Pemain"
        const breadcrumb_list = ["Pemain", "Data"];
        const { getData, deleteData } = useAxios()
        const is_loading = ref(true)
        const { app_store } = useFilterStore()

        const filter = reactive({
            page: 1,
            per_page: 25,
            name: '',
            status: '',
            city: '',
            gender: '',
        })

        function loadDataContent(page = 1) {
            is_loading.value = true
            filter.page = page
            getData('players', filter)
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
                deleteData('players/' + id)
                    .then((data) => {
                        SwalToast('Berhasil menghapus data.')
                        loadDataContent(filter.page)
                    })
            }
            
        }

        function clearFilter(){
                filter.name =  '',
                filter.status =  '',
                filter.city =  '',
                filter.gender =  '',

                loadDataContent()
            }

        return {
            breadcrumb_list,
            title,
            response,
            filter,
            is_loading,
            app_store,
            loadDataContent,
            changePerPage,
            deleteModal,
            clearFilter
        }
    }
}
</script>
