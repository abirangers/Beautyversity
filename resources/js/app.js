import "./libs/trix";
import './bootstrap';

// Alpine.js setup
import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'

// Make Alpine available globally
window.Alpine = Alpine

// Register plugins
Alpine.plugin(collapse)

// Start Alpine
Alpine.start()

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

