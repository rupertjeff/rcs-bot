import React, {Component} from 'react';
import Header from './header';

class Layout extends Component {
    render() {
        let paddingTop = '3.375rem';

        return (
            <div className="container-fluid" style={{paddingTop}}>
                <Header/>

                {this.props.children}
            </div>
        );
    }
}

export default Layout;
