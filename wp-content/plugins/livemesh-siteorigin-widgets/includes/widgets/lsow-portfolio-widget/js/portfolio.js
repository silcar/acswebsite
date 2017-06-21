jQuery(function ($) {

    if ($().isotope === undefined) {
        return;
    }

    $('.lsow-portfolio-wrap').each(function () {

        // layout Isotope after all images have loaded
        var html_content = $(this).find('.js-isotope');
        html_content.imagesLoaded(function () {
            html_content.isotope('layout');
        });

        var container = $(this).find('.lsow-portfolio');
        if (container.length === 0) {
            return; // no items to filter or load and hence don't continue
        }

        /* -------------- Taxonomy Filter --------------- */

        $(this).find('.lsow-taxonomy-filter .lsow-filter-item a').on('click', function (e) {
            e.preventDefault();

            var selector = $(this).attr('data-value');
            container.isotope({filter: selector});
            $(this).closest('.lsow-taxonomy-filter').children().removeClass('lsow-active');
            $(this).closest('.lsow-filter-item').addClass('lsow-active');
            return false;
        });
    });

});