import Auth from "../services/auth.js";
import location from "../services/location.js";
import loading from "../services/loading.js";
import TodoRepository from "../repository/todo.js";

const init = async () => {
    const { ok: isLogged } = await Auth.me()

    if (!isLogged) {
        return location.login()
    } else {
        loading.stop()
    }

    // create POST /todo { description: string }
    // get get /todo/1 - 1 это id
    // getAll get /todo
    // update put /todo/1 - 1 это id { description: string }
    // delete delete /todo/1 - 1 это id

    const response = await TodoRepository.getAll();
    
    const todos = response.data;

    const main = document.querySelector("main.main");

    main.innerHTML = `
        <h1>Todos</h1>
        <div>
            ${todos.map(todo => `
                <div>
                    <span>${todo.description}</span>
                </div>
            `).join("")}
        </div>
    `;
} 

if (document.readyState === 'loading') {
    document.addEventListener("DOMContentLoaded", init)
} else {
    init()
}
