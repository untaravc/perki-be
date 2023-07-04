<template>
    <div class="p-4 sm:ml-64">
        <div class="mt-14">
            <section class="bg-gray-50 dark:bg-gray-900">
                <div class="mx-auto max-w-screen-xl">
                    <div class="text-2xl font-semibold mb-3">
                        Users
                    </div>
                    <!-- Start coding here -->
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="overflow-x-auto" style="min-height: 600px;">
                            <Table :data_content="data_content"></Table>
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

import Table from "./Table";

export default {
    components: {Table},
    data(){
        return {
            data_content: {},
            filters:{
                page: 2,
                per_page: 10,
                s: '',
            }
        }
    },
    methods:{
        loadDataContent(page = 1){
            this.filters.page = page
            this.authGet('adm/users', this.filters)
                .then((data)=>{
                    this.data_content = data
                })
        }
    },
    created() {
        this.loadDataContent()
    },
}
</script>
