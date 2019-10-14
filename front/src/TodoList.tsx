import * as React from 'react'
import TodoStore from './TodoStore'
import TodoItem from './TodoItem'
import { Todo } from './Interfaces'

interface TodoListProps {
}

interface TodoListState {
  todos: Todo[]
}

export default class TodoList extends React.Component<TodoListProps, TodoListState> {

  private store: TodoStore = new TodoStore()
  
  constructor (props: TodoListProps) {
    super(props)
    this.store.addTodo('Manger')
    this.store.addTodo('Dormir')
    this.store.addTodo('Courir')
    this.state = {
      todos: this.store.todos
    }
  }

  render () {
    let { todos } = this.state
    console.log(todos)
    return <section className="todoapp">

              <header className="header">
                <h1>todos</h1>
                <input className="new-todo" placeholder="What needs to be done?" />
              </header>

              <section className="main">
                <input id="toggle-all" className="toggle-all" type="checkbox" />
                <label htmlFor="toggle-all">Mark all as complete</label>
                <ul className="todo-list">
                { todos.map(t => {
                  return <TodoItem todo={ t } ></TodoItem>
                }) } 
                </ul>
              </section>

              <footer className="footer" >
                <span className="todo-count"><strong>2</strong> items left</span>
                <ul className="filters">
                  <li>
                    <a href="#/" className="selected">All</a>
                  </li>
                  <li>
                    <a href="#/active">Active</a>
                  </li>
                  <li>
                    <a href="#/completed">Completed</a>
                  </li>
                </ul>
                <button className="clear-completed">Clear completed</button>
              </footer>

            </section>
  }
}
