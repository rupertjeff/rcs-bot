import React, {Component} from 'react';

class AddCommandForm extends Component {
    constructor(props) {
        super(props);

        this.state               = {
            command: '',
            action:  '',
            reply:   false
        };
        this.handleCommandChange = this.handleCommandChange.bind(this);
        this.handleActionChange  = this.handleActionChange.bind(this);
        this.handleReplyChange   = this.handleReplyChange.bind(this);
        this.saveCommand         = this.saveCommand.bind(this);
    }

    render() {
        return (
            <tr>
                <td/>
                <td>
                    <input className="form-control" type="text" placeholder="!command" value={this.state.command} onChange={this.handleCommandChange}/>
                </td>
                <td>
                    <input className="form-control" type="text" placeholder="Action" value={this.state.action} onChange={this.handleActionChange}/>
                </td>
                <td>
                    <input type="checkbox" value={this.state.reply} onChange={this.handleReplyChange}/>
                </td>
                <td>
                    {this.renderSaveButton()}
                </td>
            </tr>
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
        })
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

    saveCommand(e) {
        this.props.createCommand(this.state);
    }
}

export default AddCommandForm;
