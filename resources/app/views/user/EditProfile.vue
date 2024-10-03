<script setup>
import UserApi from '@api/user.api';
import {useAuthUserStore} from "@store/user.js";
import {getCurrentInstance, reactive, ref} from "vue";
import {ElMessage} from "element-plus";

const app = getCurrentInstance();
const t = app.appContext.config.globalProperties.$t;
const resource = ref(useAuthUserStore().getUserData);
let errors = reactive([]);
const disabled = ref(false);
const avatar_type = ref("user_avatar");

async function successUpload(data) {
    resource.value.avatar = data;
    resource.value[data.type] = data.id;
}

async function successDeleteUpload(data) {
    resource.value.avatar = null;
    resource.value[data.type] = null;
}

async function submit() {
    disabled.value = true;
    UserApi.update(resource.value)
        .then(resp => {
            useAuthUserStore().setUserData(resp.data.data)
            ElMessage({
                message: t("messages.success_update"),
                type: "success",
            });
        })
        .catch(error => {
            errors.value = error.response.data.errors
        });
    disabled.value = false;
}


</script>

<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.profile" :active="false">
                <li class="breadcrumb-item active" aria-current="page">{{ $t('messages.edit_profile') }}</li>
            </page-header>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-header rounded-bottom-0 my-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <FormInput label="messages.name" :model="resource" name="name"
                                                   :errors="errors.value"/>
                                    </div>
                                    <div class="col-md-4">
                                        <FormInput label="messages.email" :model="resource" name="email" type="email"
                                                   :errors="errors.value"/>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="mb-2">{{$t("messages.profile_photo") }}</label>
                                        <FormFileUpload :type="avatar_type" @successUpload="successUpload" :limit="1"
                                                        @successDeleteUpload="successDeleteUpload" :multiple="true"
                                                        :files="resource.avatar ? [resource.avatar] : []"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <el-button @click="submit" type="primary" class="btn btn-primary mb-4" :disabled="disabled">
                        {{ $t("messages.submit") }}
                    </el-button>
                </div>
            </div>
        </div>
    </div>
</template>
