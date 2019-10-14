import { Todo } from "./Interfaces"

export default class TodoStore {

  private static i = 0
  public todos: Todo[] = []

  static increment () {
    return this.i++
  }

  addTodo (title: string): void {
    // this.todos = this.todos.concat({
    //     id: 0,
    //     title: title,
    //     completed: false
    // })
    this.todos = [{
      id: TodoStore.increment(),
      title: title,
      completed: false
    }, ...this.todos]
  }

  removeTodo (todo: Todo): void {
    this.todos = this.todos.filter(t => t !== todo)
  }

  updateTitle (todo: Todo, title: string): void {
    this.todos = this.todos.map(t => t === todo ? { ...t, title } : t)
  }

  clearCompleted (): void {
    this.todos = this.todos.filter(t => !t.completed)
  }

  toggleTodo (completed: boolean): void {
    this.todos = this.todos.map(t => completed === t.completed ? { ...t, completed } : t)
  }

  toggleAll (completed = true): void {
    this.todos = this.todos.filter(t => !t.completed)
  }
}
