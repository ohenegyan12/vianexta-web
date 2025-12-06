// Set up the scene, camera, and renderer
    const  scene = new THREE.Scene();
    scene.background = new THREE.Color(0xffffff);

    camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 5;

    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(document.getElementById('canvas-container').offsetWidth, 350);
    document.getElementById('canvas-container').appendChild(renderer.domElement);

    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
    directionalLight.position.set(0, 1, 1);
    scene.add(directionalLight);

    controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;

    // const renderer = new THREE.WebGLRenderer({ antialias: true });
    // renderer.setSize(window.innerWidth, window.innerHeight);
    // document.body.appendChild(renderer.domElement);

    const light = new THREE.PointLight(0xffffff, 1, 100);
    light.position.set(10, 10, 10);
    scene.add(light);


    const materialGrey = new THREE.MeshStandardMaterial({ color: 0x777777, metalness: 0.5, roughness: 0.6 });

    let currentModel;

    const k_cup = new THREE.Group();
    const cupGeometry = new THREE.CylinderGeometry(2, 2.5, 3, 32);
    const kcup = new THREE.Mesh(cupGeometry, materialGrey);
    kcup.position.y = 1.5;
    k_cup.add(kcup);

    const lidGeometry = new THREE.CylinderGeometry(2.5, 2.5, 0.2, 32);
    const lid = new THREE.Mesh(lidGeometry, materialGrey);
    lid.position.y = 3.2;
    k_cup.add(lid);

    const oz_frac_pack = new THREE.Group();
    const packGeometry = new THREE.BoxGeometry(4, 6, 2);
    const fracPack = new THREE.Mesh(packGeometry, materialGrey);
    oz_frac_pack.add(fracPack);

    const lb = new THREE.Group();
    const bagBodyGeometry = new THREE.BoxGeometry(4, 8, 3);
    const coffeeBagBody = new THREE.Mesh(bagBodyGeometry, materialGrey);
    coffeeBagBody.position.y = 4;
    lb.add(coffeeBagBody);

    const topFoldGeometry = new THREE.BoxGeometry(4, 1, 3);
    const topFold = new THREE.Mesh(topFoldGeometry, materialGrey);
    topFold.position.y = 8.5;
    lb.add(topFold);

    const oz_bag = new THREE.Group();
    const bag10ozBodyGeometry = new THREE.BoxGeometry(3, 6, 2.5);
    const coffee10ozBagBody = new THREE.Mesh(bag10ozBodyGeometry, materialGrey);
    coffee10ozBagBody.position.y = 3;
    oz_bag.add(coffee10ozBagBody);

    const topFold10ozGeometry = new THREE.BoxGeometry(3, 1, 2.5);
    const topFold10oz = new THREE.Mesh(topFold10ozGeometry, materialGrey);
    topFold10oz.position.y = 6.5;
    oz_bag.add(topFold10oz);

    function showModel(modelGroup) {
      if (currentModel) {
        scene.remove(currentModel);
      }
      scene.add(modelGroup);
      currentModel = modelGroup;
    }

    function triggerModel(modeltype){
        if (modeltype == 'k_cup'){
            showModel(k_cup);
        }else if(modeltype == 'oz_frac_pack'){
            showModel(oz_frac_pack);
        }else if(modeltype == 'lb'){
            showModel(lb);
        }else if(modeltype == 'oz_bag'){
            showModel(oz_bag);
        }
    }

    // document.getElementById('showKcup').addEventListener('click', () => showModel(k_cup));
    // document.getElementById('showFracPack').addEventListener('click', () => showModel(oz_frac_pack));
    // document.getElementById('showCoffeeBag').addEventListener('click', () => showModel(lb));
    // document.getElementById('show10ozBag').addEventListener('click', () => showModel(oz_bag));
  
    // const logoUploader = document.getElementById('logoUploader');
    // const applyLogoButton = document.getElementById('applyLogo');
    // let logoTexture;

    // logoUploader.addEventListener('change', (event) => {
    //   const file = event.target.files[0];
    //   if (file) {
    //     const reader = new FileReader();
    //     reader.onload = function (e) {
    //       const textureLoader = new THREE.TextureLoader();
    //       logoTexture = textureLoader.load(e.target.result, (texture) => {
    //         texture.wrapS = THREE.ClampToEdgeWrapping;
    //         texture.wrapT = THREE.ClampToEdgeWrapping;
    //         texture.repeat.set(1, 1); // Ensure no tiling
    //       });
    //     };
    //     reader.readAsDataURL(file);
    //   }
    // });

    // applyLogoButton.addEventListener('click', () => {
    //   if (logoTexture && currentModel) {
    //     const logoMaterial = new THREE.MeshStandardMaterial({ map: logoTexture });

    //     // Apply texture based on the model
    //     if (currentModel === k_cup) {
    //       kcup.material = materialGrey; // Keep cup material grey
    //       lid.material = logoMaterial; // Apply logo only to the lid
    //     } else {
    //       currentModel.children.forEach((child) => {
    //         child.material = materialGrey; // Reset material to grey first
    //       });
    //       currentModel.children[0].material = logoMaterial; // Apply logo only to the front
    //     }
    //   } else {
    //     alert('Please upload a logo first.');
    //   }
    // });

    function animate() {
      requestAnimationFrame(animate);
      controls.update();
      renderer.render(scene, camera);
    }

    animate();

    // showModel(k_cup);

    window.addEventListener('resize', () => {
        camera.aspect = document.getElementById('canvas-container').offsetWidth / 400;
        camera.updateProjectionMatrix();
        renderer.setSize(document.getElementById('canvas-container').offsetWidth, 400);
    });

// let scene, camera, renderer, controls, currentModel;
//         const textureLoader = new THREE.TextureLoader();
//         const fbxLoader = new THREE.FBXLoader();

//         // Initialize Three.js scene
//         function init() {
//             scene = new THREE.Scene();
//             scene.background = new THREE.Color(0xffffff);

//             camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
//             camera.position.z = 5;

//             renderer = new THREE.WebGLRenderer({ antialias: true });
//             renderer.setSize(document.getElementById('canvas-container').offsetWidth, 350);
//             document.getElementById('canvas-container').appendChild(renderer.domElement);

//             const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
//             scene.add(ambientLight);

//             const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
//             directionalLight.position.set(0, 1, 1);
//             scene.add(directionalLight);

//             controls = new THREE.OrbitControls(camera, renderer.domElement);
//             controls.enableDamping = true;
//             controls.dampingFactor = 0.05;

//             animate();
//         }

//         // Animation loop
//         function animate() {
//             requestAnimationFrame(animate);
//             controls.update();
//             renderer.render(scene, camera);
//         }

//         // Logo handling
//         const logoOverlay = document.getElementById('logoOverlay');
//         let isDragging = false;
//         let currentX = 0;
//         let currentY = 0;
//         let initialX = 0;
//         let initialY = 0;
//         let xOffset = 0;
//         let yOffset = 0;

//         // Only set up logo drag events if logo overlay exists
//         if (logoOverlay) {
//             logoOverlay.addEventListener('mousedown', dragStart);
//             document.addEventListener('mousemove', drag);
//             document.addEventListener('mouseup', dragEnd);
//         }

//         function dragStart(e) {
//             initialX = e.clientX - xOffset;
//             initialY = e.clientY - yOffset;
//             if (e.target === logoOverlay) {
//                 isDragging = true;
//             }
//         }

//         function drag(e) {
//             if (isDragging) {
//                 e.preventDefault();
//                 currentX = e.clientX - initialX;
//                 currentY = e.clientY - initialY;
//                 xOffset = currentX;
//                 yOffset = currentY;
//                 setTranslate(currentX, currentY, logoOverlay);
//             }
//         }

//         function dragEnd() {
//             initialX = currentX;
//             initialY = currentY;
//             isDragging = false;
//         }

//         function setTranslate(xPos, yPos, el) {
//             el.style.transform = `translate(${xPos}px, ${yPos}px)`;
//         }

//         // Model loading and texture application
//         document.querySelectorAll('[data-model]').forEach(button => {
//             button.addEventListener('click', function() {
//                 const modelPath = this.getAttribute('data-model');
//                 // alert(modelPath);
//                 loadModel(modelPath);

//                 document.querySelectorAll('[data-model]').forEach(btn => {
//                     btn.classList.remove('active');
//                 });
//                 this.classList.add('active');

//                 // document.getElementById('logoUpload').disabled = false;
//             });
//         });

//         // Load 3D model function
//         function loadModel(modelPath) {
//             if (currentModel) {
//                 scene.remove(currentModel);
//             }

//             fbxLoader.load(
//                 modelPath,
//                 (fbx) => {
//                     currentModel = fbx;

//                     // Center the model
//                     const box = new THREE.Box3().setFromObject(currentModel);
//                     const center = box.getCenter(new THREE.Vector3());
//                     const size = box.getSize(new THREE.Vector3());

//                     // Scale model to fit view
//                     const maxDim = Math.max(size.x, size.y, size.z);
//                     const scale = 2 / maxDim;
//                     currentModel.scale.setScalar(scale);

//                     // Center model
//                     currentModel.position.sub(center.multiplyScalar(scale));

//                     scene.add(currentModel);
//                     // Hide the spinner
//                     document.getElementById('image_spinner').style.display = 'none';

//                     // Set up rotation controls
//                     document.getElementById('rotationX').addEventListener('input', updateRotation);
//                     document.getElementById('rotationY').addEventListener('input', updateRotation);
//                     document.getElementById('rotationZ').addEventListener('input', updateRotation);
//                 },
//                 (xhr) => {
//                     // Loading progress
//                     console.log((xhr.loaded / xhr.total * 100) + '% loaded');
//                 },
//                 (error) => {
//                     console.error('Error loading model:', error);
//                 }
//             );
//         }

//         // Apply texture to model
//         function applyLogoTexture(logoDataUrl) {
//             if (!currentModel) return;

//             const texture = textureLoader.load(logoDataUrl);

//             currentModel.traverse((child) => {
//                 if (child.isMesh) {
//                     // Create a new material with the logo texture
//                     const material = new THREE.MeshPhongMaterial({
//                         map: texture,
//                         transparent: true,
//                         side: THREE.DoubleSide
//                     });
//                     child.material = material;
//                 }
//             });
//         }

//         // Update model rotation
//         function updateRotation() {
//             if (!currentModel) return;

//             const rotX = THREE.MathUtils.degToRad(parseFloat(document.getElementById('rotationX').value));
//             const rotY = THREE.MathUtils.degToRad(parseFloat(document.getElementById('rotationY').value));
//             const rotZ = THREE.MathUtils.degToRad(parseFloat(document.getElementById('rotationZ').value));

//             currentModel.rotation.set(rotX, rotY, rotZ);
//         }

//         // Handle window resize
//         window.addEventListener('resize', () => {
//             camera.aspect = document.getElementById('canvas-container').offsetWidth / 400;
//             camera.updateProjectionMatrix();
//             renderer.setSize(document.getElementById('canvas-container').offsetWidth, 400);
//         });

//         // Initialize the application
//         init();