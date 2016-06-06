import React, {Component} from 'react';
import {Link} from 'react-router';

class ScheduleRow extends Component {
    render() {
        return (
            <tr>
                <td>{this.renderDeleteButton()}</td>
                <td>{this.props.name}</td>
                <td>{new Date(this.props.start_at * 1000).toString()}</td>
                <td>{this.props.repeat}</td>
                <td>{this.props.repeat_count}</td>
                <td>{this.renderEditButton()}</td>
            </tr>
        );
    }

    renderEditButton() {
        return (
            <Link className="btn btn-info btn-sm" to={`/schedules/${this.props.id}`}>
                <span className="sr-only">Edit Schedule</span>
                <span className="fa fa-pencil"/>
            </Link>
        );
    }

    renderDeleteButton() {
        return (
            <button className="btn btn-danger btn-sm" type="button">
                <span className="sr-only">Delete Schedule</span>
                <span className="fa fa-times"/>
            </button>
        );
    }
}

export default ScheduleRow;
