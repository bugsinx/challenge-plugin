jQuery(document).ready(function($) {
  $('#refresh-data').on('click', function(event) {
      event.preventDefault();
      $.ajax({
          url: ajaxurl,
          type: 'POST',
          data: {
              action: 'challenge_plugin_refresh_data',
              ajax: 1
          },
          success: function(response) {
              if ( response.success ) {
                  window.location.reload();
              } else {
                  alert( response.data.message );
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert( textStatus + ': ' + errorThrown );
          }
      });
  });
});


  