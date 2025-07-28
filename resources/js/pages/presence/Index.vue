<template>
    <div class="d-flex flex-column flex-column-fluid py-3" style="min-height: calc(100vh - 130px)">
        <div class="app-content flex-column-fluid">
            <div class="app-container container-xxl">
                <div class="card card-flush">

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Nama.."
                                       @keyup.enter="loadDataContent()"
                                       v-model="presence_store.name">
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" v-model="presence_store.align">
                                    <option value="center">Rata Tengah</option>
                                    <option value="left">Rata Kiri</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" @change="loadEvent()"
                                        v-model="presence_store.section">
                                    <option value="">Semua</option>
                                    <option v-for="section in response.sections" :value="section.section">
                                        {{ section.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3 text-right">
                                <button class="btn btn-light btn-sm" @click="clearFilter()">Clear Filter</button>
                                <button class="btn btn-primary btn-sm" @click="loadDataContent()">Reload</button>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-2">
                            <div v-for="event in response.events" @click="selectEvent(event.id)"
                                 :class="presence_store.event_id === event.id ? 'bg-blue-600 text-white' : 'bg-slate-100'"
                                 class="rounded  p-2 text-center cursor-pointer hover:bg-slate-300">
                                {{ event.name }}
                            </div>
                        </div>
                        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                                <Loading :active="is_loading" :loader="'dots'" :is-full-page="false"/>
                                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                                    <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>Nama</th>
                                        <th>Event</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    <tr v-if="response.data_content.total === 0">
                                        <td colspan="5" class="text-center"><i>Tidak ada data.</i></td>
                                    </tr>
                                    <tr v-for="(data, d) in response.data_content.data">
                                        <td>
                                            {{
                                                response.data_content.per_page * (response.data_content.current_page
                                                    - 1) + d + 1
                                            }}
                                        </td>
                                        <td>
                                            {{ $filter.formatDateTime(data.created_at) }}
                                        </td>
                                        <td>
                                            <b>{{ data.user_name }}</b>
                                        </td>
                                        <td>
                        <span v-if="data.event">
                          {{ data.event.name }}
                        </span>
                                        </td>
                                        <td class="text-end">
                                            <a :href="'/print/event-presence/' + data.id + '?align=' + presence_store.align"
                                               target="_blank"
                                               class="btn btn-primary btn-sm">
                                                Print
                                            </a>
                                            <button class="btn btn-light btn-sm" @click="deletePresence(data.id)">
                                                Del
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div
                                    class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                                    <PerPage :value="presence_store.per_page" @change-per-page="changePerPage"/>
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
            <WidgetContainerModal/>
        </div>
    </div>
</template>
<script>
import Breadcrumb from "../../components/Breadcrumb";
import PerPage from '../../components/PerPage'
import StatusDefault from '../../components/StatusDefault'
import useAxios from "../../src/service";
import DeleteModal from "./DeleteModal"
import {reactive, ref} from "vue";
import {container, promptModal} from "jenesius-vue-modal";
import SwalToast from '../../src/swal_toast'
import {useFilterStore} from "../../src/store_filter";

export default {
    components: {Breadcrumb, PerPage, WidgetContainerModal: container, StatusDefault},
    setup() {
        const title = "Data Presence"
        const breadcrumb_list = ["Presence", "Data"];
        const {getData, deleteData} = useAxios()
        const is_loading = ref(true)
        const {presence_store, date_config} = useFilterStore()

        const response = reactive({
            data_content: {
                data: []
            },
            events: [],
            sections: []
        })

        function loadDataContent(page = 1) {
            is_loading.value = true
            presence_store.page = page

            getData('event-presence', presence_store).then((data) => {
                response.data_content = data
                is_loading.value = false
            }).catch(() => {
                is_loading.value = false
            })
        }

        function loadEvent() {
            getData('events', presence_store).then((data) => {
                response.events = data.data
            })
        }

        loadDataContent(presence_store.page)

        function changePerPage(per_page) {
            presence_store.per_page = per_page
            loadDataContent()
        }

        async function deleteModal(id) {
            const delete_modal = await promptModal(DeleteModal, {title: "Hapus data?"})
            if (delete_modal) {
                deleteData('transactions/' + id)
                    .then((data) => {
                        SwalToast('Berhasil menghapus data.')
                        loadDataContent(presence_store.page)
                    })
            }
        }

        function selectEvent(event_id) {
            presence_store.event_id = event_id
            loadDataContent()
        }

        function clearFilter() {
            presence_store.event_id = null
            presence_store.name = null
            loadDataContent()
        }

        function loadSection() {
            getData('sections').then((data) => {
                response.sections = data.result
            })
        }

        loadSection()

        loadEvent()

        function deletePresence(id) {
            if (confirm('Apakah anda yakin ingin menghapus data ini?')) {
                deleteData('event-presence/' + id)
                    .then((data) => {
                        SwalToast('Berhasil menghapus data.')
                        loadDataContent(presence_store.page)
                    })
            }
        }

        return {
            breadcrumb_list,
            title,
            response,
            is_loading,
            presence_store,
            loadDataContent,
            changePerPage,
            deleteModal,
            date_config,
            selectEvent,
            clearFilter,
            deleteData,
            deletePresence,
            loadEvent
        }
    }
}
</script>
<style>
input.field-input {
    height: 42px !important;
}
</style>
