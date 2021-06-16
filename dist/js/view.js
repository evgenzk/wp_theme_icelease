export default class View {

    selectors = {
        body            : 'body',
        main            : 'main',
        preloader       : '#preloader',
        preloaderText   : '.preloader-text',

    };

    dom = {};

    linkToDomElements = _ => {

        for(const key in this.selectors){
            if(this.selectors.hasOwnProperty(key)){
                this.dom[key] = document.querySelector(this.selectors[key]);
            }
        }

    }

    addEventListeners = (pageLinks, popState) => {

        this.dom.body.addEventListener('click', pageLinks);
        window.addEventListener('popstate', popState);

    }

    scrollToTop  = _ => {
        return window.scrollTo(0, 0);
    }

    showPreloader = _ => {

        this.renderPreloaderText();


        this.dom.body.classList.remove('visibled-preloader');
        this.dom.body.classList.remove('visibled-content');
        this.dom.body.classList.remove('content-animated');

        this.dom.body.classList.add('visibled-preloader');



        setTimeout(_=> {
            this.dom.body.classList.add('visibled-content');
            this.hidePreloader();

        }, 300);

    }

    hidePreloader = _ => {
        
        setTimeout( _=> {

            this.renderPageTitle();
            
            setTimeout( _ => {
                this.dom.body.classList.add('content-animated');
            }, 300);
                
        }, 2700);

        setTimeout( _=> {
            this.dom.body.classList.remove('visibled-preloader');
        }, 3800);
    
    }

    renderPreloaderText = _ => {

        let preloaderText = Icelease.preloader.texts[~~(Math.random() * Icelease.preloader.texts.length)].text.split(' ').reduce((acc, val, index) => {
            acc[index] = `<span>${val}</span>`;
            return acc;
        }, ['']).join(' ');

        this.dom.preloaderText.innerHTML = preloaderText;
        
    }


    renderPageTitle = _ => {


        let title = document.querySelector('.page-title');

        if(title){
            title.innerHTML = title.innerHTML.split(' ').reduce((acc, val, index) => {
                acc[index] = `<span style="height: 62px; display: inline-block;">${val}</span>`;
                console.log(index);
                
                return acc;
            }, ['']).join(' ');
        }


    }
    
}