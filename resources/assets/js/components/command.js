import React, {Component} from 'react';

class Command extends Component {
    constructor(props) {
        super(props);

        this.state               = {
            id:      this.props.id,
            command: this.props.command,
            action:  this.props.action,
            reply:   this.props.reply
        };
        this.startEditing        = this.startEditing.bind(this);
        this.endEditing          = this.endEditing.bind(this);
        this.handleActionChange  = this.handleActionChange.bind(this);
        this.handleCommandChange = this.handleCommandChange.bind(this);
        this.handleReplyChange   = this.handleReplyChange.bind(this);
        this.saveCommand         = this.saveCommand.bind(this);
        this.deleteCommand       = this.deleteCommand.bind(this);
    }

    render() {
        if (this.props.isEditing) {
            return this.renderEditing();
        }

        return this.renderDefault();
    }

    renderDefault() {
        return (
            <tr>
                <td>
                    {this.renderDeleteButton()}
                </td>
                <td>
                    {this.state.command}
                </td>
                <td>
                    {this.state.action}
                </td>
                <td>
                    {this.state.reply ? 'Yes' : 'No'}
                </td>
                <td>
                    {this.renderEditButton()}
                </td>
            </tr>
        );
    }

    renderEditing() {
        return (
            <tr>
                <td>
                    {this.renderCancelButton()}
                </td>
                <td>
                    <input className="form-control" type="text" value={this.state.command} onChange={this.handleCommandChange}/>
                </td>
                <td>
                    <input className="form-control" type="text" value={this.state.action} onChange={this.handleActionChange}/>
                </td>
                <td>
                    <input type="checkbox" value="1" checked={this.state.reply} onChange={this.handleReplyChange}/>
                </td>
                <td>
                    {this.renderSaveButton()}
                </td>
            </tr>
        );
    }

    renderEditButton() {
        if (this.props.editActive) {
            return;
        }
        return (
            <button className="btn btn-info btn-sm" type="button" onClick={this.startEditing}>
                <span className="sr-only">Edit Command</span>
                <span className="fa fa-pencil"/>
            </button>
        );
    }

    renderDeleteButton() {
        return (
            <button className="btn btn-danger btn-sm" type="button" onClick={this.deleteCommand}>
                <span className="sr-only">Delete Command</span>
                <span className="fa fa-times"/>
            </button>
        );
    }

    renderCancelButton() {
        return (
            <button className="btn btn-warning btn-sm" type="button" onClick={this.endEditing}>
                <span className="sr-only">Cancel Edit</span>
                <span className="fa fa-times"/>
            </button>
        );
    }

    renderSaveButton() {
        return (
            <button className="btn btn-success btn-sm" type="button" onClick={this.saveCommand}>
                <span className="sr-only">Save Command</span>
                <span className="fa fa-check"/>
            </button>
        );
    }

    handleCommandChange(e) {
        this.setState({
            command: this.props.processCommand(e.target.value)
        });
    }

    handleActionChange(e) {
        this.setState({
            action: e.target.value
        });
    }

    handleReplyChange() {
        this.setState({
            reply: !this.state.reply
        });
    }

    startEditing() {
        this.props.startEditing(this.state);
    }

    saveCommand() {
        this.props.updateCommand(this.state);
    }

    endEditing() {
        this.setState({
            id: this.props.id,
            command: this.props.command,
            action: this.props.action,
            reply: this.props.reply
        });
        this.props.endEditing();
    }

    deleteCommand() {
        this.props.deleteCommand(this.state.id);
    }
}

export default Command;
