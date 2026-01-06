/**
 * Afrisol - Components JavaScript
 * Forms, Calculator, Checkout, etc.
 */

(function($) {
    'use strict';

    // Initialize when DOM is ready
    $(document).ready(function() {
        AfrisolComponents.init();
    });

    // Components object
    window.AfrisolComponents = {
        init: function() {
            this.initContactForm();
            this.initQuoteForm();
            this.initRepairForm();
            this.initSolarCalculator();
            this.initCheckout();
            this.initCart();
            this.initProductGallery();
            this.initTestimonialsSlider();
            this.initProductsSlider();
            this.initNotifyMe();
            this.initReviewForm();
        },

        // Contact Form
        initContactForm: function() {
            const form = document.getElementById('afrisolContactForm');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                submitBtn.disabled = true;

                const formData = new FormData(form);
                formData.append('action', 'afrisol_contact_form');
                formData.append('nonce', afrisol_ajax.nonce);

                $.ajax({
                    url: afrisol_ajax.ajax_url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Afrisol.showNotification('Message sent successfully!', 'success');
                            form.reset();
                        } else {
                            Afrisol.showNotification(response.data.message || 'Error sending message', 'error');
                        }
                    },
                    error: function() {
                        Afrisol.showNotification('Error sending message', 'error');
                    },
                    complete: function() {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                });
            });
        },

        // Multi-step Quote Form
        initQuoteForm: function() {
            const form = document.getElementById('afrisolQuoteForm');
            if (!form) return;

            const steps = form.querySelectorAll('.afrisol-quote-step');
            const indicators = document.querySelectorAll('.afrisol-quote-step-indicator');
            let currentStep = 0;

            // Service type selection
            form.querySelectorAll('.afrisol-service-type-option').forEach(option => {
                option.addEventListener('click', function() {
                    form.querySelectorAll('.afrisol-service-type-option').forEach(o => o.classList.remove('selected'));
                    this.classList.add('selected');
                    form.querySelector('input[name="service_type"]').value = this.dataset.type;
                });
            });

            // Next/Prev buttons
            form.querySelectorAll('.afrisol-quote-next').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (AfrisolComponents.validateQuoteStep(currentStep, form)) {
                        currentStep++;
                        AfrisolComponents.showQuoteStep(currentStep, steps, indicators);
                    }
                });
            });

            form.querySelectorAll('.afrisol-quote-prev').forEach(btn => {
                btn.addEventListener('click', function() {
                    currentStep--;
                    AfrisolComponents.showQuoteStep(currentStep, steps, indicators);
                });
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
                submitBtn.disabled = true;

                const formData = new FormData(form);
                formData.append('action', 'afrisol_submit_quote');
                formData.append('nonce', afrisol_ajax.nonce);

                $.ajax({
                    url: afrisol_ajax.ajax_url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Show thank you step
                            currentStep = steps.length - 1;
                            AfrisolComponents.showQuoteStep(currentStep, steps, indicators);
                            
                            // Update confirmation number
                            const confNum = document.querySelector('.afrisol-confirmation-number');
                            if (confNum) {
                                confNum.textContent = response.data.quote_number;
                            }
                        } else {
                            Afrisol.showNotification(response.data.message || 'Error submitting quote', 'error');
                            submitBtn.innerHTML = 'Submit Request';
                            submitBtn.disabled = false;
                        }
                    },
                    error: function() {
                        Afrisol.showNotification('Error submitting quote', 'error');
                        submitBtn.innerHTML = 'Submit Request';
                        submitBtn.disabled = false;
                    }
                });
            });
        },

        showQuoteStep: function(step, steps, indicators) {
            steps.forEach((s, i) => {
                s.classList.toggle('active', i === step);
            });
            
            indicators.forEach((ind, i) => {
                ind.classList.remove('active', 'completed');
                if (i === step) {
                    ind.classList.add('active');
                } else if (i < step) {
                    ind.classList.add('completed');
                }
            });

            // Scroll to top of form
            document.querySelector('.afrisol-quote-card')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        },

        validateQuoteStep: function(step, form) {
            const currentStepEl = form.querySelectorAll('.afrisol-quote-step')[step];
            const requiredFields = currentStepEl.querySelectorAll('[required]');
            let valid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });

            // Special validation for service type selection
            if (step === 0) {
                const selected = form.querySelector('.afrisol-service-type-option.selected');
                if (!selected) {
                    valid = false;
                    Afrisol.showNotification('Please select a service type', 'warning');
                }
            }

            return valid;
        },

        // Repair Form
        initRepairForm: function() {
            const form = document.getElementById('afrisolRepairForm');
            if (!form) return;

            // File upload preview
            const fileInput = form.querySelector('input[type="file"]');
            const previewContainer = form.querySelector('.afrisol-file-preview');

            if (fileInput && previewContainer) {
                fileInput.addEventListener('change', function() {
                    previewContainer.innerHTML = '';
                    Array.from(this.files).forEach(file => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.className = 'preview-thumb';
                                previewContainer.appendChild(img);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                });
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
                submitBtn.disabled = true;

                const formData = new FormData(form);
                formData.append('action', 'afrisol_submit_repair');
                formData.append('nonce', afrisol_ajax.nonce);

                $.ajax({
                    url: afrisol_ajax.ajax_url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Afrisol.showNotification('Repair request submitted! Ticket: ' + response.data.ticket_number, 'success');
                            form.reset();
                            previewContainer.innerHTML = '';
                        } else {
                            Afrisol.showNotification(response.data.message || 'Error submitting request', 'error');
                        }
                    },
                    error: function() {
                        Afrisol.showNotification('Error submitting request', 'error');
                    },
                    complete: function() {
                        submitBtn.innerHTML = 'Submit Request';
                        submitBtn.disabled = false;
                    }
                });
            });
        },

        // Solar Calculator
        initSolarCalculator: function() {
            const calculator = document.getElementById('afrisolSolarCalculator');
            if (!calculator) return;

            const steps = calculator.querySelectorAll('.afrisol-calculator-step');
            let currentStep = 0;
            let calculatorData = {
                location: '',
                propertyType: 'home',
                monthlyBill: 0,
                appliances: [],
                roofType: '',
                roofSpace: 0
            };

            // Property type selection
            calculator.querySelectorAll('.afrisol-property-option').forEach(option => {
                option.addEventListener('click', function() {
                    calculator.querySelectorAll('.afrisol-property-option').forEach(o => o.classList.remove('selected'));
                    this.classList.add('selected');
                    calculatorData.propertyType = this.dataset.type;
                });
            });

            // Appliance checkboxes
            calculator.querySelectorAll('.afrisol-appliance-item input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const appliance = this.dataset.appliance;
                    const watts = parseInt(this.dataset.watts);
                    const qtyInput = this.closest('.afrisol-appliance-item').querySelector('.afrisol-appliance-qty');
                    
                    if (this.checked) {
                        calculatorData.appliances.push({
                            name: appliance,
                            watts: watts,
                            quantity: parseInt(qtyInput?.value || 1),
                            hours: 8
                        });
                    } else {
                        calculatorData.appliances = calculatorData.appliances.filter(a => a.name !== appliance);
                    }
                });
            });

            // Next/Prev buttons
            calculator.querySelectorAll('.afrisol-calc-next').forEach(btn => {
                btn.addEventListener('click', function() {
                    currentStep++;
                    AfrisolComponents.showCalculatorStep(currentStep, steps, calculator);
                });
            });

            calculator.querySelectorAll('.afrisol-calc-prev').forEach(btn => {
                btn.addEventListener('click', function() {
                    currentStep--;
                    AfrisolComponents.showCalculatorStep(currentStep, steps, calculator);
                });
            });

            // Calculate button
            const calculateBtn = calculator.querySelector('.afrisol-calculate-btn');
            if (calculateBtn) {
                calculateBtn.addEventListener('click', function() {
                    // Get input values
                    calculatorData.location = calculator.querySelector('[name="location"]')?.value || '';
                    calculatorData.monthlyBill = parseFloat(calculator.querySelector('[name="monthly_bill"]')?.value || 0);
                    calculatorData.roofType = calculator.querySelector('[name="roof_type"]')?.value || '';
                    calculatorData.roofSpace = parseFloat(calculator.querySelector('[name="roof_space"]')?.value || 0);

                    AfrisolComponents.calculateSolarNeeds(calculatorData, calculator);
                });
            }
        },

        showCalculatorStep: function(step, steps, calculator) {
            steps.forEach((s, i) => {
                s.classList.toggle('active', i === step);
            });
        },

        calculateSolarNeeds: function(data, calculator) {
            // Calculate total daily energy consumption
            let dailyKWh = 0;
            
            if (data.appliances.length > 0) {
                data.appliances.forEach(appliance => {
                    dailyKWh += (appliance.watts * appliance.quantity * appliance.hours) / 1000;
                });
            } else if (data.monthlyBill > 0) {
                // Estimate from monthly bill (rough calculation based on Nigerian tariff)
                const estimatedMonthlyKWh = data.monthlyBill / 50; // Approximate cost per kWh
                dailyKWh = estimatedMonthlyKWh / 30;
            }

            // Solar panel calculations
            const sunHours = 5; // Average peak sun hours in Nigeria
            const systemEfficiency = 0.8; // 80% system efficiency
            const panelWattage = 400; // Standard panel wattage

            const requiredSystemSize = (dailyKWh / (sunHours * systemEfficiency));
            const numberOfPanels = Math.ceil(requiredSystemSize / (panelWattage / 1000));
            const batterySize = Math.ceil(dailyKWh * 1.5); // 1.5 days backup

            // Cost estimates (in NGN)
            const costPerWatt = 800;
            const batteryCostPerKWh = 400000;
            const installationCost = requiredSystemSize * 150000;
            
            const totalPanelCost = requiredSystemSize * 1000 * costPerWatt;
            const totalBatteryCost = batterySize * batteryCostPerKWh;
            const totalCost = totalPanelCost + totalBatteryCost + installationCost;

            // Monthly savings
            const monthlySavings = data.monthlyBill || (dailyKWh * 30 * 50);
            const roiYears = totalCost / (monthlySavings * 12);

            // CO2 savings (kg per year)
            const co2Savings = dailyKWh * 365 * 0.4; // 0.4 kg CO2 per kWh

            // Display results
            const resultsContainer = calculator.querySelector('.afrisol-calculator-results');
            if (resultsContainer) {
                resultsContainer.innerHTML = `
                    <h3 class="afrisol-section-title">Your Solar Recommendation</h3>
                    <div class="afrisol-result-grid">
                        <div class="afrisol-result-item">
                            <i class="fas fa-solar-panel"></i>
                            <div class="afrisol-result-value">${requiredSystemSize.toFixed(1)}kW</div>
                            <div class="afrisol-result-label">System Size</div>
                        </div>
                        <div class="afrisol-result-item">
                            <i class="fas fa-th"></i>
                            <div class="afrisol-result-value">${numberOfPanels}</div>
                            <div class="afrisol-result-label">Solar Panels</div>
                        </div>
                        <div class="afrisol-result-item">
                            <i class="fas fa-battery-full"></i>
                            <div class="afrisol-result-value">${batterySize}kWh</div>
                            <div class="afrisol-result-label">Battery Storage</div>
                        </div>
                        <div class="afrisol-result-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <div class="afrisol-result-value">₦${Afrisol.formatPrice(monthlySavings).replace('NGN', '').trim()}</div>
                            <div class="afrisol-result-label">Monthly Savings</div>
                        </div>
                    </div>
                    <div class="afrisol-cost-breakdown">
                        <h4>Cost Breakdown</h4>
                        <div class="afrisol-summary-row">
                            <span>Solar Panels</span>
                            <strong>₦${Afrisol.formatPrice(totalPanelCost).replace('NGN', '').trim()}</strong>
                        </div>
                        <div class="afrisol-summary-row">
                            <span>Battery Storage</span>
                            <strong>₦${Afrisol.formatPrice(totalBatteryCost).replace('NGN', '').trim()}</strong>
                        </div>
                        <div class="afrisol-summary-row">
                            <span>Installation</span>
                            <strong>₦${Afrisol.formatPrice(installationCost).replace('NGN', '').trim()}</strong>
                        </div>
                        <div class="afrisol-summary-row total">
                            <span>Estimated Total</span>
                            <strong>₦${Afrisol.formatPrice(totalCost).replace('NGN', '').trim()}</strong>
                        </div>
                    </div>
                    <div class="afrisol-roi-info">
                        <p><i class="fas fa-chart-line"></i> ROI Timeline: <strong>${roiYears.toFixed(1)} years</strong></p>
                    </div>
                    <div class="afrisol-environmental-impact">
                        <h4><i class="fas fa-leaf"></i> Environmental Impact</h4>
                        <div class="afrisol-co2-saved">${co2Savings.toFixed(0)} kg</div>
                        <p>CO₂ saved per year</p>
                    </div>
                    <div class="afrisol-text-center afrisol-mt-3">
                        <a href="/get-quote" class="afrisol-btn afrisol-btn-primary afrisol-btn-lg">
                            Get Detailed Proposal
                        </a>
                    </div>
                `;
                
                // Show results section
                resultsContainer.style.display = 'block';
                resultsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },

        // Checkout
        initCheckout: function() {
            const checkoutForm = document.getElementById('afrisolCheckoutForm');
            if (!checkoutForm) return;

            const steps = checkoutForm.querySelectorAll('.afrisol-checkout-step');
            let currentStep = 0;

            // Delivery method toggle
            checkoutForm.querySelectorAll('input[name="delivery_method"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const addressSection = checkoutForm.querySelector('.afrisol-delivery-address');
                    if (addressSection) {
                        addressSection.style.display = this.value === 'delivery' ? 'block' : 'none';
                    }
                });
            });

            // Installation required toggle
            checkoutForm.querySelectorAll('input[name="installation_required"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const scheduleSection = checkoutForm.querySelector('.afrisol-installation-schedule');
                    if (scheduleSection) {
                        scheduleSection.style.display = this.value === 'yes' ? 'block' : 'none';
                    }
                });
            });

            // Step navigation
            checkoutForm.querySelectorAll('.afrisol-checkout-next').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (AfrisolComponents.validateCheckoutStep(currentStep, checkoutForm)) {
                        currentStep++;
                        AfrisolComponents.showCheckoutStep(currentStep, steps);
                    }
                });
            });

            checkoutForm.querySelectorAll('.afrisol-checkout-prev').forEach(btn => {
                btn.addEventListener('click', function() {
                    currentStep--;
                    AfrisolComponents.showCheckoutStep(currentStep, steps);
                });
            });

            // Paystack integration
            const payBtn = checkoutForm.querySelector('.afrisol-pay-btn');
            if (payBtn) {
                payBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    AfrisolComponents.initPaystack(checkoutForm);
                });
            }
        },

        showCheckoutStep: function(step, steps) {
            steps.forEach((s, i) => {
                s.classList.toggle('active', i === step);
            });
        },

        validateCheckoutStep: function(step, form) {
            const currentStepEl = form.querySelectorAll('.afrisol-checkout-step')[step];
            const requiredFields = currentStepEl.querySelectorAll('[required]');
            let valid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });

            return valid;
        },

        initPaystack: function(form) {
            const email = form.querySelector('[name="email"]').value;
            const amount = parseFloat(form.dataset.total) * 100; // Convert to kobo

            if (!afrisol_ajax.paystack_key) {
                Afrisol.showNotification('Payment not configured', 'error');
                return;
            }

            const handler = PaystackPop.setup({
                key: afrisol_ajax.paystack_key,
                email: email,
                amount: amount,
                currency: 'NGN',
                ref: 'AFR-' + Math.floor((Math.random() * 1000000000) + 1),
                callback: function(response) {
                    // Verify payment on server
                    AfrisolComponents.verifyPayment(response.reference, form);
                },
                onClose: function() {
                    Afrisol.showNotification('Payment cancelled', 'warning');
                }
            });

            handler.openIframe();
        },

        verifyPayment: function(reference, form) {
            const formData = new FormData(form);
            formData.append('action', 'afrisol_verify_payment');
            formData.append('reference', reference);
            formData.append('nonce', afrisol_ajax.nonce);

            $.ajax({
                url: afrisol_ajax.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Redirect to thank you page
                        window.location.href = response.data.redirect;
                    } else {
                        Afrisol.showNotification(response.data.message || 'Payment verification failed', 'error');
                    }
                },
                error: function() {
                    Afrisol.showNotification('Error verifying payment', 'error');
                }
            });
        },

        // Cart
        initCart: function() {
            const cartContainer = document.querySelector('.afrisol-cart-items');
            if (!cartContainer) return;

            // Quantity change
            cartContainer.querySelectorAll('.afrisol-quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const itemId = this.closest('.afrisol-cart-item').dataset.itemId;
                    AfrisolComponents.updateCartItem(itemId, this.value);
                });
            });

            // Remove item
            cartContainer.querySelectorAll('.afrisol-cart-remove').forEach(btn => {
                btn.addEventListener('click', function() {
                    const item = this.closest('.afrisol-cart-item');
                    const itemId = item.dataset.itemId;
                    AfrisolComponents.removeCartItem(itemId, item);
                });
            });

            // Save for later
            cartContainer.querySelectorAll('.afrisol-cart-save').forEach(btn => {
                btn.addEventListener('click', function() {
                    const item = this.closest('.afrisol-cart-item');
                    const itemId = item.dataset.itemId;
                    AfrisolComponents.saveForLater(itemId, item);
                });
            });

            // Apply coupon
            const couponForm = document.querySelector('.afrisol-coupon-form');
            if (couponForm) {
                couponForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const code = this.querySelector('input').value;
                    AfrisolComponents.applyCoupon(code);
                });
            }
        },

        updateCartItem: function(itemId, quantity) {
            $.ajax({
                url: afrisol_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'afrisol_update_cart',
                    item_id: itemId,
                    quantity: quantity,
                    nonce: afrisol_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Update totals
                        AfrisolComponents.updateCartTotals(response.data);
                    }
                }
            });
        },

        removeCartItem: function(itemId, itemElement) {
            $.ajax({
                url: afrisol_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'afrisol_remove_from_cart',
                    item_id: itemId,
                    nonce: afrisol_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        itemElement.style.animation = 'fadeOut 0.3s ease-out';
                        setTimeout(() => {
                            itemElement.remove();
                            AfrisolComponents.updateCartTotals(response.data);
                        }, 300);
                        Afrisol.showNotification('Item removed from cart', 'success');
                    }
                }
            });
        },

        saveForLater: function(itemId, itemElement) {
            $.ajax({
                url: afrisol_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'afrisol_save_for_later',
                    item_id: itemId,
                    nonce: afrisol_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        itemElement.style.animation = 'fadeOut 0.3s ease-out';
                        setTimeout(() => {
                            itemElement.remove();
                            AfrisolComponents.updateCartTotals(response.data);
                        }, 300);
                        Afrisol.showNotification('Item saved for later', 'success');
                    }
                }
            });
        },

        applyCoupon: function(code) {
            $.ajax({
                url: afrisol_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'afrisol_apply_coupon',
                    code: code,
                    nonce: afrisol_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        AfrisolComponents.updateCartTotals(response.data);
                        Afrisol.showNotification('Coupon applied!', 'success');
                    } else {
                        Afrisol.showNotification(response.data.message || 'Invalid coupon', 'error');
                    }
                }
            });
        },

        updateCartTotals: function(data) {
            const summary = document.querySelector('.afrisol-cart-summary');
            if (!summary) return;

            if (data.subtotal !== undefined) {
                const subtotalEl = summary.querySelector('.afrisol-subtotal-value');
                if (subtotalEl) subtotalEl.textContent = Afrisol.formatPrice(data.subtotal);
            }

            if (data.tax !== undefined) {
                const taxEl = summary.querySelector('.afrisol-tax-value');
                if (taxEl) taxEl.textContent = Afrisol.formatPrice(data.tax);
            }

            if (data.total !== undefined) {
                const totalEl = summary.querySelector('.afrisol-total-value');
                if (totalEl) totalEl.textContent = Afrisol.formatPrice(data.total);
            }

            if (data.discount !== undefined) {
                const discountRow = summary.querySelector('.afrisol-discount-row');
                if (discountRow) {
                    discountRow.style.display = data.discount > 0 ? 'flex' : 'none';
                    const discountEl = discountRow.querySelector('.afrisol-discount-value');
                    if (discountEl) discountEl.textContent = '-' + Afrisol.formatPrice(data.discount);
                }
            }

            // Update cart count in header
            const cartCount = document.querySelector('.afrisol-cart-count');
            if (cartCount && data.cart_count !== undefined) {
                cartCount.textContent = data.cart_count;
            }
        },

        // Product Gallery
        initProductGallery: function() {
            const gallery = document.querySelector('.afrisol-product-gallery');
            if (!gallery) return;

            const mainImage = gallery.querySelector('.afrisol-gallery-main img');
            const thumbs = gallery.querySelectorAll('.afrisol-gallery-thumb');

            thumbs.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    const src = this.querySelector('img').src;
                    const largeSrc = this.dataset.large || src;
                    
                    mainImage.src = largeSrc;
                    
                    thumbs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Zoom functionality
            const zoomBtn = gallery.querySelector('.afrisol-gallery-zoom');
            if (zoomBtn) {
                zoomBtn.addEventListener('click', function() {
                    AfrisolComponents.openImageZoom(mainImage.src);
                });
            }

            // Image zoom on hover
            if (mainImage) {
                mainImage.addEventListener('mousemove', function(e) {
                    const rect = this.getBoundingClientRect();
                    const x = ((e.clientX - rect.left) / rect.width) * 100;
                    const y = ((e.clientY - rect.top) / rect.height) * 100;
                    this.style.transformOrigin = `${x}% ${y}%`;
                });

                mainImage.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.5)';
                });

                mainImage.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            }
        },

        openImageZoom: function(src) {
            const overlay = document.createElement('div');
            overlay.className = 'afrisol-image-zoom-overlay';
            overlay.innerHTML = `
                <div class="afrisol-image-zoom-container">
                    <img src="${src}" alt="Zoomed image">
                    <button class="afrisol-zoom-close"><i class="fas fa-times"></i></button>
                </div>
            `;

            document.body.appendChild(overlay);
            document.body.style.overflow = 'hidden';

            overlay.addEventListener('click', function(e) {
                if (e.target === overlay || e.target.closest('.afrisol-zoom-close')) {
                    overlay.remove();
                    document.body.style.overflow = '';
                }
            });
        },

        // Testimonials Slider
        initTestimonialsSlider: function() {
            const slider = document.querySelector('.afrisol-testimonials-slider .swiper');
            if (!slider) return;

            new Swiper(slider, {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.afrisol-testimonials-pagination',
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    992: {
                        slidesPerView: 3,
                    }
                }
            });
        },

        // Products Slider
        initProductsSlider: function() {
            const sliders = document.querySelectorAll('.afrisol-products-slider .swiper');
            
            sliders.forEach(slider => {
                new Swiper(slider, {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    navigation: {
                        nextEl: slider.parentElement.querySelector('.swiper-button-next'),
                        prevEl: slider.parentElement.querySelector('.swiper-button-prev'),
                    },
                    breakpoints: {
                        576: {
                            slidesPerView: 2,
                        },
                        768: {
                            slidesPerView: 3,
                        },
                        992: {
                            slidesPerView: 4,
                        }
                    }
                });
            });
        },

        // Notify Me
        initNotifyMe: function() {
            const notifyForms = document.querySelectorAll('.afrisol-notify-form');
            
            notifyForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const productId = this.dataset.productId;
                    const email = this.querySelector('input[type="email"]').value;
                    const submitBtn = this.querySelector('button');

                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    submitBtn.disabled = true;

                    $.ajax({
                        url: afrisol_ajax.ajax_url,
                        type: 'POST',
                        data: {
                            action: 'afrisol_notify_me',
                            product_id: productId,
                            email: email,
                            nonce: afrisol_ajax.nonce
                        },
                        success: function(response) {
                            if (response.success) {
                                Afrisol.showNotification('You will be notified when this product is available!', 'success');
                                form.innerHTML = '<p class="afrisol-text-success"><i class="fas fa-check"></i> Subscribed!</p>';
                            } else {
                                Afrisol.showNotification(response.data.message || 'Error subscribing', 'error');
                                submitBtn.innerHTML = 'Notify Me';
                                submitBtn.disabled = false;
                            }
                        },
                        error: function() {
                            Afrisol.showNotification('Error subscribing', 'error');
                            submitBtn.innerHTML = 'Notify Me';
                            submitBtn.disabled = false;
                        }
                    });
                });
            });
        },

        // Review Form
        initReviewForm: function() {
            const form = document.getElementById('afrisolReviewForm');
            if (!form) return;

            // Star rating selection
            const starsContainer = form.querySelector('.afrisol-review-stars');
            if (starsContainer) {
                const stars = starsContainer.querySelectorAll('i');
                const ratingInput = form.querySelector('input[name="rating"]');

                stars.forEach((star, index) => {
                    star.addEventListener('click', function() {
                        const rating = index + 1;
                        ratingInput.value = rating;
                        
                        stars.forEach((s, i) => {
                            s.classList.toggle('fas', i < rating);
                            s.classList.toggle('far', i >= rating);
                        });
                    });

                    star.addEventListener('mouseenter', function() {
                        stars.forEach((s, i) => {
                            s.classList.toggle('fas', i <= index);
                            s.classList.toggle('far', i > index);
                        });
                    });
                });

                starsContainer.addEventListener('mouseleave', function() {
                    const currentRating = parseInt(ratingInput.value) || 0;
                    stars.forEach((s, i) => {
                        s.classList.toggle('fas', i < currentRating);
                        s.classList.toggle('far', i >= currentRating);
                    });
                });
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
                submitBtn.disabled = true;

                const formData = new FormData(form);
                formData.append('action', 'afrisol_submit_review');
                formData.append('nonce', afrisol_ajax.nonce);

                $.ajax({
                    url: afrisol_ajax.ajax_url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Afrisol.showNotification('Review submitted successfully!', 'success');
                            form.reset();
                            
                            // Reset stars
                            if (starsContainer) {
                                starsContainer.querySelectorAll('i').forEach(s => {
                                    s.classList.remove('fas');
                                    s.classList.add('far');
                                });
                            }
                        } else {
                            Afrisol.showNotification(response.data.message || 'Error submitting review', 'error');
                        }
                    },
                    error: function() {
                        Afrisol.showNotification('Error submitting review', 'error');
                    },
                    complete: function() {
                        submitBtn.innerHTML = 'Submit Review';
                        submitBtn.disabled = false;
                    }
                });
            });
        }
    };

})(jQuery);
