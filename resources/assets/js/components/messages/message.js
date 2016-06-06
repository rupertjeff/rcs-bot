import React, {Component} from 'react';

class Message extends Component {
    constructor(props) {
        super(props);

        this.state = {
            offset:  this.props.offset,
            content: this.props.content,
            id:      this.props.id
        };

        this.handleContentChange = this.handleContentChange.bind(this);
        this.handleOffsetChange  = this.handleOffsetChange.bind(this);
        this.deleteMessage       = this.deleteMessage.bind(this);
    }

    render() {
        return (
            <tr>
                <td>
                    <textarea className="form-control" value={this.props.content} onChange={this.handleContentChange}/>
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

    handleContentChange(e) {
        this.setState({
            content: e.target.value
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
