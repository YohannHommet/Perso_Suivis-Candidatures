/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';


const navbar = document.querySelector('#nav');
const pathname = window.location.pathname;
const flashMessage = document.querySelector('#flash');

// Navbar style toggle
// if (pathname !== '/') {
//     navbar.classList.replace('nav_transparent', 'nav_glass')
// }

// if flashMessage is active, hide it after 6 seconds
if (flashMessage != null) {
    setTimeout(() => {
        flashMessage.style.display = 'none'
    }, 6000)
}