document.addEventListener('DOMContentLoaded', function() {
    const productSelection = document.getElementById('product_selection');
    const productDescription = document.getElementById('product_description');
    const productQuantity = document.getElementById('product_quantity');
    const productImage = document.getElementById('product_image');
    const productDetails = document.querySelectorAll('div[id="product_details"]');

    productSelection.addEventListener('change', function() {
        // alert('productSelection change event');
        const selectedOption = productSelection.options[productSelection.selectedIndex];
        
          if (selectedOption.value === '') {
            productDetails.forEach(function(detail) {
                detail.style.display = 'none';
            });
             setPressedOption('product','','');
        } else {
             productDetails.forEach(function(detail) {
                detail.style.display = 'block';
            });
            let product;
            try {
                product = JSON.parse(selectedOption.getAttribute('data-product'));
            } catch (e) {
                console.error('Invalid JSON in data-product attribute', e);
                productDetails.forEach(function(detail) {
                    detail.style.display = 'none';
                });
                return;
            }
            setPressedOption('product',product.id,'');
            const prodImg = product.imageUrl || '../images/market_place/product_big_img.svg';
            const prodDesc = product.supplierInfo.firstName === 'Win' ? product.description.toUpperCase() : (product.name ? product.name : product.description);
//  console.log('items:',product);
//  console.log('prod:',prodDesc);
            productDescription.textContent = prodDesc;
            productQuantity.textContent =  product.quantityLeft + ' bags available';
            productImage.src = prodImg;

            document.getElementById('vendor').textContent = product.supplierInfo.firstName != null ? product.supplierInfo.firstName : '';
            document.getElementById('variety').textContent = product.variety != null ? product.variety : '';
            document.getElementById('coffeeType').textContent = product.coffeeType != null ? product.coffeeType : '';
            document.getElementById('quality').textContent = product.quality != null ? product.quality : '';
            document.getElementById('aroma').textContent = product.aroma != null ? product.aroma : '';
            document.getElementById('process').textContent = product.process != null ? product.process : '';
        }
      
    });

    // Trigger change event to set initial values
    // productSelection.dispatchEvent(new Event('change'));

            const singleOriginRadio = document.getElementById('single_origin');
            const blendRadio = document.getElementById('blend');
           
            const productSelectionDiv = document.querySelectorAll('div[id="product_selection_div"]');
            const productMarketPlace = document.querySelector('div#product_market_place');

            function toggleProductSelection() {
                if (singleOriginRadio.checked) {
                    productSelectionDiv.forEach(function(detail) {
                        detail.style.display = 'none';
                    });
                    productMarketPlace.style.display = 'block';
                } else if (blendRadio.checked) {
                    productSelectionDiv.forEach(function(detail) {
                        detail.style.display = 'block';
                    });
                    productMarketPlace.style.display = 'none';
                }
                // Initiate select2
                $('.form-select').select2();
            }

            singleOriginRadio.addEventListener('change', toggleProductSelection);
            blendRadio.addEventListener('change', toggleProductSelection);

            // Initial call to set the correct visibility on page load
            toggleProductSelection();
});

function filterProducts() {
        $('#filterForm, #multiFilterForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    $('#productList').html(response);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    }