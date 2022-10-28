(function() {
    /**
     * Fix canonical tag for C7 products and collections.
     */
    var link = !!document.querySelector("link[rel='canonical']") ? document.querySelector("link[rel='canonical']") : document.createElement('link');
    link.setAttribute('rel', 'canonical');
    link.setAttribute('href', location.protocol + '//' + location.host + location.pathname);
    document.head.appendChild(link);
})();