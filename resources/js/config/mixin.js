import axios from 'axios'
const mixin = {
    data() {
        return {
            base_api: '',
            logged_in: false,
            page_loader_config: {
                loader: 'bars',
                canCancel: false,
                isFullPage: false,
                color: '#009ef7',
                backgroundColor: '#fff',
                opacity: 0.5,
                blur: '0px'
            },
            default_form: {},
            today_date: new Date().toJSON().slice(0, 10),
            setup_filter: 0,
            money_config: {
                decimal: ",",
                thousands: ".",
                disableNegative: true,
                precision: 0,
            },
            data_config: {
                formatted: 'll',
                onlyDate: true,
                inputSize: 'lg',
            }
        }
    },
    created: function () {
        this.base_api = '/api/'
    },
    methods: {
        async apiGet(uri, params) {
            let response = '';
            await this.$axios.get(this.base_api + uri, {
                params: params,
            }).then(({data}) => {
                response = data;
            }).catch((e) => {
                let rc = e.response.status;
                if (rc === 401) {
                    window.location = '/login'
                }
            })

            return response;
        },
        async apiPost(uri, data = {}) {
            let response = '';
            await axios.post(this.base_api + uri, data, {})
                .then(({data}) => {
                    response = data;
                }).catch((e) => {
                    let rc = e.response.message;
                })

            return response;
        },
        async authGet(uri, params) {
            let response = '';
            let token = localStorage.getItem('admin_token')
            await axios.get(this.base_api + uri, {
                params: params,
                headers: {
                    Authorization: 'Bearer ' + token,
                    Accept: "application/json",
                    "access-control-allow-origin": "*"
                },
            }).then(({data}) => {
                if (data.code === 401) {
                    window.location = '/panel/login'
                } else{
                    response = data;
                }
            }).catch((e) => {
                let rc = e.response.status;
                if (rc === 401) {
                    window.location = '/panel/login'
                } else if (rc === 422) {
                    response.status = false;
                    response.errors = '';
                }
            })

            return response;
        },
        async authPost(uri, data) {
            let response = {};
            let token = localStorage.getItem('admin_token')
            await axios.post(this.base_api + uri, data, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then(({data}) => {
                response = data;
            }).catch((e) => {
                let rc = e.response.status;
                if (rc === 401) {
                    window.location = '/login'
                } else if (rc === 422) {
                    response = e.response.data
                }
                return response;
            })

            return response;
        },
        async authPatch(uri, data) {
            let patchData = Object.assign({}, data)

            let response = '';
            let token = localStorage.getItem('admin_token')
            await axios.patch(this.base_api + uri, patchData, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then(({data}) => {
                response = data;
            }).catch((e) => {
                let rc = e.response.status;
                if (rc === 401) {
                    window.location = '/login'
                } else if (rc === 422) {
                    response = e.response.data
                }
            })

            return response;
        },
        async authDelete(uri, data) {
            let response = '';
            let deleteData = Object.assign({}, data)
            let token = localStorage.getItem('admin_token')
            await axios.delete(this.base_api + uri, {
                headers: {
                    Authorization: 'Bearer ' + token
                },
                data: deleteData
            }).then(({data}) => {
                response = data;
            }).catch((e) => {
                let rc = e.response.status;
                if (rc === 401) {
                    window.location = '/login'
                } else if (rc === 422) {
                    response.status = false;
                    response.errors = '';
                }
            })

            return response;
        },
        setHeader() {
            let ls_token = localStorage.user_token
            return {
                headers: {
                    Authorization: 'Bearer ' + ls_token,
                    Accept: 'application/json'
                }
            }
        },
    }
}

export default mixin;
