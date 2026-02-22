const params = new URLSearchParams(window.location.search);
const id = params.get('id');

async function loadPost() {
    try {
        const res = await fetch(`https://jsonplaceholder.typicode.com/posts/${id}`);

        if (!res.ok) {
            throw new Error('Ошибка загрузки поста');
        }

        const post = await res.json();

        document.getElementById('post-title').textContent = post.title;
        document.getElementById('post-body').textContent = post.body;

    } catch (error) {
        document.body.innerHTML = 'Ошибка загрузки поста';
        console.log(error);
    }
}

loadPost();