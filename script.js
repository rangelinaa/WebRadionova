function getSelectedType() {
    return document.querySelector('#typeGroup .pill.active').dataset.value;
}

function getSelectedSize() {
    return document.querySelector('#sizeGroup .pill.active').dataset.value;
}

function getSelectedToppings() {
    return [...document.querySelectorAll('.topping-label input:checked')]
        .map(el => el.value);
}

function calculate() {

    const pizza = new Pizza(
        getSelectedType(),
        getSelectedSize()
    );

    getSelectedToppings().forEach(t => pizza.addTopping(t));

    const price = pizza.calculatePrice();
    const calories = pizza.calculateCalories();

    document.getElementById("result").textContent =
        `Добавить в корзину за ${price} ₽ (${calories} Ккал)`;
}

// ТИП ПИЦЦЫ
document.querySelectorAll('#typeGroup .pill').forEach(btn => {
    btn.addEventListener('click', () => {

        document.querySelectorAll('#typeGroup .pill')
            .forEach(b => b.classList.remove('active'));

        btn.classList.add('active');

        document.querySelectorAll('.pizza-img').forEach(img => img.classList.remove('active'));
        document.getElementById('img-' + btn.dataset.value).classList.add('active');

        calculate();
    });
});

const stage = document.querySelector('.pizza-stage');

// РАЗМЕР ПИЦЦЫ
document.querySelectorAll('#sizeGroup .pill').forEach(btn => {
    btn.addEventListener('click', () => {

        document.querySelectorAll('#sizeGroup .pill')
            .forEach(b => b.classList.remove('active'));

        btn.classList.add('active');

        const isLarge = btn.dataset.value === 'LARGE';
        stage.style.transform = `scale(${isLarge ? 1.18 : 1})`;

        calculate();
    });
});

//ДОБАВКИ
document.querySelectorAll('.topping-label input')
    .forEach(ch => ch.addEventListener('change', calculate));

calculate();