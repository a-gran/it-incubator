import React from 'react';
import './App.css';
import TodoListTasks from "./TodoListTasks";
import TodoListFooter from "./TodoListFooter";
import TodoListTitle from "./TodoListTitle";
import AddNewItemForm from "./AddNewItemForm";
import {connect} from "react-redux";
import DELETE_TODOLIST from "./reducer"
import DELETE_TASK from "./reducer"
import UPDATE_TASK from "./reducer"
import ADD_TASK from "./reducer"

class TodoList extends React.Component {

    constructor(props) {
        super(props);
        this.newTasksTitileRef = React.createRef();

    }

    componentDidMount() {
        this.restoreState();
    }

    saveState = () => {
        // переводим объект в строку
        let stateAsString = JSON.stringify(this.state);
        // сохраняем нашу строку в localStorage под ключом "our-state"
        localStorage.setItem("our-state-" + this.props.id, stateAsString);
    }

    restoreState = () => {
        // объявляем наш стейт стартовый
        let state = this.state;
        // считываем сохранённую ранее строку из localStorage
        let stateAsString = localStorage.getItem("our-state-" + this.props.id);
        // а вдруг ещё не было ни одного сохранения?? тогда будет null.
        // если не null, тогда превращаем строку в объект
        if (stateAsString != null) {
            state = JSON.parse(stateAsString);
        }
        // устанавливаем стейт (либо пустой, либо восстановленный) в стейт
        this.setState(state, () => {
            this.state.tasks.forEach(t => {
                if (t.id >= this.nextTaskId) {
                    this.nextTaskId = t.id + 1;
                }
            })
        });
    }

    nextTaskId = 0;

    state = {
        tasks: [],
        filterValue: "All"
    };

    addTask = (newText) => {
        let newTask = {
            id: this.nextTaskId,
            title: newText,
            isDone: false,
            priority: "low"
        };
        // инкрементим (увеличим) id следующей таски, чтобы при следюущем добавлении, он был на 1 больше
        this.nextTaskId++;
       /* let newTasks = [...this.state.tasks, newTask];
        this.setState( {
            tasks: newTasks
        }, () => { this.saveState(); });*/
       this.props.addTask(newTask, this.props.id);

    }

    changeFilter = (newFilterValue) => {
        this.setState( {
            filterValue: newFilterValue
        }, () => { this.saveState(); });
    }

    changeTask = (taskId, obj) => {
        let newTasks = this.state.tasks.map(t => {
            if (t.id !== taskId) {
                return t;
            }
            else {
                return {...t, ...obj};
            }
        });

        this.props.updateTask(taskId, obj, this.props.id);

        this.setState({
            tasks: newTasks
        }, () => { this.saveState(); });
    }

    changeStatus = (taskId, isDone) => {
        this.changeTask(taskId, {isDone: isDone});
    }

    changeTitle = (taskId, title) => {
        this.changeTask(taskId, {title: title});
    }

    deleteTodolist = () => {
        this.props.deleteTodolist(this.props.id);
    }

    deleteTask = (taskId) => {
        this.props.deleteTask(taskId, this.props.id);
    }

    render = () => {
        return (
                <div className="todoList">
                    <div className="todoList-header">
                            <TodoListTitle title={this.props.title} onDelete={this.deleteTodolist} />
                            <AddNewItemForm addItem={this.addTask} />

                    </div>

                    <TodoListTasks changeStatus={this.changeStatus }
                                   changeTitle={this.changeTitle }
                                   deleteTask={this.deleteTask}
                                   tasks={this.state.tasks.filter(t => {
                        if (this.state.filterValue === "All") {
                            return true;
                        }
                        if (this.state.filterValue === "Active") {
                            return t.isDone === false;
                        }
                        if (this.state.filterValue === "Completed") {
                            return t.isDone === true;
                        }
                    })}/>
                    <TodoListFooter changeFilter={this.changeFilter} filterValue={this.state.filterValue} />
                </div>
        );
    }
}

const mapDispatchToProps = (dispatch) => {
    return {
        addTask(newTask, todolistId) {
            const action = { type: ADD_TASK, newTask, todolistId };
            dispatch(action);
        },
        updateTask(taskId, obj, todolistId) {
            const action = { type: UPDATE_TASK, taskId, obj, todolistId };
            dispatch(action);
        },
        deleteTodolist: (todolistId) => {
            const action = {
                type: DELETE_TODOLIST,
                todolistId: todolistId
            };
            dispatch(action)
        },
        deleteTask: (taskId, todolistId) => {
            const action = {
                type: DELETE_TASK,
                todolistId,
                taskId
            };
            dispatch(action)
        }
    }
}

const ConnectedTodolist = connect(null, mapDispatchToProps)(TodoList);

export default ConnectedTodolist;

