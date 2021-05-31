const app = {
    navbar: document.querySelector('#nav'),
    pathname: window.location.pathname,
    footer: document.querySelector('footer'),

   init: () => {

       if (app.pathname !== '/') {
           // app.navbar.classList.replace('navbar-dark', 'navbar-light');
           app.navbar.classList.replace('nav_transparent', 'nav_glass')
       }

   },

}

document.addEventListener('DOMContentLoaded', app.init);