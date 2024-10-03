<script setup>
import {ref, shallowRef, onMounted, reactive, getCurrentInstance} from 'vue'
import UserApi from "@api/user.api";
import {useLoaderStore} from "@store/loader";
import ConfirmBox from "@components/ConfirmBox.vue";
import {ElMessage} from "element-plus";

const loaderStore = useLoaderStore();
const app = getCurrentInstance();
const t = app.appContext.config.globalProperties.$t;
let resources = ref([]);
let pagination = shallowRef({page: 1});
let filters = ref({
    page: 1,
    keyword: '',
    embed: 'roles:id,roles.permissions:id',
    includeEmptyRelations: false,
    columns: 'id,name'
});

async function getResources(page = 1) {
    filters.value.page = page;
    UserApi.list(filters.value)
        .then(({data}) => {
            resources.value = data.data;
            pagination.value = data.meta;
        })
        .catch(error => {
            console.log(error);
        })
}

const deleteResource = async (selectedResource) => {
    await UserApi.delete(selectedResource)
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
})

</script>
<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.users">
                <template v-slot:button>
                    <router-link v-if="hasPermission('create', 'User')" class="btn btn-primary"
                                 to="/users/create">
                        <i class="fas fa-plus me-2 fs-13 text-babyblue"></i>
                        {{ $t("messages.add_new") }}
                    </router-link>
                </template>
            </page-header>
            <div class="card">
                <div class="card-body pb-0">
                    <Filters @submit="getResources" :model="filters"/>
                </div>
            </div>
            <spinner/>
            <el-table :data="resources" style="width: 100%" v-if="resources.length">
                <el-table-column label="#" type="index"/>
                <el-table-column :label="$t('messages.name')" prop="name"/>
                <el-table-column :label="$t('global.actions')">
                    <template #default="scope">
                        <router-link :to="'/users/edit/' + scope.row.id" v-if="hasPermission('update', 'User')">
                            <span class="mx-1 btn btn-info btn-icon text-white">
                                <i class="fas fa-edit"></i>
                            </span>
                        </router-link>
                        <ConfirmBox @confirmAction="deleteResource(scope.row)" v-if="hasPermission('delete', 'User')"
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
            <strong v-if="!resources.length && !loaderStore.loading" class="text-danger">{{
                    $t('global.no_results')
                }}</strong>
            <Pagination :pagination="pagination" @paginate="getResources"/>
        </div>
    </div>
</template>



