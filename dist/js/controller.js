import View from './view.js';
import Model from './model.js';



export default class Controller {

    static state = null;

    static init = _ => {
        Controller.state = new Controller();
    }


    constructor() {


        this.view = new View();
        this.model = new Model();

        this.view.linkToDomElements();

        this.view.addEventListeners(
            this.handlePageLinks,
            this.updatePopState
        );

        this.view.showPreloader();

    }

    handlePageLinks = (e) => {
        
        if(e.target.tagName == 'A' || e.target.parentElement.tagName == 'A'){

            e.preventDefault();
            let href = e.target.getAttribute('href') || 
                       e.target.parentElement.getAttribute('href');

            if(href){
                if(href.indexOf('#') != 0){
                    
                    let state = {
                        page : href
                    }

                    history.pushState(state, '', state.page);

                    this.model.updateState(
                        state, this.view.showPreloader, this.handleMenuAfterAjax
                    );
                } else if(href.length > 1) {
                    console.log(href);
                    document.querySelector(href).scrollIntoView({ behavior: 'smooth' });
                }

            }
            
        }
        
        if(this.view.dom.map){
            initMap();
        }

    }

    updatePopState = (e) => {

        this.model.updateState(
            e.state,
            this.view.showPreloader,
            this.handleMenuAfterAjax
        );

    }

    handleMenuAfterAjax = (data) => {

        this.view.scrollToTop();
        this.view.dom.main.innerHTML = data;
    
    }

}