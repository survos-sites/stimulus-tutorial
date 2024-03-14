import { Controller } from '@hotwired/stimulus';
// import React from 'react';
// import FeaturedProduct from '../components/FeaturedProduct';
//
export default class extends Controller {
    static values = {
        product: Object
    }

//     connect() {
//         import('react-dom').then((ReactDOM) => {
//             ReactDOM.default.render(
//                 <FeaturedProduct product={this.productValue} />,
//                 this.element
//             )
//         })
//     }
}
