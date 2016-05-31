import React, {Component} from 'react';

class ScheduleRow extends Component {
    render() {
        return (
            <tr>
                <td>{this.renderDeleteButton()}</td>
                <td>{this.props.name}</td>
                <td>{this.props.start_at}</td>
                <td>{this.props.repeat}</td>
                <td>{this.props.repeat_count}</td>
                <td>{this.renderEditButton()}</td>
            </tr>
        );
    }

    renderEditButton() {
        return (
            <button className="btn btn-info btn-sm" type="button">
                <span className="sr-only">Edit Schedule</span>
                <span className="fa fa-pencil"/>
            </button>
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
