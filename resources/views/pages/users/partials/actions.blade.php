<div class="d-flex align-items-center">
    <div class="me-3">
        <x-table.edit-btn :label="__('table.actions.edit')" :href="route('users.edit', ['user' => $model])" />
    </div>
    <div>

        <x-table.delete-btn :label="__('table.actions.delete')" :id="$model->id" :action="route('users.destroy', $model)" />
    </div>
</div>
