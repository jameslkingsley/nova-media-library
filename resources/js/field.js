Nova.booting((Vue, router) => {
    Vue.component('index-media-library-field', require('./components/IndexField'));
    Vue.component('detail-media-library-field', require('./components/DetailField'));
    Vue.component('form-media-library-field', require('./components/FormField'));
})
