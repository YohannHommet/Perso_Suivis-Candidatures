let turbo =
    {

        init:  () =>
        {
            import * as Turbo from "https://cdn.skypack.dev/@hotwired/turbo";
            Turbo();
        }


    }

document.addEventListener('DOMContentLoaded', turbo.init);