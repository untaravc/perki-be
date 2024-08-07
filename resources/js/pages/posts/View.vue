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
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
          <div class="card card-flush" v-if="form_props.data_detail">
            <div class="card-body">
              <div class="text-lg">
                [{{ form_props.data_detail.abstract_number }}] <b>{{ form_props.data_detail.title
                  }}</b>
              </div>
              <div>{{ form_props.data_detail.category }}</div>
              <div class="italic mb-4">
                Keyword: {{ form_props.data_detail.subtitle }}
              </div>
              <div class="mb-2" v-for="body in form_props.data_detail.body_parsed">
                <b>{{ body.title }}</b> {{ body.content }}
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

    const form_props = reactive({
      is_loading: false,
      edit_mode: false,
      data_detail: {}
    })

    const param_id = route.params.id
    form_props.edit_mode = param_id !== 'add'

    const title = form_props.edit_mode ? "View Post" : "Tambah Post"
    const breadcrumb_list = ["Post", form_props.edit_mode ? "Edit" : "Tambah"];

    function loadData() {
      getData('posts/' + param_id)
        .then((data) => {
          form_props.data_detail = data.result;
        })
    }

    loadData()

    return {
      breadcrumb_list,
      title,
      form_props
    }
  }
}
</script>