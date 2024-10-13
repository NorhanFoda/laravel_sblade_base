<div class="row">
    @foreach ($systemPermissions as $model => $permissionItems)
        <div class="col-md-3 mt-6 mb-4">
            <div class="card shadow-lg">
                <div class="card-header text-center pt-1 pb-1 bg-gray-200">
                    <h5 class="font-weight-normal mt-2">
                        <div class="d-flex justify-content-lg-start justify-content-center p-2">
                            <x-form.checkbox
                                label="{{ $model }}"
                                :value="$model"
                                :name="$model"
                                labelClass="font-weight-bold"
                                inputClass="main-checkbox"
                                :id="$model"
                                :checked="isset($rolePermissions) && in_array($model, $rolePermissions?->pluck('model')->toArray())"
                                :required="true"
                                :disabled="request()->routeIs('roles.show')"/>
                        </div>
                    </h5>
                </div>
                <div class="card-body text-lg-start text-center pt-0">
                    @foreach ($permissionItems as $item)
                        <div class="d-flex justify-content-lg-start justify-content-center">
                            <x-form.checkbox
                                name="role_permissions[]"
                                label="{{ $item->name }}"
                                :value="$item->name"
                                inputClass="child-checkbox form-check-input"
                                :dataModel="$model"
                                :isArray="true"
                                :id="$item->id"
                                :checked="isset($rolePermissions) && in_array($item->name, $rolePermissions?->pluck('name')->toArray())"
                                :showError="false"
                                :disabled="request()->routeIs('roles.show')"/>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
    <x-form.validation-error name="role_permissions" :errors="$errors"/>
</div>
