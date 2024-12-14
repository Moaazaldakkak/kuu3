document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-comment').forEach(button => {
        button.addEventListener('click', function () {
            const url = this.dataset.url;
            const commentId = this.dataset.id;

            if (confirm('Are you sure you want to delete this comment?')) {
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Comment soft-deleted successfully!') {
                        const commentElement = document.getElementById(`comment-${commentId}`);
                        if (commentElement) {
                            // Replace the comment content with the deleted comment placeholder
                            commentElement.innerHTML = `
                                <p class="text-sm italic text-gray-500 dark:text-gray-400">
                                    Comment created on ${data.deleted_comment.created_at} by ${data.deleted_comment.user_name} 
                                    has been deleted on ${data.deleted_comment.deleted_at}.
                                </p>
                            `;
                        }
                    } else {
                        console.error('Failed to delete the comment:', data.message);
                    }
                })
                .catch(error => console.error('Fetch error:', error));
            }
        });
    });
});
