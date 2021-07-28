const app =
    {
        navbar: document.querySelector('#nav'),
        pathname: window.location.pathname,
        flashMessage: document.querySelector('#flash'),

        init: () =>
        {
            app.bindEvents();
        },

        bindEvents: () =>
        {
            if (app.pathname !== '/') {
                app.navbar.classList.replace('nav_transparent', 'nav_glass')
            }
            // if flashMessage is active, hide it after 6 seconds
            if (app.flashMessage != null) {
                setTimeout(() =>
                {
                    app.flashMessage.style.display = 'none'
                }, 6000)
            }
        }
    }

document.addEventListener('DOMContentLoaded', app.init);