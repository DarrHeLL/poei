/**
 * Created by POE1 on 06/12/2018.
 */
(function ($, Drupal, DrupalSettings) {
    $(document).ready(function () {
        $('.block h2').click(function () {
            $(this).parent().find('.content').slideToggle();
        });

        $("a[href^='http']").attr('target', '_blank');

        var host = window.location.origin;
        $("a[href^='http']").prepend('<img src="' + host + '/d8composer/web/themes/custom/ive/images/external-link.gif" />');
    });
})(jQuery, Drupal, drupalSettings);