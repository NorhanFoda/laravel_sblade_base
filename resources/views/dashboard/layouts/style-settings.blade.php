<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="material-icons py-2">settings</i>
    </a>
    <div class="card shadow-lg">
        <div class="card-header pb-0 pt-3">
            <div class="float-start">
                <h5 class="mt-3 mb-0">Configurators</h5>
                <p>See our dashboard options.</p>
            </div>
            <div class="float-end mt-4">
                <button
                    class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                    <i class="material-icons">clear</i>
                </button>
            </div>
            <!-- End Toggle Button -->
        </div>
        <div class="card-body pt-sm-3 pt-0">
            <hr class="horizontal dark my-3"/>
            <div class="mt-2 d-flex">
                <h6 class="mb-0">Light / Dark</h6>
                <div class="form-check form-switch ps-0 ms-auto my-auto">
                    <input
                        class="form-check-input mt-1 ms-auto"
                        type="checkbox"
                        id="dark-version"
                        onclick="darkMode(this)"
                    />
                </div>
            </div>
            <hr class="horizontal dark my-sm-4"/>


            <a
                class="btn btn-outline-dark w-100"
                href="{!! route('home') !!}"
            >View Dashboard</a
            >
        </div>
    </div>
</div>
