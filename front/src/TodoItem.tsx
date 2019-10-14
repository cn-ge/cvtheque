import * as React from 'react'
import cn from 'classnames'
import { Todo } from './Interfaces'

interface TodoItemProps {
  todo: Todo
}

interface TodoItemState {
}

export default class TodoItem extends React.Component<TodoItemProps, TodoItemState> {

  render () {
    let { todo } = this.props
    return <li data-id={ todo.id } className={ cn({ completed: todo.completed }) }>
              <div className="view">
                <input className="toggle" type="checkbox" />
                <label>{ todo.title }</label>
                <button className="destroy"></button>
              </div>
            </li>
  }
}
