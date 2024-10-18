<template>
  <div class="p-4">
    <div v-if="event_id === ''">
      <div class="flex items-center">
        <div class="p-4 bg-blue-300 rounded-lg mr-4">
          <v-icon name="bi-columns-gap" />
        </div>
        <div class="text-3xl font-semibold">Pilih Event</div>
      </div>
      <div v-for="event in events" @click="selectEvent(event)"
        class="bg-blue-200 my-4 p-4 rounded-lg text-lg text-center">
        <b>{{ event.name }}</b>
        <br>
        <small>
          {{ event.title }}
        </small>
      </div>
    </div>
    <div v-if="event_id > 0">
      <!-- <div class="flex items-center mb-4">
        <div class="p-4 bg-blue-300 rounded-lg mr-4" @click="event_id = ''">
          <v-icon name="bi-arrow-left" />
        </div>
        <div class="text-3xl font-semibold">Scanner</div>
      </div> -->
      <div v-if="is_open" class="m max-w-lg mx-auto">
        <div class="flex">
          <div class="text-2xl font-semibold">Cam:</div>
          <select v-model="selectedConstraint"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full h-12 p-2">
            <option v-for="option in constraintOptions" :key="option.label" :value="option.constraints">
              {{ option.label }}
            </option>
          </select>
        </div>
      </div>
      <div>
        <div class="bg-blue-200 my-4 p-4 text-lg text-center">
          <b>{{ event_data.name }} : </b>
          <small>
            {{ $filter.truncate(event_data.title, 30) }}
          </small>
        </div>
      </div>
      <div>
        <qrcode-stream :constraints="selectedConstraint" @detect="onDetect"></qrcode-stream>
      </div>

      <div v-if="error_msg !== ''">
        <div class="bg-red-600 text-white my-4 p-4 text-lg text-center">
          {{ error_msg }}
        </div>
      </div>
      <div v-if="transaction && transaction.user_name" class="my-4">
        <div class="bg-yellow-300 p-4 text-center" v-if="has_print !== null">
          <b>Telah Cetak Name Tag</b>
        </div>
        <div class="bg-green-600 text-white p-4 text-lg text-center">
          <b>QR CODE VALID</b>
          <br>
          <div>{{ transaction.number }}</div>
          <div class="test-semibold">{{ transaction.user_name }}</div>
          <div>{{ transaction_detail.event_name }}</div>
        </div>
      </div>
      <div class="grid grid-cols-6 gap-2">
        <button class="bg-slate-300 my-4 p-4 text-lg text-center w-full rounded-lg m-1 col-span-3" @click="qrClear">
          <b>Clear</b>
        </button>
        <button v-if="transaction && transaction.user_name"
          class="bg-green-300  my-4 p-4 text-lg text-center w-full rounded-lg m-1 col-span-3" @click="doPresence">
          <b>CONFIRM</b>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { QrcodeStream } from 'vue-qrcode-reader'
import axios from 'axios'
import Swal from "../../src/swal_toast"
export default {
  components: { QrcodeStream },
  data() {
    return {
      is_open: false,
      event_id: '',
      code: '',
      event_data: {},
      events: [],
      error_msg: '',
      transaction: {},
      has_print: null,
      transaction_detail: {},
      constrains: [
        'user',
        'environment'
      ],
      selectedConstraintId: 0,
      selectedConstraint: 'user',
      constraintOptions: [
        { label: 'rear camera', constraints: { facingMode: 'environment' } },
        { label: 'front camera', constraints: { facingMode: 'user' } }
      ]
    }
  },
  methods: {
    checkEvent(code) {
      this.code = code
      axios.get('api/pub/scan-qrcode-event', {
        params: {
          code: code,
          event_id: this.event_id
        }
      }).then(({ data }) => {
        if (data.success) {
          this.transaction = data.result.transaction
          this.transaction_detail = data.result.transaction_detail
          this.has_print = data.result.has_print
        } else {
          this.error_msg = data.message
        }
      })
    },
    onDetect(detectedCodes) {
      const value = detectedCodes[0].rawValue
      this.checkEvent(value)
    },
    loadEvent() {
      axios.get('api/pub/scan-events')
        .then(({ data }) => {
          this.events = data.data
        })
    },
    selectEvent(event) {
      this.event_id = event.id
      this.event_data = event

      this.is_open = true
    },
    qrClear() {
      this.error_msg = ''
      this.is_open = false
      this.has_print = null

      setTimeout(() => {
        this.is_open = true
      }, 500)

      this.transaction = {}
      this.transaction_detail = {}
    },
    doPresence() {
      axios.post('api/pub/scan-qrcode-event', {
        code: this.code,
        event_id: this.event_id,
      })
        .then(({ data }) => {
          Swal("Berasil Scan QR")
          this.qrClear()
        })
    },
    changeCam() {
      if (this.selectedConstraintId === 0) {
        this.selectedConstraintId = 1
        this.selectedConstraint = this.constrains[1]
      } else {
        this.selectedConstraintId = 0
        this.selectedConstraint = this.constrains[0]
      }
      alert(this.selectedConstraint)
    },
    async onCameraReady() {
      const devices = await navigator.mediaDevices.enumerateDevices()
      const videoDevices = devices.filter(({ kind }) => kind === 'videoinput')
      const defaultConstraintOptions = [
        { label: 'rear camera', constraints: { facingMode: 'environment' } },
        { label: 'front camera', constraints: { facingMode: 'user' } }
      ]

      this.constraintOptions = [
        // ...defaultConstraintOptions,
        ...videoDevices.map(({ deviceId, label }) => ({
          label: `${label}`,
          constraints: { deviceId }
        }))
      ]

      console.log(videoDevices)
    }

  },
  created() {
    this.loadEvent()
    this.onCameraReady()
  }
}
</script>