<template>
    <div class="p-4 sm:ml-64">
        <div class="mt-14">
            <div class="text-2xl font-bold mb-3">Event Presence</div>
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
                name: '',
                event_id: '',
                scanner_id: '',
            }
        }
    },
    methods:{
        loadDataContent(page = 1){
            this.filters.page = page
            this.authGet('adm/event-presence', this.filters)
                .then((data)=>{
                    this.data_content = data
                })
        },
        applyFilter(filter){
            this.filters.status = filter.status
            this.filters.name = filter.name
            this.filters.event_id = filter.event_id
            this.filters.scanner_id = filter.scanner_id
            this.loadDataContent();
        },
        loadThisPage(){
            this.loadDataContent(this.filters.page);
        },
        reloadData(){
            if(this.filters.status == 100){
                this.loadDataContent()
            }
        }
    },
    created() {
        this.loadDataContent()

        setInterval(()=>{
            this.reloadData()
        }, 2000)
    },
}
</script>
