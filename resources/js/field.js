Nova.booting((Vue, router) => {
    Vue.component('index-media-library-image', require('./components/IndexField'));
    Vue.component('detail-media-library-image', require('./components/DetailField'));
    Vue.component('form-media-library-image', require('./components/FormField'));
})
