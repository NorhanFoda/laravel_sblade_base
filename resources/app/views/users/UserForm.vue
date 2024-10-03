<script setup>
import {ref, onMounted, getCurrentInstance, reactive} from "vue";
import UserApi from "@api/user.api";
import {useRoute, useRouter} from "vue-router";
import FilterApi from "@api/filter.api";
import {ElMessage} from "element-plus";
import {useLoaderStore} from "@store/loader";

const loaderStore = useLoaderStore();
const route = useRoute();
const router = useRouter();
const app = getCurrentInstance();
const t = app.appContext.config.globalProperties.$t;
let resource = ref({
    gender: 1,
    is_active: true,
    embed: "avatar,roles",
});
let isUpdateForm = ref(false);
let roles = ref([]);
const avatar_type = ref("user_avatar");
let errors = reactive([]);
const disabled = ref(false);

async function getResource() {
    if (!isUpdateForm.value) return;
    UserApi.get({id: route.params.id}, {embed: resource.value.embed})
        .then(({data}) => {
            resource.value = data.data;
        })
}

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
    if (isUpdateForm.value) {
        await update();
    } else {
        await save();
    }
}

async function save() {
    UserApi.store(resource.value)
        .then(({data}) => {
            ElMessage({
                message: t("messages.success_create"),
                type: "success",
            });
            router.push({
                path: "/users",
            });
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
        }).finally(() => {disabled.value = false})
}

async function update() {
    UserApi.update(resource.value)
        .then(({data}) => {
            ElMessage({
                message: t("messages.success_update"),
                type: "success",
            });
            router.push({
                path: "/users",
            });
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
        }).finally(() => {disabled.value = false})
}

async function getResourceRelatedModels() {
    FilterApi.modelFilters("User")
        .then(({data}) => {
            roles.value = data.roles;
        })
}

onMounted(async () => {
    isUpdateForm.value = !!route.params.id;
    await getResource();
    await getResourceRelatedModels();
});
</script>
<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.users" :active="false">
                <li class="breadcrumb-item active" aria-current="page">
                    {{ isUpdateForm ? $t("forms.edit") : $t("messages.add_new") }}
                </li>
            </page-header>

            <spinner v-if="loaderStore.loading"></spinner>
            <el-form label-position="top">
                <!-- Basic Info -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between flex-wrap pb-2 pt-2 mb-3 border-bottom">
                            <h6 class="fw-bold">
                                {{ $t("messages.basic_info") }}
                            </h6>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <FormInput label="messages.name" :model="resource" name="name"
                                           :errors="errors.value"/>
                            </div>
                            <div class="col-md-4">
                                <FormInput label="messages.email" :model="resource" name="email" type="email"
                                           :errors="errors.value"/>
                            </div>
                            <div class="col-md-4">
                                <FormSelect title="messages.role" :model="resource" name="role_id"
                                            label="name" :options="roles" :errors="errors.value"/>
                            </div>
                            <div class="col-md-4">
                                <FormInput label="forms.inputs.password" :model="resource" name="password" type="password"
                                           :errors="errors.value"/>
                            </div>
                            <div class="col-md-4">
                                <FormInput label="forms.inputs.password_confirmation" :model="resource"
                                           name="password_confirmation" type="password" :errors="errors.value"/>
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
                <el-button @click="submit" type="primary" class="btn btn-primary mb-4" :disabled="disabled">
                    {{ $t("messages.submit") }}
                </el-button>
            </el-form>
        </div>
    </div>
</template>

<style scoped></style>
