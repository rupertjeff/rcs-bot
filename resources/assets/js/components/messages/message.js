import React, {Component} from 'react';

class Message extends Component {
    constructor(props) {
        super(props);

        this.state = {
            offset:  this.props.offset,
            message: this.props.message,
            id:      this.props.id
        };

        this.handleMessageChange = this.handleMessageChange.bind(this);
        this.handleOffsetChange  = this.handleOffsetChange.bind(this);
        this.deleteMessage       = this.deleteMessage.bind(this);
    }

    render() {
        return (
            <tr>
                <td>
                    <textarea className="form-control" value={this.props.message} onChange={this.handleMessageChange}/>
                </td>
                <td>
                    <input type="number" className="form-control" value={this.props.offset} onChange={this.handleOffsetChange}/>
                </td>
                <td>
                    <button className="btn btn-danger btn-sm" onClick={this.deleteMessage}>
                        <span className="sr-only">Delete Message</span>
                        <span className="fa fa-times"/>
                    </button>
                </td>
            </tr>
        );
    }

    handleMessageChange(e) {
        this.setState({
            message: e.target.value
        })
    }

    handleOffsetChange(e) {
        this.setState({
            offset: Math.abs(e.target.value)
        });
    }

    deleteMessage(e) {
        this.props.deleteMessage(this.state);
    }
}

export default Message;
