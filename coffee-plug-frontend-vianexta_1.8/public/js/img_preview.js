// const canvas = document.getElementById("viewer");
// const context = canvas.getContext("2d");

// // Canvas size
// canvas.width = 800;
// canvas.height = 400;

// // Load 360 images (images should be named sequentially, e.g., frame1.jpg, frame2.jpg)
// const frameCount = 36; // Total number of frames
// const images = [];
// for (let i = 1; i <= frameCount; i++) {
//     const img = new Image();
//     img.src = `../frames/frame${i}.jpg`;
//     images.push(img);
// }

// // Track the current frame and interaction
// let currentFrame = 0;
// let isDragging = false;
// let startX = 0;

// // Function to draw the current frame
// const drawFrame = (index) => {
//     const image = images[index];
//     if (image.complete) {
//         context.clearRect(0, 0, canvas.width, canvas.height);
//         context.drawImage(image, 0, 0, canvas.width, canvas.height);
//     } else {
//         image.onload = () => drawFrame(index);
//     }
// };

// // Handle mouse events
// canvas.addEventListener("mousedown", (event) => {
//     isDragging = true;
//     startX = event.clientX;
// });

// canvas.addEventListener("mousemove", (event) => {
//     if (!isDragging) return;
//     const deltaX = event.clientX - startX;
//     startX = event.clientX;

//     // Calculate frame based on movement
//     currentFrame = (currentFrame + Math.sign(deltaX) + frameCount) % frameCount;
//     drawFrame(currentFrame);
// });

// canvas.addEventListener("mouseup", () => {
//     isDragging = false;
// });

// // Handle touch events for mobile
// canvas.addEventListener("touchstart", (event) => {
//     isDragging = true;
//     startX = event.touches[0].clientX;
// });

// canvas.addEventListener("touchmove", (event) => {
//     if (!isDragging) return;
//     const deltaX = event.touches[0].clientX - startX;
//     startX = event.touches[0].clientX;

//     currentFrame = (currentFrame + Math.sign(deltaX) + frameCount) % frameCount;
//     drawFrame(currentFrame);
// });

// canvas.addEventListener("touchend", () => {
//     isDragging = false;
// });

// // Initial render
// images[0].onload = () => drawFrame(currentFrame);

//     var dimage= "https://s3.eu-central-1.amazonaws.com/threesixty.js/watch.jpg";
//     var dimageg= "../images/market_place/blackbags/dbag.jpg";
//    const threesixty = new ThreeSixty(document.getElementById('threesixty'), {
//         image: dimageg,
//         width: 320,
//         height: 320,
//         count: 31,
//         perRow: 4,
//         speed: 100,
//         prev: document.getElementById('prev'),
//         next: document.getElementById('next')
//     });

//     threesixty.play();


    // JS for the new images prieview
 let isDragging = false;
        let currentX;
        let currentY;
        let initialX;
        let initialY;
        let xOffset = 0;
        let yOffset = 0;

        // Handle product image selection
        document.querySelectorAll('.product-image').forEach(img => {
            img.addEventListener('click', function() {
                document.querySelectorAll('.product-image').forEach(i => {
                    i.classList.remove('selected');
                });

                this.classList.add('selected');

                const selectedImage = document.getElementById('selectedImage');
                selectedImage.src = this.getAttribute('data-image');
                selectedImage.style.display = 'block';

                // Enable logo upload
                document.getElementById('logoUpload').disabled = false;
            });
        });

        // Handle logo upload
        document.getElementById('logoUpload').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    const logoOverlay = document.getElementById('logoOverlay');
                    logoOverlay.src = event.target.result;
                    logoOverlay.style.display = 'block';

                    xOffset = 0;
                    yOffset = 0;
                    setTranslate(0, 0, logoOverlay);
                }

                reader.readAsDataURL(e.target.files[0]);
            }
        });

        const logoOverlay = document.getElementById('logoOverlay');

        logoOverlay.addEventListener('mousedown', dragStart);
        document.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', dragEnd);

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

                currentX = e.clientX - initialX;
                currentY = e.clientY - initialY;

                xOffset = currentX;
                yOffset = currentY;

                setTranslate(currentX, currentY, logoOverlay);
            }
        }

        function dragEnd(e) {
            initialX = currentX;
            initialY = currentY;
            isDragging = false;
        }

        function setTranslate(xPos, yPos, el) {
            el.style.transform = `translate(${xPos}px, ${yPos}px)`;
        }