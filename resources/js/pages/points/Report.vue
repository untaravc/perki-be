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

      </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
      <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card card-flush">
          <div class="p-8">
            <div class="row">
              <div class="col-md-4">
                <label class="form-label">Kategori</label>
                <vue-select label="name" v-model="filter.player_category_code" :reduce="name => name.code"
                  :options="filter_props.player_categories"></vue-select>
              </div>
              <div class="col-md-4">
                <label class="form-label">.</label>
                <div>
                  <button class="btn btn-sm btn-primary" @click="loadDataContent">
                    <v-icon name="bi-search" />
                  </button>
                </div>
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
                      <th>Nama</th>
                      <th>Poin</th>
                      <th class="text-end">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="fw-semibold text-gray-600">
                    <tr v-if="response.result.length === 0">
                      <td colspan="6" class="text-center"><i>Tidak ada data.</i></td>
                    </tr>
                    <tr v-for="(data, d) in response.result">
                      <td>{{ d + 1 }}</td>
                      <td>
                        {{ data.player_name }}
                      </td>
                      <td>
                        <span v-if="data.points">{{ data.points }}</span>
                      </td>
                      <td class="text-end">
                        <div class="dropdown">
                          <button class="btn btn-light dropdown-toggle btn-sm" data-toggle="dropdown">
                            Aksi
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <!-- <router-link :to="'/admin/points/' + data.id" class="dropdown-item"> -->
                            Detail
                            <!-- </router-link> -->
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                  <PerPage :value="filter.limit" @change-per-page="changePerPage" />
                </div>

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
import PerPage from '../../components/PerPage'
import useAxios from "../../src/service";
import { reactive, ref } from "vue";
import { useFilterStore } from "../../src/store_filter";
import VueSelect from "vue-select";

export default {
  components: { Breadcrumb, PerPage, VueSelect },
  setup() {
    const title = "Report Point"
    const breadcrumb_list = ["Poin", "Report"];
    const { getData } = useAxios()
    const is_loading = ref(false)
    const { app_store } = useFilterStore()

    const filter = reactive({
      page: 1,
      name: '',
      limit: 25,
      player_category_code: '',
    })

    const filter_props = reactive({
      player_categories: []
    })

    function loadDataContent() {
      is_loading.value = true
      getData('point-reports', filter)
        .then((data) => {
          if (data.success) {
            response.result = data.result
          }
          is_loading.value = false
        })
    }

    loadDataContent()

    const response = reactive({
      result: []
    })

    function changePerPage(limit) {
      filter.limit = limit
      loadDataContent()
    }

    function loadCategoryList() {
      getData('categories-list', { type: 'player' })
        .then((data) => {
          filter_props.player_categories = data.result
        })
    }

    loadCategoryList()

    return {
      breadcrumb_list,
      title,
      response,
      filter,
      is_loading,
      app_store,
      filter_props,
      loadDataContent,
      changePerPage,
    }
  }
}
</script>
