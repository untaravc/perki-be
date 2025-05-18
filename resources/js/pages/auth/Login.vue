<template>
    <div class="d-flex flex-column flex-lg-row flex-column-fluid bg-center bg-cover bg-no-repeat"
         style="background-image: url('https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2Fbg_login_page.jpg?alt=media&token=98c8f5b5-b5d2-4af4-b739-c9504bdacf78')">
        <!--begin::Aside-->
        <div class="d-flex flex-lg-row-fluid">

        </div>
        <!--begin::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
            <!--begin::Wrapper-->
            <div class="bg-body d-flex flex-center rounded-4 w-md-600px p-10">
                <!--begin::Content-->
                <div class="w-md-400px">
                    <!--begin::Form-->
                    <div class="flex justify-center">
                        <img src="https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2Flogo-perki-jogja.png?alt=media&token=81d230eb-a9f6-4649-bbad-18b60eb24a26"
                             style="max-height: 100px" alt="">
                    </div>
                    <!--begin::Separator-->
                    <div class="text-center mt-10 mb-4 fw-semibold fs-7">Sign In to Panel</div>
                    <!--end::Separator-->
                    <form>
                        <!--begin::Input group=-->
                        <div class="fv-row mb-8">
                            <!--begin::Email-->
                            <input type="text" placeholder="username" autocomplete="new-password"
                                v-model="credential.email" class="form-control bg-transparent" />
                            <!--end::Email-->
                        </div>
                        <!--end::Input group=-->

                        <div class="fv-row mb-8">
                            <!--begin::Password-->
                            <input type="password" placeholder="Password" name="password" autocomplete="new-password"
                                v-model="credential.password" @keyup.enter="doLogin"
                                class="form-control bg-transparent" />
                            <!--end::Password-->
                        </div>
                    </form>
                    <!--end::Input group=-->
                    <!--begin::Submit button-->
                    <div class="d-grid mb-10">
                        <button @click="doLogin" id="kt_sign_in_submit" class="btn btn-primary">
                            <span v-if="!credential.is_loading">Sign In</span>
                            <span v-if="credential.is_loading">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Submit button-->
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Body-->
    </div>
</template>
<script>
import { reactive } from 'vue'
import useAxios from '../../src/service'

export default {
    setup() {
        const credential = reactive({
            email: '',
            password: '',
            is_loading: false,
        })

        const { postData } = useAxios();

        function doLogin() {
            credential.is_loading = true
            postData('login', {
                email: credential.email,
                password: credential.password
            }).then((data) => {
                credential.is_loading = false
                if (data.success) {
                    localStorage.setItem('user_token', data.result.token)
                    localStorage.setItem('user_id', data.result.user.id)
                    window.location = '/panel/dashboard'
                } else {
                    alert('Email atau password salah!')
                }
            })
        }

        return {
            credential,
            doLogin
        }
    }
}

</script>
