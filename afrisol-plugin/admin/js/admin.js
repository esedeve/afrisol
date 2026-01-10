/**
 * Afrisol Admin JavaScript
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        AfrisolAdmin.init();
    });

    window.AfrisolAdmin = {
        init: function() {
            this.initStatusUpdates();
            this.initMediaUploader();
            this.initEditorTabs();
            this.initConfirmActions();
        },

        // Status select updates
        initStatusUpdates: function() {
            // Order status
            $('.afrisol-order-status').on('change', function() {
                var orderId = $(this).data('order-id');
                var status = $(this).val();
                AfrisolAdmin.updateStatus('order', orderId, status);
            });

            // Quote status
            $('.afrisol-quote-status').on('change', function() {
                var quoteId = $(this).data('quote-id');
                var status = $(this).val();
                AfrisolAdmin.updateStatus('quote', quoteId, status);
            });

            // Repair status
            $('.afrisol-repair-status').on('change', function() {
                var repairId = $(this).data('repair-id');
                var status = $(this).val();
                AfrisolAdmin.updateStatus('repair', repairId, status);
            });

            // Review status
            $('.afrisol-review-status').on('change', function() {
                var reviewId = $(this).data('review-id');
                var status = $(this).val();
                AfrisolAdmin.updateStatus('review', reviewId, status);
            });
        },

        updateStatus: function(type, id, status) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'afrisol_admin_update_status',
                    type: type,
                    id: id,
                    status: status,
                    nonce: afrisol_admin.nonce
                },
                success: function(response) {
                    if (response.success) {
                        AfrisolAdmin.showNotice('Status updated successfully!', 'success');
                    } else {
                        AfrisolAdmin.showNotice('Error updating status', 'error');
                    }
                },
                error: function() {
                    AfrisolAdmin.showNotice('Error updating status', 'error');
                }
            });
        },

        // Media uploader
        initMediaUploader: function() {
            var mediaUploader;

            $('.afrisol-upload-image').on('click', function(e) {
                e.preventDefault();
                var button = $(this);
                var targetInput = button.data('target');
                var previewContainer = button.siblings('.afrisol-image-preview');

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media({
                    title: 'Select Image',
                    button: {
                        text: 'Use This Image'
                    },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $(targetInput).val(attachment.url);
                    if (previewContainer.length) {
                        previewContainer.html('<img src="' + attachment.url + '" style="max-width:200px">');
                    }
                });

                mediaUploader.open();
            });

            $('.afrisol-remove-image').on('click', function(e) {
                e.preventDefault();
                var targetInput = $(this).data('target');
                var previewContainer = $(this).siblings('.afrisol-image-preview');
                $(targetInput).val('');
                previewContainer.html('');
            });
        },

        // Editor tabs
        initEditorTabs: function() {
            $('.afrisol-editor-tab').on('click', function() {
                var tab = $(this).data('tab');
                
                $('.afrisol-editor-tab').removeClass('active');
                $(this).addClass('active');
                
                $('.afrisol-editor-panel').removeClass('active');
                $('#' + tab + '-panel').addClass('active');
            });
        },

        // Confirm dangerous actions
        initConfirmActions: function() {
            $('.afrisol-delete-review').on('click', function(e) {
                if (!confirm('Are you sure you want to delete this review?')) {
                    e.preventDefault();
                    return;
                }
                
                var reviewId = $(this).data('review-id');
                var row = $(this).closest('tr');
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'afrisol_admin_delete_review',
                        id: reviewId,
                        nonce: afrisol_admin.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            row.fadeOut(300, function() {
                                $(this).remove();
                            });
                            AfrisolAdmin.showNotice('Review deleted', 'success');
                        }
                    }
                });
            });
        },

        // Show admin notice
        showNotice: function(message, type) {
            var notice = $('<div class="notice notice-' + type + ' is-dismissible"><p>' + message + '</p></div>');
            $('.afrisol-admin-wrap h1').after(notice);
            
            setTimeout(function() {
                notice.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
    };

})(jQuery);