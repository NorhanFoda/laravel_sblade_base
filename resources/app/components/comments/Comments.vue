<script setup>
import { ref, getCurrentInstance } from "vue";
import CommentForm from "@components/comments/CommentForm.vue";
import AttachmentViewModal from "@components/AttachmentViewModal.vue";

const app = getCurrentInstance();
const t = app.appContext.config.globalProperties.$t;

const props = defineProps({
    resource: {
        type: Object,
        required: true,
    },
    title: {
        type: String,
        required: false,
        default: "messages.ticket_comments"
    },
    viewUploadedFiles:{
        type: Boolean,
        required: false,
        default: true
    },
    viewUploadFileForm:{
        type: Boolean,
        required: false,
        default: true
    }
});

let openViewAttachmentModal = ref(false);

async function commentAdded(comment) {
    props.resource.comments.push(comment);
    comment.files.forEach((file) => {
        props.resource.files.push(file);
    });
}

const openAttachmentModal = () => {
    openViewAttachmentModal.value = true;
};

const close = () => {
    openViewAttachmentModal.value = false;
}

</script>
<template>
    <div class="card">
        <div
            class="card-header py-3 mb-2 d-flex justify-content-between flex-wrap flex-md-nowrap"
        >
            <div class="d-flex align-items-center flex-wrap flex-md-nowrap">
                <h6 class="mb-2 mb-md-0 fw-bold">
                    {{ $t(title) }}
                </h6>
                <b class="mb-2 ms-2 mb-md-0">
                    <span class="text-primary"
                        >({{ resource.comments?.length }}
                        {{ $t("messages.comments") }} )</span
                    ></b
                >
            </div>
        </div>

        <div class="card-body">
            <h6 class="mb-3 fw-bold" v-if="viewUploadedFiles">{{ $t('messages.uploaded_files') }}</h6>
            <ul class="row mb-3">
                <li class="col-md-1" v-for="(file, index) in resource.files" :key="index">
                    <el-button
                        class="btn h-auto"
                        @click="openAttachmentModal()"
                    >
                        <i class="fas fa-3x fa-file-word text-primary"></i>
                    </el-button>
                </li>
            </ul>

            <AttachmentViewModal
                v-for="(file, index) in resource.files" :key="index"
                :openModal="openViewAttachmentModal"
                :file="file"
                @close="close"
            />

            <div v-for="(comment, index) in resource.comments" :key="index"
                class="p-2 rounded-lg mb-3 bg-lightGray3 fs-14">
                <div
                    class="d-flex align-items-center flex-wrap justify-content-between pb-2 mb-3 border-bottom"
                >
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <div class="flex-shrink-0">
                            <img
                                class="mr-3 img-thumbnail rounded-circle"
                                width="40"
                                height="40"
                                :src="comment.user?.avatar?.url ?? `https://toppng.com/uploads/preview/icons-logos-emojis-user-icon-png-transparent-11563566676e32kbvynug.png`"
                                alt="User Thumb"
                            />
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-primary fw-bold">
                                <router-link
                                    :to="{name: 'employees.show', params: {id: comment.user?.id}}"
                                >
                                    {{ comment.user?.name }}
                                </router-link>
                            </h6>
                            <span class="text-grayClr fs-13">
                                {{ comment.created_at }}
                            </span>
                        </div>
                    </div>
                </div>
                <p v-html="comment.text"></p>
            </div>

            <CommentForm v-if="hasPermission('create', 'Note')"
                :resource="resource"
                :viewUploadFileForm="viewUploadFileForm"
                @commentAdded="commentAdded"
            />
        </div>
    </div>
</template>
