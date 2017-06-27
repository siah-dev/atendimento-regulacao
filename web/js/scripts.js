$('#atendimento-unidade_solicitante').change(function() {
    var str = "";

    $( "#atendimento-unidade_solicitante option:selected" ).each(function() {
        str += $( this ).text();
    });
    if(str === 'OUTROS'){
        $('<label>Solicitante:</label> <input type="text" name="Atendimento[outro_solicitante]" required />').appendTo($(".field-atendimento-unidade_solicitante"));
    }
    console.log(str);
}).trigger( "change" );

$('#atendimento-unidade_encaminhada').change(function() {
    var str = "";

    $( "#atendimento-unidade_encaminhada option:selected" ).each(function() {
        str += $( this ).text();
    });
    if(str === 'OUTROS'){
        $('<label>Encaminhada:</label> <input type="text" name="Atendimento[outro_encaminhada]" required />').appendTo($(".field-atendimento-unidade_encaminhada"));
    }
    console.log(str);
}).trigger( "change" );