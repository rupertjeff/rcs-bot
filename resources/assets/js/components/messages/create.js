import React, {Component} from 'react';

class CreateMessage extends Component {
    constructor(props) {
        super(props);

        this.state = {
            id: 'd' + +new Date,
            content: '',
            offset:  0
        };

        this.handleOffsetChange  = this.handleOffsetChange.bind(this);
        this.handleContentChange = this.handleContentChange.bind(this);
        this.handleAddMessage    = this.handleAddMessage.bind(this);
    }

    render() {
        return (
            <tr>
                <td>
                    <textarea className="form-control" value={this.state.content} onChange={this.handleContentChange}/>
                </td>
                <td>
                    <input type="number" className="form-control" value={this.state.offset} onChange={this.handleOffsetChange}/>
                </td>
                <td>
                    <button className="btn btn-success btn-sm" type="button" onClick={this.handleAddMessage}>
                        <span className="sr-only">Add Message</span>
                        <span className="fa fa-plus"/>
                    </button>
                </td>
            </tr>
        );
    }

    handleContentChange(e) {
        this.setState({
            content: e.target.value
        });
    }

    handleOffsetChange(e) {
        this.setState({
            offset: Math.abs(e.target.value)
        });
    }

    handleAddMessage(e) {
        this.props.addMessage(this.state);
        this.setState({
            id: 'd' + +new Date,
            content: '',
            offset: 0
        })
    }
}

export default CreateMessage;
