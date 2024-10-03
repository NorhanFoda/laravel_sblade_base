<script setup>

const emit = defineEmits(["change"]);
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
        type: [Array, Object],
    },
    name: {
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
});
</script>
<template>
    <div class="mb-3">
        <el-form-item :label="$t(props.title)" prop="name" class="mb-0">
        </el-form-item>
        <el-select
            :multiple="props.multiple"
            v-model="props.model[name]"
            :clearable="true"
            :filterable="true"
            :placeholder="$t('forms.select')"
            @change="$emit('change')"
        >
            <el-option
                v-for="(item, index) in props.options"
                :key="index"
                :label="item"
                :value="index"
            />
        </el-select>
        <form-validation-errors :errors="props.errors" :name="props.name" />
    </div>
</template>

<style scoped>
:deep() {
    --vs-dropdown-option--active-bg: #07a55c;
    --vs-dropdown-option--active-color: #eeeeee;
    --form-select-color: #eeeeee;
}
</style>
