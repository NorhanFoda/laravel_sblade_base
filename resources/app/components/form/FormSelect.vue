<template>
    <div class="mb-3">
        <el-form-item :label="$t(props.title)" class="mb-0" prop="name">
        </el-form-item>

        <el-select v-model="props.model[name]" :clearable="true" :filterable="true" collapse-tags
                   collapse-tags-tooltip :disabled="props.disabled"
                   :multiple="props.multiple" :placeholder="placeholder ? placeholder : $t('forms.select')"
                   @change="change" @removeTag="onRemoveTag" @clear="clear">
            <el-option v-for="item in props.options" :key="item.id" :label="item[label]" :value="item.id">
                <span>{{ item[label] }}</span>
                <slot name="option_badge" :item="item"></slot>
            </el-option>
        </el-select>
        <form-validation-errors :errors="props.errors" :name="errorsName!==''?errorsName :props.name"/>
    </div>
</template>
<script setup>
const emit = defineEmits(["change", "onRemoveTag", "onAddTag", "clear"]);
const props = defineProps({
    title: {
        type: String,
        default: "",
    },
    label: {
        type: String,
        default: "",
    },
    model: {
        type: [Array, Object, String],
    },
    name: {
        type: [Number, String],
        default: "",
    },
    placeholder: {
        type: String,
        default: "",
    },
    errors: {
        type: [Array, Object],
        default: [],
    },
    values: {
        type: [Array, Object],
        default: [],
    },
    multiple: {
        type: Boolean,
        default: false,
    },
    options: {
        type: [Array, Object],
        default: [],
    },
    errorsName: {
        type: String,
        default: ''
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

async function change(value) {
    props.errors[props.errorsName !== '' ? props.errorsName : props.name] = []
    emit("change", value);
}

async function onRemoveTag(tag) {
    emit("onRemoveTag", tag);
}

async function onAddTag(tag) {
    console.log(tag);
    emit("onAddTag", tag);
}

async function clear() {
    emit("clear", '');
}

</script>
<style scoped>
:deep() {
    --vs-dropdown-option--active-bg: #07a55c;
    --vs-dropdown-option--active-color: #eeeeee;
    --form-select-color: #eeeeee;
}
</style>
