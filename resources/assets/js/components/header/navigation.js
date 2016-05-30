import React, {Component} from 'react';
import Page from './page';

class HeaderNavigation extends Component {
    render() {
        var pages = this.props.pages.map(function (page) {
            return (
                <Page {...page} key={page.name}/>
            );
        });
        
        return (
            <ul className="nav navbar-nav">
                {pages}
            </ul>
        );
    }
}

export default HeaderNavigation;
