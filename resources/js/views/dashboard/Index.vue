<template>
    <div class="p-4 sm:ml-64">
        <div class="px-4 pt-16 py-6">
            <div class="grid grid-cols-12 gap-2">
                <div class="grid-cols-2 col-span-5 grid gap-2">
                    <div class="bg-white rounded-lg p-4 min-h-100px">
                        <div class="flex mb-2">
                            <div class="bg-yellow-300 rounded-lg flex justify-center items-center  p-3 inline-block">
                                <unicon name="bell" width="20px" height="20px"></unicon>
                            </div>
                        </div>
                        <div class="font-bold">
                            Transaksi Berhasil
                        </div>
                        <div class="text-lg font-bold ">
                            100
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 min-h-100px">
                        <div class="flex mb-2">
                            <div class="bg-yellow-300 rounded-lg flex justify-center items-center  p-3 inline-block">
                                <unicon name="bell" width="20px" height="20px"></unicon>
                            </div>
                        </div>
                        <div class="font-bold">
                            Total Pendapatan
                        </div>
                        <div class="text-lg font-bold ">
                            100
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 min-h-100px">
                        <div class="flex mb-2">
                            <div class="bg-yellow-300 rounded-lg flex justify-center items-center  p-3 inline-block">
                                <unicon name="bell" width="20px" height="20px"></unicon>
                            </div>
                        </div>
                        <div>
                            Peserta Total
                        </div>
                        <div class="text-lg font-bold">
                            100
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 min-h-100px">
                        <div class="flex mb-2">
                            <div class="bg-yellow-300 rounded-lg flex justify-center items-center  p-3 inline-block">
                                <unicon name="bell" width="20px" height="20px"></unicon>
                            </div>
                        </div>
                        <div class="font-bold">
                            Peserta Aktif
                        </div>
                        <div class="text-lg font-bold">
                            100
                        </div>
                    </div>
                </div>
                <div class="col-span-7">
                    <div class="bg-white rounded-xl p-2" >
                        chart
                    </div>
                </div>
                <div class="col-span-8">
                    <div class="bg-white rounded-xl p-2" >
                        Event Group
                    </div>
                </div>
                <div class="col-span-4">
                    <div class="bg-white rounded-xl p-2" >
                        User Group
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
            stat: {
                speakers: 0,
                member: 0,
                transaction_success: 0,
                transaction_pending: 0,
            },
            member: [],
            chart: {},
        }
    },
    methods: {
        loadStat() {
            this.authGet('adm/dashboard-stat')
                .then((data)=>{
                    this.stat = data.result.stat
                    this.member = data.result.member
                })
        },
        loadChart() {
            this.authGet('adm/dashboard-chart')
        },
        loadEventPurchase() {
            this.authGet('adm/dashboard-event-purchase')
        },
    },
    created() {
        loadStat() {
            this.authGet('adm/dashboard-stat')
        },
    }
}
</script>
