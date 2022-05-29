
var editor;
 
$(document).ready(function() {
    editor = new $.fn.dataTable.Editor( {
        ajax: "index.php",
        table: "#example",
        fields: [ {
                label: "first_name:",
                name: "users.first_name"
            }, {
                label: "Last name:",
                name: "users.last_name"
            }, {
                label: "gender:",
                name: "users.gender"
            }, {
                label: "birth_date:",
                name: "users.birth_date",
                type: "datetime"
            }, {
                label: "hire_date:",
                name: "users.hire_date",
                type: "datetime"
            },{
                name: "users.removed_date",
                type: "hidden"
            }
        ]
    } );
 
    var table = $('#example').DataTable( {
        dom: "Bfrtip",
        "processing": true,
        "serverSide": true,
        "ajax": {
        "url": "index.php",
        "type": "POST"
      },
        columns: [
            { data: "id"},
            { data: "first_name" },
            { data: "last_name" },
            { data: "gender" },
            { data: "birth_date" },
            { data: "hire_date" }
        ],
        select: true,
        buttons: [
            { extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            {
                extend: "selected",
                text: 'Delete',
                action: function ( e, dt, node, config ) {
                    var rows = table.rows( {selected: true} ).indexes();
 
                    editor
                        .hide( editor.fields() )
                        .one( 'close', function () {
                            setTimeout( function () { // Wait for animation
                                editor.show( editor.fields() );
                            }, 500 );
                        } )
                        .edit( rows, {
                            title: 'Delete',
                            message: rows.length === 1 ?
                                'Are you sure you wish to delete this row?' :
                                'Are you sure you wish to delete these '+rows.length+' rows',
                            buttons: 'Delete'
                        } )
                        .val( 'users.removed_date', (new Date()).toISOString().split('T')[0] );
                }
            }
        ]
    } );
} );