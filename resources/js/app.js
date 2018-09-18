Nova.booting((Vue, router) => {
    Vue.component('index-nova-media-library-image-field', require('./components/Image/IndexField'))
    Vue.component('detail-nova-media-library-image-field', require('./components/Image/DetailField'))
    Vue.component('form-nova-media-library-image-field', require('./components/Image/FormField'))

    Vue.component('index-nova-media-library-file-field', require('./components/File/IndexField'))
    Vue.component('detail-nova-media-library-file-field', require('./components/File/DetailField'))
    Vue.component('form-nova-media-library-file-field', require('./components/File/FormField'))
})
