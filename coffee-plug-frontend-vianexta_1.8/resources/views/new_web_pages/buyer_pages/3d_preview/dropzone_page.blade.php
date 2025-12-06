<div class="form-group mb-4">
    <!-- <label class="form-label text-muted opacity-75 fw-medium" for="formImage">Image</label> -->
    <div class="dropzone-drag-area form-control" id="previews">
        <div class="dz-message text-muted opacity-50" data-dz-message>
            <span>Drag file here to upload</span>
        </div>
        <div class="d-none" id="dzPreviewContainer">
            <div class="dz-preview dz-file-preview">
                <div class="dz-photo">
                    <img class="dz-thumbnail" data-dz-thumbnail>
                </div>
                <button class="dz-delete border-0 p-0" type="button" data-dz-remove>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="times">
                        <path fill="#FFFFFF" d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div class="invalid-feedback fw-bold">Please upload an image.</div>
</div>