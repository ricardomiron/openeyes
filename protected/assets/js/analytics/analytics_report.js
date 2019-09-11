<script src="<?= Yii::app()->assetManager->createUrl('js/analytics/analytics_report.js')?>"></script>

// analytics_sidebar scripts

    $('#js-btn-selected-eye').click(function(e){
        $('#js-chart-filter-eye-side').trigger( "changeEyeSide" );
    });
    $('#js-chart-filter-eye-side').bind( "changeEyeSide", function(){
        var side = $('#js-chart-filter-eye-side').text().toLowerCase();
        var opposite_side = side == 'left' ? 'right' : 'left';
        $('#js-hs-chart-analytics-clinical-others-' + side).show();
        $('#js-hs-chart-analytics-clinical-others-' + opposite_side).hide();
    });

    $('#js-chart-filter-age').on('DOMSubtreeModified', function () {
        if ($('#js-chart-filter-age').html() == "Range") {
            $('#js-chart-filter-age-all').hide();
            $('#js-chart-filter-age-min').addClass('js-hs-filters');
            $('#js-chart-filter-age-max').addClass('js-hs-filters');
            $('#js-chart-filter-age-range').show();
        } else {
            $('#js-chart-filter-age-range').hide();
            $('#js-chart-filter-age-min').removeClass('js-hs-filters');
            $('#js-chart-filter-age-max').removeClass('js-hs-filters');
            $('#js-chart-filter-age-all').show();
        }
    });

    function getCurrentShownPlotId(){
        var plot_id;
        $('.js-plotly-plot').each(function () {
            if($(this).is(':visible')){
                plot_id =  $(this)[0].id;
                return false;
            }
        });
        return plot_id;
    }

    $('#search-form').on('submit', function (e) {
        e.preventDefault();
        let current_plot = $("#"+getCurrentShownPlotId());
        current_plot.hide();
        $('#js-analytics-spinner').show();
        $.ajax({
            url: '/analytics/updateData',
            data:$('#search-form').serialize() + getDataFilters(),
            dataType:'json',
            success: function (data, textStatus, jqXHR) {
                $('#js-analytics-spinner').hide();
                current_plot.show();
                plotUpdate(data);
            }
        });
    });

    function getDataFilters(specialty, side_bar_user_list){
        var specialty = specialty;
        var side_bar_user_list = side_bar_user_list;
        var service_common_disorders = JSON.parse(<?=json_encode(json_encode($common_disorders));?>);
        var mr_custom_diagnosis = ['AMD(wet)', 'BRVO', 'CRVO', 'DMO'];
        var gl_custom_diagnosis = ['Glaucoma', 'Open Angle Glaucoma', 'Angle Closure Glaucoma', 'Low Tension Glaucoma', 'Ocular Hypertension'];
        var mr_custom_treatment = ['Lucentis', 'Elyea', 'Avastin', 'Triamcinolone', 'Ozurdex'];
        var gl_custom_procedure = ['Cataract Extraction','Trabeculectomy', 'Aqueous Shunt','Cypass','SLT','Cyclodiode'];
        var filters ="specialty="+specialty;
        $('.js-hs-filters').each(function () {
            if($(this).is('span')){
                if ($(this).html() !== 'All'){
                    if ($(this).hasClass('js-hs-surgeon')){
                        if(side_bar_user_list !== null){
                            filters += '&'+$(this).data('name')+'='+side_bar_user_list[$(this).html()];
                        }
                    }else if($(this).data('name') == "service_diagnosis"){
                        filters += '&'+$(this).data('name')+'='+Object.keys(service_common_disorders).find(key => service_common_disorders[key] ===$(this).html());
                    }else if($(this).hasClass('js-hs-custom-mr-diagnosis')){
                        var diagnosis_array = $(this).html().split(",");
                        var diagnoses = "";
                        diagnosis_array.forEach(
                            function (item) {
                                diagnoses += mr_custom_diagnosis.indexOf(item) + ',';
                            }
                        );
                        diagnoses = diagnoses.slice(0,-1);
                        filters += '&'+$(this).data('name')+'='+diagnoses;
                    }else if($(this).hasClass('js-hs-custom-mr-treatment')){
                        var treatment = mr_custom_treatment.indexOf($(this).html());
                        filters += '&'+$(this).data('name')+'='+treatment;
                    }else if($(this).hasClass('js-hs-custom-gl-procedure')){
                        var procedure = gl_custom_procedure.indexOf($(this).html());
                        filters += '&'+$(this).data('name')+'='+procedure;
                    }else if($(this).hasClass('js-hs-custom-gl-diagnosis')){
                        var diagnosis_array = $(this).html().split(",");
                        var diagnoses = "";
                        diagnosis_array.forEach(
                            function (item) {
                                diagnoses += gl_custom_diagnosis.indexOf(item) + ',';
                            }
                        );
                        diagnoses = diagnoses.slice(0,-1);
                        filters += '&'+$(this).data('name')+'='+diagnoses;
                    }else if($(this).hasClass('js-hs-custom-mr-plot-type')){
                        if ($(this).html().includes('change')){
                            filters += '&'+$(this).data('name')+'=change';
                        }
                    }
                    else{
                        filters += '&'+$(this).data('name')+'='+$(this).html();
                    }
                }
            }else if($(this).is('select')){
                filters += '&'+$(this).data('name')+'='+$(this).val();
            }
        });
        return filters;
    }
    function plotUpdate(data, specialty){
        var clinical_chart = $('#js-hs-chart-analytics-clinical')[0];
        var clinical_data = data[0];
        window.csv_data_for_report['clinical_data'] = clinical_data['csv_data'];
        clinical_chart.data[0]['x'] = clinical_data.x;
        clinical_chart.data[0]['y'] = clinical_data.y;
        clinical_chart.data[0]['customdata'] = clinical_data.customdata;
        clinical_chart.data[0]['text'] = clinical_data.text;
        clinical_chart.layout['yaxis']['tickvals'] = clinical_data['y'];
        clinical_chart.layout['yaxis']['ticktext'] = clinical_data['text'];
        clinical_chart.layout['hoverinfo'] = 'x+y';
        Plotly.redraw(clinical_chart);
        if (specialty !== 'All'){
            var custom_charts = ['js-hs-chart-analytics-clinical-others-left','js-hs-chart-analytics-clinical-others-right'];
            var custom_data = data[2];
            window.csv_data_for_report['custom_data'] = custom_data['csv_data'];
            for (var i = 0; i < custom_charts.length; i++) {
                var chart = $('#'+custom_charts[i])[0];
                chart.layout['title'] = (i)? 'Clinical Section (Right Eye)': 'Clinical Section (Left Eye)';
                chart.layout['yaxis']['title'] = {
                  font: {
                    family: 'sans-serif',
                    size: 12,
                    color: '#fff',
                  },
                  text: getVATitle(),
                };
              //Set VA unit tick labels
              var va_mode = $('#js-chart-filter-plot');
              if (va_mode.html().includes('change')) {
                chart.layout['yaxis']['tickmode'] = 'auto';
              } else {
                chart.layout['yaxis']['tickmode'] = 'array';
                chart.layout['yaxis']['tickvals'] = JSON.parse($va_final_ticks['tick_position']);;
                chart.layout['yaxis']['ticktext'] = JSON.parse($va_final_ticks['tick_labels']);
              }
                chart.data[0]['x'] = custom_data[i][0]['x'];
                chart.data[0]['y'] = custom_data[i][0]['y'];
                chart.data[0]['customdata'] = custom_data[i][0]['customdata'];
                chart.data[0]['error_y'] = custom_data[i][0]['error_y'];
                chart.data[0]['hoverinfo'] = custom_data[i][0]['hoverinfo'];
                chart.data[0]['hovertext'] = custom_data[i][0]['hovertext'];
                chart.data[1]['x'] = custom_data[i][1]['x'];
                chart.data[1]['y'] = custom_data[i][1]['y'];
                chart.data[1]['customdata'] = custom_data[i][1]['customdata'];
                chart.data[1]['error_y'] = custom_data[i][1]['error_y'];
                chart.data[1]['hoverinfo'] = custom_data[i][1]['hoverinfo'];
                chart.data[1]['hovertext'] = custom_data[i][1]['hovertext'];
                Plotly.redraw(chart);
            }
        }
        //update the service data
        constructPlotlyData(data[1]['plot_data']);
        window.csv_data_for_report['service_data'] = data[1]['csv_data'];
    }
    function viewAllDates() {
        $('#analytics_datepicker_from').val("");
        $('#analytics_datepicker_to').val("");
    }
    
    function getVATitle(){
      var va_mode = $('#js-chart-filter-plot');
      var va_title;
      if (va_mode.html().includes('change')) {
        va_title = "Visual acuity change from baseline (LogMAR)";
      } else {
        va_title = "Visual acuity (LogMAR)";
      }
      return va_title;
    }
</script>

// analytics_sidebar_cataract scripts
<script type="text/javascript">
    <?php
    $side_bar_user_list = array();
    if (isset($user_list)) {
        foreach ($user_list as $user) {
            $side_bar_user_list[$user->getFullName()] = $user->id;
        }
    } else {
        $side_bar_user_list = null;
    }
    ?>
    // when the page is initialized with the first plot initialized, #search-form will get submit event in OpenEyes.Dash.js
    // $('#search-form').on('submit', function (e) {
    //     e.preventDefault();
    //     $('.report-search-form').trigger('submit');
    // });

    function viewAllSurgeons() {
        if ($('#analytics_allsurgeons').val() == 'on') {
            $('#analytics_allsurgeons').val('');
            $('#js-all-surgeons').html('View all surgeons');
        } else {
            $('#analytics_allsurgeons').val('on');
            $('#js-all-surgeons').html('View current surgeons');
        }
    }
    function viewAllDates() {
        $('#analytics_datepicker_from').val("");
        $('#analytics_datepicker_to').val("");
    }
    $('#js-btn-clinical').on('click',function () {
        if ($('#pcr-risk-grid').html() == "" && $('#js-chart-CA-selection').val() == '0'){
            OpenEyes.Dash.init('#pcr-risk-grid');
            OpenEyes.Dash.addBespokeReport('/report/ajaxReport?report=PcrRisk&template=analytics', null, 10);
            $('.mdl-cell').css('height','600px');
            $('.mdl-cell').css('width','1000px');
        }
    });
    $('.js-cataract-report-type').on('click',function () {
        // everytime switching between cataract report type will bind a submit event on #search-form
        // clear that out at beginning, as plot initialization will bind submit event
        if($._data(document.getElementById('search-form'), "events").hasOwnProperty('submit')){
            $('#search-form').off('submit')
        }
        $(this).addClass("selected");
        $('.js-cataract-report-type').not(this).removeClass("selected");
        $('#pcr-risk-grid').html("");
        $('#cataract-complication-grid').html("");
        $('#visual-acuity-grid').html("");
        $('#refractive-outcome-grid').html("");
        $('#nod-audit-grid').html("");
        $('#analytics_datepicker_from').val("");
        $('#analytics_datepicker_to').val("");
        $('#analytics_allsurgeons').val("");
        $('.analytics-event-list-row').hide();
        $('.analytics-event-list').hide();
        $('#js-back-to-chart').hide();
        $('#js-all-surgeons').html('View all surgeons');
        var selected_value = $(this).data("report");
        switch (selected_value) {
            case "PCR":
                OpenEyes.Dash.init('#pcr-risk-grid');
                OpenEyes.Dash.addBespokeReport('/report/ajaxReport?report=PcrRisk&template=analytics', null, 10);
                break;
            case "CP":
                OpenEyes.Dash.init('#cataract-complication-grid');
                OpenEyes.Dash.addBespokeReport('/report/ajaxReport?report=CataractComplications&template=analytics', null,10);
                break;
            case "VA":
                OpenEyes.Dash.init('#visual-acuity-grid');
                OpenEyes.Dash.addBespokeReport('/report/ajaxReport?report=\\OEModule\\OphCiExamination\\components\\VisualOutcome&template=analytics', null, 10);
                break;
            case "RO":
                OpenEyes.Dash.init('#refractive-outcome-grid');
                OpenEyes.Dash.addBespokeReport('/report/ajaxReport?report=\\OEModule\\OphCiExamination\\components\\RefractiveOutcome&template=analytics&procedures[]=all', null, 10);
                break;
            case "NOD":
                OpenEyes.Dash.init('#nod-audit-grid');
                OpenEyes.Dash.addBespokeReport('/report/ajaxReport?report=NodAudit&template=analytics', null, 10);
                break;
        }
    });
    // allow one click every two seconds
    // to avoid multi-click on this button
    $('#js-download-pdf').on('click', _.throttle(reportPlotToPDF, 2000, {'trailing': false}));

    // the callback for download pdf click event
    function reportPlotToPDF(){
        // grab dates
        // if from, to not filled, the max / min date from event data will be filled in
        var date = "";
        var from_date = $('#analytics_datepicker_from').val() ? $('#analytics_datepicker_from').val() : "<?php echo $min_event_date?>";
        var to_date = $('#analytics_datepicker_to').val() ? " to " + $('#analytics_datepicker_to').val() : " to " + "<?php echo $max_event_date?>";
        // make sure the entry is logical
        if(new Date(from_date) > new Date(to_date)){
            alert('From date cannot be later than To date')
            return;
        }
        if(new Date(to_date) < new Date(from_date)){
            alert('To date cannot be earlier than From date')
            return;
        }
        date = from_date + to_date
        // prevent click during downloading
        if($(this).text() === 'Downloading...'){
            return false;
        }

        // for better user experience to let them know it is downloading
        var originalText = $(this).text();
        $(this).text('Downloading...');
        var dict = {
            '/report/ajaxReport?report=PcrRisk&template=analytics': [
                'PcrRiskReport', 
                '#pcr-risk-grid',
                'PCR',
            ],
            '/report/ajaxReport?report=CataractComplications&template=analytics': [
                'CataractComplicationsReport', 
                '#cataract-complication-grid',
                'CP',
            ],
            '/report/ajaxReport?report=\\OEModule\\OphCiExamination\\components\\VisualOutcome&template=analytics': [
                'OEModule_OphCiExamination_components_VisualOutcomeReport', 
                '#visual-acuity-grid',
                'VA',
            ],
            '/report/ajaxReport?report=NodAudit&template=analytics': [
                'NodAuditReport', 
                '#nod-audit-grid',
                'NOD',
            ],
            '/report/ajaxReport?report=\\OEModule\\OphCiExamination\\components\\RefractiveOutcome&template=analytics&procedures[]=all': [
                'OEModule_OphCiExamination_components_RefractiveOutcomeReport', 
                '#refractive-outcome-grid',
                'RO',
            ]

        };

        // plot config
        var config = {
            // transparent plot bg color for not blocking texts
            paper_bgcolor: 'rgba(0, 0, 0, 0)',
            plot_bgcolor: 'rgba(0, 0, 0, 0)',
            font: {
                color: 'black',
            },
            yaxis: {
                linecolor: 'black',
            },
            xaxis: {
                linecolor: 'black',
            }
        };

        // instantiate jsPDF
        var doc = new jsPDF('l', 'pt', 'A4'); 
        // get page size
        var pageW = doc.internal.pageSize.width;
        var pageH = doc.internal.pageSize.height;

        // store total number of reports
        var total = Object.keys(dict).length;

        // initialize the counter for controlling the logic, 
        // because when the page load, there is always one plot is initialized
        var counter = 1;

        // margin top
        var marginT = 15;
        // margin left
        var marginL = 10;

        // fix plot width
        // marginL * 3 means: left, middle, right
        var plotWidth = (pageW - marginL * 3) / 2;
        // fix plot width
        // marginL * 3 means: top, middle, bottom
        var plotHeight = (pageH - marginT * 3) / 2;

        // get current selected cataract report type
        var selected = $('.js-cataract-report-type.selected').data('report'); 

        for(var key in dict){
            // whichever plot is initialized will be put into pdf first
            if(dict[key][2] === selected){
                // get the plot and set required color
                var currentPlot = document.getElementById(dict[key][0]);
                // set plot color in pdf
                configPlotPDF(currentPlot, config);
                Plotly.toImage(currentPlot)
                    .then((dataURL)=>{
                        doc.setFontSize(8);
                        doc.text(15, 10, 'Surgeon Name: ' + 
                        "<?php echo $current_user->contact->first_name . ' ' . $current_user->contact->last_name; ?>");
                        doc.text(15, 20, 'Date: ' + date);

                        doc.addImage(dataURL, 'PNG', marginL, marginT, plotWidth, plotHeight);
                        counter++;
                    });
                    // put the color back for update chart function
                    // analytics_layout is from analytics_plotly.js
                    configPlotPDF(currentPlot, analytics_layout);
                    continue;
            }
            // hide all the none current plots to avoid page shake
            $(dict[key][1]).hide();
            // initialize all the none current plots
            OpenEyes.Dash.init(dict[key][1]);
            OpenEyes.Dash.addBespokeReport(key, null, 10);
        }
        // within this ajaxSuccess, the ajax request tirggered by download pdf button will be caught
        // and add generated plot into pdf after the requestcomplete
        $(document).ajaxSuccess(function(event, request, settings){
            // flag for if the pdf is saved
            var saved = false;
            // only the events triggered by js-download-pdf will be captured
            if(event.target.activeElement.id && event.target.activeElement.id === 'js-download-pdf') {
                // get plot
                var plot = document.getElementById(dict[settings.url][0]);
                // set plot color
                configPlotPDF(plot, config);

                // convert the plot into image
                Plotly.toImage(plot)
                    .then((dataURL)=>{
                        // calculate offset of the plot in pdf
                        var offsetW = (counter % 2 === 0) ? (marginL * 2 + plotWidth) : marginL;
                        var offsetH = ((((counter - 1) % 4) + 1)* plotWidth + marginL * 2 > pageW) ? (marginT * 2 + plotHeight) : marginT;

                        // put the image into pdf
                        doc.addImage(dataURL, 'PNG', offsetW, offsetH, plotWidth, plotHeight);
                        
                        if(counter >= total){
                            doc.save('Cataract_Plots.pdf');
                            saved = true;
                            return saved;
                        } else {
                            counter++;
                            // every four plots add new page
                            if(counter % 4 === 1){
                                doc.addPage();
                            }
                        }
                    }).then(function(flag){
                        // once the plot is added into pdf, it will be cleared out
                        // and show it (it is hidden before) to avoid crashing other
                        // functions
                        $(dict[settings.url][1]).html("");
                        $(dict[settings.url][1]).show();

                        // the search form will be affected by initializing all the plots
                        // bring it back at this stage
                        if(flag){
                            // clear the dictionary
                            delete dict;
                            // to reset the search form
                            $('.js-cataract-report-type.selected').click();
                            // without doing so, previous requests will be captured
                            $(document).off('ajaxSuccess');
                            $('#js-download-pdf').text(originalText);
                        }
                    });
            }
        });
        return true;
    }
    // to config the colors for the plots
    // config: the config object from the beginning of reportPlotToPDF function
    // or the analytics_layout from analytics_plotly.js
    function configPlotPDF(plot, config){
        // in case the plot is not passed in
        if(plot){
            plot.layout.paper_bgcolor = config.paper_bgcolor;
            plot.layout.plot_bgcolor = config.plot_bgcolor;
            plot.layout.font.color = config.font === undefined ? 'white' : config.font.color;
            plot.layout.yaxis.linecolor = config.yaxis.linecolor;
            plot.layout.xaxis.linecolor = config.xaxis.linecolor;
        }
    }
</script>


// analytics_cataract scripts
<script type="text/javascript">
    $('.clickable').click(function () {
        var link = $(this).attr('id');
        window.location.href = '/OphTrOperationnote/default/view/' + link;
    });
    $('#js-back-to-chart').click(function () {
        $('.analytics-event-list-row').hide();
        $('.analytics-event-list').hide();
        $(this).hide();
        $('.analytics-charts').show();
        if ($('#cataract-complication-grid').html()){
            $('#cataract-complication-grid').html("");
            $('#cataract-complication-grid').show();
            OpenEyes.Dash.init('#cataract-complication-grid');
            OpenEyes.Dash.addBespokeReport('/report/ajaxReport?report=CataractComplications&template=analytics', null,10);
        }else if ($('#visual-acuity-grid').html()){
            $('#visual-acuity-grid').html("");
            $('#visual-acuity-grid').show();
            OpenEyes.Dash.init('#visual-acuity-grid');
            OpenEyes.Dash.addBespokeReport('/report/ajaxReport?report=\\OEModule\\OphCiExamination\\components\\VisualOutcome&template=analytics', null, 10);
        }else if ($('#refractive-outcome-grid').html()){
            $('#refractive-outcome-grid').html("");
            $('#refractive-outcome-grid').show();
            OpenEyes.Dash.init('#refractive-outcome-grid');
            OpenEyes.Dash.addBespokeReport('/report/ajaxReport?report=\\OEModule\\OphCiExamination\\components\\RefractiveOutcome&template=analytics&procedures[]=all', null, 10);
        }else if ($('#nod-audit-grid').html()){
            $('#nod-audit-grid').html("");
            $('#nod-audit-grid').show();
            OpenEyes.Dash.init('#nod-audit-grid');
            OpenEyes.Dash.addBespokeReport('/report/ajaxReport?report=NodAudit&template=analytics', null, 10);
        }
        viewAllDates();
        if ($('#analytics_allsurgeons').val() == 'on'){
            viewAllSurgeons();
        }
    });
</script>
<script src="<?= Yii::app()->assetManager->createUrl('js/analytics/analytics_csv_cataract.js')?>"></script>
