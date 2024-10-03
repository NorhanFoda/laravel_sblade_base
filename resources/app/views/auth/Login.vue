<script setup>
import { reactive } from "vue";
import { useAuthUserStore } from "@store/user";
import { useRouter } from 'vue-router'
import { ElMessage } from "element-plus";

const router = useRouter();
const loginForm = reactive({
    email: '',
    password: '',
});
let errors = reactive([]);

async function handleLogin() {
    useAuthUserStore().login(loginForm)
        .then(() => {
            router.push({
                path: '/dashboard'
            });
        })
        .catch((error) => {
            ElMessage({
                message: error.response.data.message,
                type: 'error',
            })
            errors.value = error.response.data.errors;
        });
}
</script>

<template>
    <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
        <div class="authForm mx-auto">
            <div class="text-center mb-2">
                <!-- <img :src="`${publicPath}/assets/images/logo.png`" class="header-brand-img" alt="logo"> -->
                LOGO
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center fs-20">{{ $t('global.sign_in_message') }}</h4>
                    <el-form label-position="top">
                        <div class="mb-3">
                            <form-input label="messages.email" type="email" :model="loginForm" name="email"
                                :errors="errors.value" />
                        </div>
                        <div class="mb-3">
                            <form-input label="messages.password" type="password" :model="loginForm" name="password"
                                :errors="errors.value" />
                        </div>
                        <button type="submit" @click.prevent="handleLogin" class="btn ripple btn-primary w-100">
                            {{ $t('global.sign_in') }}
                        </button>
                    </el-form>
<!--                    <div class="mt-3 text-center">-->
<!--                        <p class="mb-1"><a href="#">{{ $t('global.forget_password') }}?</a></p>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</template>
