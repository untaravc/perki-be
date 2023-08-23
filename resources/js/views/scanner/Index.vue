<template>
    <div>
        <div class="m-2">
            <div class="mb-2">
                <div class="block font-bold text-lg text-center">Admin</div>
                <select v-model="params.admin_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                    <option :value="adm.id" v-for="adm in admin">{{ adm.name }}</option>
                </select>
            </div>
            <div class="mb-2">
                <div class="block font-bold text-lg text-center">Event</div>
                <select v-model="params.event_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                    <option :value="event.id" v-for="event in events">{{ event.name }}</option>
                </select>
            </div>
        </div>
        <div class="m-2">
            <qrcode-scanner
                style="width: 100%"
                @result="onScan"
            />
        </div>
        <!--        <button @click="onScan('JCU23000136')">Test</button>-->

        <div id="showModal" tabindex="-1" aria-hidden="true"
             class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-3xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-3 border-b rounded-t">
                        <h3 class="text-lg font-semibold text-gray-900 lg:text-2xl">
                            Detail Transaksi
                        </h3>
                        <button type="button" @click="modal.hide()"
                                class="text-gray-400 bg-transparent text-sm p-1.5 ml-auto inline-flex items-center">
                            <unicon name="times"></unicon>
                        </button>
                    </div>
                    <div class="p-3">
                        <table>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{ transaction.user_name }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>Valid</td>
                            </tr>
                        </table>
                        <div class="text-center">
                            <button @click="postScan"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-nonetext-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none">
                                Presensi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            admin: [],
            modal: '',
            events: [],
            params: {
                code: '',
                admin_id: '',
                event_id: '',
            },
            transaction: {},
            transaction_details: {},
        }
    },
    methods: {
        onScan(decodedText) {
            this.params.code = decodedText

            this.apiGet("pub/scan-qrcode-event", this.params)
                .then((data) => {
                    if (data.status) {
                        this.transaction = data.result.transaction
                        this.transaction_details = data.result.transaction_details

                        this.modal.show();
                    } else {
                        alert(data.message)
                    }
                })
        },
        loadScannerParams() {
            this.apiGet("pub/scan-params")
                .then((data) => {
                    if (data.status) {
                        this.admin = data.result.admin
                        this.events = data.result.events
                    }
                })
        },
        postScan() {
            this.apiPost("pub/scan-qrcode-event", this.params)
                .then((data) => {
                    if (data.status) {
                        this.modal.hide();
                    } else {
                        alert(data.message)
                    }
                })
        }
    },
    mounted() {
        const $targetEl = document.getElementById('showModal');
        this.modal = new Modal($targetEl);
    },
    created() {
        this.loadScannerParams()
    }
}
</script>
<style>
#html5-qrcode-select-camera {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

#html5-qrcode-button-camera-start {
    margin: 20px !important;
    color: #fff;
    background-color: #28a745;
    border-color: #28a745;
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

#html5-qrcode-button-camera-stop {
    margin: 20px !important;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

#html5-qrcode-anchor-scan-type-change {
    display: none !important;
}

#qr-code-full-region__scan_region img {
    margin: auto;
}
</style>
