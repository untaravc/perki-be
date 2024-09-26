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
              <div class="mb-4" v-for="body in form_props.data_detail.body_parsed">
                <b>{{ body.title }}</b> {{ body.content }}
              </div>
              <div v-if="form_props.data_detail.image">
                <img :src="form_props.data_detail.image" alt="">
              </div>
              <hr>
              <div class="h3 mt-4 mb-2">Review</div>
              <div class="row mb-4">
                <div class="col-md-6">
                  <table class="table">
                    <tr>
                      <td>Parameters</td>
                      <td>Score</td>
                    </tr>
                    <tr>
                      <td><b>Introduction (10)</b></td>
                      <td>
                        <input type="number" class="form-control mb-2" min="0" max="10" @change="calculateScore"
                          v-model="form_props.data_detail.scores.first_score">
                      </td>
                    </tr>
                    <tr>
                      <td><b>Materials and Methods (10)</b></td>
                      <td>
                        <input type="number" class="form-control mb-2" min="0" max="10" @change="calculateScore"
                          v-model="form_props.data_detail.scores.second_score">
                      </td>
                    </tr>
                    <tr>
                      <td><b>Research Findings / Results (15)</b></td>
                      <td>
                        <input type="number" class="form-control mb-2" min="0" max="15" @change="calculateScore"
                          v-model="form_props.data_detail.scores.third_score">
                      </td>
                    </tr>
                    <tr>
                      <td><b>Depth of Research (15)</b></td>
                      <td>
                        <input type="number" class="form-control mb-2" min="0" max="15" @change="calculateScore"
                          v-model="form_props.data_detail.scores.fourth_score">
                      </td>
                    </tr>
                    <tr>
                      <td><b>Relevance of Research to Clinical Situation (15)</b></td>
                      <td>
                        <input type="number" class="form-control mb-2" min="0" max="15" @change="calculateScore"
                          v-model="form_props.data_detail.scores.fifth_score">
                      </td>
                    </tr>
                    <tr>
                      <td><b>Novelty (10)</b></td>
                      <td>
                        <input type="number" class="form-control mb-2" min="0" max="10" @change="calculateScore"
                          v-model="form_props.data_detail.scores.sixth_score">
                      </td>
                    </tr>
                    <tr>
                      <td><b>Originality (15)</b></td>
                      <td>
                        <input type="number" class="form-control mb-2" min="0" max="15" @change="calculateScore"
                          v-model="form_props.data_detail.scores.seventh_score">
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-6">
                      <label>Skor</label>
                      <div class="text-xl font-semibold">
                        {{ form_props.data_detail.score }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label>Status</label>
                      <select class="form-control" v-model="form_props.data_detail.status">
                        <option value="0">Pending</option>
                        <option value="1">Accepted</option>
                        <option value="2">Reject</option>
                      </select>
                    </div>
                    <div class="col-md-12">
                      <label>Komentar</label>
                      <textarea class="form-control" v-model="form_props.data_detail.comment" cols="30"
                        rows="5"></textarea>
                    </div>
                  </div>
                </div>

              </div>
              <div class="text-right">
                <router-link to="/panel/posts" class="btn btn-sm bg-secondary m-1">
                  Batal
                </router-link>
                <button class="btn btn-sm bg-success m-1" @click="processAbstract()">
                  Simpan Review
                </button>
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
import VueSelect from "vue-select";

export default {
  components: { Breadcrumb, VueSelect },
  setup() {
    const { getData, patchData } = useAxios()
    const router = useRouter()
    const { setErrors, getStatus, getMessage, resetErrors } = useValidation()
    const route = useRoute()

    const form_props = reactive({
      is_loading: false,
      edit_mode: false,
      data_detail: {
        id: '',
        abstract_number: '',
        title: '',
        subtitle: '',
        body_parsed: '',
        image: '',
        status: '',
        comment: '',
        score: '',
        scores: {
          first_score: '',
          second_score: '',
          third_score: '',
          fourth_score: '',
          fifth_score: '',
          sixth_score: '',
          seventh_score: '',
        }
      }
    })

    const param_id = route.params.id
    form_props.edit_mode = param_id !== 'add'

    const title = form_props.edit_mode ? "View Post" : "Tambah Post"
    const breadcrumb_list = ["Post", form_props.edit_mode ? "Edit" : "Tambah"];

    function loadData() {
      getData('posts/' + param_id)
        .then((data) => {
          form_props.data_detail.id = data.result.id;
          form_props.data_detail.abstract_number = data.result.abstract_number;
          form_props.data_detail.title = data.result.title;
          form_props.data_detail.subtitle = data.result.subtitle;
          form_props.data_detail.body_parsed = data.result.body_parsed;
          form_props.data_detail.image = data.result.image;
          form_props.data_detail.status = data.result.status;
          form_props.data_detail.comment = data.result.comment;
          form_props.data_detail.score = data.result.score;
          if (data.result.scores) {
            form_props.data_detail.scores = data.result.scores;
          }
        })
    }

    loadData()

    function calculateScore() {
      let total = 0
      total += form_props.data_detail.scores.first_score
      total += form_props.data_detail.scores.second_score
      total += form_props.data_detail.scores.third_score
      total += form_props.data_detail.scores.fourth_score
      total += form_props.data_detail.scores.fifth_score
      total += form_props.data_detail.scores.sixth_score
      total += form_props.data_detail.scores.seventh_score

      form_props.data_detail.score = total
    }

    function processAbstract() {
      form_props.is_loading = true
      patchData('posts/' + param_id, form_props.data_detail).then((data) => {
        form_props.is_loading = false;
        if (data.success) {
          router.push('/panel/posts')
          resetErrors()
        } else {
          setErrors(data.errors)
        }
      })
    }

    return {
      breadcrumb_list,
      title,
      form_props,
      processAbstract,
      calculateScore
    }
  }
}
</script>