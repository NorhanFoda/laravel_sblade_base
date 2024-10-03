<script setup>
import {ref, onMounted, reactive, getCurrentInstance} from "vue";
import RoleApi from "@api/role.api";
import {ElMessage} from "element-plus";
import {useLoaderStore} from "@store/loader";
import ConfirmBox from "@components/ConfirmBox.vue";

const app = getCurrentInstance();
const t = app.appContext.config.globalProperties.$t;
const loaderStore = useLoaderStore();
let resources = ref([]);
let permissions = ref([]);
let openPermissionModal = ref(false);
let title = ref("");
let filters = ref({
    page: 1,
    embed: "permissions",
});
let pagination = ref({
    page: 1,
});

async function getResources(page = 1) {
    filters.value.page = page;
    RoleApi.list(filters.value)
        .then(({ data }) => {
            resources.value = data.data;
            pagination = data;
        })
        .catch((error) => {
            console.log(error);
        });
}

const viewPermission = (selectedResource) => {
    title.value = "messages.permission";
    Object.assign(permissions, selectedResource.permissions);
    openPermissionModal.value = true;
};

const deleteResource = async (selectedResource) => {
    await RoleApi.delete(selectedResource)
        .then(async () => {
            await getResources();
            ElMessage({
                type: "success",
                message: t("messages.success_delete"),
            });
        })
};

onMounted(async () => {
    await getResources();
});
</script>

<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.roles">
                <template v-slot:button>
                    <router-link v-if="hasPermission('create', 'Role')" class="btn btn-primary"
                        to="/roles/create">
                        <i class="fas fa-plus me-2 fs-13 text-babyblue"></i>
                        {{ $t("messages.add_new") }}
                    </router-link>
                </template>
            </page-header>

            <div class="card">
                <div class="card-body pb-0">
                    <Filters @submit="getResources" :model="filters" />
                </div>
            </div>
            <spinner v-if="loaderStore.loading"></spinner>
            <el-table :data="resources" style="width: 100%" v-if="resources.length">
                <el-table-column label="#" type="index" />
                <el-table-column :label="$t('messages.name')" prop="name"/>
                <el-table-column :label="$t('global.actions')">
                    <template #default="scope">
                        <router-link :to="'/roles/show/' + scope.row.id" v-if="hasPermission('read', 'Role')">
                            <span class="btn btn-primary btn-icon text-white">
                                <i class="fas fa-eye"></i>
                            </span>
                        </router-link>
                        <router-link :to="'/roles/edit/' + scope.row.id" v-if="hasPermission('update', 'Role')">
                            <span class="mx-1 btn btn-info btn-icon text-white">
                                <i class="fas fa-edit"></i>
                            </span>
                        </router-link>
                        <ConfirmBox @confirmAction="deleteResource(scope.row)" v-if="hasPermission('delete', 'Role')"
                                    :title="t('messages.are_you_sure')">
                            <template #content>
                                <a href="javascript:void(0)" class="btn btn-danger btn-icon text-white">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </template>
                        </ConfirmBox>
                    </template>
                </el-table-column>
            </el-table>
            <strong v-if="!resources.length && !loaderStore.loading" class="text-danger">
                {{ $t("global.no_results") }}
            </strong>
            <Pagination :pagination="pagination" @paginate="getResources" />
        </div>
    </div>
</template>
