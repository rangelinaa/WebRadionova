import api from "../services/api.js";

const TodoRepository = {
  async getAll() {
    return await api("/todo");
  },
}

export default TodoRepository;