import React from 'react';
import './App.css';
import TodoList from "./TodoList";
import AddNewItemForm from "./AddNewItemForm";
import {connect} from "react-redux";
import {ADD_TODOLIST, addTodolistAC} from "./reducer";
import axios from "axios"

class App extends React.Component {

    nextTodoListId = 0;

    state = {
        todolists: []

    }

    addTodoList = (title) => {

        let newTodoList = {
            id: this.nextTodoListId,
            title: title,
            tasks:[]
        }

        this.props.addTodolist(newTodoList);/*

        this.setState({todolists: [...this.state.todolists, newTodoList]}, () => {
            this.saveState();
        });

        this.nextTodoListId++;*/


    }

    componentDidMount() {
        this.restoreState();
    }

    restoreState = () => {
        axios.get("https://social-network.samuraijs.com/api/1.1/todo-lists", {withCredentials: true})
           .then(res => {
               this.props.setTodolists(res.data
           });
    }

    saveState = () => {
        // переводим объект в строку
        let stateAsString = JSON.stringify(this.state);
        // сохраняем нашу строку в localStorage под ключом "our-state"
        localStorage.setItem("todolists-state", stateAsString);
    }

    _restoreState = () => {
        // объявляем наш стейт стартовый
        let state = this.state;
        // считываем сохранённую ранее строку из localStorage
        let stateAsString = localStorage.getItem("todolists-state");
        // а вдруг ещё не было ни одного сохранения?? тогда будет null.
        // если не null, тогда превращаем строку в объект
        if (stateAsString != null) {
            state = JSON.parse(stateAsString);
        }
        // устанавливаем стейт (либо пустой, либо восстановленный) в стейт
        this.setState(state, () => {
            this.state.todolists.forEach(t => {
                if (t.id >= this.nextTodoListId) {
                    this.nextTodoListId = t.id + 1;
                }
            })
        });
    }

    render = () => {
        const todolists = this.props
            .todolists
            .map(tl => <TodoList id={tl.id} title={tl.title} tasks={tl.tasks} />)

        return (
            <>
                <div>
                    <AddNewItemForm addItem={this.addTodoList}/>
                </div>
                <div className="App">
                    {todolists}
                </div>
            </>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        todolists: state.todolists
    }
}

const mapDispatchToProps = (dispatch) => {
    return {
        addTodolist: (newTodolist) => {
            const action = addTodolistAC(newTodolist);
            dispatch(action)
        },

        setTodolists: (todolist) => {
            const action = addTodolistAC(newTodolist);
            dispatch(action)
        }
    }
}

const ConnectedApp = connect(mapStateToProps, mapDispatchToProps)(App);
export default ConnectedApp;

