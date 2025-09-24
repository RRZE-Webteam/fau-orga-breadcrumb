// 🟩 Script nur für FAU Elemental geladen!
(function(api, $){
    function refreshOrgaOptions() {
        var type    = api.has('faue_website_type') ? api('faue_website_type')() : '';
        var faculty = api.has('faue_faculty') ? api('faue_faculty')() : '';
        var current = api('fau_orga_breadcrumb_options[site-orga]')();

        $.post(FAU_ORGA_BREADCRUMB.ajaxUrl, {
            action: 'fau_orga_refresh_orga_options',
            _ajax_nonce: FAU_ORGA_BREADCRUMB.nonce,
            website_type: type,
            faculty: faculty,
            current_orga: current
        }).done(function(html){
            var ctrl = api.control(FAU_ORGA_BREADCRUMB.controlId);
            if (ctrl) {
                ctrl.container.find('select').html(html);
            }
        });
    }

    api.bind('ready', function(){
        if (api.has('faue_website_type')) api('faue_website_type').bind(refreshOrgaOptions);
        if (api.has('faue_faculty'))      api('faue_faculty').bind(refreshOrgaOptions);
    });
})(window.wp.customize, jQuery);
