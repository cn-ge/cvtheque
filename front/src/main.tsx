import * as React from 'react'
import store from './TodoStore'
import TodoList from './TodoList'

console.log(store)

let ReactDOM = require('react-dom')

ReactDOM.render(
    // <div>Salut les gens</div>
    <TodoList></TodoList>,
    document.getElementById('app') as Element
)
