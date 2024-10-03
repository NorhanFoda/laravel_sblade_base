<script setup>
import {getCurrentInstance, onMounted, reactive, ref} from "vue";
import RoleApi from "@api/role.api";
import PermissionApi from "@api/permission.api";
import PermissionCard from "./PermissionCard.vue";
import {useRouter, useRoute} from "vue-router";
import FormInput from "@components/form/FormInput.vue";
import {ElMessage} from "element-plus";

const app = getCurrentInstance();
const t = app.appContext.config.globalProperties.$t;
const redirectRouter = useRouter();
const route = useRoute();
const isUpdateForm = !!route.params?.id;
let errors = reactive([]);
const disabled = ref(false);

let isReadonly = ref(false);
let form = reactive({
    name: "",
    role_permissions: {},
});
let resource = ref({});
let system_permissions = ref([]);

const getRole = async () => {
    await RoleApi.get({id: route.params.id}).then(({data}) => {
        resource.value = data.data;
        Object.assign(form, resource.value);
        if (resource.value.id === 1 || route.name === "role-show") isReadonly.value = true;
    });
};

const getSystemPermissions = async () => {
    await PermissionApi.list().then(({data}) => {
        system_permissions.value = data;
    });
};

const submit = async () => {
    disabled.value = true;
    if (isUpdateForm) {
        await update();
    } else {
        await save();
    }
};

async function save() {
    RoleApi.store(form)
        .then(() => {
            ElMessage({
                message: t('messages.success_create'),
                type: "success",
            });
            redirectRouter.push({name: "roles"});
        })
        .catch((error) => {
            errors.value = error.response.data.errors
        }).finally(() => {disabled.value = false});
}

async function update() {
    RoleApi.update(form)
        .then(() => {
            ElMessage({
                message: t('messages.success_update'),
                type: "success",
            });
            redirectRouter.push({name: "roles"});
        })
        .catch((error) => {
            errors.value = error.response.data.errors
        }).finally(() => {disabled.value = false});
}

onMounted(async () => {
    if (isUpdateForm) {
        await getRole();
    }
    await getSystemPermissions();
});
</script>

<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.roles" :active="false">
                <li class="breadcrumb-item active" aria-current="page" v-if="route.name !== 'role-show'">
                    {{ isUpdateForm ? $t("messages.edit") : $t("messages.add_new") }}
                </li>
                <li class="breadcrumb-item active" aria-current="page" v-else>
                    {{ $t("messages.view") }}
                </li>
            </page-header>

            <div class="py-2">
                <div class="card rounded border-0 shadow-sm mt-4">
                    <div class="card-body pb-0">
                        <el-form ref="ruleFormRef" :model="form">
                            <div class="col-md-12">
                                <FormInput label="messages.name" :model="form" name="name"
                                           :errors="errors.value" :disabled="isReadonly"/>
                            </div>
                        </el-form>
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-md-4" v-for="(model_permissions, index) in system_permissions" :key="index">
                        <PermissionCard :permissions="model_permissions" :group-title="index"
                                        v-model="form.role_permissions" :readonly="isReadonly"/>
                    </div>
                </div>

                <div :hidden="isReadonly">
                    <el-button type="primary" @click="submit()" :disabled="disabled">
                        {{ $t("forms.submit") }}
                    </el-button>
                </div>
            </div>
        </div>
    </div>
</template>
