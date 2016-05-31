import React, {Component} from 'react';
import MessageList from './../messages/list';

class CreateSchedule extends Component {
    constructor(props) {
        super(props);

        this.state        = {
            name:        '',
            repeat:      'daily',
            repeatCount: 0,
            startAt:     '',
            messages:    []
        };
        this.repeatValues = [
            'daily',
            'weekly',
            'monthly'
        ];

        this.handleNameChange        = this.handleNameChange.bind(this);
        this.handleRepeatChange      = this.handleRepeatChange.bind(this);
        this.handleRepeatCountChange = this.handleRepeatCountChange.bind(this);
        this.updateMessages          = this.updateMessages.bind(this);
    }

    render() {
        let repeatOptions = this.repeatValues.map((value, index) => {
            return (
                <option key={index} value={value}>{value.ucwords()}</option>
            );
        });

        return (
            <form>
                <h1>Create Schedule</h1>
                <div className="form-group">
                    <label htmlFor="schedule-name">Schedule Name:</label>
                    <input type="text" className="form-control" id="schedule-name" value={this.state.name} onChange={this.handleNameChange}/>
                </div>
                <div className="form-group">
                    <label htmlFor="schedule-repeat">Repeat Frequency:</label>
                    <select id="schedule-repeat" className="form-control" value={this.state.repeat} onChange={this.handleRepeatChange}>
                        {repeatOptions}
                    </select>
                </div>
                <div className="form-group">
                    <label for="schedule-repeat-count">Times to Repeat:</label>
                    <input type="number" className="form-control" id="schedule-repeat-count" value={this.state.repeatCount} onChange={this.handleRepeatCountChange}/>
                </div>
                <div className="form-group">
                    <label for="schedule-start-at">Start Schedule At:</label>
                    <input type="text" className="form-control" id="schedule-start-at" placeholder="mm/dd/yyyy hh:mm (24hr)" value={this.state.startAt} onChange={this.handleStartAtChange}/>
                </div>
                <MessageList
                    messages={this.state.messages}
                    updateMessages={this.updateMessages}
                />
                <div className="form-group form-actions">
                    <button className="btn btn-warning" type="button">
                        <span className="fa fa-times"/> Cancel
                    </button>
                    <button className="btn btn-success" type="button">
                        <span className="fa fa-check"/> Save
                    </button>
                </div>
            </form>
        );
    }

    handleNameChange(e) {
        this.setState({
            name: e.target.value
        })
    }

    handleRepeatChange(e) {
        this.setState({
            repeat: e.target.value
        });
    }

    handleRepeatCountChange(e) {
        this.setState({
            repeatCount: Math.abs(e.target.value)
        });
    }

    handleStartAtChange(e) {
        this.setState({
            startAt: e.target.value
        })
    }

    updateMessages(messages) {
        this.setState({
            messages: messages
        });
    }
}

export default CreateSchedule;
