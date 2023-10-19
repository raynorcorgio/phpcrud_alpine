const headers = {
    'Content-Type': 'application/json; charset=utf-8'
};

const fetchPost = (url, method, body, headers) => {
    return fetch(url, {
        method,
        headers,
        body: JSON.stringify(body),
    })
}

document.addEventListener("alpine:init", () => {
    Alpine.data("posting", () => ({
        currUserId: '',
        posts: [],
        form: {
            title: '',
            content: '',
            user_id: '',
        },
        submitPost() {
            this.form.user_id = this.currUserId;
            fetchPost('addPost.php',
                'POST',
                this.form,
                headers)
                .then(res => res.json())
                .then(response => {
                    this.posts = response
                })
                .catch(error => console.error("Error:" + error))
        },

        deletePost(postId){
            fetchPost('delete-post.php',
                'POST',
                {id: postId},
                headers)
                .then(res => res.text())
                .then(response => {
                    let position = this.posts.findIndex(post => post.id === postId);
                    this.posts.splice(position, 1);
                })
                .catch(error => console.error("Error:" + error))
        },

        likePost(postId){
            fetchPost('like-post.php',
                'POST',
                {postId, userId: this.currUserId},
                headers)
                .then(res => res.json())
                .then(response => {
                    let position = this.posts.findIndex(post => post.id === postId);
                    this.posts[position].likes_count = response.likes;
                    // console.log(response);
                })
                .catch(error => console.error("Error:" + error))
        }
    }));
});

