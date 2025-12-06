  <div class="container">
      <h4>3D Preview of Bag?</h4>
      <div class="row mt-4">
          <div class="col-md-12">
              <div id="canvas-container">
                  <!-- <div class="spinner-border text-success" id="image_spinner" role="status">
                      <span class="visually-hidden">Loading...</span>
                  </div> -->
                  <img id="logoOverlay" style="position: absolute; pointer-events: auto;">
                  <!-- <img id="logoOverlay" style="display: none;"> -->
              </div>
          </div>
          <div class="col-md-12">
              <div class="controls">
                  <!-- <h5>Model Controls</h5> -->
                  <h5>Select bag color</h5>
                  <div class="row">
                      <div class="col-md-4 mb-3">
                          <!-- <label>Select bag color</label> -->
                          <input type="color" class="form-control form-control-color" name="bag_color" id="bag_color" value="#f7ecf0" title="Choose your color" oninput="document.getElementById('color_hex').value = this.value;">
                      </div>

                  </div>

              </div>
          </div>
      </div>
  </div>