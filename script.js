document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('.feedback');
    if (!section) return;

    const productId = +section.dataset.productId;
    const list = document.getElementById('feedback-list');
    const form = document.getElementById('feedback-form');

    async function api(action, params = {}) {
        const res = await fetch('api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action, ...params }),
        });
        return res.json();
    }

    const escape = (s) => {
        const div = document.createElement('div');
        div.textContent = s;
        return div.innerHTML;
    };

    const stars = (n) => '★'.repeat(n) + '☆'.repeat(5 - n);

    const formatDate = (iso) => {
        const d = new Date(iso);
        return d.toLocaleDateString('ru-RU', {
            day: '2-digit', month: '2-digit', year: 'numeric'
        });
    };

    async function loadFeedback() {
        list.innerHTML = '<p class="muted">loading...</p>';
        const res = await api('list', { product_id: productId });

        if (!res.ok) {
            list.innerHTML = '<p class="muted">// ошибка загрузки</p>';
            return;
        }
        if (!res.data.length) {
            list.innerHTML = '<p class="muted">// пока тихо. будьте первым.</p>';
            return;
        }

        list.innerHTML = res.data.map(item => `
            <article class="review" data-id="${item.id}" data-rating="${item.rating}">
                <header class="review__head">
                    <span class="review__author">${escape(item.author)}</span>
                    <span class="review__stars">${stars(+item.rating)}</span>
                    <span class="review__date">${formatDate(item.created_at)}</span>
                </header>
                <p class="review__text">${escape(item.comment)}</p>
                <div class="review__actions">
                    <button type="button" class="btn-edit">edit</button>
                    <button type="button" class="btn-delete">delete</button>
                </div>
            </article>
        `).join('');
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const fd = new FormData(form);
        const res = await api('create', {
            product_id: productId,
            author: fd.get('author'),
            rating: fd.get('rating'),
            comment: fd.get('comment'),
        });
        if (res.ok) {
            form.reset();
            loadFeedback();
        } else {
            alert('ошибка: ' + res.error);
        }
    });

    list.addEventListener('click', async (e) => {
        const card = e.target.closest('.review');
        if (!card) return;
        const id = +card.dataset.id;

        if (e.target.classList.contains('btn-delete')) {
            if (!confirm('удалить отзыв?')) return;
            const res = await api('delete', { id });
            if (res.ok) loadFeedback();
        }

        if (e.target.classList.contains('btn-edit')) {
            const oldText = card.querySelector('.review__text').textContent;
            const newText = prompt('новый текст отзыва:', oldText);
            if (newText === null) return;

            const oldRating = +card.dataset.rating;
            const newRating = prompt('новая оценка (1–5):', oldRating);
            if (newRating === null) return;

            const res = await api('update', {
                id,
                comment: newText,
                rating: +newRating,
            });
            if (res.ok) loadFeedback();
            else alert('ошибка: ' + res.error);
        }
    });

    loadFeedback();

    const ratingEl = document.querySelector('[data-rating]');
if (ratingEl) {
    const stars = ratingEl.querySelectorAll('.rating__star');
    const hidden = ratingEl.parentElement.querySelector('input[name="rating"]');
    let currentValue = 5;

    const paint = (value) => {
        stars.forEach(s => {
            s.classList.toggle('is-active', +s.dataset.value <= value);
        });
    };

    stars.forEach(star => {
        star.addEventListener('mouseenter', () => paint(+star.dataset.value));
        star.addEventListener('click', () => {
            currentValue = +star.dataset.value;
            hidden.value = currentValue;
            paint(currentValue);
        });
    });
    ratingEl.addEventListener('mouseleave', () => paint(currentValue));
    paint(currentValue);
}
});