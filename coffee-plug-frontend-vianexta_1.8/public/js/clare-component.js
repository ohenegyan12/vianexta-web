/**
 * Clare Chat Component
 * A reusable JavaScript component for Clare chat functionality
 * Based on the implementation from new_landing_page.blade.php
 */

class ClareChatComponent {
    constructor(options = {}) {
        this.options = {
            apiEndpoint: 'https://coffeeplug-api-b982ba0e7659.herokuapp.com/api/voiceflow/chat',
            buttonText: 'Talk to Clare',
            buttonIcon: '/new_landing_assets/clare-icon.svg',
            logoIcon: '/new_landing_assets/winwin-circle.svg',
            ...options
        };
        
        this.isInitialized = false;
        this.userId = null;
        this.logoUploaded = false;
        this.uploadedLogoUrl = null;
        
        this.init();
    }

    init() {
        if (this.isInitialized) return;
        
        this.generateUserId();
        this.createChatButton();
        this.createChatDrawer();
        this.attachEventListeners();
        this.isInitialized = true;
        
        console.log('Clare Chat Component initialized');
    }

    generateUserId() {
        this.userId = localStorage.getItem('clare_chat_user_id');
        if (!this.userId) {
            this.userId = 'user_' + Math.random().toString(36).substr(2, 9) + '_' + Date.now();
            localStorage.setItem('clare_chat_user_id', this.userId);
        }
    }

    createChatButton() {
        // Remove existing button if it exists
        const existingButton = document.getElementById('clare-chat-btn');
        if (existingButton) {
            existingButton.remove();
        }

        const button = document.createElement('button');
        button.id = 'clare-chat-btn';
        button.className = 'clare-chat-btn';
        button.setAttribute('aria-label', 'Talk to Clare');
        button.type = 'button';
        
        button.innerHTML = `
            <img
                src="${this.options.buttonIcon}"
                alt="Clare Icon"
                class="clare-chat-icon"
                draggable="false"
            />
            <span class="clare-chat-text">${this.options.buttonText}</span>
        `;
        
        document.body.appendChild(button);
    }

    createChatDrawer() {
        // Remove existing drawer if it exists
        const existingDrawer = document.getElementById('clare-chat-drawer');
        if (existingDrawer) {
            existingDrawer.remove();
        }

        const drawer = document.createElement('div');
        drawer.id = 'clare-chat-drawer';
        drawer.className = 'clare-chat-drawer';
        
        drawer.innerHTML = `
            <div class="clare-chat-header">
                <div class="clare-chat-header-left">
                    <img src="${this.options.logoIcon}" alt="Clare Logo" class="clare-chat-logo" />
                    <span class="clare-chat-title">Clare</span>
                </div>
                <button class="clare-chat-close" id="clare-chat-close" aria-label="Close">
                    <svg width="20" height="20" fill="none" stroke="#222" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 6l12 12M6 18L18 6"/>
                    </svg>
                </button>
            </div>
            <div class="clare-chat-messages" id="clare-chat-messages"></div>
            <div class="clare-chat-input-area">
                <textarea id="clare-chat-input" class="clare-chat-input" placeholder="What can I help you with?" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" rows="1"></textarea>
                <button class="clare-chat-send" id="clare-chat-send" aria-label="Send">
                    <svg class="clare-chat-send-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(drawer);
    }

    attachEventListeners() {
        const chatBtn = document.getElementById('clare-chat-btn');
        const chatDrawer = document.getElementById('clare-chat-drawer');
        const chatClose = document.getElementById('clare-chat-close');
        const chatInput = document.getElementById('clare-chat-input');
        const chatSend = document.getElementById('clare-chat-send');

        // Open chat
        if (chatBtn) {
            chatBtn.addEventListener('click', () => {
                chatDrawer.classList.add('open');
                this.toggleBodyScroll(true);
                setTimeout(() => this.initializeSafariInput(), 300);
            });
        }

        // Close chat
        if (chatClose) {
            chatClose.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                chatDrawer.classList.remove('open');
                this.toggleBodyScroll(false);
            });
        }

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && chatDrawer.classList.contains('open')) {
                chatDrawer.classList.remove('open');
                this.toggleBodyScroll(false);
            }
        });

        // Close on click outside (desktop only)
        document.addEventListener('click', (e) => {
            if (window.innerWidth > 768 && 
                chatDrawer.classList.contains('open') && 
                !chatDrawer.contains(e.target) && 
                !e.target.closest('.clare-chat-btn')) {
                chatDrawer.classList.remove('open');
                this.toggleBodyScroll(false);
            }
        });

        // Input handling
        if (chatInput) {
            chatInput.addEventListener('input', (e) => {
                this.handleInputChange(e.target);
            });
            
            chatInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    this.handleSend();
                }
            });
            
            chatInput.addEventListener('paste', (e) => {
                setTimeout(() => {
                    this.handleInputChange(e.target);
                }, 10);
            });
            
            this.handleInputChange(chatInput);
        }

        // Send button
        if (chatSend) {
            chatSend.addEventListener('click', () => {
                this.handleSend();
            });
        }

        // Button overlap detection
        this.setupButtonOverlapDetection();
    }

    setupButtonOverlapDetection() {
        const chatBtn = document.getElementById('clare-chat-btn');
        if (!chatBtn) return;

        const checkOverlap = () => {
            const buttonRect = chatBtn.getBoundingClientRect();
            const greenSections = document.querySelectorAll('.green-section');
            let overlap = false;
            
            greenSections.forEach(section => {
                const sectionRect = section.getBoundingClientRect();
                if (
                    buttonRect.bottom > sectionRect.top &&
                    buttonRect.top < sectionRect.bottom &&
                    buttonRect.right > sectionRect.left &&
                    buttonRect.left < sectionRect.right
                ) {
                    overlap = true;
                }
            });
            
            if (overlap) {
                chatBtn.classList.add('on-green');
            } else {
                chatBtn.classList.remove('on-green');
            }
        };

        window.addEventListener('scroll', checkOverlap);
        window.addEventListener('resize', checkOverlap);
        window.addEventListener('DOMContentLoaded', () => setTimeout(checkOverlap, 100));
    }

    handleInputChange(input) {
        input.style.height = 'auto';
        const newHeight = Math.min(input.scrollHeight, 7.5 * 16);
        input.style.height = newHeight + 'px';
        
        if (input.scrollHeight > 7.5 * 16) {
            input.style.overflowY = 'auto';
        } else {
            input.style.overflowY = 'hidden';
        }
    }

    isSafari() {
        return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    }

    initializeSafariInput() {
        const chatInput = document.getElementById('clare-chat-input');
        if (this.isSafari() && chatInput) {
            chatInput.style.display = 'none';
            chatInput.style.opacity = '0';
            chatInput.style.visibility = 'hidden';
            
            setTimeout(() => {
                chatInput.style.display = 'block';
                chatInput.style.opacity = '1';
                chatInput.style.visibility = 'visible';
                chatInput.style.position = 'relative';
                chatInput.style.zIndex = '1000';
                chatInput.focus();
                chatInput.blur();
                
                setTimeout(() => {
                    chatInput.focus();
                }, 50);
            }, 100);
        }
    }

    toggleBodyScroll(disable) {
        if (window.innerWidth <= 768) {
            if (disable) {
                document.body.style.overflow = 'hidden';
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
            } else {
                document.body.style.overflow = '';
                document.body.style.position = '';
                document.body.style.width = '';
            }
        }
    }

    addUserMessage(text) {
        const chatMessages = document.getElementById('clare-chat-messages');
        const div = document.createElement('div');
        div.className = 'clare-chat-message-user';
        div.textContent = text;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    addBotMessage(html) {
        const chatMessages = document.getElementById('clare-chat-messages');
        const div = document.createElement('div');
        div.className = 'clare-chat-message-bot';
        
        const processedHtml = this.processImageUrls(html);
        
        div.innerHTML = `
            <img src="${this.options.logoIcon}" alt="Clare" class="clare-chat-bot-avatar" />
            <div class="clare-chat-message-bot-content">${processedHtml}</div>
        `;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    addTypingIndicator() {
        const chatMessages = document.getElementById('clare-chat-messages');
        const div = document.createElement('div');
        div.className = 'clare-chat-message-bot clare-chat-message-typing';
        div.innerHTML = `
            <img src="${this.options.logoIcon}" alt="Clare" class="clare-chat-bot-avatar" style="opacity:0.6;" />
            <div class="clare-chat-message-bot-content">Clare is typing...</div>
        `;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        return div;
    }

    cleanCloudinaryUrl(url) {
        try {
            let cleanedUrl = url;
            cleanedUrl = cleanedUrl.replace(/<\/?em>/g, '');
            cleanedUrl = cleanedUrl.replace(/lcoffeeplug:baglogos:baglogos:logoimage/g, 'l_coffee_plug:bag_logos:bag_logos:logo_image');
            cleanedUrl = cleanedUrl.replace(/w270,h350/g, 'w_270,h_350');
            cleanedUrl = cleanedUrl.replace(/gcenter,y80/g, 'g_center,y_80');
            cleanedUrl = cleanedUrl.replace(/flrelative/g, 'fl_relative');
            cleanedUrl = cleanedUrl.replace(/fl_relative5lb/g, 'fl_relative/5lb');
            
            cleanedUrl = cleanedUrl
                .replace(/&lt;/g, '<')
                .replace(/&gt;/g, '>')
                .replace(/&amp;/g, '&')
                .replace(/&quot;/g, '"')
                .replace(/&#x27;/g, "'")
                .replace(/&#x2F;/g, '/');
            
            cleanedUrl = cleanedUrl.replace(/<[^>]*>/g, '');
            cleanedUrl = cleanedUrl.replace(/[^\x20-\x7E]/g, '');
            
            if (!cleanedUrl.startsWith('http://') && !cleanedUrl.startsWith('https://')) {
                cleanedUrl = 'https://' + cleanedUrl;
            }
            
            return cleanedUrl;
        } catch (error) {
            console.error('Error cleaning Cloudinary URL:', error);
            return url;
        }
    }

    processImageUrls(html) {
        const markdownImageRegex = /!\[([^\]]*)\]\((https?:\/\/[^\s)]+)\)/gi;
        const imageUrlRegex = /@(https?:\/\/[^\s]+\.(?:png|jpg|jpeg|gif|webp))/gi;
        
        let processedHtml = html;
        
        processedHtml = processedHtml.replace(markdownImageRegex, (match, altText, url) => {
            const cleanedUrl = this.cleanCloudinaryUrl(url);
            return `<div class="clare-chat-image-card">
                <img src="${cleanedUrl}" alt="${altText}" class="clare-chat-image" onerror="this.style.display='none'; this.parentElement.style.display='none';" />
            </div>`;
        });
        
        processedHtml = processedHtml.replace(imageUrlRegex, (match, url) => {
            const cleanedUrl = this.cleanCloudinaryUrl(url);
            return `<div class="clare-chat-image-card">
                <img src="${cleanedUrl}" alt="Product Image" class="clare-chat-image" onerror="this.style.display='none'; this.parentElement.style.display='none';" />
            </div>`;
        });
        
        // Check for EULA message and add View EULA button
        if (processedHtml.toLowerCase().includes('eula') && 
            (processedHtml.toLowerCase().includes('agree') || processedHtml.toLowerCase().includes('disagree'))) {
            processedHtml += `
                <div style="margin-top: 16px;">
                    <button id="view-eula-btn" class="eula-view-btn" onclick="showEULA()">
                        View EULA
                    </button>
                </div>
            `;
        }

        // Check for branding/brand question and add logo upload dropzone
        const lowerHtml = processedHtml.toLowerCase();
        
        // Check if logo has already been uploaded (prevent showing dropzone again)
        const logoAlreadyUploaded = window.logoUploaded || localStorage.getItem('logoUploaded') === 'true';
        
        // Check for logo URL requests that should be replaced with dropzone
        const logoUrlRequestKeywords = [
            'provide the image url',
            'image url for your logo',
            'logo url',
            'image url',
            'provide.*url.*logo',
            'url.*logo.*bag',
            'logo.*url.*bag',
            'please provide.*url',
            'share.*logo.*url',
            'send.*logo.*url',
            'upload.*logo.*url',
            'logo.*image.*url',
            'image.*url.*logo',
            'upload your logo now'
        ];
        
        const isLogoUrlRequest = logoUrlRequestKeywords.some(keyword => {
            const regex = new RegExp(keyword.toLowerCase(), 'i');
            return regex.test(lowerHtml);
        });
        
        // If it's a logo URL request, replace the message with dropzone
        if (isLogoUrlRequest && !logoAlreadyUploaded) {
            console.log('Logo URL request detected, replacing with dropzone');
            processedHtml = `
                <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                    <p style="margin: 0 0 16px 0; padding: 0; font-size: 15px;">
                        Great! Please upload your logo that you'd like on the bags.
                    </p>
                    <div style="margin-top: 16px; padding: 16px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #06382F;">
                        <h4 style="margin: 0 0 12px 0; color: #06382F; font-size: 16px;">🎨 Upload Your Brand Logo</h4>
                        <p style="margin: 0 0 16px 0; color: #374151; font-size: 14px;">Upload your logo to customize your coffee packaging with your brand.</p>
                        <div class="file-upload-dropzone" onclick="document.getElementById('logo-upload-input').click()">
                            <svg class="file-upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <div class="file-upload-text">Upload your brand logo</div>
                            <div class="file-upload-hint">Click to browse or drag and drop (max 2MB)</div>
                            <input type="file" id="logo-upload-input" class="file-upload-input" accept="image/*" onchange="handleLogoUpload(event)">
                        </div>
                        <div id="logo-preview-container" class="file-preview-container" style="display: none;">
                            <div class="bag-preview">
                                <img id="logo-preview" class="logo-preview" alt="Logo Preview">
                            </div>
                            <div id="upload-status"></div>
                        </div>
                    </div>
                </div>
            `;
        } else {
            // Original branding question detection logic
            const specificBrandingQuestion = lowerHtml.includes('packaged with your own branding') && 
                                           lowerHtml.includes('custom branding') &&
                                           lowerHtml.includes('upload your brand logo');
            
            // General branding keywords as fallback
            const brandingKeywords = [
                'your own brand',
                'own brand',
                'custom brand',
                'brand logo',
                'company logo',
                'business logo',
                'branding option',
                'branding',
                'logo on bag',
                'custom logo',
                'personalize',
                'personalization',
                'packaged with your own branding',
                'custom branding',
                'upload your brand logo',
                'own branding',
                'standard packaging'
            ];
            
            const hasBrandingKeywords = brandingKeywords.some(keyword => 
                lowerHtml.includes(keyword.toLowerCase())
            );
            
            // Show logo upload when:
            // 1. It's the specific branding question OR has branding keywords
            // 2. Not yet at EULA stage
            // 3. Logo hasn't been uploaded yet
            const shouldShowLogoUpload = (specificBrandingQuestion || hasBrandingKeywords) && !lowerHtml.includes('eula') && !logoAlreadyUploaded;
            
            if (shouldShowLogoUpload) {
                console.log('Logo upload interface triggered by branding question:', processedHtml);
                console.log('Specific branding question detected:', specificBrandingQuestion);
                console.log('Branding keywords found:', brandingKeywords.filter(keyword => lowerHtml.includes(keyword.toLowerCase())));
                processedHtml += `
                    <div style="margin-top: 16px; padding: 16px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #06382F;">
                        <h4 style="margin: 0 0 12px 0; color: #06382F; font-size: 16px;">🎨 Add Your Brand</h4>
                        <p style="margin: 0 0 16px 0; color: #374151; font-size: 14px;">Would you like to add your own brand logo to your order? Upload your logo to customize your packaging.</p>
                        <div class="file-upload-dropzone" onclick="document.getElementById('logo-upload-input').click()">
                            <svg class="file-upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <div class="file-upload-text">Upload your brand logo</div>
                            <div class="file-upload-hint">Click to browse or drag and drop (max 2MB)</div>
                            <input type="file" id="logo-upload-input" class="file-upload-input" accept="image/*" onchange="handleLogoUpload(event)">
                        </div>
                        <div id="logo-preview-container" class="file-preview-container" style="display: none;">
                            <div class="bag-preview">
                                <img id="logo-preview" class="logo-preview" alt="Logo Preview">
                            </div>
                            <div id="upload-status"></div>
                        </div>
                    </div>
                `;
            }
        }
        
        return processedHtml;
    }

    async sendMessageToAPI(message, logoUrl = null) {
        const payload = {
            userId: this.userId,
            message: message
        };

        if (logoUrl) {
            payload.logoUrl = logoUrl;
        }

        try {
            const response = await fetch(this.options.apiEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Origin': window.location.origin,
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            
            let responseText = null;
            
            if (data.success && data.data && data.data.formattedResponse) {
                responseText = data.data.formattedResponse;
            } else if (data.formattedResponse) {
                responseText = data.formattedResponse;
            } else if (data.data && data.data.response) {
                responseText = data.data.response;
            } else if (data.response) {
                responseText = data.response;
            } else if (data.message) {
                responseText = data.message;
            } else if (data.text) {
                responseText = data.text;
            } else if (data.content) {
                responseText = data.content;
            } else if (data.answer) {
                responseText = data.answer;
            } else if (data.reply) {
                responseText = data.reply;
            } else if (data.error) {
                responseText = data.error;
            } else if (typeof data === 'string') {
                responseText = data;
            }
            
            if (responseText) {
                return responseText;
            } else {
                throw new Error('No response text found in API response');
            }
        } catch (error) {
            console.error('Error sending message to API:', error);
            return `<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                <p style="margin: 0 0 16px 0; padding: 0; color: #dc2626;">
                    <strong>API Error:</strong> ${error.message}
                </p>
                <p style="margin: 0 0 16px 0; padding: 0; font-size: 0.875rem; color: #6b7280;">
                    Please check the console for more details.
                </p>
            </div>`;
        }
    }

    async handleSend() {
        const chatInput = document.getElementById('clare-chat-input');
        const value = chatInput.value.trim();
        if (!value) return;

        this.addUserMessage(value);
        chatInput.value = '';
        chatInput.focus();

        const typingDiv = this.addTypingIndicator();

        try {
            const response = await this.sendMessageToAPI(value);
            typingDiv.remove();
            this.addBotMessage(response);
        } catch (error) {
            console.error('Error in handleSend:', error);
            typingDiv.remove();
            this.addBotMessage(`<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;"><p style="margin: 0 0 16px 0; padding: 0;">Sorry, something went wrong. Error: ${error.message}</p></div>`);
        }
    }

    // Public method to open chat programmatically
    openChat() {
        const chatDrawer = document.getElementById('clare-chat-drawer');
        if (chatDrawer) {
            chatDrawer.classList.add('open');
            this.toggleBodyScroll(true);
            setTimeout(() => this.initializeSafariInput(), 300);
        }
    }

    // Public method to close chat programmatically
    closeChat() {
        const chatDrawer = document.getElementById('clare-chat-drawer');
        if (chatDrawer) {
            chatDrawer.classList.remove('open');
            this.toggleBodyScroll(false);
        }
    }

    // Public method to destroy the component
    destroy() {
        const chatBtn = document.getElementById('clare-chat-btn');
        const chatDrawer = document.getElementById('clare-chat-drawer');
        
        if (chatBtn) chatBtn.remove();
        if (chatDrawer) chatDrawer.remove();
        
        this.isInitialized = false;
    }

    // Logo upload functionality
    showLogoUploadSpinner() {
        const spinner = document.getElementById('logo-upload-spinner');
        if (spinner) {
            spinner.classList.add('show');
            document.body.style.overflow = 'hidden';
            
            // Auto-hide spinner after 30 seconds as a safety measure
            setTimeout(() => {
                this.hideLogoUploadSpinner();
            }, 30000);
        }
    }

    hideLogoUploadSpinner() {
        const spinner = document.getElementById('logo-upload-spinner');
        if (spinner) {
            spinner.classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    showUploadStatus(message, type) {
        const statusDiv = document.getElementById('upload-status');
        if (statusDiv) {
            statusDiv.textContent = message;
            statusDiv.className = type === 'success' ? 'upload-success' : 'upload-error';
            statusDiv.style.display = 'block';
        }
    }

    async uploadLogoToLaravel(file) {
        const formData = new FormData();
        formData.append('file', file);

        console.log('Uploading logo to Laravel backend...');

        try {
            // Get CSRF token with fallback
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value ||
                             '{{ csrf_token() }}';
            
            const response = await fetch('/uploadbaglogo', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData
            });

            console.log('Upload response status:', response.status);

            if (!response.ok) {
                const errorData = await response.text();
                console.error('Laravel upload error:', errorData);
                throw new Error(`Failed to upload to Laravel: ${response.status} ${response.statusText} - ${errorData}`);
            }

            const data = await response.json();
            console.log('Upload successful:', data);
            
            // The Laravel controller stores the URL in session, we need to get it
            const sessionResponse = await fetch('/get-bag-image-url', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                }
            });
            
            if (sessionResponse.ok) {
                const sessionData = await sessionResponse.json();
                const logoUrl = decodeURIComponent(sessionData.bagImage || sessionData.imageUrl || '');
                console.log('Retrieved logo URL from session:', logoUrl);
                return logoUrl;
            } else {
                throw new Error('Failed to retrieve uploaded image URL from session');
            }
        } catch (error) {
            console.error('Upload error:', error);
            throw error;
        }
    }

    async handleSendWithMessageAndLogoUrl(message, logoUrl) {
        // Add user message
        this.addUserMessage(message);
        
        // Show typing indicator
        const typingDiv = this.addTypingIndicator();

        try {
            // Send message to API with logo URL
            const response = await this.sendMessageToAPI(message, logoUrl);
            
            // Remove typing indicator
            typingDiv.remove();
            
            // Add bot response
            this.addBotMessage(response);
        } catch (error) {
            console.error('Error in handleSendWithMessageAndLogoUrl:', error);
            
            // Remove typing indicator
            typingDiv.remove();
            
            // Add error message
            this.addBotMessage(`<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;"><p style="margin: 0 0 16px 0; padding: 0;">Sorry, something went wrong. Error: ${error.message}</p></div>`);
        }
    }

    setupDragAndDrop() {
        document.addEventListener('dragover', function(e) {
            e.preventDefault();
            const dropzone = document.querySelector('.file-upload-dropzone');
            if (dropzone && e.target.closest('.file-upload-dropzone')) {
                dropzone.classList.add('dragover');
            }
        });

        document.addEventListener('dragleave', function(e) {
            const dropzone = document.querySelector('.file-upload-dropzone');
            if (dropzone && !e.target.closest('.file-upload-dropzone')) {
                dropzone.classList.remove('dragover');
            }
        });

        document.addEventListener('drop', function(e) {
            e.preventDefault();
            const dropzone = document.querySelector('.file-upload-dropzone');
            if (dropzone) {
                dropzone.classList.remove('dragover');
            }

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                const event = { target: { files: [file] } };
                window.handleLogoUpload(event);
            }
        });
    }
}

// Global functions for logo upload (accessible from HTML)
window.handleLogoUpload = async function(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Validate file type
    if (!file.type.startsWith('image/')) {
        if (window.clareChat) {
            window.clareChat.showUploadStatus('Please select an image file.', 'error');
        }
        return;
    }

    // Validate file size (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
        if (window.clareChat) {
            window.clareChat.showUploadStatus('File size must be less than 2MB.', 'error');
        }
        return;
    }

    if (window.clareChat) {
        window.clareChat.showUploadStatus('Uploading logo to Cloudinary...', 'success');
    }
    console.log('Starting logo upload to Cloudinary...');
    
    // Show the upload spinner
    if (window.clareChat) {
        window.clareChat.showLogoUploadSpinner();
    }

    try {
        // Upload to Laravel backend using existing Cloudinary implementation
        const logoUrl = await window.clareChat.uploadLogoToLaravel(file);
        console.log('Logo uploaded via Laravel successfully');
        console.log('Logo URL:', logoUrl);
        
        // Store the logo URL globally for the API
        window.uploadedLogoUrl = logoUrl;
          
        // Hide the dropzone
        const dropzone = event.target.closest('.file-upload-dropzone');
        if (dropzone) {
            dropzone.style.display = 'none';
        }

        // Mark logo as uploaded to prevent showing dropzone again
        window.logoUploaded = true;
        localStorage.setItem('logoUploaded', 'true');
        localStorage.setItem('uploadedLogoUrl', logoUrl);
        
        // Hide the spinner
        if (window.clareChat) {
            window.clareChat.hideLogoUploadSpinner();
        }
        
        // Show success message
        if (window.clareChat) {
            window.clareChat.showUploadStatus('Logo uploaded successfully! Sending to Clare...', 'success');
        }
        
        // Automatically send logo URL to Clare
        setTimeout(() => {
            console.log('Sending logo URL to Clare...');
            // Send the message with logo URL to Clare
            if (window.clareChat) {
                window.clareChat.handleSendWithMessageAndLogoUrl('Here is my logo URL: ' + logoUrl, logoUrl);
            }
        }, 1000); // 1 second delay to show the success message first
    } catch (error) {
        console.error('Logo upload error:', error);
        // Hide the spinner on error
        if (window.clareChat) {
            window.clareChat.hideLogoUploadSpinner();
            window.clareChat.showUploadStatus(`Error uploading logo: ${error.message}`, 'error');
        }
    }
};

window.showEULA = function() {
    // This function can be implemented if EULA functionality is needed
    console.log('EULA functionality not implemented in component version');
};

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize if not already present
    if (!document.getElementById('clare-chat-btn')) {
        window.clareChat = new ClareChatComponent();
        
        // Setup drag and drop for logo upload
        window.clareChat.setupDragAndDrop();
        
        // Create logo upload spinner
        const spinner = document.createElement('div');
        spinner.id = 'logo-upload-spinner';
        spinner.className = 'logo-upload-spinner';
        spinner.innerHTML = `
            <div class="logo-upload-spinner-content">
                <div class="spinner"></div>
                <p class="spinner-text">Uploading logo ...</p>
            </div>
        `;
        document.body.appendChild(spinner);
    }
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ClareChatComponent;
}
