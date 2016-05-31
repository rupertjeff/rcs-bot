import React, {Component} from 'react';
import Message from './message';
import CreateMessage from './create';

class MessageList extends Component {
    constructor(props) {
        super(props);

        this.addMessage    = this.addMessage.bind(this);
        this.deleteMessage = this.deleteMessage.bind(this);
    }

    render() {
        let messageRows = this.props.messages.map((message, index) => {
            return (
                <Message
                    {...message}
                    key={message.id}
                    index={index}
                    deleteMessage={this.deleteMessage}
                />
            );
        });

        return (
            <div className="form-group">
                <table className="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Message</th>
                            <th>Minute Offset</th>
                            <th/>
                        </tr>
                    </thead>
                    <tbody>
                        {messageRows}
                        <CreateMessage
                            addMessage={this.addMessage}
                        />
                    </tbody>
                </table>
            </div>
        );
    }

    addMessage(message) {
        this.props.messages.push(message);
        this.props.updateMessages(this.props.messages);
    }

    deleteMessage(messageId) {
        this.props.updateMessages(this.props.messages.filter(function (message) {
            let id = messageId;

            if (messageId.id) {
                id = messageId.id;
            }

            return id !== message.id;
        }));
    }
}

export default MessageList;
