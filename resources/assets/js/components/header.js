import React, {Component} from 'react';
import HeaderNavigation from './header/navigation';

class Header extends Component {
    constructor(props) {
        super(props);

        this.state = {
            pages: [
                {
                    name: 'Commands',
                    url:  '/commands'
                },
                {
                    name: 'Schedules',
                    url:  '/schedules'
                }
            ]
        };
    }

    render() {
        return (
            <header>
                <nav className="navbar navbar-fixed-top bg-inverse">
                    <h1 className="navbar-brand">RCS Discord Bot</h1>
                    <HeaderNavigation pages={this.state.pages}/>
                </nav>
            </header>
        );
    }
}

export default Header;
