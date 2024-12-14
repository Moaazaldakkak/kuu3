document.addEventListener('DOMContentLoaded', function () {
    const socialMediaFields = document.getElementById('social-media-fields');
    const addButton = document.getElementById('add-social-media');
    let socialMediaIndex = socialMediaFields?.children.length || 0;

    if (socialMediaFields && addButton) {
        // Add event listener to the "Add Social Media" button
        addButton.addEventListener('click', function () {
            // Find an existing input to clone
            const templateInput = socialMediaFields.querySelector('input[name^="social_media_accounts"]');
            if (!templateInput) {
                console.error("Template input not found! Make sure at least one input exists on the page.");
                return;
            }

            // Clone the parent container of the existing input
            const newField = templateInput.closest('div').cloneNode(true);

            // Update the name attributes to use the new index
            const platformInput = newField.querySelector('input[name*="[platform]"]');
            const linkInput = newField.querySelector('input[name*="[link]"]');
            if (platformInput) platformInput.name = `social_media_accounts[${socialMediaIndex}][platform]`;
            if (linkInput) linkInput.name = `social_media_accounts[${socialMediaIndex}][link]`;

            // Clear values for the new input
            if (platformInput) platformInput.value = '';
            if (linkInput) linkInput.value = '';

            // Append the new field to the container
            socialMediaFields.appendChild(newField);
            socialMediaIndex++;
        });

        // Handle removing dynamically added fields
        socialMediaFields.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-field')) {
                event.target.closest('div').remove();
            }
        });
    }

});
