/*
 *  Copyright (c) Codiad & Kent Safranski (codiad.com), distributed
 *  as-is and without warranty under the MIT License. See
 *  [root]/license.txt for more. This information must remain intact.
 */

(function(global, $) {

    var codiad = global.codiad;

    $(function() {
        codiad.git.init();
    });

    //////////////////////////////////////////////////////////////////
    //
    // Active Files Component for Codiad
    // ---------------------------------
    // Track and manage EditSession instaces of files being edited.
    //
    //////////////////////////////////////////////////////////////////

    codiad.git = {

        controller: 'components/git/controller.php',

        init: function() {

            var _this = this;

        },
        
        commit: function(path) {
            console.log(path);
            codiad.modal.load(400, 'components/git/dialog.php?action=commit&path='+path);
            codiad.modal.hideOverlay();
        },
        
        status: function(path) {
            
            var _this = this;
            
            $.get(_this.controller + '?action=status&path='+path, function(data) {
                var listResponse = codiad.jsend.parse(data);
                $('#commit_wait').hide();
                if (listResponse !== null) {
                    $.each(listResponse, function(index, data) {
                        $('#commit_files').append('<tr><td><input type="checkbox" name="files[]" value="'+data+'"></td><td>'+data+'</td></tr>');
                    });
                    $('#commit_button').show();
                } else {
                    $('#commit_empty').show();
                }
            });
        },
        
        push: function(button) {
            
            var _this = this;
            var _form = $('#commit_form').closest('form');
            
            $('#commit_button').hide();
            
            //console.log(_form.serialize());
            $.post(_this.controller + '?action=push', _form.serialize(), function(outData){
                $('#commit_form').hide();
                $('#commit_message').show();
            })
        }
    };

})(this, jQuery);
