<template>
    <div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-3">No</th>
                <th scope="col" class="px-4 py-3">Title</th>
                <th scope="col" class="px-4 py-3">Category</th>
                <th scope="col" class="px-4 py-3" v-if="admin_type === 'admin'">Reviewer</th>
                <th scope="col" class="px-4 py-3">Status</th>
                <th scope="col" class="px-4 py-3">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody v-if="data_content.data">
            <tr class="border-b" v-for="(data, i) in data_content.data">
                <td class="px-4 py-3">
                    {{ (data_content.current_page - 1) * data_content.per_page + i + 1 }}
                </td>
                <td class="px-4 py-3">
                    <small> {{ data.created_at | formatDateTime }}</small>
                    <br>
                    {{ data.title }}
                    <br>
                    <b v-if="data.user">{{ data.user.name }}</b>
                </td>
                <td class="px-4 py-3">
                    {{ data.category }}
                </td>
                <td v-if="admin_type === 'admin'">
                    <select type="text" v-model="data.reviewer_id" @change="setReviewer(data, $event)"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        <option :value="rev.id" v-for="rev in data_raw.reviewers">{{ rev.name }}</option>
                    </select>
                </td>
                <td class="px-4 py-3">
                    {{ data.status_label }}
                </td>
                <td class="px-4 py-3 flex items-center justify-end">
                    <div class="dropdown relative group">
                        <button
                            class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                            type="button">
                            <unicon name="ellipsis-h"></unicon>
                        </button>
                        <div
                            class="dropdown-menu absolute block hidden group-hover:visible -left-32 z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="apple-imac-27-dropdown-button">
                                <li>
                                    <a :href="'/panel/print-abstract?post_id='+data.id+'&type=full_text'"
                                       target="_blank"
                                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        Show
                                    </a>
                                    <a href="#" @click="reviewModal(data)"
                                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        Review
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

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
                    <div class="p-6 space-y-6">
                        <div>
                            <b>Title</b>
                            <h5>{{ data_detail.title }}</h5>
                        </div>
                        <div v-for="body in data_detail.body_parsed">
                            <b>{{ body.title }}</b>
                            <p>{{ body.content }}</p>
                        </div>
                        <div>
                            <b>Attachment:</b>
                            <a :href="data_detail.file" target="_blank">{{ data_detail.file }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
export default {
    props: ['data_content'],
    data() {
        return {
            modal: '',
            admin_type: 'reviewer',
            data_detail: {},
            data_raw: {
                reviewers: [],
            },
            form: {
                post_id: '',
                score: '',
                status: '',
                comment: '',
            }
        }
    },
    methods: {
        setAdminType() {
            let type = localStorage.getItem('admin_type')

            if (!type) {
                setTimeout(() => {
                    this.setAdminType()
                }, 2000)
            } else {
                this.admin_type = type;
            }
        },
        loadReviewer() {
            this.authGet('adm/reviewer-list')
                .then((data) => {
                    this.data_raw.reviewers = data.result
                })
        },
        setReviewer(data, event) {
            let reviewer_id = event.target.value;
            this.authPost('adm/post-set-reviewer/' + data.id, {
                reviewer_id: reviewer_id
            }).then(() => {
                this.$parent.loadDataContent();
            })
        },
        reviewModal(data) {
            this.data_detail = data;
            this.modal.show()
        }
    },
    mounted() {
        const options = {
            placement: 'top-center',
            backdrop: 'static',
        };

        const $targetEl = document.getElementById('showModal');
        this.modal = new Modal($targetEl, options);
    },
    created() {
        this.setAdminType()
        this.loadReviewer()
    }
}
</script>
<style>
.dropdown:hover .dropdown-menu {
    display: block;
}
</style>
