import React, {Component} from 'react';
import {Link} from 'react-router';

class Page extends Component {
    render() {
        let myClass = 'nav-item';
        
        if (this.context.router && this.context.router.isActive(this.props.url)) {
            myClass += ' active';
        }
        
        return (
            <li className={myClass}>
                <Link to={this.props.url}>{this.props.name}</Link>
            </li>
        );
    }
}

export default Page;
