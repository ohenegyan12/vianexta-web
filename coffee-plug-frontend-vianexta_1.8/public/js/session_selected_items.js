document.addEventListener('DOMContentLoaded', function() {
    checkSessionRoast();
    checkSessionProduct();
    checkSessionGrindRoastType();
    checkSessionPackage();
  

    function checkSessionRoast() {
        var roastOption = document.getElementById('session_roast').value;
        if (roastOption === 'yes') {
            setPressedOption('roast', 'yes', document.querySelector('.option-button[onclick*="setPressedOption(\'roast\',\'yes\',this)"]'));
        } 
        if (roastOption === 'no') {
            setPressedOption('roast', 'no', document.querySelector('.option-button[onclick*="setPressedOption(\'roast\',\'no\',this)"]'));
        }
        if (roastOption === 'whole_sale_brand') {
            setPressedOption('roast', 'whole_sale_brand', document.querySelector('.option-button[onclick*="setPressedOption(\'roast\',\'whole_sale_brand\',this)"]'));
        }
    }

    function checkSessionProduct() {
        var productOption = document.getElementById('session_product').value;
        if (productOption !== '') {
            setPressedOption('product',productOption,'product_'+productOption);
        }
    }
    function checkSessionGrindRoastType() {
        var roastTypeOption = document.getElementById('session_roast_type').value;
        var grindTypeOption = document.getElementById('session_grind_type').value;
        // alert('roastTypeOption: '+roastTypeOption);
        if (roastTypeOption !== '') {
            setPressedOption('roast_type',roastTypeOption,roastTypeOption+"_roast_type");
        }
        if (grindTypeOption !== '') {
            setPressedOption('grind_type',grindTypeOption,grindTypeOption+"_grind_type");
        }
    }
    function checkSessionPackage() {
        var numOfBagsOption = document.getElementById('session_num_of_bags').value;
        var bagSizeOption = document.getElementById('session_bag_size').value;
        // alert('bagSizeOption: '+bagSizeOption);
        if (bagSizeOption !== '') {
            const button = document.getElementById(bagSizeOption);
                if (button) {
                    button.classList.add('active');
                    button.classList.remove('btn-light');
                            
                    // Update product details based on selected size
                    const size = button.getAttribute('data-size');
                    updateProductDetails(size);
                    
                    // For frac pack, use the specific size from selected_bag if available
                    if (size === 'frac_pack') {
                        const selectedBag = document.getElementById('selected_bag');
                        if (selectedBag && selectedBag.value && (selectedBag.value === 'frac_pack_3oz' || selectedBag.value === 'frac_pack_4oz')) {
                            saveBagOption(selectedBag.value);
                        } else {
                            saveBagOption(size);
                        }
                    } else {
                        saveBagOption(size);
                    }
                 }
        }

                   
        
    }
});