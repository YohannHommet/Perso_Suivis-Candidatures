
let app =
    {
        navbar: document.querySelector('#nav'),
        pathname: window.location.pathname,

        init: () =>
        {
            if (app.pathname !== '/') {
                app.navbar.classList.replace('nav_transparent', 'nav_glass')
            }
        },

    }

document.addEventListener('DOMContentLoaded', app.init);