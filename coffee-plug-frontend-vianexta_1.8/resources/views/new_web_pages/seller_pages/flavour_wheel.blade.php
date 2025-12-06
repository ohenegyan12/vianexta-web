<script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-sunburst.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-data-adapter.min.js"></script>
  <script type="text/javascript">anychart.onDocumentReady(function () {
  // The data used in this sample can be obtained from the CDN
  // https://cdn.anychart.com/samples/sunburst-charts/coffee-flavour-wheel/data.json
  anychart.data.loadJsonFile(
    'https://cdn.anychart.com/samples/sunburst-charts/coffee-flavour-wheel/data.json',
    function (data) {
      // makes tree from the data for the sample
      var dataTree = anychart.data.tree(data, 'as-table');

      // create sunburst chart
      var chart = anychart.sunburst(dataTree);

      // set calculation mode
      chart.calculationMode('ordinal-from-root');

      // set chart title
      chart.title('Coffee Flavour Wheel');

      // set settings for the penultimate level labels
      chart.level(-2).labels().position('radial');

      // set chart labels settings
      chart.labels().hAlign('center');

      // set settings for leaves labels
      chart.leaves().labels().minFontSize(8).textOverflow('...');

      // the fill specified in the data has priority
      // set point fill
      chart.fill(function () {
        return anychart.color.darken(this.parentColor, 0.15);
      });

      chart.listen('pointsSelect', function(e) {
          	if (e.points.length) {
            for (var i = 0, len = e.points.length; i < len; i++) {
              var point = e.points[i]; 
                  setFlaovor(point.get('id'));
              //  alert('I got here: '+ point.get('id'));
            }
          }
         
       });

      // set container id for the chart
      chart.container('container');
      // initiate chart drawing
      chart.draw();
    }
  );
});

function setFlaovor(flavor){
  const flavorDiv = document.getElementById('flavors_div');
  var ses_flavors =[];
  // sessionStorage.clear();
  var ses_storage=sessionStorage.getItem('flavors');
 
  // alert(ses_storage);
  if(ses_storage != null && ses_storage.length > 0){
    //  alert(ses_storage);
      ses_flavors = ses_storage.split(",");
  }
   
  // Check if flavor is already selected
  if(ses_flavors.includes(flavor) == false){
    // Add new flavor
    ses_flavors.push(flavor);
    sessionStorage.setItem("flavors", ses_flavors.join(","));
    
    // Create modern flavor badge with remove button
    const flavorBadge = document.createElement('span');
    flavorBadge.className = 'flavor-badge';
    flavorBadge.style.cssText = 'background: #07382F; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.5rem; margin-right: 10px; margin-bottom: 5px;';
    
    flavorBadge.innerHTML = `
      ${flavor}
      <button type="button" class="flavor-remove" onclick="removeFlavor('${flavor}')" style="background: #D8501C; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.8rem;">&times;</button>
    `;
    
    // Remove the placeholder text if it exists
    if(flavorDiv.querySelector('.text-muted')) {
      flavorDiv.innerHTML = '';
    }
    
    flavorDiv.appendChild(flavorBadge);
  } else {
    // Flavor already exists, remove it
    removeFlavor(flavor);
  }
}

function removeFlavor(flavor) {
  const flavorDiv = document.getElementById('flavors_div');
  var ses_flavors = [];
  var ses_storage = sessionStorage.getItem('flavors');
  
  if(ses_storage != null && ses_storage.length > 0){
    ses_flavors = ses_storage.split(",");
  }
  
  // Remove the flavor
  ses_flavors = ses_flavors.filter(f => f !== flavor);
  sessionStorage.setItem("flavors", ses_flavors.join(","));
  
  // Update display
  if(ses_flavors.length === 0) {
    flavorDiv.innerHTML = '<p class="text-muted">Click on the flavor wheel to select flavors</p>';
  } else {
    // Rebuild the display
    flavorDiv.innerHTML = '';
    ses_flavors.forEach(flavor => {
      const flavorBadge = document.createElement('span');
      flavorBadge.className = 'flavor-badge';
      flavorBadge.style.cssText = 'background: #07382F; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.5rem; margin-right: 10px; margin-bottom: 5px;';
      
      flavorBadge.innerHTML = `
        ${flavor}
        <button type="button" class="flavor-remove" onclick="removeFlavor('${flavor}')" style="background: #D8501C; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.8rem;">&times;</button>
      `;
      
      flavorDiv.appendChild(flavorBadge);
    });
  }
}

</script>