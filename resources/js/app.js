import "./libs/trix";
import './bootstrap';

function uploadTrixAttachment(editor, attachment) {
    if (!attachment.file) {
        return;
    }

    const endpoint = editor.dataset.uploadEndpoint;

    if (!endpoint || !window.axios) {
        return;
    }

    const formData = new FormData();
    formData.append('attachment', attachment.file);

    window.axios.post(endpoint, formData, {
        onUploadProgress(progressEvent) {
            if (progressEvent.total) {
                const progress = Math.round((progressEvent.loaded / progressEvent.total) * 100);
                attachment.setUploadProgress(progress);
            }
        },
    }).then(({ data }) => {
        if (data?.image_url) {
            attachment.setAttributes({
                url: data.image_url,
            });
        } else {
            attachment.remove();
        }
    }).catch(() => {
        attachment.remove();
    });
}

document.addEventListener('trix-attachment-add', (event) => {
    uploadTrixAttachment(event.target, event.attachment);
});

document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenuCloseButton = document.getElementById('mobile-menu-close-button');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

    if (mobileMenuButton && mobileMenuCloseButton && mobileMenuOverlay) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenuOverlay.classList.remove('hidden');
        });

        mobileMenuCloseButton.addEventListener('click', function() {
            mobileMenuOverlay.classList.add('hidden');
        });

        // Optional: Close menu when clicking outside the menu content
        mobileMenuOverlay.addEventListener('click', function(e) {
            if (e.target === mobileMenuOverlay) {
                mobileMenuOverlay.classList.add('hidden');
            }
        });
    }
});
