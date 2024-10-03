<script setup>
import {reactive, shallowRef} from "vue";
import FormHelper from "@mixins/form";
import NoteApi from "@api/note.api";

const emit = defineEmits(['commentAdded']);
const props = defineProps({
    resource: {
        type: Object,
        required: true
    },
    viewUploadFileForm:{
        type: Boolean,
        required: false,
        default: true
    }
});
let isSubmitted = shallowRef(false);

const resource = reactive({});

let errors = reactive([]);

async function save()
{
    isSubmitted.value = true;
    resource.notable_type = props.resource.model_class;
    resource.notable_id = props.resource.id;

    NoteApi.store(resource)
        .then((response) => {
            let comment = response.data.data;
            comment.text = FormHelper.parseHtmlToText(comment.text);
            emit("commentAdded", comment);
            FormHelper.resetForm(resource);
            errors.value = [];
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
        })
        .finally(() => isSubmitted.value = false );
}

async function successDeleteUpload(data) {
    if (!resource[data.type]){
        resource[data.type] = [];
    }
    resource[data.type].splice(resource[data.type].indexOf(data.id), 1)
}


async function successUpload(data) {
    if (!resource[data.type]){
        resource[data.type] = [];
        resource['attachments'] = [];
    }
    resource[data.type].push(data.id)
    resource['attachments'].push(data)
}

</script>
<template>

    <div class="d-flex flex-column flex-md-row">
        <div class="flex-shrink-0">
            <img
                class="img-thumbnail rounded-circle mb-3"
                width="50"
                height="50"
                src="https://toppng.com/uploads/preview/icons-logos-emojis-user-icon-png-transparent-11563566676e32kbvynug.png"
                alt=""
            />
        </div>
        <div class="flex-grow-1 ms-3">
            <el-form>
                <div class="mb-3">
                    <FormEditor
                        :model="resource"
                        name="text"
                        :errors="errors.value"
                    />
                </div>
                <div class="mb-3" v-if="viewUploadFileForm">
                    <FormFileUpload
                        :files="resource.attachments? resource.attachments : []"
                        :multiple="true"
                        type="ticket_comment_attachments"
                        @successDeleteUpload="successDeleteUpload"
                        @successUpload="successUpload"
                    />
                </div>
                <button type="button" class="btn btn-primary" @click="save" :disabled="isSubmitted">
                    {{ $t('messages.add_comment') }}
                </button>
            </el-form>
        </div>
    </div>
</template>
