<script setup>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import {ref} from "vue";

const props = defineProps({
    label: {
        type: String,
        default: ''
    },
    model: {
        type: [Array, Object]
    },
    name: {
        type: String,
        default: ''
    },
    errors: {
        type: [Array, Object],
        default: []
    }
})

const editor = ref(ClassicEditor);
const editorConfig = ref({
    toolbar: {
        items: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList',
            'numberedList', 'blockQuote', 'insertTable', 'mediaEmbed',
            'undo', 'redo', 'insertImage']
    },
    table: {
        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
    }
});
</script>

<template>
    <el-form-item :label="$t(props.label)" class="mb-0" prop="name">
    </el-form-item>

    <ckeditor :editor="editor" v-model="props.model[name]" :config="editorConfig"></ckeditor>
    <form-validation-errors :errors="props.errors" :name="props.name" />
</template>

<style scoped>

</style>
