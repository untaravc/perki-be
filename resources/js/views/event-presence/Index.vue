<template>
    <div class="p-4 sm:ml-64">
        <div class="mt-14">
            <div class="text-2xl font-bold mb-3">Event Presence</div>
            <section class="bg-gray-50 dark:bg-gray-900">
                <div class="mx-auto max-w-screen-xl">
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="p-2 flex justify-content-end">
                            <div class="flex items-center">
                                <input checked id="checked-checkbox" type="checkbox" value="1" v-model="auto_print"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Auto Print
                                </label>
                            </div>
                        </div>
                        <div class="overflow-x-auto" style="min-height: 600px;">
                            <DataTable :data_content="data_content"></DataTable>
                        </div>
                        <nav
                            class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                            aria-label="Table navigation">
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                Showing
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ (data_content.current_page - 1) * data_content.per_page + 1 }}
                                    -
                                    {{ data_content.to }}
                                </span>
                                of
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ data_content.total }}
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
    data() {
        return {
            data_content: {},
            auto_print: false,
            filters: {
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
    methods: {
        async loadDataContent(page = 1) {
            this.filters.page = page
            await this.authGet('adm/event-presence', this.filters)
                .then((data) => {
                    this.data_content = data
                    this.autoPrint()
                })
        },
        autoPrint(){
            try {
                this.data_content.data.forEach(item => {
                    if (item.status === 100 && this.auto_print) {
                        window.open("http://src.perki-jogja.com/print/event-presence/" + item.id, '_blank');
                        console.log('PRINT', item.id)
                        this.updateData(item.id)
                        throw new Error("stop")
                    }
                })
            } catch (error) {
                console.log('done')
            }
        },
        applyFilter(filter) {
            this.filters.status = filter.status
            this.filters.name = filter.name
            this.filters.event_id = filter.event_id
            this.filters.scanner_id = filter.scanner_id
            this.loadDataContent();
        },
        reloadData() {
            if (this.auto_print) {
                this.loadDataContent()
            }
        },
        updateData(id) {
            this.authPatch('adm/event-presence/' + id, {
                status: 200
            })
        }
    },
    created() {
        setInterval(() => {
            this.reloadData()
        }, 5000)
    },
}
</script>
