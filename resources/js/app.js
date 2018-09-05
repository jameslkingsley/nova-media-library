Nova.booting((Vue, router) => {
    Vue.component('index-nova-media-library-image-field', require('./components/IndexField'))
    Vue.component('detail-nova-media-library-image-field', require('./components/DetailField'))
    Vue.component('form-nova-media-library-image-field', require('./components/FormField'))
})
