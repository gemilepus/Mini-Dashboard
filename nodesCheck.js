var myVar = setInterval(myTimer, 100);

function myTimer() {
    var str;

    cy.edges().length.toString();
    cy.nodes().length.toString();

    str = "node " +  cy.nodes().length.toString() + " , edge " +   cy.edges().length.toString() ;
    document.getElementById("demo").innerHTML = str;


    var edges_array;
    edges_array = "length" + cy.edges().length.toString() + " : ";

    var check_array = [];
    cy.edges().forEach(function( ele ){
        var datastr;
        datastr =  ele.data("source").toString() + " to " + ele.data("target").toString();
        edges_array += datastr + "  |  ";

        if( check_array.indexOf(datastr) === -1 ){
            check_array.push(   datastr  );
        }else{
            ele.remove();
        }

        if( ele.data("source").toString() != "Server" && ele.data("target").toString().indexOf("-") === -1 ) {
            ele.remove();
        }
    });
    document.getElementById("textview").innerHTML = edges_array;
}