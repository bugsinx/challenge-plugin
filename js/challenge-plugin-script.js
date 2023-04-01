(function( $ ) {
    'use strict';

    $(function() {
        var $table = $( '#challenge-plugin-table' );
        if ( $table.length ) {
            var nonce = challenge_plugin_data.nonce;
            $.ajax({
                url: challenge_plugin_data.ajax_url + '?action=nopriv_challenge_plugin_data&_wpnonce=' + nonce,
                success: function( data ) {
                    if ( data ) {
                        var tbody = $table.find( 'tbody' );
                        const { data: { data:{rows}}} = data;
                        const { data: { data:{headers}}} = data;

                        // Create the table header row
                        var headerRow = $('<tr>');
                        $.each(headers, function (index, value) {
                            headerRow.append($('<th>').text(value));
                        });
                        tbody.append(headerRow);

                        // Create the table data rows
                        $.each(rows, function (index, value) {
                            var row = $('<tr>');
                            $.each(value, function (key, value) {
                                row.append($('<td>').text(value));
                            });
                            tbody.append(row);
                        });
                    }
                }
            });
        }
    });

})( jQuery );
