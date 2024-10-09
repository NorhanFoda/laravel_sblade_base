<div class="row">
    @foreach ($permissions as $model => $permissionItems)
        <div class="col-md-3 mt-6 mb-4">
            <div class="card shadow-lg">
                <div class="card-header text-center pt-4 pb-3">
                    <h5 class="font-weight-normal mt-2">
                        <div class="d-flex justify-content-lg-start justify-content-center p-2">
                            <x-form.checkbox 
                                label="{{ $model }}" 
                                :value="$model" 
                                :name="$model"
                                labelClass="font-weight-bold" 
                                inputClass="main-checkbox" 
                                :id="$model" 
                                :required="true" />
                        </div>
                    </h5>
                </div>
                <div class="card-body text-lg-start text-center pt-0">
                    @foreach ($permissionItems as $item)
                        <div class="d-flex justify-content-lg-start justify-content-center p-2">
                            <x-form.checkbox 
                                name="role_permissions" 
                                label="{{ $item->name }}" 
                                :value="$item->id"
                                inputClass="child-checkbox form-check-input" 
                                :dataModel="$model" 
                                :isArray="true" 
                                :id="$item->id"
                                :showError="false" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
    <x-form.validation-error name="role_permissions" :errors="$errors" />
</div>
