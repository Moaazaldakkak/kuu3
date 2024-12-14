document.addEventListener('DOMContentLoaded', function () {
    let socialMediaIndex = 1;

    document.getElementById('add-social-media-field').addEventListener('click', function () {
        const container = document.getElementById('social-media-fields');
        const newField = document.createElement('div');
        newField.className = 'flex items-center space-x-2';
        newField.innerHTML = `
            <input type="text" name="social_media_accounts[${socialMediaIndex}][platform]" placeholder="Platform (e.g., Twitter)" class="w-1/2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
            <input type="url" name="social_media_accounts[${socialMediaIndex}][link]" placeholder="Link (e.g., https://instagram.com/example)" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
            <button type="button" class="text-red-500 hover:text-red-700 remove-field">Remove</button>
        `;
        container.appendChild(newField);
        socialMediaIndex++;
    });

    document.getElementById('social-media-fields').addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-field')) {
            event.target.parentElement.remove();
        }
    });
});