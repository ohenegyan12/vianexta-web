document.addEventListener('DOMContentLoaded', function () {
    const roastedCard = document.getElementById('roasted-card');
    const wholesaleCard = document.getElementById('wholesale-card');
    const step2 = document.getElementById('step2');
    const singleOriginCard = document.getElementById('single-origin-card');
    const blendCard = document.getElementById('blend-card');
    const singleOriginSection = document.getElementById('single-origin-section');
    const roastTypeSection = document.getElementById('roast-type-section');
    const grindTypeSection = document.getElementById('grind-type-section');
    const packageSection = document.getElementById('package-section');
    const blendProductSection = document.getElementById('blend-product-section');
    const blendDetailSection = document.getElementById('blend-detail-section');
    // colombianCard and brazilCard removed - replaced with dynamic blend loading
    const productDetailImg = document.querySelector('.product-detail-img');
    const wholesaleProductSection = document.getElementById('wholesale-product-section');
    const wholesaleDetailSection = document.getElementById('wholesale-detail-section');
    const doneSection = document.getElementById('done-section');
    const beanCardGrid = document.getElementById('bean-card-grid');
    
    // Quantity section attention animation
    const quantitySection = document.getElementById('quantity_section');
    if (quantitySection) {
        // Add attention animation when quantity section is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        quantitySection.classList.add('attention');
                        setTimeout(() => {
                            quantitySection.classList.remove('attention');
                        }, 6000); // Remove class after animation completes
                    }, 500); // Small delay to ensure smooth transition
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(quantitySection);
    }

    // Global variables for wizard state
    let selectedProduct = null;
    let selectedRoastType = null;
    let selectedGrindType = null;
    let selectedBagSize = null;
    let currentPage = 1;
    let currentProductType = 'roasted_single_origin';
    let wholesaleCurrentPage = 1;
    let wholesaleTotalPages = 1;

    // Loading spinner functions
    window.showLoadingSpinner = function() {
        console.log('🔄 showLoadingSpinner called');
        const spinner = document.getElementById('loadingSpinner');
        const beanCardGrid = document.getElementById('bean-card-grid');
        const prevBtn = document.getElementById('prev-page');
        const nextBtn = document.getElementById('next-page');
        
        if (spinner) {
            spinner.classList.add('show');
            console.log('✅ Loading spinner shown');
        } else {
            console.error('❌ Loading spinner element not found');
        }
        if (beanCardGrid) beanCardGrid.classList.add('loading');
        if (prevBtn) prevBtn.classList.add('loading');
        if (nextBtn) nextBtn.classList.add('loading');
    }

    window.hideLoadingSpinner = function() {
        console.log('🔄 hideLoadingSpinner called');
        const spinner = document.getElementById('loadingSpinner');
        const beanCardGrid = document.getElementById('bean-card-grid');
        const prevBtn = document.getElementById('prev-page');
        const nextBtn = document.getElementById('next-page');
        const paginationTabs = document.querySelectorAll('.pagination-tab');
        
        if (spinner) {
            spinner.classList.remove('show');
            console.log('✅ Loading spinner hidden');
        } else {
            console.error('❌ Loading spinner element not found');
        }
        if (beanCardGrid) beanCardGrid.classList.remove('loading');
        if (prevBtn) prevBtn.classList.remove('loading');
        if (nextBtn) nextBtn.classList.remove('loading');
        paginationTabs.forEach(tab => tab.classList.remove('loading'));
    }

    // Wholesale loading spinner functions
    // Make wholesale loading functions globally accessible
    window.showWholesaleLoadingSpinner = function() {
        const spinner = document.getElementById('loadingSpinner');
        const wholesaleCardGrid = document.getElementById('wholesale-card-grid');
        const wholesalePrevBtn = document.getElementById('wholesale-prev-page');
        const wholesaleNextBtn = document.getElementById('wholesale-next-page');
        
        if (spinner) spinner.classList.add('show');
        if (wholesaleCardGrid) wholesaleCardGrid.classList.add('loading');
        if (wholesalePrevBtn) wholesalePrevBtn.classList.add('loading');
        if (wholesaleNextBtn) wholesaleNextBtn.classList.add('loading');
    }

    window.hideWholesaleLoadingSpinner = function() {
        const spinner = document.getElementById('loadingSpinner');
        const wholesaleCardGrid = document.getElementById('wholesale-card-grid');
        const wholesalePrevBtn = document.getElementById('wholesale-prev-page');
        const wholesaleNextBtn = document.getElementById('wholesale-next-page');
        const wholesalePaginationTabs = document.querySelectorAll('#wholesale-pagination .pagination-tab');
        
        if (spinner) spinner.classList.remove('show');
        if (wholesaleCardGrid) wholesaleCardGrid.classList.remove('loading');
        if (wholesalePrevBtn) wholesalePrevBtn.classList.remove('loading');
        if (wholesaleNextBtn) wholesaleNextBtn.classList.remove('loading');
        wholesalePaginationTabs.forEach(tab => tab.classList.remove('loading'));
    }

    // JavaScript equivalent of PHP getCountryCode function
    window.getCountryCode = function(countryName) {
        const countries = [
            { name: "Afghanistan", code: "AF" },
            { name: "Aland Islands", code: "AX" },
            { name: "Albania", code: "AL" },
            { name: "Algeria", code: "DZ" },
            { name: "AmericanSamoa", code: "AS" },
            { name: "Andorra", code: "AD" },
            { name: "Angola", code: "AO" },
            { name: "Anguilla", code: "AI" },
            { name: "Antarctica", code: "AQ" },
            { name: "Antigua and Barbuda", code: "AG" },
            { name: "Argentina", code: "AR" },
            { name: "Armenia", code: "AM" },
            { name: "Aruba", code: "AW" },
            { name: "Australia", code: "AU" },
            { name: "Austria", code: "AT" },
            { name: "Azerbaijan", code: "AZ" },
            { name: "Bahamas", code: "BS" },
            { name: "Bahrain", code: "BH" },
            { name: "Bangladesh", code: "BD" },
            { name: "Barbados", code: "BB" },
            { name: "Belarus", code: "BY" },
            { name: "Belgium", code: "BE" },
            { name: "Belize", code: "BZ" },
            { name: "Benin", code: "BJ" },
            { name: "Bermuda", code: "BM" },
            { name: "Bhutan", code: "BT" },
            { name: "Bolivia", code: "BO" },
            { name: "Bosnia and Herzegovina", code: "BA" },
            { name: "Botswana", code: "BW" },
            { name: "Bouvet Island", code: "BV" },
            { name: "Brazil", code: "BR" },
            { name: "British Indian Ocean Territory", code: "IO" },
            { name: "Brunei Darussalam", code: "BN" },
            { name: "Bulgaria", code: "BG" },
            { name: "Burkina Faso", code: "BF" },
            { name: "Burundi", code: "BI" },
            { name: "Cambodia", code: "KH" },
            { name: "Cameroon", code: "CM" },
            { name: "Canada", code: "CA" },
            { name: "Cape Verde", code: "CV" },
            { name: "Cayman Islands", code: "KY" },
            { name: "Central African Republic", code: "CF" },
            { name: "Chad", code: "TD" },
            { name: "Chile", code: "CL" },
            { name: "China", code: "CN" },
            { name: "Christmas Island", code: "CX" },
            { name: "Cocos (Keeling) Islands", code: "CC" },
            { name: "Colombia", code: "CO" },
            { name: "Comoros", code: "KM" },
            { name: "Congo", code: "CG" },
            { name: "Congo, Democratic Republic of the", code: "CD" },
            { name: "Cook Islands", code: "CK" },
            { name: "Costa Rica", code: "CR" },
            { name: "Cote d'Ivoire", code: "CI" },
            { name: "Croatia", code: "HR" },
            { name: "Cuba", code: "CU" },
            { name: "Cyprus", code: "CY" },
            { name: "Czech Republic", code: "CZ" },
            { name: "Denmark", code: "DK" },
            { name: "Djibouti", code: "DJ" },
            { name: "Dominica", code: "DM" },
            { name: "Dominican Republic", code: "DO" },
            { name: "Ecuador", code: "EC" },
            { name: "Egypt", code: "EG" },
            { name: "El Salvador", code: "SV" },
            { name: "Equatorial Guinea", code: "GQ" },
            { name: "Eritrea", code: "ER" },
            { name: "Estonia", code: "EE" },
            { name: "Ethiopia", code: "ET" },
            { name: "Falkland Islands (Malvinas)", code: "FK" },
            { name: "Faroe Islands", code: "FO" },
            { name: "Fiji", code: "FJ" },
            { name: "Finland", code: "FI" },
            { name: "France", code: "FR" },
            { name: "French Guiana", code: "GF" },
            { name: "French Polynesia", code: "PF" },
            { name: "French Southern Territories", code: "TF" },
            { name: "Gabon", code: "GA" },
            { name: "Gambia", code: "GM" },
            { name: "Georgia", code: "GE" },
            { name: "Germany", code: "DE" },
            { name: "Ghana", code: "GH" },
            { name: "Gibraltar", code: "GI" },
            { name: "Greece", code: "GR" },
            { name: "Greenland", code: "GL" },
            { name: "Grenada", code: "GD" },
            { name: "Guadeloupe", code: "GP" },
            { name: "Guam", code: "GU" },
            { name: "Guatemala", code: "GT" },
            { name: "Guernsey", code: "GG" },
            { name: "Guinea", code: "GN" },
            { name: "Guinea-Bissau", code: "GW" },
            { name: "Guinea-Bissau", code: "GW" },
            { name: "Guyana", code: "GY" },
            { name: "Haiti", code: "HT" },
            { name: "Heard Island & Mcdonald Islands", code: "HM" },
            { name: "Holy See (Vatican City State)", code: "VA" },
            { name: "Honduras", code: "HN" },
            { name: "Hong Kong", code: "HK" },
            { name: "Hungary", code: "HU" },
            { name: "Iceland", code: "IS" },
            { name: "India", code: "IN" },
            { name: "Indonesia", code: "ID" },
            { name: "Iran, Islamic Republic Of", code: "IR" },
            { name: "Iraq", code: "IQ" },
            { name: "Ireland", code: "IE" },
            { name: "Isle Of Man", code: "IM" },
            { name: "Israel", code: "IL" },
            { name: "Italy", code: "IT" },
            { name: "Jamaica", code: "JM" },
            { name: "Japan", code: "JP" },
            { name: "Jersey", code: "JE" },
            { name: "Jordan", code: "JO" },
            { name: "Kazakhstan", code: "KZ" },
            { name: "Kenya", code: "KE" },
            { name: "Kiribati", code: "KI" },
            { name: "Korea", code: "KR" },
            { name: "Kuwait", code: "KW" },
            { name: "Kyrgyzstan", code: "KG" },
            { name: "Lao People's Democratic Republic", code: "LA" },
            { name: "Latvia", code: "LV" },
            { name: "Lebanon", code: "LB" },
            { name: "Lesotho", code: "LS" },
            { name: "Liberia", code: "LR" },
            { name: "Libyan Arab Jamahiriya", code: "LY" },
            { name: "Liechtenstein", code: "LI" },
            { name: "Lithuania", code: "LT" },
            { name: "Luxembourg", code: "LU" },
            { name: "Macao", code: "MO" },
            { name: "Macedonia", code: "MK" },
            { name: "Madagascar", code: "MG" },
            { name: "Malawi", code: "MW" },
            { name: "Malaysia", code: "MY" },
            { name: "Maldives", code: "MV" },
            { name: "Malta", code: "MT" },
            { name: "Marshall Islands", code: "MH" },
            { name: "Martinique", code: "MQ" },
            { name: "Mauritania", code: "MR" },
            { name: "Mauritius", code: "MU" },
            { name: "Mayotte", code: "YT" },
            { name: "Mexico", code: "MX" },
            { name: "Micronesia, Federated States Of", code: "FM" },
            { name: "Moldova", code: "MD" },
            { name: "Monaco", code: "MC" },
            { name: "Mongolia", code: "MN" },
            { name: "Montenegro", code: "ME" },
            { name: "Montserrat", code: "MS" },
            { name: "Morocco", code: "MA" },
            { name: "Mozambique", code: "MZ" },
            { name: "Myanmar", code: "MM" },
            { name: "Namibia", code: "NA" },
            { name: "Nauru", code: "NR" },
            { name: "Nepal", code: "NP" },
            { name: "Netherlands", code: "NL" },
            { name: "Netherlands Antilles", code: "AN" },
            { name: "Mali", code: "ML" },
            { name: "New Caledonia", code: "NC" },
            { name: "New Zealand", code: "NZ" },
            { name: "Nicaragua", code: "NI" },
            { name: "Niger", code: "NE" },
            { name: "Niger", code: "NE" },
            { name: "Nigeria", code: "NG" },
            { name: "Niue", code: "NU" },
            { name: "Norfolk Island", code: "NF" },
            { name: "Northern Mariana Islands", code: "MP" },
            { name: "Norway", code: "NO" },
            { name: "Oman", code: "OM" },
            { name: "Pakistan", code: "PK" },
            { name: "Palau", code: "PW" },
            { name: "Palestinian Territory, Occupied", code: "PS" },
            { name: "Panama", code: "PA" },
            { name: "Papua New Guinea", code: "PG" },
            { name: "Paraguay", code: "PY" },
            { name: "Peru", code: "PE" },
            { name: "Philippines", code: "PH" },
            { name: "Pitcairn", code: "PN" },
            { name: "Poland", code: "PL" },
            { name: "Portugal", code: "PT" },
            { name: "Puerto Rico", code: "PR" },
            { name: "Qatar", code: "QA" },
            { name: "Reunion", code: "RE" },
            { name: "Romania", code: "RO" },
            { name: "Russian Federation", code: "RU" },
            { name: "Rwanda", code: "RW" },
            { name: "Saint Barthelemy", code: "BL" },
            { name: "Saint Helena", code: "SH" },
            { name: "Saint Kitts and Nevis", code: "KN" },
            { name: "Saint Lucia", code: "LC" },
            { name: "Saint Martin", code: "MF" },
            { name: "Saint Pierre and Miquelon", code: "PM" },
            { name: "Saint Vincent and Grenadines", code: "VC" },
            { name: "Samoa", code: "WS" },
            { name: "San Marino", code: "SM" },
            { name: "Sao Tome and Principe", code: "ST" },
            { name: "Saudi Arabia", code: "SA" },
            { name: "Senegal", code: "SN" },
            { name: "Serbia", code: "RS" },
            { name: "Seychelles", code: "SC" },
            { name: "Sierra Leone", code: "SL" },
            { name: "Singapore", code: "SG" },
            { name: "Slovakia", code: "SK" },
            { name: "Slovenia", code: "SI" },
            { name: "Solomon Islands", code: "SB" },
            { name: "Somalia", code: "SO" },
            { name: "South Africa", code: "ZA" },
            { name: "South Georgia and Sandwich Isl.", code: "GS" },
            { name: "Spain", code: "ES" },
            { name: "Sri Lanka", code: "LK" },
            { name: "Sudan", code: "SD" },
            { name: "Suriname", code: "SR" },
            { name: "Svalbard and Jan Mayen", code: "SJ" },
            { name: "Swaziland", code: "SZ" },
            { name: "Sweden", code: "SE" },
            { name: "Switzerland", code: "CH" },
            { name: "Syrian Arab Republic", code: "SY" },
            { name: "Taiwan", code: "TW" },
            { name: "Tajikistan", code: "TJ" },
            { name: "Tanzania", code: "TZ" },
            { name: "Thailand", code: "TH" },
            { name: "Timor-Leste", code: "TL" },
            { name: "Togo", code: "TG" },
            { name: "Tokelau", code: "TK" },
            { name: "Tonga", code: "TO" },
            { name: "Trinidad and Tobago", code: "TT" },
            { name: "Tunisia", code: "TN" },
            { name: "Turkey", code: "TR" },
            { name: "Turkmenistan", code: "TM" },
            { name: "Turks and Caicos Islands", code: "TC" },
            { name: "Tuvalu", code: "TV" },
            { name: "Uganda", code: "UG" },
            { name: "Ukraine", code: "UA" },
            { name: "United Arab Emirates", code: "AE" },
            { name: "United Kingdom", code: "GB" },
            { name: "United States", code: "US" },
            { name: "United States Minor Outlying Islands", code: "UM" },
            { name: "Uruguay", code: "UY" },
            { name: "Uzbekistan", code: "UZ" },
            { name: "Vanuatu", code: "VU" },
            { name: "Venezuela", code: "VE" },
            { name: "Vietnam", code: "VN" },
            { name: "Virgin Islands, British", code: "VG" },
            { name: "Virgin Islands, U.S.", code: "VI" },
            { name: "Wallis and Futuna", code: "WF" },
            { name: "Western Sahara", code: "EH" },
            { name: "Yemen", code: "YE" },
            { name: "Zambia", code: "ZM" },
            { name: "Zimbabwe", code: "ZW" }
        ];
        
        for (let country of countries) {
            if (country.name.toLowerCase() === countryName.toLowerCase()) {
                return country.code;
            }
        }
        return "US"; // Default fallback
    }

    // Product selection function
    window.selectProduct = function(productId, productName, productType) {
        selectedProduct = {
            id: productId,
            name: productName,
            type: productType
        };
        
        // Update session via AJAX
        fetch('/buyerOrderOptions/product/' + productId, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        }).then(response => {
            console.log('Product selected:', productName);
        }).catch(error => {
            console.error('Error saving product selection:', error);
        });

        // Highlight selected card
        const allCards = document.querySelectorAll('.bean-card');
        allCards.forEach(card => card.classList.remove('active'));
        event.target.closest('.bean-card').classList.add('active');

        // Show roast type section
        if (roastTypeSection) {
            roastTypeSection.style.display = 'block';
            scrollToSection(roastTypeSection);
        }
    };

    // Pagination functionality for bean cards with AJAX
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const paginationTabs = document.getElementById('pagination-tabs');
    const wholesalePrevPageBtn = document.getElementById('wholesale-prev-page');
    const wholesaleNextPageBtn = document.getElementById('wholesale-next-page');
    
    if (prevPageBtn) {
        prevPageBtn.addEventListener('click', function() {
            if (currentPage > 1) {
                showLoadingSpinner();
                currentPage--;
                loadProducts('roasted_single_origin', currentPage);
            }
        });
    }
    
    if (nextPageBtn) {
        nextPageBtn.addEventListener('click', function() {
            showLoadingSpinner();
            currentPage++;
            loadProducts('roasted_single_origin', currentPage);
        });
    }

    // Wholesale pagination event listeners
    if (wholesalePrevPageBtn) {
        wholesalePrevPageBtn.addEventListener('click', function() {
            if (wholesaleCurrentPage > 1) {
                showWholesaleLoadingSpinner();
                wholesaleCurrentPage--;
                loadWholesaleProducts('whole_sale_brand', wholesaleCurrentPage);
            }
        });
    }

    if (wholesaleNextPageBtn) {
        wholesaleNextPageBtn.addEventListener('click', function() {
            showWholesaleLoadingSpinner();
            wholesaleCurrentPage++;
            loadWholesaleProducts('whole_sale_brand', wholesaleCurrentPage);
        });
    }

    // Make loadProducts globally accessible
    window.loadProducts = function(productType, page = 1) {
        console.log('🔄 loadProducts called with:', { productType, page });
        currentPage = page;
        showLoadingSpinner();
        
        // Add a small delay to make loading spinner visible (remove in production)
        setTimeout(() => {
            fetch('/get-wizard-products', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    productType: productType,
                    page: currentPage
                })
            })
            .then(response => response.json())
            .then(data => {
                hideLoadingSpinner();
                if (data.products && data.products.length > 0) {
                    // Clear existing products and add new ones
                    const grid = document.getElementById('bean-card-grid');
                    if (grid) {
                        grid.innerHTML = '';
                        appendProducts(data.products, productType);
                    }
                    
                    // Update pagination info
                    const pageInfo = document.getElementById('single-origin-page-info');
                    if (pageInfo) {
                        pageInfo.textContent = `Page ${data.currentPage} of ${data.totalPages}`;
                    }
                    
                    // Generate pagination tabs
                    generatePaginationTabs(data.currentPage, data.totalPages);
                    
                    // Update navigation buttons
                    updateNavigationButtons(data.currentPage, data.totalPages);
                }
            })
            .catch(error => {
                hideLoadingSpinner();
                console.error('Error loading products:', error);
            });
        }, 500); // 500ms delay for testing - remove in production
    }

    // Make loadBlendProducts globally accessible
    window.loadBlendProducts = function(productType, page = 1, retryCount = 0) {
        showLoadingSpinner();
        
        console.log('Loading blend products:', { productType, page, retryCount });
        
        // Add a timeout to automatically hide spinner if something goes wrong
        const spinnerTimeout = setTimeout(() => {
            console.log('⚠️ Blend spinner timeout reached, hiding spinner and loading fallback');
            hideLoadingSpinner();
            // Load fallback products if API doesn't respond
            console.log('Loading fallback blend products due to timeout...');
            loadFallbackBlendProducts();
        }, 3000); // 3 second timeout - very fast fallback
        
        // Simplified approach: Try API first, fallback immediately if it fails
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 3000); // 3 second timeout
        
        fetch('/get-wizard-products', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                productType: productType,
                page: page
            }),
            signal: controller.signal
        })
        .then(response => {
            clearTimeout(timeoutId);
            console.log('Raw blend response status:', response.status, response.statusText);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return response.json();
        })
        .then(data => {
            clearTimeout(spinnerTimeout); // Clear the timeout
            hideLoadingSpinner();
            console.log('Blend products response:', data);
            
            // Validate response structure
            if (!data || typeof data !== 'object') {
                console.error('Invalid blend response format:', data);
                loadFallbackBlendProducts();
                return;
            }
            
            if (data.products && Array.isArray(data.products) && data.products.length > 0) {
                // Clear existing products and add new ones
                const grid = document.getElementById('blend-card-grid');
                if (grid) {
                    appendBlendProducts(data.products, productType);
                }
                
                // Update pagination info
                const pageInfo = document.getElementById('blend-page-info');
                if (pageInfo) {
                    pageInfo.textContent = `Page ${data.currentPage || 1} of ${data.totalPages || 1}`;
                }
                
                // Generate pagination tabs
                if (data.totalPages > 1) {
                    generateBlendPaginationTabs(data.currentPage || 1, data.totalPages);
                }
                
                // Update navigation buttons
                updateBlendNavigationButtons(data.currentPage || 1, data.totalPages || 1);
                
                // Show pagination controls
                const blendPagination = document.getElementById('blend-pagination');
                if (blendPagination) {
                    if (data.totalPages > 1) {
                        blendPagination.style.display = 'block';
                        console.log('✅ Blend pagination shown for', data.totalPages, 'pages');
                    } else {
                        blendPagination.style.display = 'none';
                        console.log('✅ Blend pagination hidden - only 1 page');
                    }
                } else {
                    console.error('❌ Blend pagination element not found');
                }
            } else {
                console.log('No blend products returned or empty array');
                console.log('Response data:', data);
                loadFallbackBlendProducts();
            }
        })
        .catch(error => {
            clearTimeout(timeoutId);
            clearTimeout(spinnerTimeout); // Clear the spinner timeout
            hideLoadingSpinner();
            console.error('Error loading blend products:', error);
            
            // Immediately load fallback products on any error
            console.log('Loading fallback blend products due to error...');
            loadFallbackBlendProducts();
        });
    }

    // Make loadWholesaleProducts globally accessible
    window.loadWholesaleProducts = function(productType, page = 1, retryCount = 0) {
        wholesaleCurrentPage = page;
        showWholesaleLoadingSpinner();
        
        console.log('Loading wholesale products:', { productType, page, retryCount });
        console.log('Loading spinner element:', document.getElementById('loadingSpinner'));
        console.log('Wholesale card grid element:', document.getElementById('wholesale-card-grid'));
        
        // Add a timeout to automatically hide spinner if something goes wrong
        const spinnerTimeout = setTimeout(() => {
            console.log('⚠️ Spinner timeout reached, hiding spinner and loading fallback');
            hideWholesaleLoadingSpinner();
            // Load fallback products if API doesn't respond
            console.log('Loading fallback products due to timeout...');
            loadFallbackWholesaleProducts();
        }, 3000); // 3 second timeout - very fast fallback
        
        // Simplified approach: Try API first, fallback immediately if it fails
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 3000); // 3 second timeout
        
        fetch('/get-wizard-products', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                productType: productType,
                page: wholesaleCurrentPage
            }),
            signal: controller.signal
        })
        .then(response => {
            clearTimeout(timeoutId);
            console.log('Raw response status:', response.status, response.statusText);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return response.json();
        })
        .then(data => {
            clearTimeout(spinnerTimeout); // Clear the timeout
            hideWholesaleLoadingSpinner();
            console.log('Wholesale products response:', data);
            
            // Validate response structure
            if (!data || typeof data !== 'object') {
                console.error('Invalid response format:', data);
                loadFallbackWholesaleProducts();
                return;
            }
            
            if (data.products && Array.isArray(data.products) && data.products.length > 0) {
                // Clear existing products and add new ones
                const grid = document.getElementById('wholesale-card-grid');
                if (grid) {
                    appendWholesaleProducts(data.products, productType);
                }
                
                // Update pagination info
                const pageInfo = document.getElementById('wholesale-page-info');
                if (pageInfo) {
                    pageInfo.textContent = `Page ${data.currentPage || 1} of ${data.totalPages || 1}`;
                }
                
                // Generate pagination tabs
                if (data.totalPages > 1) {
                    generateWholesalePaginationTabs(data.currentPage || 1, data.totalPages);
                }
                
                // Update navigation buttons
                updateWholesaleNavigationButtons(data.currentPage || 1, data.totalPages || 1);
                
                // Show pagination controls
                const wholesalePagination = document.getElementById('wholesale-pagination');
                if (wholesalePagination && data.totalPages > 1) {
                    wholesalePagination.style.display = 'block';
                } else if (wholesalePagination) {
                    wholesalePagination.style.display = 'none';
                }
            } else {
                console.log('No wholesale products returned or empty array');
                console.log('Response data:', data);
                loadFallbackWholesaleProducts();
            }
        })
        .catch(error => {
            clearTimeout(timeoutId);
            clearTimeout(spinnerTimeout); // Clear the spinner timeout
            hideWholesaleLoadingSpinner();
            console.error('Error loading wholesale products:', error);
            
            // Immediately load fallback products on any error
            console.log('Loading fallback products due to error...');
            loadFallbackWholesaleProducts();
        });
    }

    function generatePaginationTabs(currentPage, totalPages) {
        const paginationTabs = document.getElementById('pagination-tabs');
        if (!paginationTabs) return;
        
        paginationTabs.innerHTML = '';
        
        // Show max 7 tabs (current page, 3 before, 3 after)
        const maxTabs = 7;
        let startPage = Math.max(1, currentPage - Math.floor(maxTabs / 2));
        let endPage = Math.min(totalPages, startPage + maxTabs - 1);
        
        // Adjust start page if we're near the end
        if (endPage - startPage < maxTabs - 1) {
            startPage = Math.max(1, endPage - maxTabs + 1);
        }
        
        // Add first page if not included
        if (startPage > 1) {
            addPaginationTab(1, currentPage);
            if (startPage > 2) {
                addPaginationEllipsis();
            }
        }
        
        // Add page tabs
        for (let i = startPage; i <= endPage; i++) {
            addPaginationTab(i, currentPage);
        }
        
        // Add last page if not included
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                addPaginationEllipsis();
            }
            addPaginationTab(totalPages, currentPage);
        }
    }

    function generateWholesalePaginationTabs(currentPage, totalPages) {
        const paginationTabs = document.getElementById('wholesale-pagination-tabs');
        if (!paginationTabs) return;
        
        paginationTabs.innerHTML = '';
        
        // Show max 7 tabs (current page, 3 before, 3 after)
        const maxTabs = 7;
        let startPage = Math.max(1, currentPage - Math.floor(maxTabs / 2));
        let endPage = Math.min(totalPages, startPage + maxTabs - 1);
        
        // Adjust start page if we're near the end
        if (endPage - startPage < maxTabs - 1) {
            startPage = Math.max(1, endPage - maxTabs + 1);
        }
        
        // Add first page if not included
        if (startPage > 1) {
            addWholesalePaginationTab(1, currentPage);
            if (startPage > 2) {
                addWholesalePaginationEllipsis();
            }
        }
        
        // Add page tabs
        for (let i = startPage; i <= endPage; i++) {
            addWholesalePaginationTab(i, currentPage);
        }
        
        // Add last page if not included
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                addWholesalePaginationEllipsis();
            }
            addWholesalePaginationTab(totalPages, currentPage);
        }
    }

    function addPaginationTab(pageNum, currentPage) {
        const paginationTabs = document.getElementById('pagination-tabs');
        const tab = document.createElement('button');
        tab.className = `pagination-tab ${pageNum === currentPage ? 'active' : ''}`;
        tab.textContent = pageNum;
        tab.addEventListener('click', () => {
            loadProducts('roasted_single_origin', pageNum);
        });
        paginationTabs.appendChild(tab);
    }

    function addWholesalePaginationTab(pageNum, currentPage) {
        const paginationTabs = document.getElementById('wholesale-pagination-tabs');
        const tab = document.createElement('button');
        tab.className = `pagination-tab ${pageNum === currentPage ? 'active' : ''}`;
        tab.textContent = pageNum;
        tab.addEventListener('click', () => {
            loadWholesaleProducts('whole_sale_brand', pageNum);
        });
        paginationTabs.appendChild(tab);
    }

    function addPaginationEllipsis() {
        const paginationTabs = document.getElementById('pagination-tabs');
        const ellipsis = document.createElement('span');
        ellipsis.className = 'pagination-ellipsis';
        ellipsis.textContent = '...';
        ellipsis.style.cssText = 'padding: 0 8px; color: #666; font-weight: bold;';
        paginationTabs.appendChild(ellipsis);
    }

    function addWholesalePaginationEllipsis() {
        const paginationTabs = document.getElementById('wholesale-pagination-tabs');
        const ellipsis = document.createElement('span');
        ellipsis.className = 'pagination-ellipsis';
        ellipsis.textContent = '...';
        ellipsis.style.cssText = 'padding: 0 8px; color: #666; font-weight: bold;';
        paginationTabs.appendChild(ellipsis);
    }

    function updateNavigationButtons(currentPage, totalPages) {
        const prevBtn = document.getElementById('prev-page');
        const nextBtn = document.getElementById('next-page');
        
        if (prevBtn) {
            prevBtn.disabled = currentPage <= 1;
        }
        
        if (nextBtn) {
            nextBtn.disabled = currentPage >= totalPages;
        }
    }

    function updateWholesaleNavigationButtons(currentPage, totalPages) {
        const prevBtn = document.getElementById('wholesale-prev-page');
        const nextBtn = document.getElementById('wholesale-next-page');
        
        if (prevBtn) {
            prevBtn.disabled = currentPage <= 1;
        }
        
        if (nextBtn) {
            nextBtn.disabled = currentPage >= totalPages;
        }
    }

    function appendProducts(products, productType) {
        console.log('🔄 appendProducts called with:', { products: products?.length, productType });
        const grid = document.getElementById('bean-card-grid');
        if (!grid) return;

        // Clear existing content
        grid.innerHTML = '';

        // Center grid if there are only 2-3 products
        if (products.length <= 3) {
            grid.classList.add('centered');
            console.log('✅ Grid centered for', products.length, 'products');
        } else {
            grid.classList.remove('centered');
        }

        products.forEach(product => {
            const card = document.createElement('div');
            card.className = 'bean-card';
            card.setAttribute('data-product-id', product.id || '');
            card.setAttribute('data-product-name', product.description || '');
            card.setAttribute('data-product-type', productType);
            card.onclick = function() {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                const productType = this.getAttribute('data-product-type');

                // Highlight selected card
                document.querySelectorAll('.bean-card').forEach(c => c.classList.remove('active'));
                this.classList.add('active');

                // Update session via AJAX
                fetch('/buyerOrderOptions/product/' + productId, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    }
                }).then(response => {
                    console.log('Product selected:', productName);
                }).catch(error => {
                    console.error('Error saving product selection:', error);
                });

                // Show roast type section
                const roastTypeSection = document.getElementById('roast-type-section');
                if (roastTypeSection) {
                    roastTypeSection.style.display = 'block';
                    roastTypeSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            };

                           // Get country code for flag using the same logic as the blade template
               let prodCountry;
            //    if(product.supplierInfo?.firstName === 'Win'){
                   const countryFromDesc = product.description.split(' ');
                   // Handle multi-word country names like "Costa Rica", "United States", etc.
                   prodCountry = '';
                   for(let i = 0; i < countryFromDesc.length; i++){
                       const testCountry = countryFromDesc.slice(0, i + 1).join(' ');
                       const testCode = getCountryCode(testCountry);
                       if(testCode !== 'US' || i === 0){
                           prodCountry = testCountry;
                           if(testCode !== 'US'){
                               break;
                           }
                       }
                   }
            //    }else{
            //        prodCountry = product.supplierInfo?.billingCountry || 'US';
            //    }
               
               // JavaScript equivalent of getCountryCode function
               const countryCode = getCountryCode(prodCountry);
               const flagUrl = `https://flagcdn.com/w40/${countryCode.toLowerCase()}.png`;

            card.innerHTML = `
                <img src="${product.imageUrl || '/new_buyer_wizard/images/green-been.png'}" alt="Coffee Bean" class="bean-img">
                <div class="bean-card-info">
                    <div class="bean-card-main">
                        <div class="bean-card-title">${(product.description || 'Unknown').toUpperCase()}</div>
                        <div class="bean-card-meta">
                            <img src="${flagUrl}" alt="Country Flag" class="bean-flag">
                            <span class="bean-region">${prodCountry}</span>
                        </div>
                        <div class="bean-type">${product.coffeeType || 'Arabica'}</div>
                    </div>
                    <div class="bean-card-score">
                        <div class="score-box">${product.quality || 'N/A'}</div>
                        <div class="score-label">Score</div>
                    </div>
                </div>
            `;

            grid.appendChild(card);
        });
    }

    window.appendWholesaleProducts = function(products, productType) {
        const grid = document.getElementById('wholesale-card-grid');
        if (!grid) return;

        // Clear the grid first
        grid.innerHTML = '';

        // If no products, show no products message
        if (!products || products.length === 0) {
            grid.innerHTML = `
                <div class="no-products-message">
                    <div class="no-products-icon">📦</div>
                    <div class="no-products-title">No Wholesale Products Available</div>
                    <div class="no-products-description">There are currently no wholesale products available. Please check back later or contact our support team.</div>
                </div>
            `;
            return;
        }

        // Center grid if there are only 2-3 products
        if (products.length <= 3) {
            grid.classList.add('centered');
            console.log('✅ Wholesale grid centered for', products.length, 'products');
        } else {
            grid.classList.remove('centered');
        }

        products.forEach(product => {
            const card = document.createElement('div');
            card.className = 'bean-card';
            card.setAttribute('data-product-id', product.id || '');
            card.setAttribute('data-product-name', product.description || '');
            card.setAttribute('data-product-type', productType);
            card.onclick = function() {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                const productType = this.getAttribute('data-product-type');

                // Remove active class from all wholesale cards
                document.querySelectorAll('#wholesale-card-grid .bean-card').forEach(c => c.classList.remove('active'));
                // Add active class to clicked card
                this.classList.add('active');

                // Update session via AJAX
                fetch('/buyerOrderOptions/product/' + productId, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    }
                }).then(response => {
                    console.log('Wholesale product selected:', productName);
                }).catch(error => {
                    console.error('Error saving wholesale product selection:', error);
                });

                // Hide all sections first
                const singleOriginSection = document.getElementById('single-origin-section');
                const blendProductSection = document.getElementById('blend-product-section');
                const roastTypeSection = document.getElementById('roast-type-section');
                const grindTypeSection = document.getElementById('grind-type-section');
                const packageSection = document.getElementById('package-section');
                const doneSection = document.getElementById('done-section');
                
                if (singleOriginSection) singleOriginSection.style.display = 'none';
                if (blendProductSection) blendProductSection.style.display = 'none';
                if (roastTypeSection) roastTypeSection.style.display = 'none';
                if (grindTypeSection) grindTypeSection.style.display = 'none';
                if (packageSection) packageSection.style.display = 'none';
                if (doneSection) doneSection.style.display = 'none';
                // colombian-detail-section removed - no longer exists

                // Show wholesale detail section
                const wholesaleDetailSection = document.getElementById('wholesale-detail-section');
                if (wholesaleDetailSection) {
                    wholesaleDetailSection.style.display = 'block';
                    wholesaleDetailSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }

                // Update wholesale detail section with product info
                updateWholesaleProductDetails(product);
            };

            // Get country code for flag using the same logic as the blade template
            let prodCountry;
            // if (product.supplierInfo?.firstName === 'Win') {
                const countryFromDesc = product.description.split(' ');
                // Handle multi-word country names like "Costa Rica", "United States", etc.
                prodCountry = '';
                for(let i = 0; i < countryFromDesc.length; i++){
                    const testCountry = countryFromDesc.slice(0, i + 1).join(' ');
                    const testCode = getCountryCode(testCountry);
                    if(testCode !== 'US' || i === 0){
                        prodCountry = testCountry;
                        if(testCode !== 'US'){
                            break;
                        }
                    }
                }
            // } else {
            //     prodCountry = product.supplierInfo?.billingCountry || 'US';
            // }

            // JavaScript equivalent of getCountryCode function
            const countImg = getCountryCode(prodCountry);
            const flagUrl = `https://flagcdn.com/w40/${countImg.toLowerCase()}.png`;

            card.innerHTML = `
                <img src="${product.imageUrl || '/new_buyer_wizard/images/wholesale-bag.png'}" alt="Wholesale Product" class="bean-img">
                <div class="bean-card-info">
                    <div class="bean-card-main">
                        <div class="bean-card-title">${(product.description || 'Unknown').toUpperCase()}</div>
                        <div class="bean-card-meta">
                            <img src="${flagUrl}" alt="${prodCountry}" class="bean-flag">
                            <span class="bean-region">${prodCountry}</span>
                        </div>
                        <div class="bean-type">${product.coffeeType || 'Arabica'}</div>
                    </div>
                    <div class="bean-card-score">
                        <div class="score-box">${product.quality || 'N/A'}</div>
                        <div class="score-label">Score</div>
                    </div>
                </div>
            `;

            grid.appendChild(card);
        });
    }

    // Pagination controls will be shown when single origin section is displayed

    function hideAllMainSections() {
        if (doneSection) doneSection.style.display = 'none';
        if (wholesaleDetailSection) wholesaleDetailSection.style.display = 'none';
        if (wholesaleProductSection) wholesaleProductSection.style.display = 'none';
        if (packageSection) packageSection.style.display = 'none';
        // colombianDetailSection removed - replaced with blendDetailSection
        if (blendDetailSection) blendDetailSection.style.display = 'none';
        if (blendProductSection) blendProductSection.style.display = 'none';
        if (singleOriginSection) singleOriginSection.style.display = 'none';
        if (roastTypeSection) roastTypeSection.style.display = 'none';
        if (grindTypeSection) grindTypeSection.style.display = 'none';
    }

    function scrollToSection(section) {
        if (section) {
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    roastedCard.addEventListener('click', function () {
        // Remove active class from all wizard option cards
        document.querySelectorAll('.wizard-option-card').forEach(c => c.classList.remove('active'));
        // Add active class to clicked card
        roastedCard.classList.add('active');
        wholesaleCard.classList.remove('active');
        console.log('✅ Roasted card selected - active classes cleared and set correctly');
        console.log('Roasted card classes:', roastedCard.className);
        console.log('Wholesale card classes:', wholesaleCard.className);
        
        // Debug: Check all wizard option cards
        document.querySelectorAll('.wizard-option-card').forEach((card, index) => {
            console.log(`Card ${index + 1} (${card.id}):`, card.className, 'Active:', card.classList.contains('active'));
        });
        
        // Update roast session variable to "yes"
        fetch('/buyerOrderOptions/roast/yes', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        }).then(response => {
            console.log('✅ Roast session variable set to "yes"');
        }).catch(error => {
            console.error('Error setting roast session variable:', error);
        });
        
        // Hide all main sections including wholesale products
        hideAllMainSections();
        
        // Show step2 section for "How do you want your coffee?"
        step2.style.display = 'block';
        scrollToSection(step2);
    });

        wholesaleCard.addEventListener('click', function () {
        // Remove active class from all wizard option cards
        document.querySelectorAll('.wizard-option-card').forEach(c => c.classList.remove('active'));
        // Add active class to clicked card
        wholesaleCard.classList.add('active');
        roastedCard.classList.remove('active');
        console.log('✅ Wholesale card selected - active classes cleared and set correctly');
        console.log('Wholesale card classes:', wholesaleCard.className);
        console.log('Roasted card classes:', roastedCard.className);
        
        // Debug: Check all wizard option cards
        document.querySelectorAll('.wizard-option-card').forEach((card, index) => {
            console.log(`Card ${index + 1} (${card.id}):`, card.className, 'Active:', card.classList.contains('active'));
        });
        
        // Reset session data for wholesale option
        fetch('/buyerOrderOptions/roast_type/null', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        }).then(response => {
            console.log('✅ Roast type session variable reset to null for wholesale');
        }).catch(error => {
            console.error('Error resetting roast type session variable for wholesale:', error);
        });

        fetch('/buyerOrderOptions/grind_type/null', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        }).then(response => {
            console.log('✅ Grind type session variable reset to null for wholesale');
        }).catch(error => {
            console.error('Error resetting grind type session variable for wholesale:', error);
        });

        fetch('/buyerOrderOptions/bag_size/null', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        }).then(response => {
            console.log('✅ Bag size session variable reset to null for wholesale');
        }).catch(error => {
            console.error('Error resetting bag size session variable for wholesale:', error);
        });

        fetch('/buyerOrderOptions/bag_image/', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        }).then(response => {
            console.log('✅ Bag image session variable reset to empty for wholesale');
        }).catch(error => {
            console.error('Error resetting bag image session variable for wholesale:', error);
        });
        
        // Update roast session variable to "yes"
        fetch('/buyerOrderOptions/roast/yes', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        }).then(response => {
            console.log('✅ Roast session variable set to "yes" for wholesale');
        }).catch(error => {
            console.error('Error setting roast session variable for wholesale:', error);
        });
        
        // Hide step2 section for wholesale (no "How do you want your coffee?" needed)
        step2.style.display = 'none';
        console.log('✅ Step2 section hidden for wholesale selection');
        hideAllMainSections();
        if (wholesaleProductSection) {
            wholesaleProductSection.style.display = 'block';
            scrollToSection(wholesaleProductSection);
            
            // Ensure wholesale card grid exists before loading products
            const wholesaleCardGrid = document.getElementById('wholesale-card-grid');
            if (!wholesaleCardGrid) {
                console.error('❌ Wholesale card grid not found!');
                hideWholesaleLoadingSpinner();
                return;
            }
            
            console.log('✅ Wholesale card grid found, loading products...');
            
            // Load wholesale products
            if (typeof window.loadWholesaleProducts === 'function') {
                window.loadWholesaleProducts('whole_sale_brand', 1);
            } else {
                console.error('❌ loadWholesaleProducts function not available');
                // Load fallback products directly
                if (typeof window.loadFallbackWholesaleProducts === 'function') {
                    window.loadFallbackWholesaleProducts();
                }
            }
        }
    });

    singleOriginCard.addEventListener('click', function () {
        console.log('🔄 Single origin card clicked!');
        // Remove active class from all step 2 wizard option cards
        document.querySelectorAll('#step2 .wizard-option-card').forEach(c => c.classList.remove('active'));
        // Add active class to clicked card
        singleOriginCard.classList.add('active');
        blendCard.classList.remove('active');
        
        // Don't hide step2 section - keep "How do you want your coffee?" visible
        // Only hide other sections
        if (doneSection) doneSection.style.display = 'none';
        if (wholesaleDetailSection) wholesaleDetailSection.style.display = 'none';
        if (wholesaleProductSection) wholesaleProductSection.style.display = 'none';
        if (packageSection) packageSection.style.display = 'none';
        // colombianDetailSection removed - replaced with blendDetailSection
        if (blendDetailSection) blendDetailSection.style.display = 'none';
        if (blendProductSection) blendProductSection.style.display = 'none';
        if (roastTypeSection) roastTypeSection.style.display = 'none';
        if (grindTypeSection) grindTypeSection.style.display = 'none';
        
        if (singleOriginSection) {
            singleOriginSection.style.display = 'block';
            scrollToSection(singleOriginSection);
            
            // Ensure step2 section remains visible
            if (step2) {
                step2.style.display = 'block';
                console.log('✅ Step2 section kept visible for "How do you want your coffee?"');
            }
            
            console.log('✅ Single origin section displayed, loading products...');
            
            // Check if elements exist
            const beanCardGrid = document.getElementById('bean-card-grid');
            const paginationControls = document.getElementById('single-origin-pagination');
            console.log('Elements found:', { 
                singleOriginSection: !!singleOriginSection, 
                beanCardGrid: !!beanCardGrid, 
                paginationControls: !!paginationControls 
            });
            
            // Initialize pagination for single origin products
            if (paginationControls) {
                paginationControls.style.display = 'block';
                // Load first page of products
                if (typeof loadProducts === 'function') {
                    console.log('✅ loadProducts function found, calling...');
                    loadProducts('roasted_single_origin', 1);
                } else {
                    console.error('❌ loadProducts function not available');
                }
            } else {
                console.error('❌ Single origin pagination controls not found');
            }
        }
    });

    blendCard.addEventListener('click', function () {
        console.log('🔄 Blend card clicked!');
        // Remove active class from all step 2 wizard option cards
        document.querySelectorAll('#step2 .wizard-option-card').forEach(c => c.classList.remove('active'));
        // Add active class to clicked card
        blendCard.classList.add('active');
        singleOriginCard.classList.remove('active');
        
        // Don't hide step2 section - keep "How do you want your coffee?" visible
        // Only hide other sections
        if (doneSection) doneSection.style.display = 'none';
        if (wholesaleDetailSection) wholesaleDetailSection.style.display = 'none';
        if (wholesaleProductSection) wholesaleProductSection.style.display = 'none';
        if (packageSection) packageSection.style.display = 'none';
        // colombianDetailSection removed - replaced with blendDetailSection
        if (blendDetailSection) blendDetailSection.style.display = 'none';
        if (singleOriginSection) singleOriginSection.style.display = 'none';
        if (roastTypeSection) roastTypeSection.style.display = 'none';
        if (grindTypeSection) grindTypeSection.style.display = 'none';
        
        if (blendProductSection) {
            blendProductSection.style.display = 'block';
            scrollToSection(blendProductSection);
            
            // Ensure step2 section remains visible
            if (step2) {
                step2.style.display = 'block';
                console.log('✅ Step2 section kept visible for "How do you want your coffee?"');
            }
            
            console.log('✅ Blend product section displayed, loading products...');
            
            // Check if elements exist
            const blendCardGrid = document.getElementById('blend-card-grid');
            const paginationControls = document.getElementById('blend-pagination');
            console.log('Blend elements found:', { 
                blendProductSection: !!blendProductSection, 
                blendCardGrid: !!blendCardGrid, 
                paginationControls: !!paginationControls 
            });
            
            // Load blend products
            if (typeof window.loadBlendProducts === 'function') {
                console.log('✅ loadBlendProducts function found, calling...');
                window.loadBlendProducts('roasted_blend', 1);
            } else {
                console.error('❌ loadBlendProducts function not available');
                // Load fallback products directly
                if (typeof window.loadFallbackBlendProducts === 'function') {
                    console.log('✅ Loading fallback blend products...');
                    window.loadFallbackBlendProducts();
                } else {
                    console.error('❌ loadFallbackBlendProducts function not available');
                }
            }
        }
    });

    // Roast type selection
    document.querySelectorAll('.roast-type-card').forEach(function(card) {
        card.addEventListener('click', function() {
            document.querySelectorAll('.roast-type-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            
            const roastTypeLabel = card.querySelector('.roast-type-label').textContent.trim();
            
            // Map display labels to session values
            let selectedRoastType;
            switch(roastTypeLabel.toLowerCase()) {
                case 'light':
                    selectedRoastType = 'light';
                    break;
                case 'medium':
                    selectedRoastType = 'medium';
                    break;
                case 'medium-dark':
                    selectedRoastType = 'medium_dark';
                    break;
                case 'dark':
                    selectedRoastType = 'dark';
                    break;
                default:
                    selectedRoastType = roastTypeLabel.toLowerCase();
            }
            
            // Update session
            fetch('/buyerOrderOptions/roast_type/' + encodeURIComponent(selectedRoastType), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                }
            }).then(response => {
                console.log('Roast type selected:', selectedRoastType);
            }).catch(error => {
                console.error('Error saving roast type:', error);
            });
            
            if (grindTypeSection) {
                grindTypeSection.style.display = 'block';
                scrollToSection(grindTypeSection);
            }
        });
    });

    // Grind type selection
    document.querySelectorAll('.grind-type-card').forEach(function(card) {
        card.addEventListener('click', function() {
            document.querySelectorAll('.grind-type-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            
            const grindTypeLabel = card.querySelector('.grind-type-label').textContent.trim();
            
            // Map display labels to session values
            let selectedGrindType;
            switch(grindTypeLabel.toLowerCase()) {
                case 'whole bean':
                    selectedGrindType = 'whole_grain';
                    break;
                case 'coarse':
                    selectedGrindType = 'coarse';
                    break;
                case 'medium':
                    selectedGrindType = 'medium';
                    break;
                case 'fine':
                    selectedGrindType = 'fine';
                    break;
                case 'extra fine':
                    selectedGrindType = 'extra_fine';
                    break;
                default:
                    selectedGrindType = grindTypeLabel.toLowerCase().replace(' ', '_');
            }
            
            // Update session
            fetch('/buyerOrderOptions/grind_type/' + encodeURIComponent(selectedGrindType), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                }
            }).then(response => {
                console.log('Grind type selected:', selectedGrindType);
            }).catch(error => {
                console.error('Error saving grind type:', error);
            });
            
            if (packageSection) {
                packageSection.style.display = 'block';
                scrollToSection(packageSection);
            }
        });
    });

    // Package size selection with different previews
    const packagePreviewImg = document.getElementById('package-preview-img');
    const packageOptions = document.querySelectorAll('.package-option');
    
    console.log('🔍 script.js: Found', packageOptions.length, 'package-option elements');
    
    packageOptions.forEach(function(option) {
        option.addEventListener('click', function() {
            packageOptions.forEach(c => c.classList.remove('active'));
            option.classList.add('active');
            
            // Get the text content without the arrow span
            const bagSizeLabel = option.childNodes[0].textContent.trim();
            
            // Map display labels to session values
            let selectedBagSize;
            switch(bagSizeLabel.toLowerCase()) {
                case 'k cup':
                    selectedBagSize = 'k_cup';
                    break;
                case '12oz bag':
                    selectedBagSize = 'oz_frac_pack';
                    break;
                case '10oz bag':
                    selectedBagSize = 'oz_bag';
                    break;
                case '5lb bag':
                    selectedBagSize = 'lb';
                    break;
                default:
                    selectedBagSize = bagSizeLabel.toLowerCase().replace(/\s+/g, '_');
            }
            
            // Update session
            fetch('/buyerOrderOptions/bag_size/' + encodeURIComponent(selectedBagSize), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                }
            }).then(response => {
                console.log('Bag size selected:', selectedBagSize);
            }).catch(error => {
                console.error('Error saving bag size:', error);
            });
            
            // Update preview image based on selection
            const packageText = option.textContent.trim();
            if (packagePreviewImg) {
                if (packageText.includes('5lb')) {
                    packagePreviewImg.src = '/new_buyer_wizard/images/single-product.png'; // 5lb specific creative
                } else if (packageText.includes('K Cup')) {
                    packagePreviewImg.src = '/new_buyer_wizard/images/preview.png'; // K-cup specific creative
                } else {
                    packagePreviewImg.src = '/new_buyer_wizard/images/product.png'; // Same creative for 12oz and 10oz
                }
            }
            
            // Hide done section for K Cup (K Cup should not show done section)
            if (packageText.includes('K Cup')) {
                if (doneSection) doneSection.style.display = 'none';
            }
            // For other bags, done section will be shown when quantity is entered
        });
    });

    // Enhanced upload functionality with drag & drop
    const uploadCard = document.getElementById('logo-upload-card');
    const uploadInput = document.getElementById('logo-upload-input');
    const uploadIcon = document.getElementById('upload-icon');
    const uploadText = document.getElementById('upload-text');

    if (uploadCard && uploadInput) {
        // Click to upload
        uploadCard.addEventListener('click', function() {
            uploadInput.click();
        });

        // Drag and drop functionality
        uploadCard.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadCard.classList.add('drag-over');
        });

        uploadCard.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadCard.classList.remove('drag-over');
        });

        uploadCard.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadCard.classList.remove('drag-over');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileUpload(files[0]);
            }
        });

        uploadInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                handleFileUpload(file);
            }
        });

        function handleFileUpload(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    // Remove icon and text, show image preview
                    if (uploadIcon) uploadIcon.style.display = 'none';
                    if (uploadText) uploadText.style.display = 'none';
                    
                    let img = uploadCard.querySelector('.logo-preview');
                    if (!img) {
                        img = document.createElement('img');
                        img.className = 'logo-preview';
                        img.style.maxHeight = '48px';
                        img.style.maxWidth = '120px';
                        img.style.objectFit = 'contain';
                        img.style.display = 'block';
                        img.style.margin = '0 auto';
                        uploadCard.appendChild(img);
                    }
                    img.src = evt.target.result;

                    // Display logo on bag preview
                    const logoOverlay = document.getElementById('logoOverlay');
                    if (logoOverlay) {
                        logoOverlay.src = evt.target.result;
                        logoOverlay.style.display = 'block';
                    }

                    // Show logo placeholder on bag preview
                    const logoPlaceholder = document.getElementById('logoPlaceholder');
                    if (logoPlaceholder) {
                        logoPlaceholder.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        }
    }

    // Blend product card selection
    const blendProductCards = document.querySelectorAll('.blend-product-card');
    blendProductCards.forEach(function(card) {
        card.addEventListener('click', function() {
            blendProductCards.forEach(c => c.classList.remove('active'));
            card.classList.add('active');
        });
    });

    // colombianCard and brazilCard click handlers removed - replaced with dynamic blend loading

    if (productDetailImg) {
        productDetailImg.addEventListener('click', function () {
            if (packageSection) {
                packageSection.style.display = 'block';
                scrollToSection(packageSection);
            }
        });
    }

    if (wholesaleProductSection) {
        document.querySelectorAll('.wholesale-product-card').forEach(function(card) {
            card.addEventListener('click', function() {
                hideAllMainSections();
                if (wholesaleDetailSection) {
                    wholesaleDetailSection.style.display = 'block';
                    scrollToSection(wholesaleDetailSection);
                }
            });
        });
    }

    const wholesaleProceedBtn = document.querySelector('.wholesale-detail-proceed');
    if (wholesaleProceedBtn) {
        wholesaleProceedBtn.addEventListener('click', function() {
            // Get the selected wholesale product quantity (default to 1 if not set)
            const selectedQuantity = sessionStorage.getItem('selectedWholesaleQuantity') || 1;
            
            // Redirect to buyerWizardSuccess route with quantity and default stockpostingid
            window.location.href = `/buyerWizardSuccess/${encodeURIComponent(selectedQuantity)}/${encodeURIComponent(3)}`;
        });
    }
});

// Align certification card height to SCA Score table
function alignCertBoxHeight() {
    const certBox = document.querySelector('.product-detail-cert-box');
    const scaTableWrap = document.querySelector('.product-detail-sca-table-wrap');
    if (certBox && scaTableWrap) {
        certBox.style.minHeight = scaTableWrap.offsetHeight + 'px';
    }
}

window.addEventListener('load', alignCertBoxHeight);
window.addEventListener('resize', alignCertBoxHeight);

    // Note: updateWholesaleProductDetails is defined in the Blade template
    // This function has been removed to prevent conflicts with the comprehensive version

    window.loadFallbackWholesaleProducts = function() {
        console.log('Loading fallback wholesale products...');
        
        // Create some dummy products for testing
        const fallbackProducts = [
            {
                id: 'fallback-1',
                description: 'Sample Wholesale Coffee',
                imageUrl: '/new_buyer_wizard/images/wholesale-bag.png',
                supplierInfo: { firstName: 'Sample Vendor', billingCountry: 'US' },
                coffeeType: 'Arabica',
                quality: '85'
            },
            {
                id: 'fallback-2',
                description: 'Premium Wholesale Blend',
                imageUrl: '/new_buyer_wizard/images/wholesale-bag.png',
                supplierInfo: { firstName: 'Premium Co', billingCountry: 'Brazil' },
                coffeeType: 'Arabica',
                quality: '88'
            }
        ];
        
        hideWholesaleLoadingSpinner();
        appendWholesaleProducts(fallbackProducts, 'whole_sale_brand');
        
        // Hide pagination since we only have fallback data
        const wholesalePagination = document.getElementById('wholesale-pagination');
        if (wholesalePagination) {
            wholesalePagination.style.display = 'none';
        }
        
        console.log('Fallback products loaded');
    }

    // Blend Products Functions
    window.appendBlendProducts = function(products, productType) {
        const grid = document.getElementById('blend-card-grid');
        if (!grid) {
            console.error('Blend card grid not found');
            return;
        }

        // Clear existing content
        grid.innerHTML = '';

        if (!products || products.length === 0) {
            grid.innerHTML = `
                <div class="no-products-message">
                    <div class="no-products-icon">☕</div>
                    <div class="no-products-title">No Blend Products Available</div>
                    <div class="no-products-description">There are currently no blend products available. Please check back later or try selecting a different option.</div>
                </div>
            `;
            return;
        }

        // Center grid if there are only 2-3 products
        if (products.length <= 3) {
            grid.classList.add('centered');
            console.log('✅ Grid centered for', products.length, 'products');
        } else {
            grid.classList.remove('centered');
        }

        products.forEach(product => {
            const card = document.createElement('div');
            card.className = 'bean-card';
            card.setAttribute('data-product-id', product.id || '');
            card.setAttribute('data-product-name', product.description || '');
            card.setAttribute('data-product-type', 'blend');
            card.setAttribute('data-product-data', JSON.stringify(product));

            // Get country code for flag using the same logic as the blade template
            let prodCountry;
            if (product.supplierInfo?.firstName === 'Win') {
                const countryFromDesc = product.description.split(' ');
                // Handle multi-word country names like "Costa Rica", "United States", etc.
                prodCountry = '';
                for(let i = 0; i < countryFromDesc.length; i++){
                    const testCountry = countryFromDesc.slice(0, i + 1).join(' ');
                    const testCode = getCountryCode(testCountry);
                    if(testCode !== 'US' || i === 0){
                        prodCountry = testCountry;
                        if(testCode !== 'US'){
                            break;
                        }
                    }
                }
            } else {
                prodCountry = product.supplierInfo?.billingCountry || 'US';
            }
            
            // JavaScript equivalent of getCountryCode function
            const countImg = getCountryCode(prodCountry);
            const flagUrl = `https://flagcdn.com/w40/${countImg.toLowerCase()}.png`;

            card.innerHTML = `
                <img src="${product.imageUrl || '/new_buyer_wizard/images/green-been.png'}" alt="Coffee Bean" class="bean-img">
                <div class="bean-card-info">
                    <div class="bean-card-main">
                        <div class="bean-card-title">${(product.description || 'Unknown').toUpperCase()}</div>
                        <div class="bean-card-meta">
                            <img src="${flagUrl}" alt="${prodCountry}" class="bean-flag">
                            <span class="bean-region">${prodCountry}</span>
                        </div>
                        <div class="bean-type">${product.coffeeType || 'Arabica'}</div>
                    </div>
                    <div class="bean-card-score">
                        <div class="score-box">${product.quality || 'N/A'}</div>
                        <div class="score-label">Score</div>
                    </div>
                </div>
            `;

            // Add click handler
            card.addEventListener('click', function() {
                // Remove active class from all bean cards
                document.querySelectorAll('#blend-card-grid .bean-card').forEach(c => c.classList.remove('active'));
                // Add active class to clicked card
                this.classList.add('active');

                // Update session via AJAX
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                fetch('/buyerOrderOptions/product/' + productId, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    }
                }).then(response => {
                    console.log('Blend product selected:', productName);
                }).catch(error => {
                    console.error('Error saving blend product selection:', error);
                });

                // Show roast type section (same flow as single origin)
                const roastTypeSection = document.getElementById('roast-type-section');
                if (roastTypeSection) {
                    roastTypeSection.style.display = 'block';
                    roastTypeSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    console.log('✅ Roast type section shown for blend selection');
                } else {
                    console.error('❌ Roast type section not found');
                }
            });

            grid.appendChild(card);
        });
    }

    window.loadFallbackBlendProducts = function() {
        console.log('Loading fallback blend products...');
        
        const fallbackProducts = [
            {
                id: 'blend-1',
                description: 'Colombian Blend',
                coffeeType: 'Arabica',
                quality: '8.5',
                imageUrl: '/new_buyer_wizard/images/green-been.png',
                supplierInfo: { billingCountry: 'Colombia' },
                notes: 'Honey, Floral',
                process: 'Natural Washed',
                certifications: 'Fair Trade, Rainforest Alliance, USDA Organic',
                scaScores: { fragrance: 8, flavor: 8.5, acidity: 8, body: 8, uniformity: 8.5, balance: 8 }
            },
            {
                id: 'blend-2',
                description: 'Brazilian Blend',
                coffeeType: 'Arabica',
                quality: '8.2',
                imageUrl: '/new_buyer_wizard/images/green-been.png',
                supplierInfo: { billingCountry: 'Brazil' },
                notes: 'Nutty, Chocolate',
                process: 'Natural',
                certifications: 'Fair Trade, UTZ Certified',
                scaScores: { fragrance: 7.5, flavor: 8, acidity: 7, body: 8.5, uniformity: 8, balance: 7.5 }
            },
            {
                id: 'blend-3',
                description: 'Ethiopian Blend',
                coffeeType: 'Arabica',
                quality: '8.8',
                imageUrl: '/new_buyer_wizard/images/green-been.png',
                supplierInfo: { billingCountry: 'Ethiopia' },
                notes: 'Fruity, Floral',
                process: 'Washed',
                certifications: 'Fair Trade, Organic',
                scaScores: { fragrance: 8.5, flavor: 9, acidity: 8.5, body: 8, uniformity: 8.5, balance: 8.5 }
            },
            {
                id: 'blend-4',
                description: 'Guatemalan Blend',
                coffeeType: 'Arabica',
                quality: '8.3',
                imageUrl: '/new_buyer_wizard/images/green-been.png',
                supplierInfo: { billingCountry: 'Guatemala' },
                notes: 'Chocolate, Spice',
                process: 'Semi-Washed',
                certifications: 'Rainforest Alliance',
                scaScores: { fragrance: 8, flavor: 8.5, acidity: 7.5, body: 8.5, uniformity: 8, balance: 8 }
            }
        ];

        appendBlendProducts(fallbackProducts, 'roasted_blend');
        
        // Show pagination controls for fallback products (simulate multiple pages)
        const blendPagination = document.getElementById('blend-pagination');
        if (blendPagination) {
            blendPagination.style.display = 'block';
            console.log('✅ Blend pagination shown for fallback products');
        }
        
        // Update page info
        const pageInfo = document.getElementById('blend-page-info');
        if (pageInfo) {
            pageInfo.textContent = 'Page 1 of 2';
        }
        
        // Generate pagination tabs
        generateBlendPaginationTabs(1, 2);
        
        // Update navigation buttons
        updateBlendNavigationButtons(1, 2);
    }

    // updateBlendProductDetails function removed - blend now uses same flow as single origin

    window.generateBlendPaginationTabs = function(currentPage, totalPages) {
        const tabsContainer = document.getElementById('blend-pagination-tabs');
        if (!tabsContainer) return;

        tabsContainer.innerHTML = '';

        if (totalPages <= 1) return;

        // Always show first page
        addBlendPaginationTab(1, currentPage);

        if (totalPages > 7) {
            if (currentPage > 4) {
                addBlendPaginationEllipsis();
            }

            const start = Math.max(2, currentPage - 1);
            const end = Math.min(totalPages - 1, currentPage + 1);

            for (let i = start; i <= end; i++) {
                addBlendPaginationTab(i, currentPage);
            }

            if (currentPage < totalPages - 3) {
                addBlendPaginationEllipsis();
            }
        } else {
            for (let i = 2; i <= totalPages; i++) {
                addBlendPaginationTab(i, currentPage);
            }
        }

        // Always show last page if there are more than 1 page
        if (totalPages > 1) {
            addBlendPaginationTab(totalPages, currentPage);
        }
    }

    window.addBlendPaginationTab = function(pageNum, currentPage) {
        const tabsContainer = document.getElementById('blend-pagination-tabs');
        if (!tabsContainer) return;

        const tab = document.createElement('button');
        tab.className = 'pagination-tab';
        tab.textContent = pageNum;
        tab.setAttribute('data-page', pageNum);

        if (pageNum === currentPage) {
            tab.classList.add('active');
        }

        tab.addEventListener('click', function() {
            loadBlendProducts('roasted_blend', pageNum);
        });

        tabsContainer.appendChild(tab);
    }

    window.addBlendPaginationEllipsis = function() {
        const tabsContainer = document.getElementById('blend-pagination-tabs');
        if (!tabsContainer) return;

        const ellipsis = document.createElement('span');
        ellipsis.className = 'pagination-ellipsis';
        ellipsis.textContent = '...';
        tabsContainer.appendChild(ellipsis);
    }

    window.updateBlendNavigationButtons = function(currentPage, totalPages) {
        const prevButton = document.getElementById('blend-prev-page');
        const nextButton = document.getElementById('blend-next-page');

        if (prevButton) {
            prevButton.disabled = currentPage <= 1;
            prevButton.onclick = () => {
                if (currentPage > 1) {
                    loadBlendProducts('roasted_blend', currentPage - 1);
                }
            };
        }

        if (nextButton) {
            nextButton.onclick = () => {
                if (currentPage < totalPages) {
                    loadBlendProducts('roasted_blend', currentPage + 1);
                }
            };
        }
    }

    // proceedToPackageFromBlend function removed - blend now uses same flow as single origin