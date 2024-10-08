<div class="d-flex align-items-center">
    <div class="me-3">
        <x-table.edit-btn :label="__('app.table.actions.edit')" :href="route('roles.edit', ['role' => $model])" />
    </div>
    <div>

        <x-table.delete-btn :label="__('app.table.actions.delete')" :id="$model->id" :action="route('roles.destroy', $model)" />
    </div>
</div>
