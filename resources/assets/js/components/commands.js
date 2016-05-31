import React, {Component} from 'react';
import CommandService from './../services/command';
import Command from './commands/command'
import AddCommandForm from './commands/addCommandForm';

class Commands extends Component {
    constructor(props) {
        super(props);

        this.state          = {
            command:  {},
            commands: [],
            editing:  false
        };
        this.commandService = new CommandService;

        this.startEditing  = this.startEditing.bind(this);
        this.endEditing    = this.endEditing.bind(this);
        this.isEditing     = this.isEditing.bind(this);
        this.handleSubmit  = this.handleSubmit.bind(this);
        this.createCommand = this.createCommand.bind(this);
        this.saveCommand   = this.saveCommand.bind(this);
        this.deleteCommand = this.deleteCommand.bind(this);
    }

    componentDidMount() {
        this.loadCommands();
    }

    loadCommands() {
        return this.commandService.all().then((response) => {
            this.setState({
                commands: response.data.data
            });

            return Promise.resolve(response);
        });
    }

    render() {
        let commandRows = this.state.commands.map((command, index) => {
            return (
                <Command
                    {...command}
                    key={command.id}
                    index={index}
                    startEditing={this.startEditing}
                    endEditing={this.endEditing}
                    editActive={this.isEditing()}
                    isEditing={this.isEditing(command)}
                    updateCommand={this.saveCommand}
                    deleteCommand={this.deleteCommand}
                    processCommand={this.processCommand}
                />
            );
        });

        return (
            <form onSubmit={this.handleSubmit}>
                <table className="table table-bordered table-striped table-hover">
                    <thead className="thead-default">
                        <tr>
                            <th/>
                            <th>Command</th>
                            <th>Action</th>
                            <th>Replies to User</th>
                            <th/>
                        </tr>
                    </thead>
                    <tbody>
                        {commandRows}
                        <AddCommandForm
                            processCommand={this.processCommand}
                            createCommand={this.createCommand}
                        />
                    </tbody>
                </table>
            </form>
        );
    }

    handleSubmit(e) {
        e.preventDefault();
    }
    
    createCommand(command) {
        this.commandService.save(command).then(() => {
            this.loadCommands();
        });
    }

    isEditing(command = null) {
        if (null !== command) {
            return this.state.editing && command.id === this.state.command.id;
        }

        return this.state.editing;
    }

    startEditing(command) {
        this.setState({
            command: command,
            editing: true
        })
    }

    endEditing() {
        this.setState({
            command: {},
            editing: false
        })
    }

    saveCommand(command) {
        this.commandService.save(command).then(() => {
            return this.loadCommands();
        });
        this.endEditing();
    }

    deleteCommand(id) {
        this.setState({
            commands: this.state.commands.filter(function (command) {
                return command.id !== id;
            })
        });

        this.commandService.delete(id).then(() => {
            return this.loadCommands();
        });
    }

    processCommand(value) {
        value = value.replace(/[^a-z!]/gi, '');

        if (0 >= value.indexOf('!') && '!' !== value.substr(0, 1)) {
            value = '!' + value;
        }

        return value;
    }
}

export default Commands;
