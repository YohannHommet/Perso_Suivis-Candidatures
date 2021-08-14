const navbar =
    {
        navbar:         document.querySelector('#nav'),
        pathname:       window.location.pathname,
        flashMessage:   document.querySelector('#flash'),

        init: () =>
        {
            navbar.bindEvents();
        },

        bindEvents: () =>
        {
            if (navbar.pathname === '/') {
                navbar.navbar.classList.replace('nav_glass', 'nav_transparent')
            }
            // if flashMessage is active, hide it after 6 seconds
            if (navbar.flashMessage != null) {
                setTimeout(() =>
                {
                    navbar.flashMessage.style.display = 'none'
                }, 6000)
            }
        }
    }

document.addEventListener('DOMContentLoaded', navbar.init);