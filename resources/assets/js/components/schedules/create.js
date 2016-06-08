import React, {Component, PropTypes} from 'react';
import MessageList from './../messages/list';
import ScheduleService from './../../services/schedule';
import {Link} from 'react-router';
import moment from 'moment';

class CreateSchedule extends Component {
    constructor(props) {
        super(props);

        this.state           = {
            name:        '',
            repeat:      'weekly',
            repeatCount: 0,
            startAt:     '',
            messages:    []
        };
        this.repeatValues    = [
            'hourly',
            'daily',
            'weekly',
            'monthly'
        ];
        this.scheduleService = new ScheduleService;

        this.handleNameChange        = this.handleNameChange.bind(this);
        this.handleRepeatChange      = this.handleRepeatChange.bind(this);
        this.handleRepeatCountChange = this.handleRepeatCountChange.bind(this);
        this.handleStartAtChange     = this.handleStartAtChange.bind(this);
        this.updateMessages          = this.updateMessages.bind(this);
        this.saveSchedule            = this.saveSchedule.bind(this);
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
                    <Link to="/schedules" className="btn btn-warning">
                        <span className="fa fa-times"/> Cancel
                    </Link>
                    <button className="btn btn-success" type="button" onClick={this.saveSchedule}>
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

    saveSchedule(e) {
        let startAt  = this.generateStartAt(this.state.startAt),
            endAt    = this.generateEndAt(startAt, this.state.repeat, this.state.repeatCount);
        let schedule = {
            name:     this.state.name,
            repeat:   this.state.repeat,
            start_at: startAt,
            end_at:   endAt,
            messages: this.state.messages
        };

        if (this.state.id) {
            schedule.id = this.state.id;
        }

        this.scheduleService.save(schedule).then(() => {
            this.context.router.push('/schedules');
        }).catch((error) => {
            console.log(error);
        });
    }

    generateStartAt(startAt) {
        return +moment(new Date(startAt)).format('X');
    }

    generateEndAt(startAt, repeatType, repeatCount) {
        let msIncrement = 60 * repeatCount;

        switch (repeatType) {
            case 'monthly':
                msIncrement *= 4;

            case 'weekly':
                msIncrement *= 7;

            case 'daily':
                msIncrement *= 24;
                
            case 'hourly':
                msIncrement *= 60;
        }

        return +moment.unix(startAt + msIncrement).format('X');
    }
}

CreateSchedule.contextTypes = {
    router: PropTypes.object
};

export default CreateSchedule;
