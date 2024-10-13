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
      <div class="flex items-center mb-4">
        <div class="p-4 bg-blue-300 rounded-lg mr-4" @click="event_id = ''">
          <v-icon name="bi-arrow-left" />
        </div>
        <div class="text-3xl font-semibold">Scanner</div>
      </div>
      <div v-if="is_open" class="m max-w-lg mx-auto">
        <div>
          <qrcode-stream :constraints="selectedConstraint" @detect="onDetect"></qrcode-stream>
        </div>
        <div>
          <div class="bg-blue-200 my-4 p-4 text-lg text-center">
            <b>{{ event_data.name }}</b>
            <br>
            <small>
              {{ $filter.truncate(event_data.title, 30) }}
            </small>
          </div>
        </div>
        <div v-if="error_msg !== ''">
          <div class="bg-red-600 text-white my-4 p-4 text-lg text-center">
            {{ error_msg }}
          </div>
        </div>
        <div v-if="transaction && transaction.user_name">
          <div class="bg-green-600 text-white my-4 p-4 text-lg text-center">
            <b>QR CODE VALID</b>
            <br>
            <div>{{ transaction.number }}</div>
            <div class="test-semibold">{{ transaction.user_name }}</div>
            <div>{{ transaction_detail.event_name }}</div>
          </div>
        </div>
        <div class="grid grid-cols-2">
          <button class="bg-slate-300 my-4 p-4 text-lg text-center w-full rounded-lg m-1" @click="qrClear">
            <b>Clear</b>
          </button>
          <button v-if="transaction && transaction.user_name"
            class="bg-green-300  my-4 p-4 text-lg text-center w-full rounded-lg m-1" @click="doPresence">
            <b>CONFIRM</b>
          </button>
        </div>
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
      transaction_detail: {},
      selectedConstraint: { label: 'rear camera', constraints: { facingMode: 'environment' } }
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
          console.log(this.events)
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
    }
  },
  created() {
    this.loadEvent()
  }
}
</script>