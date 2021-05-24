const app = {
    navbar: document.querySelector('#nav'),
    pathname: window.location.pathname,
    footer: document.querySelector('footer'),

   init: () => {

       if (app.pathname === '/login' || app.pathname === '/applications' || app.pathname === 'register') {
           app.navbar.classList.replace('navbar-dark', 'navbar-light')
           app.footer.style.display = "none"
       }

   },

}

document.addEventListener('DOMContentLoaded', app.init);