<template>
    <div class="p-4 sm:ml-64">
        <div class="mt-14">
            <div class="text-2xl font-bold mb-3">Transaksi</div>
            <section class="bg-gray-50 dark:bg-gray-900">
                <div class="mx-auto max-w-screen-xl">
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="overflow-x-auto" style="min-height: 600px;">
                            <DataTable :data_content="data_content"></DataTable>
                        </div>
                        <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                            aria-label="Table navigation">
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                Showing
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{(data_content.current_page - 1) * data_content.per_page + 1}}
                                    -
                                    {{data_content.to}}
                                </span>
                                of
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{data_content.total}}
                                </span>
                            </span>
                            <div>
                                <pagination :data="data_content" :limit="2"
                                            @pagination-change-page="loadDataContent"></pagination>
                            </div>
                        </nav>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>
<script>

import DataTable from "./Table";

export default {
    components: {DataTable},
    data(){
        return {
            data_content: {},
            filters:{
                page: 1,
                per_page: 10,
                s: '',
                status: '',
                id:'',
                job_type_code:'',
            }
        }
    },
    methods:{
        loadDataContent(page = 1){
            this.filters.page = page
            this.getUrlQuery()
            this.authGet('adm/transactions', this.filters)
                .then((data)=>{
                    this.data_content = data
                    Fire.$emit('reload-sidebar-label')
                })
        },
        applyFilter(filter){
            this.filters.status = filter.status
            this.filters.s = filter.name
            this.filters.job_type_code = filter.job_type_code
            this.loadDataContent();
        },
        loadThisPage(){
            this.loadDataContent(this.filters.page);
        },
        getUrlQuery(){
            let id = this.$route.query.id
            if(id){
                this.filters.id = id
            }
        }
    },
    created() {
        this.loadDataContent()
    },
}
</script>
