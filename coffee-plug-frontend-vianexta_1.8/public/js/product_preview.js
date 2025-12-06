
        // Product data object
        const productData = {
            '5lb': {
                title: '5lb Bag',
                size: '~8" W x 5" D x 19" H',
                roast: 'Color: Matte black',
                origin: 'Roasted in the USA',
                note: 'Label size: 5.50 in (H) x 4 in (L)',
                mainImage: '5lb_1.jpg', // Different image dimensions for different packages
                previewImages: ['5lb_1.jpg', '5lb.jpg', '5lb.jpg', '5lb.jpg']
            },
            '12oz': {
                title: '12oz Bag',
                size: '~4" W x 3" D x 12" H',
                roast: 'Color: Matte black',
                origin: 'Roasted in the USA',
                note: 'Label size: 1.75 in (H) x 3.75 in (L)',
                mainImage: '12oz_1.png',
                previewImages: ['12oz_1.png', '12oz_2.png', '12oz_3.png', '12oz_4.jpg']
            },
            'frac_pack': {
                title: 'Frac Packs',
                size: '~6.5" W x 2.5" D x 8" H',
                roast: 'Color: Silver foil',
                origin: 'Roasted in the USA',
                note: 'Label size: 3.5 in (H) x 2.75 in (L)',
                mainImage: 'frac_pack.jpg',
                previewImages: ['frac_pack.jpg', 'frac_pack.jpg', 'frac_pack.jpg', 'frac_pack.jpg']
            },
            '10oz': {
                title: '10oz Bag',
                size: '~3.5" W x 2.5" D x 10" H',
                roast: 'Color: Matte black',
                origin: 'Roasted in the USA',
                note: 'Label size: 1.75 in (H) x 3.75 in (L)',
                mainImage: '10oz_1.png',
                previewImages: ['10oz_1.png', '10oz_2.jpg', '10oz_3.jpg', '10oz_4.jpg']
            },
            'kcup': {
                title: 'K Cup',
                size: '12 Count Box',
                roast: 'Color: Matte black',
                origin: 'Roasted in the USA',
                note: '',
                mainImage: 'kcup.jpg',
                previewImages: ['kcup.jpg', 'kcup_2.jpg', 'kcup_3.jpg', 'kcup_4.jpg']
            }
        };

         let currentMainImage = '';

        // Get all package buttons
        const packageButtons = document.querySelectorAll('.package-btn');
        const mainImage = document.getElementById('mainImage');

        // Function to handle preview image interactions
        function setupPreviewImages(size) {
            const product = productData[size];
            currentMainImage = `../images/buyer/${product.mainImage}`;

            // Set up each preview image
            // for (let i = 1; i <= 4; i++) {
            //     const previewImg = document.getElementById(`pv${i}Image`);
            //     const previewSrc = `../images/buyer/${product.previewImages[i-1]}`;
            //     previewImg.src = previewSrc;

            //     // Add hover event
            //     previewImg.addEventListener('mouseenter', () => {
            //         mainImage.src = previewSrc;
            //     });

            //     // Add mouseleave event
            //     previewImg.addEventListener('mouseleave', () => {
            //         mainImage.src = currentMainImage;
            //     });

            //     // Add click event
            //     previewImg.addEventListener('click', () => {
            //         currentMainImage = previewSrc;
            //         mainImage.src = currentMainImage;
            //         if (i === 1) {
            //             document.getElementById('logoOverlay').style.display = 'block';
            //         } else {
            //             document.getElementById('logoOverlay').style.display = 'none';
            //         } 
            //     });
            // }
        }

        // Add click event listeners to all package buttons
        packageButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                packageButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.classList.add('btn-light');
                });
                
                // Add active class to clicked button
                button.classList.add('active');
                button.classList.remove('btn-light');
                
                // Update product details based on selected size
                const size = button.getAttribute('data-size');
                if (size === 'kcup') {
                    document.getElementById('quantity_section').style.display = 'none';
                    document.getElementById('designOverlay').style.display = 'none';
                    document.getElementById('formDropzone').style.display = 'none';
                } else {
                    document.getElementById('quantity_section').style.display = 'block';
                    document.getElementById('designOverlay').style.display = 'block';
                    document.getElementById('formDropzone').style.display = 'block';
                }
                updateProductDetails(size);
                 // save bag option
                saveBagOption(size);
            });
        });

             // Set up draggable and resizable functionality
        const logoPlaceholder = document.getElementById('logoPlaceholder');
        const mainPreview = document.querySelector('.main-preview');
        // const num_of_bags = document.getElementById('bag_quantity').value;
        // const stockPostingId = document.getElementById('stock_id').value;

        // Initialize position and size variables
        let currentX = 0;
        let currentY = 0;
        let currentWidth = 180;
        let currentHeight = 80;
        interact(logoPlaceholder)
            .draggable({
                inertia: true,
                modifiers: [
                    interact.modifiers.restrictRect({
                        restriction: '.main-preview',
                        endOnly: true
                    })
                ],
                listeners: {
                    move: dragMoveListener,
                    start: function (event) {
                        event.target.classList.add('dragging');
                    },
                    end: function (event) {
                        event.target.classList.remove('dragging');
                    }
                }
            })
            .resizable({
                edges: { 
                    left: '.resize-handle.top-left, .resize-handle.bottom-left', 
                    right: '.resize-handle.top-right, .resize-handle.bottom-right', 
                    top: '.resize-handle.top-left, .resize-handle.top-right', 
                    bottom: '.resize-handle.bottom-left, .resize-handle.bottom-right'
                },
                restrictEdges: {
                    outer: '.main-preview',
                    endOnly: true
                },
                restrictSize: {
                    min: { width: 100, height: 50 }
                },
                inertia: true
            })
            .on('resizemove', function (event) {
                currentX = (parseFloat(event.target.getAttribute('data-x')) || 0);
                currentY = (parseFloat(event.target.getAttribute('data-y')) || 0);

                Object.assign(event.target.style, {
                    width: `${event.rect.width}px`,
                    height: `${event.rect.height}px`,
                    transform: `translate(${currentX}px, ${currentY}px)`
                });

                currentWidth = event.rect.width;
                currentHeight = event.rect.height;
            });

        function dragMoveListener(event) {
            currentX = (parseFloat(event.target.getAttribute('data-x')) || 0) + event.dx;
            currentY = (parseFloat(event.target.getAttribute('data-y')) || 0) + event.dy;

            Object.assign(event.target.style, {
                transform: `translate(${currentX}px, ${currentY}px)`
            });

            // Store the position
            event.target.setAttribute('data-x', currentX);
            event.target.setAttribute('data-y', currentY);
        }

        // Function to update product details
        function updateProductDetails(size) {
            const product = productData[size];
            const productDetails = document.getElementById('productDetails');

            document.getElementById('designOverlay').className = `design-overlay-${size}`;         // Update product details
            productDetails.innerHTML = `
                            <h4 class="mb-3 top_space"><b>${product.title}</b></h4>
                            <h6>Bag details</h6>
                            <p class="mb-1">Size: ${product.size}</p>
                            <p class="mb-1">${product.roast}</p>
                            <p class="mb-1">${product.origin}</p>
                            <p class="small text-muted mb-4">${product.note}</p>
                        `;          // Update main image
            mainImage.src = `../images/buyer/${product.mainImage}`;
            currentMainImage = `../images/buyer/${product.mainImage}`;

            // Set up preview images
            setupPreviewImages(size);

             // Reset logo placeholder position
            logoPlaceholder.style.transform = 'translate(-50%, -50%)';
            logoPlaceholder.setAttribute('data-x', 0);
            logoPlaceholder.setAttribute('data-y', 0);
            currentX = 0;
            currentY = 0;
        }

        function saveBagOption(size) {
            var selected_bag= document.getElementById('selected_bag');
            if (size === 'kcup') {
            //    setPressedOption('bag_size','k_cup','k_cup_bag_size');
            //    selected_bag.value = 'k_cup';
               selected_bag.value = '';
            }
            if (size === '12oz') {
               setPressedOption('bag_size','12oz_frac_pack','oz_frac_pack_bag_size');
               selected_bag.value = '12oz_frac_pack';
            }
            if (size === 'frac_pack') {
               setPressedOption('bag_size','frac_pack_3oz','frac_pack_bag_size');
               selected_bag.value = 'frac_pack_3oz';
            }
            if (size === 'frac_pack_3oz') {
               setPressedOption('bag_size','frac_pack_3oz','frac_pack_bag_size');
               selected_bag.value = 'frac_pack_3oz';
            }
            if (size === 'frac_pack_4oz') {
               setPressedOption('bag_size','frac_pack_4oz','frac_pack_bag_size');
               selected_bag.value = 'frac_pack_4oz';
            }
            if (size === '10oz') {
               setPressedOption('bag_size','10oz_bag','oz_bag_size');
               selected_bag.value = '10oz_bag';
            }
            if (size === '5lb') {
               setPressedOption('bag_size','5lb_bag','lb_bag_size');
               selected_bag.value = '5lb_bag';
            }
            showCompleteNextButton(document.getElementById('numBags').value);
        }

                // Logo handling
        const logoOverlay = document.getElementById('logoOverlay');
        let isDragging = false;
        let icurrentX = 0;
        let icurrentY = 0;
        let initialX = 0;
        let initialY = 0;
        let xOffset = 0;
        let yOffset = 0;

        // Only set up logo drag events if logo overlay exists
        if (logoOverlay) {
            logoOverlay.addEventListener('mousedown', dragStart);
            document.addEventListener('mousemove', drag);
            document.addEventListener('mouseup', dragEnd);
        }

        function dragStart(e) {
            initialX = e.clientX - xOffset;
            initialY = e.clientY - yOffset;
            if (e.target === logoOverlay) {
                isDragging = true;
            }
        }

        function drag(e) {
            if (isDragging) {
                e.preventDefault();
                icurrentX = e.clientX - initialX;
                icurrentY = e.clientY - initialY;
                xOffset = icurrentX;
                yOffset = currentY;
                setTranslate(icurrentX, icurrentY, logoOverlay);
            }
        }

        function dragEnd() {
            initialX = icurrentX;
            initialY = icurrentY;
            isDragging = false;
        }

        function setTranslate(xPos, yPos, el) {
            el.style.transform = `translate(${xPos}px, ${yPos}px)`;
        }

        document.getElementById('numBags').addEventListener('input', function() {
            showCompleteNextButton(this.value);
             setPressedOption('num_of_bags',this.value,'');
        });


    function showCompleteNextButton(numBags) {
            const btnRoastNext = document.getElementById('btn_roast_next');
            var selected_bag = document.getElementById('selected_bag').value;
            // alert('numBags: ' + numBags + ' selected_bag: ' + selected_bag);
            if (numBags > 0 && selected_bag !== '') {
                btnRoastNext.innerHTML = ` <a href="/buyerWizardSuccess/${encodeURIComponent(numBags)}/${encodeURIComponent(3)}" class="btn btn-primary w-100 text-white">Next</a>`;
                // btnRoastNext.style.display = 'block';
                // btnRoastNext.href = "{{ route('buyerWizardSuccess', [${encodeURIComponent(num_of_bags)}, ${encodeURIComponent(stockPostingId)}]) }}";
                // //

            } else {
               btnRoastNext.innerHTML = ``;
            }
    }
       