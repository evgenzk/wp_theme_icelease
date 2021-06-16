export default class Model{

    preloaderTexts = null;

    updateState(state, handleMenuBeforeAjax, handleMenuAfterAjax){

        if(!state) return;

        const aja = new XMLHttpRequest();
        const formData = new FormData();

        formData.append('action', 'fill-main');
        formData.append('state[page]', state.page);

        aja.onloadstart = () => {
            handleMenuBeforeAjax();
        }

        aja.onloadend = () => {
            handleMenuAfterAjax(aja.response);
        }

        aja.open('POST', Icelease.ajax);
        aja.send(formData);

    }


}